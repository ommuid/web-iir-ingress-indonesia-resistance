<?php


	
	

	protected $table          = 'module_to_hook';
	protected $identifier     = 'id_module';
	private $moduleCaches     = array();
	// Daftar modul yg tidak akan discan oleh sistem.
	private $ignoreFromScan   = array();	
	
	
	



	
	
	
	
	

	/**
	 * Ubah status aktif modul dari 0 menjadi 1.
	 */
	public function install($moduleName) {
		$model = new ComModules;
		$result = ComModules::model()->find(array(
			'condition' => 'name = :name AND enabled=0',
			'params' => array(
				':name' => $moduleName,
			),
		));

		if($result !== null) {
			return false;
		}else {
			$desc     = Yii::app()->getModule($moduleName)->description;
			$active   = Yii::app()->getModule($moduleName)->active;
			$hookName = Yii::app()->getModule($moduleName)->defaultHook;
			$idHook   = $this->getIdHookByName($hookName);

			Yii::app()->db->createCommand('INSERT INTO module(nama, deskripsi, aktif) VALUES(:nama, :desc, :aktif)')->
			execute(array(
				':nama' => $moduleName, ':desc' => $desc, ':aktif' => $active
			));

			$moduleToHook = new ModuleToHook;
			$moduleToHook->id_module = $result->id_module;
			$moduleToHook->id_hook = $idHook;
			$moduleToHook->position = 0;

			if($moduleToHook->save(false))
				return true;
			else
				return false;
		}
	}

	/*
	 * Hapus modul dari tabel.
	*/
	public function uninstall($idModule) {
		$model = new ComModules;

		$result = ComModules::model()->find(array(
			'condition' => 'id = :id_module',
			'params' => array(':id_module' => $idModule),
		));

		if($result === null) {
			return false;
		}else {
			$idModule = $result->id_module;

			$isModuleHooked = ModuleToHook::model()->find(array(
				'condition' => 'id_module = :id_module',
				'params' => array(
					':id_module' => $idModule,
				),
			));

			// Remove from module_to_hook
			if($isModuleHooked !== null) {
				// Hapus modul dari tabel module_to_hook
				$isModuleHooked->delete();
			}

			// set aktif = 0 pada tabel module.
			$result->aktif = 0;
			if($result->save())
				return true;
			else
				return false;
		}
	}

	/*
	 Memeriksa apakah module telah dihook.
	 @return true jika telah dihook dan false jika belum dihook.
	*/
	public function isModuleHooked($idModule) {
		$conn    = Yii::app()->db;
		$sql     = sprintf('SELECT * FROM module_to_hook hm WHERE hm.id_module = %d', $idModule);
		$result  = $conn->createCommand($sql)->query();

		if(!$result->rowCount)
			return false;
		else
			return true;
	}

	/*
	 Mendapatkan id_hook berdasarkan nama hook.
	 @return false jika tak ditemukan dan id_hook jika ketemu.
	*/
	public function getIdHookByName($hookName) {
		$model = new Hook;
		$result = $model->find(array(
			'condition' => 'LOWER(nama) = :nama',
			'params' => array(
				':nama' => strtolower($hookName),
			),
		));

		if(!$result)
			return false;
		else {
			return $result->id_hook;
		}
	}

	/*
	 Mendapatkan id modul berdasarkan nama module.
	 @return false if not found or id_module if founded.
	*/
	public function getIdModuleByName($moduleName) {
		$conn = Yii::app()->db;
		$sql  = 'SELECT id_module FROM module WHERE nama = "' . $moduleName . '"';
		$command = $conn->createCommand($sql);
		$result = $command->query();

		if(!$result->rowCount)
			return false;
		else {
			$rows = $result->read();
			return $rows['id_module'];
		}
	}

	public function registerHook($hookName) {
		$conn = Yii::app()->db;
		$sql  = 'SELECT id_module FROM module_to_hook hm, hook h WHERE h.nama = "' . $hookName . '"';
		$sql .= ' AND hm.id_module = ' . $this->id . ' AND hm.id_hook = h.id_hook';
		$command = $conn->createCommand($sql);
		$result  = $command->query();

		$idModule = 0;
		if(!$result->rowCount)
			return false;
		else {
			$rows     = $result->read();
			$idModule = $rows['id_module'];
		}

		// Get id hook
		$sql  = 'SELECT id_hook FROM hook WHERE nama = "' . $hookName . '"';
		$command = $conn->createCommand($sql);
		$result  = $command->query();
		$idHook = 0;
		if(!$result->rowCount)
			return false;
		else {
			$rows = $result->read();
			$idHook = $rows['id_hook'];
		}

		// Get module position in hook
		$sql  = 'SELECT MAX(position) AS position FROM module_to_hook WHERE id_hook = ' . $idHook;
		$command = $conn->createCommand($sql);
		$result  = $command->query();
		$position = 0;

		if(!$result->rowCount)
			return false;
		else {
			$rows = $result->read();
			$position = $rows['position'];
		}

		// Register module in hook
		$sql  = 'INSERT INTO module_to_hook(id_module, id_hook, position) VALUES(' . $idModule . ', ';
		$sql .= $idHook . ', ' . ($position + 1) . ')';
		$command = $conn->createCommand($sql);
		$result  = $command->query();
		if(!$result)
			return false;
		else
			return true;
	}

	public function unregisterHook($idHook) {
	}

	public function getPosition($idHook) {
	}

	public function updatePosition($idHook) {
	}

	public function getModulesInstalled($position = 0) {
	}

	public function isModuleInstalled($idModule) {
		$model = new Module;
		$result = $model->find(array(
			'condition' => 'id_module = :id_module AND aktif = :aktif',
			'params' => array(
				':id_module' => $idModule,
				':aktif' => 1,
			),
		));

		if($result)
			return true;
		else
			return false;
	}

	/**
	 * Check if module already actived or not.
	 *
	 * @param string $name module's name
	 * @return boolean
	 */
	public function isModuleActived($name) {
		$result = Yii::app()->db->createCommand("SELECT * FROM {$this->_moduleTableName} WHERE enabled=1 AND name= :name")->queryRow(true, array(
			':name' => trim(strtolower($name)))
		);

		if($result === false)
			return false;
		else
			return true;
	}

}

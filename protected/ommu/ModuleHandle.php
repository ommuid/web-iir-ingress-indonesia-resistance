<?php
/**
 * ModuleHandle class file
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @create date November 27, 2013 15:02 WIB
 * @version 1.0
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 *
 * Contains many function that most used
 *
 * getModulesFromDb
 * getModuleConfig
 * cacheModuleConfig
 * deleteModuleFolder
 * deleteModule
 * getIgnoreModule
 * getModulesFromDir
 * updateModuleAddonFromDir
 * getIdMax
 * setModuleToDb
 * updateModuleAddon
 * installModule
 *
 */

class ModuleHandle extends CApplicationComponent
{
	public $modulePath        = 'protected/modules';
	public $configPath        = 'protected/config/module_addon.php';
	
	private $_moduleTableName = 'ommu_core_plugins';
	
	
	/*
	 Dapatkan total modul yang ada pada tabel modul.
	 @return integer rows.
	*/
	public function getModulesFromDb($actived=null) {
		$criteria = new CDbCriteria;
		if($actived == null) {
			$criteria->condition = 'code != :code';
			$criteria->params = array(
				':code'=>10000,
			);		
		} else if($actived == 'enabled') {
			$criteria->condition = 'actived != :actived AND code != :code';
			$criteria->params = array(
				':actived'=>0,
				':code'=>10000,
			);
		} else {
			$criteria->condition = 'actived == :actived AND code != :code';
			$criteria->params = array(
				':actived'=>$actived,
				':code'=>10000,
			);
		}
		$criteria->order = 'folder ASC';
		$modules = OmmuPlugins::model()->findAll($criteria);
		
		return $modules;
	}

	/**
	 * Get module config from yaml file
	 *
	 * @param string $moduleName
	 * @return array
	 */
	public function getModuleConfig($moduleName) {
		Yii::import('application.components.plugin.Spyc');
		define('DS', DIRECTORY_SEPARATOR);
		
		$configPath = Yii::getPathOfAlias('application.modules.'.$moduleName).DS.$moduleName.'.yaml';
		if(file_exists($configPath))
			return Spyc::YAMLLoad($configPath);
		else
			return null;
	}
	
	/**
	 * Cache modul dari database ke bentuk file.
	 * Untuk mengurangi query pada saat install ke database.
	 */
	public function cacheModuleConfig() {
		$modules = $this->getModulesFromDb();
		$arrayModule = '';

		foreach($modules as $module) {
			$arrayModule .= $module->folder . "\n";
		}
		$filePath   = Yii::getPathOfAlias('application.config');
		$fileHandle = fopen($filePath.'/cache_module.php', 'w');
		fwrite($fileHandle, $arrayModule);
		fclose($fileHandle);
	}
	
	/**
	 * Delete Folder
	 */
	public function deleteModuleFolder($dirname) {
	    // Sanity check
	    if (file_exists($dirname)) {
			// Simple delete for a file
			if (is_file($dirname) || is_link($dirname)) {
				return unlink($dirname);
			}

			// Loop through the folder
			$dir = dir($dirname);
			while (false !== $entry = $dir->read()) {
				// Skip pointers
				if ($entry == '.' || $entry == '..') {
					continue;
				}

				// Recurse
				$this->deleteModuleFolder($dirname . DIRECTORY_SEPARATOR . $entry);
			}

			// Clean up
			$dir->close();
			return rmdir($dirname);
		
	    } else {
	        return false;		
		}	
	}	

	/**
	 * Delete modules
	 */
	public function deleteModule($module=null) {
		if($module != null) {
			$config    = $this->getModuleConfig($module);
			$tableName = $config['db_table_name'];
			if(count($config) > 0) {
				if($tableName != null) {
					foreach($tableName as $val){
						Yii::app()->db->createCommand("DROP TABLE {$val}")->execute();
					}
				}
			}
		
			$sourcePath = Yii::getPathOfAlias('application.modules.'.trim($module));
			$externalPath = Yii::getPathOfAlias('webroot.externals.'.trim($module));
			$publicPath = Yii::getPathOfAlias('webroot.public.'.trim($module));

			//Delete module source
			$this->deleteModuleFolder($sourcePath);
			//Delete external source
			$this->deleteModuleFolder($externalPath);
			//Delete public source
			$this->deleteModuleFolder($publicPath);
		
		} else {
			return false;
		}
	}
	
	/**
	 * return ignore module from scanner.
	 */
	public function getIgnoreModule() {
		return array();
	}

	/**
	 * Mendapatkan daftar modul dari folder protected/modules.
	 *
	 * @return array daftar modul yang ada atau false jika tidak terdapat modul.
	 */
	public function getModulesFromDir() {
		$moduleList = array();
		$modulePath = Yii::getPathOfAlias('application.modules');
		$modules    = scandir(Yii::getPathOfAlias('application.modules'));
		foreach($modules as $name) {
			$moduleFile = $modulePath.'/'.$name.'/'.ucfirst($name).'Module.php';
			if (file_exists($moduleFile)) {
				$moduleName = strtolower(trim($name));
				if(!in_array($moduleName, self::getIgnoreModule())) {
					$moduleList[] = $moduleName;
				}
			}
		}

		if(count($moduleList) > 0) {
			return $moduleList;
		}else {
			return false;
		}
	}
	
	/**
	 * Install modul ke file protected/config/modules.php
	 */
	public function updateModuleAddonFromDir($module = array()) {
		$config = '';
		$moduleCaches = $this->getModulesFromDir();
		if(count($module) > 0 && is_array($module)) {
			$moduleCaches = $module;
		}

		if(count($moduleCaches) > 0) {
			$config .= "<?php \n";
			$config .= "return array(\n\t'modules' => array(\n";
			for($i = 0; $i < count($moduleCaches); $i++) {
				if($i !== (count($moduleCaches) - 1))
					$config .= "\t\t'" . $moduleCaches[$i] . "',\n";
				else
					$config .= "\t\t'" . $moduleCaches[$i] . "'\n";
			}
			$config .= "\t),\n);";
			$config .= "\n?>";
		}

		$fileHandle = fopen($this->configPath, 'w');
		fwrite($fileHandle, $config, strlen($config));
		fclose($fileHandle);
	}

	/**/
	public function getIdMax($fieldName, $tableName) {
		$conn = Yii::app()->db;
		$sql  = 'SELECT IFNULL(MAX(' . $fieldName . ')+1, 1) as id FROM ' . $tableName;
		return $conn->createCommand($sql)->queryScalar();
	}
	
	/**
	 * Install modul ke database
	 */
	public function setModuleToDb() {
		$countModulesFile = count($this->getModulesFromDir());
		$countModulesDb = count($this->getModulesFromDb());
		$toBeInstalled    = array();

		if($countModulesFile > $countModulesDb) {
			$cacheModule     = file(Yii::getPathOfAlias('application.config').'/cache_module.php');
			$installedModule = $this->getModulesFromDir();
			$toBeInstalled   = array();
			$caches = array();
			foreach($cacheModule as $val) {
				$caches[] = trim(strtolower($val));
			}

			// Cari nama modul yang belum masuk database.
			if(count($cacheModule) == 0 || count($cacheModule) < 1) {
				if($installedModule) {
					foreach($installedModule as $val) {
						$toBeInstalled[] = $val;
					}
				}

			} else {
				if($installedModule) {
					foreach($installedModule as $val) {
						$val = trim($val);
						if(!in_array(strtolower($val), $caches)) {
							$toBeInstalled[] = $val;
						}
					}
				}
			}

			$sql = "INSERT INTO {$this->_moduleTableName}(plugin_id, folder) VALUES";
			$id  = $this->getIdMax('plugin_id', 'ommu_core_plugins');
			for($i = 0; $i < count($toBeInstalled); $i++) {
				if(isset(Yii::app()->getModule($toBeInstalled[$i])->active))
					$active = Yii::app()->getModule($toBeInstalled[$i])->active;
				else
					$active = 0;

				$desc = Yii::app()->getModule($toBeInstalled[$i])->description;

				if($i == (count($toBeInstalled) - 1)) {
					$sql .= '(' . $id . ', "' . $toBeInstalled[$i] . '")';
				}else
					$sql .= '(' . $id . ', "' . $toBeInstalled[$i] . '"),';

				$id++;
			}

			//Check if module already inserted to table.
			$conn    = Yii::app()->db;

			if(count($toBeInstalled) > 0) {
				$result  = $conn->createCommand($sql)->execute();
				if($result)
					return true;
				else
					return false;
			}
		}
	}

	/**
	 * Update module from db to file
	 */
	public function updateModuleAddon() {
		$modules = $this->getModulesFromDb('enabled');

		if(count($modules) > 0) {
			$config  = "<?php \n";
			$config .= "return array(\n\t'modules' => array(\n";
			$i = 1;
			foreach($modules as $val) {
				if($i !== count($modules))
					$config .= "\t\t'" . $val['folder'] . "',\n";
				else
					$config .= "\t\t'" . $val['folder'] . "'\n";
				$i++;
			}
			$config .= "\t),\n);";

		} else {
			$config  = "<?php \n";
			$config .= "return array(\n\t'modules' => array(\n";
			$config .= "\t),\n);";
		}

		$fileHandle = @fopen(Yii::getPathOfAlias('application.config').'/module_addon.php', 'w');
		@fwrite($fileHandle, $config, strlen($config));
		@fclose($fileHandle);
	}

	/**
	 * Create additional table inside module(if any)
	 *
	 * @param string $moduleName
	 * @return void.
	 */
	public function installModule($id, $moduleName) {
		$module		= OmmuPlugins::model()->findByPk($id);
		$config		= $this->getModuleConfig($moduleName);
		if($config != null) {			
			$module->code = trim($config['code']);
			$module->model = trim($config['global_model']);
			$module->name = trim($config['name']);
			$module->desc = trim($config['description']);
			$module->version = trim($config['version']);
			$module->created_date = date('Y-m-d H:i:s');
			
			if($module->save()) {
				$tableName = $config['db_table_name'];
				$fileName  = trim($config['db_sql_filename']);

				if($tableName != null && $fileName != '') {
					$sqlPath = Yii::getPathOfAlias('application.modules.'.$moduleName).DS.'assets'.DS.$fileName;
					$tables  = Yii::app()->db->createCommand('SHOW FULL TABLES WHERE table_type = "BASE TABLE"')->queryColumn();

					if(!in_array($tableName, $tables)) {
						$sql = file_get_contents($sqlPath);
						Yii::app()->db->createCommand($sql)->execute();
					}
				}				
			}
		}
	}
	
}

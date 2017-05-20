<?php
/**
 * OClientScript class file.
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @create date Maret 1, 2014 14:02 WIB
 * @updated date Maret 1, 2014 15:50 WIB
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 */
 
Yii::import('system.web.CClientScript');
 
class OClientScript extends CClientScript
{
	//$cs=Yii::app()->getClientScript();
	//$cs->getOmmuScript();

	/**
	 * Get the proper http URL prefix depending on if this was a secure page request or not
	 *
	 * @return string https or https
	 */
	public function getProtocol()
	{
		if(Yii::app()->request->isSecureConnection)
			return 'https';
		return 'http';
	}

	/**
	 * Get the proper http URL prefix depending on if this was a secure page request or not
	 */
	public function getCssFiles()
	{
		//$return = array();
		//$return = $this->cssFiles;
		$return = '';		
		//print_r($this->cssFiles);
		if(!empty($this->cssFiles)) {
			foreach($this->cssFiles as $key=>$val) {
				if((is_string($key)) || is_array($val))
					if($key == $row)
						$cssFile = $this->getProtocol()."://".Yii::app()->request->serverName.$key;
					$return .= '@import url("'.$cssFile.'");';
			}
		}
		
		//$return = $this->coreScripts;
		//print_r($this->coreScripts);
		if(!empty($this->coreScripts)) {
			foreach($this->coreScripts as $key=>$val) {
				if((is_string($key) && $key != 'jquery') && is_array($val)) {
				//if((is_string($key)) && is_array($val))
					if($val['css'] != null && $val['baseUrl'] != null)
						$cssFile = $this->getProtocol()."://".Yii::app()->request->serverName.$val['baseUrl'].'/'.$val['css'][0];
					$return .= '@import url("'.$cssFile.'");';
				}
			}
		}
		return $return;
	}

	/**
	 * Get the proper http URL prefix depending on if this was a secure page request or not
	 */
	public function getScriptFiles()
	{
		$return = array();
		//$return = $this->coreScripts;
		//print_r($this->coreScripts);
		if(!empty($this->coreScripts)) {
			foreach($this->coreScripts as $key=>$val) {
				if((is_string($key) && $key != 'jquery') && is_array($val)) {
				//if((is_string($key)) && is_array($val))
					if($val['baseUrl'] != null)
						$return[] = /*$this->getProtocol()."://".Yii::app()->request->serverName.*/$val['baseUrl'].'/'.$val['js'][0];
					else 
						$return[] = /*$this->getProtocol()."://".Yii::app()->request->serverName.*/$this->getCoreScriptUrl().'/'.$val['js'][0];
				}
			}
		}
		//echo '===========================================';
		
		//$return = $this->scriptFiles;
		//print_r($this->scriptFiles);
		if(!empty($this->scriptFiles)) {
			foreach($this->scriptFiles as $key=>$val) {
				if((is_string($key)) || is_array($val)) {
					if(!empty($val)) {
						foreach($val as $key=>$row)
							if($key == $row || $row==null)
								$return[] = /*$this->getProtocol()."://".Yii::app()->request->serverName.*/$key;
					}
				}
			}
		}
		return $return;
	}

	/**
	 * Get the proper http URL prefix depending on if this was a secure page request or not
	 */
	public function getScripts()
	{
		//$return = $this->scripts;
		$return = '';
		if(!empty($this->scripts)) {
			foreach($this->scripts as $key=>$val) {
				if((is_string($key)) || is_array($val)) {
					if(!empty($val)) {
						foreach($val as $key=>$row)
							$return .= $row;
					}
				}
			}
		}
		return $return;
	}

	/**
	 * Initializes the grid view.
	 * This method will initialize required property values and instantiate {@link columns} objects.
	 */
	public function getOmmuScript() 
	{
		$module = strtolower(Yii::app()->controller->module->id);
		$controller = strtolower(Yii::app()->controller->id);
		$action = strtolower(Yii::app()->controller->action->id);
		if(isset($_GET))
			$attr = array_merge($_GET, array('protocol'=>'script'));
		else
			$attr = array('protocol'=>'script');
		
		if($module == 'null')
			$url = Yii::app()->createUrl($controller.'/'.$action, $attr);
		else
			$url = Yii::app()->createUrl($module.'/'.$controller.'/'.$action, $attr);
		
		$return = array();
		$return['cssFiles'] = $this->getCssFiles();
		$return['scriptFiles'] = $this->getScriptFiles();
		$return['scriptFiles'][] = $url;
		//$return['scripts'] = $this->getScripts();
		$return['powered'] = 'Ommu Platform by putra@sudaryanto.id';
		
		return $return;
	}

	/**
	 * Renders the registered scripts.
	 * This method is called in {@link CController::render} when it finishes
	 * rendering content. CClientScript thus gets a chance to insert script tags
	 * at <code>head</code> and <code>body</code> sections in the HTML output.
	 * @param string $output the existing output that needs to be inserted with script tags
	 */
	public function render(&$output)
	{
		if(!$this->hasScripts)
			return;

		if(!Yii::app()->request->isAjaxRequest)
			$this->renderCoreScripts();

		if(!empty($this->scriptMap))
			$this->remapScripts();

		$this->unifyScripts();

		if(!Yii::app()->request->isAjaxRequest)
			$this->renderHead($output);
		if($this->enableJavaScript)
		{
			if(!Yii::app()->request->isAjaxRequest) {
				$this->renderBodyBegin($output);
				$this->renderBodyEnd($output);			
			}
		}
	}
}

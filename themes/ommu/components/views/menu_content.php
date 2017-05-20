<?php
$module = strtolower(Yii::app()->controller->module->id);
$controller = strtolower(Yii::app()->controller->id);
$action = strtolower(Yii::app()->controller->action->id);
				
// Left Position
if($model != null) {
	echo '<ul class="left clearfix">';
	foreach($model as $val) {
		//attr url					
		$arrAttrParams = array();
		if($val['urlPath']['attr'] != null && $val['urlPath']['attr'] != '-') {
			$arrAttr = explode(',', $val['urlPath']['attr']);
			if(count($arrAttr) > 0) {
				foreach($arrAttr as $row) {
					$part = explode('=', $row);
					if(strpos($part[1], '$_GET') !== false) {								
						$list = explode('*', $part[1]);
						if(count($list) == 2)
							$arrAttrParams[$part[0]] = $_GET[$list[1]];
						elseif(count($list) == 3)
							$arrAttrParams[$part[0]] = $_GET[$list[1]][$list[2]];
						elseif(count($list) == 4)
							$arrAttrParams[$part[0]] = $_GET[$list[1]][$list[2]][$list[3]];
						elseif(count($list) == 5)
							$arrAttrParams[$part[0]] = $_GET[$list[1]][$list[2]][$list[3]][$list[4]];
						
					} else
						$arrAttrParams[$part[0]] = $part[1];
				}
			}
		}
		
		$link = $val['urlPath']['url'] != null && $val['urlPath']['url'] != '-' ? Yii::app()->controller->createUrl($val['urlPath']['url'], $arrAttrParams) : 'javascript:void(0);';
		$icons = $val['urlPath']['icon'] != null && $val['urlPath']['icon'] != '-' ? $val['urlPath']['icon'] : 'C';
		$submenu = $val['submenu'];
				
		$siteType = explode(',', $val['urlRules']['siteType']);
		$userLevel = explode(',', $val['urlRules']['userLevel']);
		$renderContentMenu = false;
		
		if(count($val['urlRules']) == 5) {
			$actionArray = explode(',', $val['urlRules'][2]);
			if($val['urlRules'][0] == $module && $val['urlRules'][1] == $controller && in_array($action, $actionArray) && in_array($setting->site_type, $siteType) && in_array(Yii::app()->user->level, $userLevel))
				$renderContentMenu = true;
		} else {
			$actionArray = explode(',', $val['urlRules'][1]);
			if($val['urlRules'][0] == $controller && in_array($action, $actionArray) && in_array($setting->site_type, $siteType) && in_array(Yii::app()->user->level, $userLevel))
				$renderContentMenu = true;
		}
		
		if($renderContentMenu == true) {
			echo '<li>';
			echo '<a href="'.$link.'" title="'.Yii::t('phrase', $val['urlTitle']).'"><span class="icons">'.$icons.'</span>'.Yii::t('phrase', $val['urlTitle']).'</a>';
			
			if($submenu != null) {
				echo '<ul>';
				foreach($submenu as $key => $data) {
					//attr url					
					$arrAttrParams = array();
					if($data['urlPath']['attr'] != null && $data['urlPath']['attr'] != '-') {
						$arrAttr = explode(',', $data['urlPath']['attr']);
						if(count($arrAttr) > 0) {
							foreach($arrAttr as $row) {
								$part = explode('=', $row);
								if(strpos($part[1], '$_GET') !== false) {								
									$list = explode('*', $part[1]);
									if(count($list) == 2)
										$arrAttrParams[$part[0]] = $_GET[$list[1]];
									elseif(count($list) == 3)
										$arrAttrParams[$part[0]] = $_GET[$list[1]][$list[2]];
									elseif(count($list) == 4)
										$arrAttrParams[$part[0]] = $_GET[$list[1]][$list[2]][$list[3]];
									elseif(count($list) == 5)
										$arrAttrParams[$part[0]] = $_GET[$list[1]][$list[2]][$list[3]][$list[4]];
									
								} else
									$arrAttrParams[$part[0]] = $part[1];
							}
						}
					}
					$link = $data['urlPath']['url'] != null && $data['urlPath']['url'] != '-' ? Yii::app()->controller->createUrl($data['urlPath']['url'], $arrAttrParams) : 'javascript:void(0);';
					$icons = $data['urlPath']['icon'] != null && $data['urlPath']['icon'] != '-' ? $data['urlPath']['icon'] : 'C';
					
					$siteType = explode(',', $data['urlRules']['siteType']);
					$userLevel = explode(',', $data['urlRules']['userLevel']);
					
					if(count($data['urlRules']) == 5) {
						$actionArray = explode(',', $data['urlRules'][2]);
						if($data['urlRules'][0] == $module && $data['urlRules'][1] == $controller && in_array($action, $actionArray) && in_array($setting->site_type, $siteType) && in_array(Yii::app()->user->level, $userLevel))
							echo '<li><a href="'.$link.'" title="'.Yii::t('phrase', $data['urlTitle']).'"><span class="icons">'.$icons.'</span>'.Yii::t('phrase', $data['urlTitle']).'</a></li>';
					} else {
						$actionArray = explode(',', $data['urlRules'][1]);
						if($data['urlRules'][0] == $controller && in_array($action, $actionArray) && in_array($setting->site_type, $siteType) && in_array(Yii::app()->user->level, $userLevel))
							echo '<li><a href="'.$link.'" title="'.Yii::t('phrase', $data['urlTitle']).'"><span class="icons">'.$icons.'</span>'.Yii::t('phrase', $data['urlTitle']).'</a></li>';					
					}
				}
				echo '</ul>';
			}
			echo '</li>';
		}
	}
	echo '</ul>';
} ?>
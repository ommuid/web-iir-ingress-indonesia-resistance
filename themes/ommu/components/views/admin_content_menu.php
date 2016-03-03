<?php
// Left Position
if($model != null) {
	echo '<ul class="left clearfix">';
	foreach($model as $val) {
		//list action
		$arrAction = explode(',', $val->action);
		$arrControllerAction = array();
		if(count($arrAction) > 1) {
			foreach($arrAction as $item) {
				$arrControllerAction[] = ($module !=null ? $module .'/' : '').Yii::app()->controller->id.'/'.$item;
			}
		} else {
			$arrControllerAction[] = ($module !=null ? $module .'/' : '').Yii::app()->controller->id.'/'.$val->action;				
		}
		
		//attr url					
		$arrAttrParams = array();
		if($val->attr != '-') {
			$arrAttr = explode(',', $val->attr);
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
						
					}else
						$arrAttrParams[$part[0]] = $part[1];
				}
			}
		}

		$link = $val->url != '-' ? Yii::app()->controller->createUrl($val->url, $arrAttrParams) : 'javascript:void(0);';
		$icons = $val->icon != '-' ? $val->icon : 'C';
	
		if (in_array($currentAction, $arrControllerAction)) {
			echo '<li><a href="'.$link.'" title="'.Phrase::trans($val->name, 2).'"><span class="icons">'.$icons.'</span>'.Phrase::trans($val->name, 2).'</a></li>';
		}
	}
	echo '</ul>';
} ?>
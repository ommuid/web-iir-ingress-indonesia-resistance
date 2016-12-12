<?php
	$menuRender = 0;
	if(($module == null && in_array($controller, array('admin'))) || ($module != null && ($module == 'report' && !in_array($controller, array('o/category')) || ($module == 'support' && (!in_array($currentAction, array('o/mail/setting')) && !in_array($controller, array('o/contact','o/contactcategory','o/widget'))))))) {
		$menuRender = 1;
		$title = 'Submenu';
		
	} elseif($module == null && in_array($controller, array('page','module','globaltag','anotherdetail','author','authorcontact','translate','menu'))) {
		$menuRender = 2;
		$title = 'Submenu';
		
	} elseif($module != null && $module == 'users') {
		$menuRender = 3;
		$title = 'Submenu';
		
	} elseif($module == null && in_array($controller, array('settings','language','theme','locale','meta','template','menucategory','zonecountry','zoneprovince','zonecity','zonedistrict','zonevillage')) || ($module != null && ($module == 'report' && in_array($controller, array('o/category')) || ($module == 'support' && (in_array($currentAction, array('o/mail/setting')) || in_array($controller, array('o/contact','o/contactcategory','o/widget'))))))) {
		$menuRender = 4;
		$title = 'Submenu';
	}
?>

<?php //begin.Main Menu ?>
<div class="mainmenu">
	<ul class="clearfix">
		<li <?php echo $menuRender == 1 ? 'class="active"' : ''; ?>><a class="dashboard" href="<?php echo Yii::app()->createUrl('admin/index');?>" title="<?php echo Yii::t('phrase', 'Dashboard');?>"><?php echo Yii::t('phrase', 'Dashboard');?></a></li>
		<li <?php echo $menuRender == 2 ? 'class="active"' : ''; ?>><a class="content" href="<?php echo Yii::app()->createUrl('page/manage');?>" title="<?php echo Yii::t('phrase', 'Content');?>"><?php echo Yii::t('phrase', 'Content');?></a></li>
		<?php 
			$plugin = OmmuPlugins::getPlugin(1, null, 'data');
			if($plugin != null) {
				foreach($plugin as $key => $val) {
					$menu = Utility::getPluginMenu($val->folder);
					if($menu != null) {
						//attr url					
						$arrAttrParams = array();
						if($menu[0][urlPath][attr] != null) {
							$arrAttr = explode(',', $menu[0][urlPath][attr]);
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
										
									} else {
										$arrAttrParams[$part[0]] = $part[1];
									}
								}
							}
						}

						$url = Yii::app()->createUrl($val->folder.'/'.$menu[0][urlPath][url], $arrAttrParams);
						//$titleApps = $val->name;
						$titleApps = $val->name;
						if($val->folder == $module) {
							$class = 'class="active"';
							$title = $val->name;
						} else
							$class = '';

						$item = '<li '.$class.'>';
						$item .= '<a href="'.$url.'" title="'.Yii::t('phrase', $titleApps).'">'.Yii::t('phrase', $titleApps).'</a>';						
						$item .= '</li>';
						echo $item;
					}
				}
			}
		?>
		<li <?php echo $menuRender == 3 ? 'class="active"' : ''; ?>><a class="member" href="<?php echo Yii::app()->user->level != 1 ? Yii::app()->createUrl('users/o/member/manage') : Yii::app()->createUrl('users/o/admin/manage') ?>" title="<?php echo Yii::t('phrase', 'Member');?>"><?php echo Yii::t('phrase', 'Member');?></a></li>
		<li <?php echo $menuRender == 4 ? 'class="active"' : ''; ?>><a class="setting" href="<?php echo Yii::app()->user->level == 1 ? Yii::app()->createUrl('settings/general') : Yii::app()->createUrl('support/o/contact/manage');?>" title="<?php echo Yii::t('phrase', 'Settings');?>"><?php echo Yii::t('phrase', 'Settings');?></a></li>
	</ul>
</div>
<?php //end.Main Menu ?>

<?php //begin.Submenu ?>
<div class="submenu">
	<h3><?php echo $title;?></h3>
	<ul>
	<?php if($menuRender == 1) { //Begin.Dashboard ?>
		<li <?php echo $currentAction == 'admin/dashboard' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('admin/dashboard');?>" title="<?php echo Yii::t('phrase', 'Summary');?>"><?php echo Yii::t('phrase', 'Summary');?></a></li>
		<?php 
		$core = OmmuPlugins::getPlugin(2, null, 'data');
		if($core != null) {
			foreach($core as $key => $val) {
				$menu = Utility::getPluginMenu($val->folder);
				if($menu != null) {
					if(count($menu) == 1) {
						$url = Yii::app()->createUrl($val->folder.'/'.$menu[0][urlPath][url]);
						$titleApps = $val->name;
						$urlArray = explode('/', $menu[0][urlPath][url]);
						if(count($urlArray) == 3)
							$class = $controller == $urlArray[0].'/'.$urlArray[1] ? 'class="selected"' : '';
						else
							$class = $controller == $urlArray[0] ? 'class="selected"' : '';
					} else {
						if($val->folder == $module) {
							$class = 'class="submenu-show"';
							$url = 'javascript:void(0);';
						} else {
							$class = '';
							$url = Yii::app()->createUrl($val->folder.'/'.$menu[0][urlPath][url]);
						}
						$titleApps = $val->name;
					}

					$item = '<li '.$class.'>';
					$item .= '<a href="'.$url.'" title="'.Yii::t('phrase', $titleApps).'">'.Yii::t('phrase', $titleApps).'</a>';
					if(count($menu) > 1) {
						$item .= '<ul>';
						foreach($menu as $key => $data) {
							$liClass = '';
							if($data[urlPath][url] != null) {
								$urlArray = explode('/', $data[urlPath][url]);
								if(count($urlArray) == 3)
									$liClass = $controller == $urlArray[0].'/'.$urlArray[1] ? 'class="selected"' : '';
								else
									$liClass = $controller == $urlArray[0] ? 'class="selected"' : '';
							}
							$icons = $data[urlPath][icon] != null ? $data[urlPath][icon] : 'C';
							$url = $data[urlPath][url] != null ? Yii::app()->createUrl($val->folder.'/'.$data[urlPath][url]) : 'javascript:void(0)';

							$item .= '<li '.$liClass.'><a href="'.$url.'" title="'.Yii::t('phrase', $data[urlTitle]).'"><span class="icons">'.$icons.'</span>'.Yii::t('phrase', $data[urlTitle]).'</a></li>';
						}	
						$item .= '</ul>';
					}
					$item .= '</li>';
					echo $item;
				}
			}
		}?>
		<li><a href="<?php echo Yii::app()->createUrl('users/o/admin/edit')?>" title="<?php echo Yii::t('phrase', 'Edit Account').': '.Yii::app()->user->displayname;?>"><?php echo Yii::t('phrase', 'Edit Account');?></a></li>
		<li><a href="<?php echo Yii::app()->createUrl('users/o/admin/password')?>" title="<?php echo Yii::t('phrase', 'Change Password').': '.Yii::app()->user->displayname;?>"><?php echo Yii::t('phrase', 'Change Password');?></a></li>

	<?php } elseif($menuRender == 2) { //Begin.Content ?>
		<li <?php echo $controller == 'page' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('page/manage');?>" title="<?php echo Yii::t('phrase', 'Pages');?>"><?php echo Yii::t('phrase', 'Pages');?></a></li>
		<?php if(Yii::app()->user->level == 1) {?>
			<li <?php echo $controller == 'module' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('module/manage');?>" title="<?php echo Yii::t('phrase', 'Modules');?>"><?php echo Yii::t('phrase', 'Modules');?></a></li>
		<?php }?>
		<li <?php echo $controller == 'globaltag' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('globaltag/manage');?>" title="<?php echo Yii::t('phrase', 'Tags');?>"><?php echo Yii::t('phrase', 'Tags');?></a></li>
		<?php if($setting->site_type == 1) {?>
			<li <?php echo ($module == null && in_array($controller, array('author','authorcontact'))) ? 'class="submenu-show"' : '';?>>
				<a href="<?php echo ($module == null && in_array($controller, array('author','authorcontact'))) ? 'javascript:void(0);' : Yii::app()->createUrl('author/manage');?>" title="<?php echo Yii::t('phrase', 'Authors');?>"><?php echo Yii::t('phrase', 'Authors');?></a>
				<?php if($module == null && in_array($controller, array('author','authorcontact'))) {?>
				<ul>
					<li <?php echo $controller == 'author' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('author/manage');?>" title="<?php echo Yii::t('phrase', 'Author');?>"><span class="icons">C</span><?php echo Yii::t('phrase', 'Author');?></a></li>
					<li <?php echo $controller == 'authorcontact' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('authorcontact/manage');?>" title="<?php echo Yii::t('phrase', 'Author Contact');?>"><span class="icons">C</span><?php echo Yii::t('phrase', 'Author Contact');?></a></li>
				</ul>
				<?php }?>
			</li>
		<?php }?>
		<?php if(Yii::app()->user->level == 1) {?>
		<li <?php echo $controller == 'menu' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('menu/manage');?>" title="<?php echo Yii::t('phrase', 'Menus');?>"><?php echo Yii::t('phrase', 'Menus');?></a></li>
		<?php }?>
		<li <?php echo $controller == 'translate' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('translate/manage');?>" title="<?php echo Yii::t('phrase', 'Translate');?>"><?php echo Yii::t('phrase', 'Translate');?></a></li>

	<?php } elseif($module != null && !in_array($module, array('users','report','support'))) {
		$menu = Utility::getPluginMenu($module);
		if($menu != null) {
			foreach($menu as $key => $val) {
				$siteType = explode(',', $val[urlRules][siteType]);
				$userLevel = explode(',', $val[urlRules][userLevel]);
				if(in_array(OmmuSettings::getInfo('site_type'), $siteType) && in_array(Yii::app()->user->level, $userLevel)) {
					$aClass = '';
					if($val[urlPath][url] != null) {
						$urlArray = explode('/', $val[urlPath][url]);
						if(count($urlArray) == 3)
							$aClass = $controller == $urlArray[0].'/'.$urlArray[1] ? 'class="active"' : '';
						else
							$aClass = $controller == $urlArray[0] ? 'class="active"' : '';
					}					
					$icons = $val[urlPath][icon] != null ? $val[urlPath][icon] : 'C';

					//attr url					
					$arrAttrParams = array();
					if($val[urlPath][attr] != null) {
						$arrAttr = explode(',', $val[urlPath][attr]);
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
									
								} else {
									$arrAttrParams[$part[0]] = $part[1];
								}
							}
						}
					}
					$submenu = $val[submenu];
					$class = $submenu != null ? 'class="submenu-show"' : '';
					$url = $val[urlPath][url] != null ? Yii::app()->createUrl($module.'/'.$val[urlPath][url], $arrAttrParams) : 'javascript:void(0)';
					
					echo '<li '.$class.'>';
					echo '<a '.$aClass.' href="'.$url.'" title="'.Yii::t('phrase', $val[urlTitle]).'">'.Yii::t('phrase', $val[urlTitle]).'</a>';
					if($submenu != null) {
						echo '<ul>';
						foreach($submenu as $key => $data) {
							$siteType = explode(',', $data[urlRules][siteType]);
							$userLevel = explode(',', $data[urlRules][userLevel]);
							if(in_array(OmmuSettings::getInfo('site_type'), $siteType) && in_array(Yii::app()->user->level, $userLevel)) {
								$subLiClass = '';
								if($data[urlPath][url] != null) {
									$urlArray = explode('/', $data[urlPath][url]);
									if(count($urlArray) == 3)
										$subLiClass = $controller == $urlArray[0].'/'.$urlArray[1] ? 'class="selected"' : '';
									else
										$subLiClass = $controller == $urlArray[0] ? 'class="selected"' : '';
								}
								$subIcons = $data[urlPath][icon] != null ? $data[urlPath][icon] : 'C';

								//attr url					
								$arrAttrParams = array();
								if($data[urlPath][attr] != null) {
									$arrAttr = explode(',', $data[urlPath][attr]);
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
												
											} else {
												$arrAttrParams[$part[0]] = $part[1];
											}
										}
									}
								}
								$url = $data[urlPath][url] != null ? Yii::app()->createUrl($module.'/'.$data[urlPath][url], $arrAttrParams) : 'javascript:void(0)';
								echo '<li '.$subLiClass.'><a href="'.$url.'" title="'.Yii::t('phrase', $data[urlTitle]).'"><span class="icons">'.$subIcons.'</span>'.Yii::t('phrase', $data[urlTitle]).'</a></li>';
							}								
						}
						echo '</ul>';
					}						
					echo '</li>';					
				}
			}
		}
		
	} elseif($menuRender == 3) { //Begin.Member 
		$menu = Utility::getPluginMenu('users');
		if($menu != null) {
			foreach($menu as $key => $val) {
				$siteType = explode(',', $val[urlRules][siteType]);
				$userLevel = explode(',', $val[urlRules][userLevel]);
				if(in_array(OmmuSettings::getInfo('site_type'), $siteType) && in_array(Yii::app()->user->level, $userLevel)) {
					$aClass = '';
					if($val[urlPath][url] != null) {
						$urlArray = explode('/', $val[urlPath][url]);
						if(count($urlArray) == 3)
							$aClass = $controller == $urlArray[0].'/'.$urlArray[1] ? 'class="active"' : '';
						else
							$aClass = $controller == $urlArray[0] ? 'class="active"' : '';					
					}					
					$icons = $val[urlPath][icon] != null ? $val[urlPath][icon] : 'C';

					//attr url					
					$arrAttrParams = array();
					if($val[urlPath][attr] != null) {
						$arrAttr = explode(',', $val[urlPath][attr]);
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
									
								} else {
									$arrAttrParams[$part[0]] = $part[1];
								}
							}
						}
					}				
					$submenu = $val[submenu];
					$class = $submenu != null ? 'class="submenu-show"' : '';
					$url = $val[urlPath][url] != null ? Yii::app()->createUrl($module.'/'.$val[urlPath][url], $arrAttrParams) : 'javascript:void(0)';
					
					echo '<li '.$class.'>';
					echo '<a '.$aClass.' href="'.$url.'" title="'.Yii::t('phrase', $val[urlTitle]).'">'.Yii::t('phrase', $val[urlTitle]).'</a>';
					if($submenu != null) {
						echo '<ul>';
						foreach($submenu as $key => $data) {
							$siteType = explode(',', $data[urlRules][siteType]);
							$userLevel = explode(',', $data[urlRules][userLevel]);
							if(in_array(OmmuSettings::getInfo('site_type'), $siteType) && in_array(Yii::app()->user->level, $userLevel)) {
								$subLiClass = '';
								if($data[urlPath][url] != null) {
									$urlArray = explode('/', $data[urlPath][url]);
									if(in_array($controller, array('o/history'))) {
										if(count($urlArray) == 3)
											$subLiClass = $controller == $urlArray[0].'/'.$urlArray[1] && $action == $urlArray[2] ? 'class="selected"' : '';
										else
											$subLiClass = $controller == $urlArray[0] && $action == $urlArray[1]  ? 'class="selected"' : '';								
									} else {
										if(count($urlArray) == 3)
											$subLiClass = $controller == $urlArray[0].'/'.$urlArray[1] ? 'class="selected"' : '';
										else
											$subLiClass = $controller == $urlArray[0] ? 'class="selected"' : '';
									}
								}
								$subIcons = $data[urlPath][icon] != null ? $data[urlPath][icon] : 'C';

								//attr url					
								$arrAttrParams = array();
								if($data[urlPath][attr] != null) {
									$arrAttr = explode(',', $data[urlPath][attr]);
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
												
											} else {
												$arrAttrParams[$part[0]] = $part[1];
											}
										}
									}
								}
								$url = $data[urlPath][url] != null ? Yii::app()->createUrl($module.'/'.$data[urlPath][url], $arrAttrParams) : 'javascript:void(0)';
								echo '<li '.$subLiClass.'><a href="'.$url.'" title="'.Yii::t('phrase', $data[urlTitle]).'"><span class="icons">'.$subIcons.'</span>'.Yii::t('phrase', $data[urlTitle]).'</a></li>';
							}
						}
						echo '</ul>';
					}						
					echo '</li>';
					
				}
			}
		}
	
	} elseif($menuRender == 4) { //Begin.Setting ?>
		<?php if(Yii::app()->user->level == 1) {?>
			<li <?php echo $currentAction == 'settings/general' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('settings/general');?>" title="<?php echo Yii::t('phrase', 'General Settings');?>"><?php echo Yii::t('phrase', 'General Settings');?></a></li>
			<?php if($setting->site_type == 1) {?>
				<li <?php echo $currentAction == 'settings/banned' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('settings/banned');?>" title="<?php echo Yii::t('phrase', 'Spam & Banning Tools');?>"><?php echo Yii::t('phrase', 'Spam & Banning Tools');?></a></li>				
			<?php }?>
			<li <?php echo $currentAction == 'settings/signup' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('settings/signup');?>" title="<?php echo Yii::t('phrase', 'Signup Settings');?>"><?php echo Yii::t('phrase', 'Signup Settings');?></a></li>
			<li <?php echo $controller == 'meta' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('meta/edit');?>" title="<?php echo Yii::t('phrase', 'Meta Settings');?>"><?php echo Yii::t('phrase', 'Meta Settings');?></a></li>
			<li <?php echo $currentAction == 'settings/analytic' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('settings/analytic');?>" title="<?php echo Yii::t('phrase', 'Google Analytics Settings');?>"><?php echo Yii::t('phrase', 'Google Analytics Settings');?></a></li>	
			<li <?php echo in_array($controller, array('language')) ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('language/manage');?>" title="<?php echo Yii::t('phrase', 'Language Settings');?>"><?php echo Yii::t('phrase', 'Language Settings');?></a></li>
			<li <?php echo in_array($controller, array('locale','zonecountry','zoneprovince','zonecity','zonedistrict','zonevillage')) ? 'class="submenu-show"' : '' ?>>
				<a <?php echo $controller == 'locale' ? 'class="active"' : '' ?> href="<?php echo Yii::app()->createUrl('locale/setting');?>" title="<?php echo Yii::t('phrase', 'Locale Settings');?>"><?php echo Yii::t('phrase', 'Locale Settings');?></a>
				<ul>
					<li <?php echo $controller == 'zonecountry' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('zonecountry/manage');?>" title="<?php echo Yii::t('phrase', 'Country');?>"><span class="icons">C</span><?php echo Yii::t('phrase', 'Country');?></a></li>
					<li <?php echo $controller == 'zoneprovince' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('zoneprovince/manage');?>" title="<?php echo Yii::t('phrase', 'Province');?>"><span class="icons">C</span><?php echo Yii::t('phrase', 'Province');?></a></li>
					<li <?php echo $controller == 'zonecity' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('zonecity/manage');?>" title="<?php echo Yii::t('phrase', 'City');?>"><span class="icons">C</span><?php echo Yii::t('phrase', 'City');?></a></li>
					<li <?php echo $controller == 'zonedistrict' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('zonedistrict/manage');?>" title="<?php echo Yii::t('phrase', 'Districts');?>"><span class="icons">C</span><?php echo Yii::t('phrase', 'Districts');?></a></li>
					<li <?php echo $controller == 'zonevillage' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('zonevillage/manage');?>" title="<?php echo Yii::t('phrase', 'Village');?>"><span class="icons">C</span><?php echo Yii::t('phrase', 'Village');?></a></li>
				</ul>
			</li>
			<li <?php echo ($currentAction == 'o/mail/setting' || $controller == 'template') ? 'class="submenu-show"' : '' ?>>
				<a <?php echo $currentAction == 'o/mail/setting' ? 'class="active"' : '' ?> href="<?php echo Yii::app()->createUrl('support/o/mail/setting');?>" title="<?php echo Yii::t('phrase', 'Mail Settings');?>"><?php echo Yii::t('phrase', 'Mail Settings');?></a>
				<ul>
					<li <?php echo $controller == 'template' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('template/manage');?>" title="<?php echo Yii::t('phrase', 'Template Email');?>"><span class="icons">C</span><?php echo Yii::t('phrase', 'Template Email');?></a></li>
				</ul>
			</li>
			<li <?php echo in_array($controller, array('o/contact','o/contactcategory','o/widget')) ? 'class="submenu-show"' : '' ?>>
				<a href="<?php echo Yii::app()->createUrl('support/o/contact/manage');?>" title="<?php echo Yii::t('phrase', 'Contact Settings');?>"><?php echo Yii::t('phrase', 'Contact Settings');?></a>
				<ul>
					<li <?php echo $controller == 'o/contact' && $action != 'setting' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('support/o/contact/manage');?>" title="<?php echo Yii::t('phrase', 'Manage Contact');?>"><span class="icons">C</span><?php echo Yii::t('phrase', 'Manage Contact');?></a></li>
					<li <?php echo $controller == 'o/contactcategory' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('support/o/contactcategory/manage');?>" title="<?php echo Yii::t('phrase', 'Contact Categories');?>"><span class="icons">C</span><?php echo Yii::t('phrase', 'Contact Categories');?></a></li>
					<li <?php echo $controller == 'o/contact' && $action == 'setting' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('support/o/contact/setting');?>" title="<?php echo Yii::t('phrase', 'Address Settings');?>"><span class="icons">C</span><?php echo Yii::t('phrase', 'Address Settings');?></a></li>
					<li <?php echo $controller == 'o/widget' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('support/o/widget/manage');?>" title="<?php echo Yii::t('phrase', 'Social Media Widget');?>"><span class="icons">C</span><?php echo Yii::t('phrase', 'SosMed Widget');?></a></li>
				</ul>				
			</li>
			<li <?php echo in_array($controller, array('o/category')) ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('report/o/category/manage');?>" title="<?php echo Yii::t('phrase', 'Report Settings');?>"><?php echo Yii::t('phrase', 'Report Settings');?></a></li>
			<li <?php echo $controller == 'menucategory' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('menucategory/manage');?>" title="<?php echo Yii::t('phrase', 'Menu Settings');?>"><?php echo Yii::t('phrase', 'Menu Settings');?></a></li>
			<li <?php echo $controller == 'theme' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('theme/manage');?>" title="<?php echo Yii::t('phrase', 'Theme Settings');?>"><?php echo Yii::t('phrase', 'Theme Settings');?></a></li>
		<?php } else {?>
			<li <?php echo in_array($controller, array('o/contact','o/contactcategory')) ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('support/o/contact/manage');?>" title="<?php echo Yii::t('phrase', 'Contact Settings');?>"><?php echo Yii::t('phrase', 'Contact Settings');?></a></li>
			<li <?php echo $controller == 'template' ? 'class="selected"' : '' ?>><a href="<?php echo Yii::app()->createUrl('template/manage');?>" title="<?php echo Yii::t('phrase', 'Template Email');?>"><?php echo Yii::t('phrase', 'Template Email');?></a></li>
		<?php }?> 
	<?php }?>
	</ul>
</div>
<?php //end.Submenu ?>
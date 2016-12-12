<?php
/**
 * Ommu class file
 * Bootstrap application
 * in this class you set default controller to be executed first time
 *
 * Reference start
 *
 * TOC :
 *	init
 *	getDefaultTheme
 *	getRulePos
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @create date August 6, 2012 15:02 WIB
 * @updated date February 20, 2014 15:50 WIB
 * @version 1.0.9
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contect (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */
Yii::import('application.components.plugin.Spyc');
define('DS', DIRECTORY_SEPARATOR);

class Ommu extends CApplicationComponent
{
	/**
	 * Initialize
	 *
	 * load some custom components here, for example
	 * theme, url manager, or config from database Alhamdulillah :)
	 */
	public function init() {
		/**
		 * set default themes
		 */
		$theme = $this->getDefaultTheme();
		if(isset($_GET['theme'])) {
			$theme = trim($_GET['theme']);
		}
		Yii::app()->theme = $theme;
		
		/**
		 * controllerMap
		 */
		$themePath = Yii::getPathOfAlias('webroot.themes.'.$theme).DS.$theme.'.yaml';
		$arrayThemeSpyc = Spyc::YAMLLoad($themePath);
		$controllerSpyc = $arrayThemeSpyc['controller'];
		if(!empty($controllerSpyc)) {
			foreach($controllerSpyc as $key => $val)
				$controllerMap[$key] = 'webroot.themes.'.$theme.'.controllers.'.$val;
			Yii::app()->controllerMap = $controllerMap;
		}

		/**
		 * set url manager
		 */
		$rules = array(
			//a standard rule mapping '/' to 'site/index' action
			'' 																	=> 'site/index',
			
			//a standard rule mapping '/login' to 'site/login', and so on
			'<action:(login|logout)>' 											=> 'site/<action>',
			'<id:\d+>-<t:[\w\-]+>/<static:[\w\-]+>-<picture:[\w\-]+>'			=> 'page/view',
			'<id:\d+>-<t:[\w\-]+>'												=> 'page/view',
			//'<id:\d+>-<t:[\w\-]+>'											=> 'maintenance/page',
			
			// Article
			'<module:\w+>/<controller:\w+>/<t:[\w\-]+>-<id:\d+>/<category:\d+>'		=> '<module>/<controller>/index',			
			'<module:\w+>/<controller:\w+>/<t:[\w\-]+>/<category:\d+>'				=> '<module>/<controller>/index',
			'<module:\w+>/<controller:\w+>/<t:[\w\-]+>-<id:\d+>'					=> '<module>/<controller>/index',
			'<module:\w+>/<controller:\w+>/<id:\d+>'								=> '<module>/<controller>/index',
			'<module:\w+>/<controller:\w+>'											=> '<module>/<controller>/index',
			
			'<module:\w+>/<controller:\w+>/view/<t:[\w\-]+>-<id:\d+>/<photo:\d+>'		=> '<module>/<controller>/view',
			'<module:\w+>/<controller:\w+>/view/<t:[\w\-]+>-<id:\d+>'					=> '<module>/<controller>/view',
			
			'<module:\w+>/<controller:\w+>/<action:\w+>/<t:[\w\-]+>-<id:\d+>'		=> '<module>/<controller>/<action>',
			'<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'					=> '<module>/<controller>/<action>',
			'<module:\w+>/<controller:\w+>/<action:\w+>'							=> '<module>/<controller>/<action>',
			'<module:\w+>/<controller:\w+>'											=> '<module>/<controller>',
			
			//controller condition
			'<controller:\w+>/<t:[\w\-]+>-<id:\d+>/<category:\d+>'					=> '<controller>/index',			
			'<controller:\w+>/<t:[\w\-]+>/<category:\d+>'							=> '<controller>/index',
			'<controller:\w+>/<t:[\w\-]+>-<id:\d+>'									=> '<controller>/index',
			'<controller:\w+>/<id:\d+>'												=> '<controller>/index',
			'<controller:\w+>'														=> '<controller>/index',
			
			'<controller:\w+>/view/<t:[\w\-]+>-<id:\d+>/<photo:\d+>'					=> '<controller>/view',
			'<controller:\w+>/view/<t:[\w\-]+>-<id:\d+>'								=> '<controller>/view',
			
			'<controller:\w+>/<action:\w+>/<t:[\w\-]+>-<id:\d+>'				=> '<controller>/<action>',
			'<controller:\w+>/<action:\w+>/<id:\d+>'							=> '<controller>/<action>',
			'<controller:\w+>/<action:\w+>'										=> '<controller>/<action>',
			//'<controller:\w+>/<action:\w+>'									=> '<controller>/<action>',
			'<controller:\w+>'													=> '<controller>', 
		);

		/**
		 * Set default controller for homepage, it can be controller, action or module
		 * example:
		 * controller: 'site'
		 * controller from module: 'pose/site/index'.
		 */
		$default = OmmuPlugins::model()->findByAttributes(array('defaults' => 1), array(
			'select' => 'folder',
		));
		if(($default == null) || ($default->folder == '-') || ($default->actived == '2')) {
			$rules[''] = 'site/index';

		} else {
			$url = $default->folder != '-' ? $default->folder : 'site/index';
			Yii::app()->defaultController = trim($url);
			$rules[''] =  trim($url);
		}

		/**
		 * Split rules into 2 part and then insert url from tabel between them.
		 * and then merge all array back to $rules.
		 */
		$module = OmmuPlugins::model()->findAll(array(
			'select'    => 'folder',
			'condition' => 'actived != 0',
		));

		$moduleRules  = array();
		$sliceRules   = $this->getRulePos($rules);
		if($module !== null) {
			foreach($module as $key => $val) {
				$moduleRules[$val->folder] = $val->folder;
			}
		}
		$rules = array_merge($sliceRules['before'], $moduleRules, $sliceRules['after']);

		Yii::app()->setComponents(array(
			'urlManager' => array(
				'urlFormat' => 'path',
				'showScriptName' => false,
				'rules' => $rules,
			),
		));

		Yii::setPathOfAlias('modules', Yii::app()->basePath.DIRECTORY_SEPARATOR.'modules');
		
		/**
		 * Registers meta tags declared
		 * google discoverability
		 * google plus
		 * facebook opengraph
		 * twitter
		 */
		$meta = OmmuMeta::model()->findByPk(1);
		$images = $meta->meta_image != '' ? $meta->meta_image : 'meta_default.png';
		$metaImages = Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->request->baseUrl.'/public/'.$images;
		
		// Google Discoverability mata tags
		$point = explode(',', $meta->office_location);
		
		// Facebook mata tags
		$arrayFacebookGlobal = array(
			'og:type'=>$meta->facebook_type == 1 ? 'profile' : 'website',
			'og:title'=>'MY_WEBSITE_NAME',
			'og:description'=>'MY_WEBSITE_DESCRIPTION',
			'og:image'=>$metaImages,
		);
		if($meta->facebook_sitename != '')
			$arrayFacebookGlobal['og:site_name'] = $meta->facebook_sitename;
		if($meta->facebook_see_also != '')
			$arrayFacebookGlobal['og:see_also'] = $meta->facebook_see_also;
		if($meta->facebook_admins != '')
			$arrayFacebookGlobal['fb:admins'] = $meta->facebook_admins;
		
		if($meta->facebook_type == 1) {
			$arrayFacebook = array(
				'profile:first_name'=>$meta->facebook_profile_firstname,
				'profile:last_name'=>$meta->facebook_profile_lastname,
				'profile:username'=>$meta->facebook_profile_username,
			);	
		} else {
			$arrayFacebook = array();
		}
		
		// Twitter mata tags
		if($meta->twitter_card == 1) {
			$cardType = 'summary';
			$arrayTwitter = array();
		} else if($meta->twitter_card == 2) {
			$cardType = 'summary_large_image';
			$arrayTwitter = array();
		} else if($meta->twitter_card == 3) {
			$cardType = 'photo';
			$arrayTwitter = array(
				'twitter:image:width'=>$meta->twitter_photo_width,
				'twitter:image:height'=>$meta->twitter_photo_height,
			);
		} else {
			$cardType = 'app';
			if($meta->twitter_country != '')
				$arrayTwitter['twitter:app:country'] = $meta->twitter_country;
			if($meta->twitter_iphone_name != '')
				$arrayTwitter['twitter:app:name:iphone'] = $meta->twitter_iphone_name;
			if($meta->twitter_iphone_id != '')
				$arrayTwitter['twitter:app:id:iphone'] = $meta->twitter_iphone_id;
			if($meta->twitter_iphone_url != '')
				$arrayTwitter['twitter:app:url:iphone'] = $meta->twitter_iphone_url;
			if($meta->twitter_ipad_name != '')
				$arrayTwitter['twitter:app:name:ipad'] = $meta->twitter_ipad_name;
			if($meta->twitter_ipad_id != '')
				$arrayTwitter['twitter:app:id:ipad'] = $meta->twitter_ipad_id;
			if($meta->twitter_ipad_url != '')
				$arrayTwitter['twitter:app:url:ipad'] = $meta->twitter_ipad_url;
			if($meta->twitter_googleplay_name != '')
				$arrayTwitter['twitter:app:name:googleplay'] = $meta->twitter_googleplay_name;
			if($meta->twitter_googleplay_id != '')
				$arrayTwitter['twitter:app:id:googleplay'] = $meta->twitter_googleplay_id;
			if($meta->twitter_googleplay_url != '')
				$arrayTwitter['twitter:app:url:googleplay'] = $meta->twitter_googleplay_url;
			
			if(empty($arrayTwitter))
				$arrayTwitter = array();
		}
		$arrayTwitterGlobal = array(
			'twitter:card'=>$cardType,
			'twitter:site'=>$meta->twitter_site,
			'twitter:title'=>'MY_WEBSITE_NAME',
			'twitter:description'=>'MY_WEBSITE_DESCRIPTION',
			'twitter:image'=>$metaImages,
		);
		if(in_array($meta->twitter_card, array(2)))
			$arrayTwitterGlobal['twitter:creator'] = $meta->twitter_creator;
		if($meta->meta_image_alt != '' && in_array($meta->meta_image_alt, array(1,2)))
			$arrayTwitterGlobal['twitter:image:alt'] = $meta->meta_image_alt;
		
		/**
		 * Registe Meta Tags
		 */ 
		Yii::app()->setComponents(array(
			'meta'=>array(
				'class' => 'application.components.plugin.MetaTags',
				'googleOwnerTags'=>array(	// set default OG tags
					'place:location:latitude'=>$point[0],
					'place:location:longitude'=>$point[1],
					'business:contact_data:street_address'=>$meta->office_place.', '.$meta->office_village.', '.$meta->office_district,
					'business:contact_data:country_name'=>$meta->view_meta->country,					
					'business:contact_data:locality'=>$meta->view_meta->city,
					'business:contact_data:region'=>$meta->office_district,
					'business:contact_data:postal_code'=>$meta->office_zipcode,
					'business:contact_data:email'=>$meta->office_email,
					'business:contact_data:phone_number'=>$meta->office_phone,
					'business:contact_data:fax_number'=>$meta->office_fax,
					'business:contact_data:website'=>$meta->office_website,
				),
				'googlePlusTags'=>array(	// set default OG tags
					'name'=>'MY_WEBSITE_NAME',
					'description'=>'MY_WEBSITE_DESCRIPTION',
					'image'=>$metaImages,
				),
				'facebookTags'=>CMap::mergeArray(
					$arrayFacebookGlobal,
					$arrayFacebook
				),
				'twitterTags'=>CMap::mergeArray(
					$arrayTwitterGlobal,
					$arrayTwitter
				),
			),
		));
	}

	/**
	 * Get default theme from database
	 *
	 * @return string theme name
	 */
	public function getDefaultTheme() {
		$theme = OmmuThemes::model()->find(array(
			'select'    => 'folder',
			'condition' => 'group_page= :group AND default_theme= "1"',
			'params'    => array(':group' => 'public'),
		));

		if($theme !== null)
			return $theme->folder;
		else
			return null;
	}

	/**
	 * Split rules into two part
	 *
	 * @param array $rules
	 * @return array
	 */
	public function getRulePos($rules) {
		$result = 1;
		$before = array();
		$after  = array();

		foreach($rules as $key => $val) {
			if($key == '<controller:\w+>')
				break;
			$result++;
		}

		$i = 1;
		foreach($rules as $key => $val) {
			if($i < $result) {
				$before[$key] = $val;
			}elseif($i >= $pos) {
				$after[$key]  = $val;
			}
			$i++;
		}

		return array('after' => $after, 'before' => $before);
	}
}

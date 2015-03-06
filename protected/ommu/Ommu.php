<?php
/**
 * Ommu class file
 *
 * Bootstrap application
 * in this class you set default controller to be executed first time
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @create date August 6, 2012 15:02 WIB
 * @updated date February 20, 2014 15:50 WIB
 * @version 1.0.9
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 */

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
		 * set url manager
		 */
		$rules = array(
			//a standard rule mapping '/' to 'site/index' action
			'' 															=> 'site/index',
			
			//a standard rule mapping '/login' to 'site/login', and so on
			'<action:(login|logout)>' 									=> 'site/<action>',
			
			//controller condition
			'<id:\d+>-<t:[\w\-]+>'										=> 'page/view',
			'<id:\d+>-<t:[\w\-]+>'										=> 'maintenance/page',
			'<controller:\w+>/view/<id:\d+>-<t:[\w\-]+>'				=> '<controller>/view',
			//'<controller:\w+>/<action:\w+>'							=> '<controller>/<action>',
			
			//module condition
			'<module:\w+>-<controller:\w+>/<t:[\w\-]+>-<id:\d+>-<photo:\d+>'	=> '<module>/<controller>/view',
			'<module:\w+>-<controller:\w+>/<t:[\w\-]+>-<id:\d+>'	=> '<module>/<controller>/view',
			//'<module:\w+>/<controller:\w+>/<action:\w+>'				=> '<module>/<controller>/<action>',
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
			'og:site_name'=>$meta->facebook_sitename,
			'og:see_also'=>$meta->facebook_see_also,
			'fb:admins'=>$meta->facebook_admins,
		);
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
			$arrayTwitter = array(
				'twitter:app:id:iphone'=>$meta->twitter_iphone_id,
				'twitter:app:url:iphone'=>$meta->twitter_iphone_url,
				'twitter:app:name:ipad'=>$meta->twitter_ipad_name,
				'twitter:app:url:ipad'=>$meta->twitter_ipad_url,
				'twitter:app:id:googleplay'=>$meta->twitter_googleplay_id,
				'twitter:app:url:googleplay'=>$meta->twitter_googleplay_url,
			);
		}
		$arrayTwitterGlobal = array(
			'twitter:card'=>$cardType,
			'twitter:site'=>$meta->twitter_card != 4 ? $meta->twitter_site : '',
			'twitter:creator'=>$meta->twitter_card != 4 ? $meta->twitter_creator : '',
			'twitter:title'=>'MY_WEBSITE_NAME',
			'twitter:description'=>'MY_WEBSITE_DESCRIPTION',
			'twitter:image:src'=>$metaImages,
		);
		
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
					'business:contact_data:country_name'=>OmmuZoneCountry::getInfo($meta->office_country, 'country'),
					'business:contact_data:locality'=>OmmuZoneCity::getInfo($meta->office_city, 'city'),
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

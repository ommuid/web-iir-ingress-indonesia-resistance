<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contect (+62)856-299-4114
 *
 */

$module = strtolower(Yii::app()->controller->module->id);
$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
$currentModule = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id);
$currentModuleAction = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);

class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = 'default';

	/**
	 * admin controller
	 */
	public $trashOption = false;
	public $searchOption = false;

	/**
	 * front controller
	 *
	 * Dialog Condition
	 *	example (action in controller)
	 *
	 *	$this->dialogDetail = true;
	 *	$this->dialogWidth = int; int => ???
	 *	$this->dialogGroundUrl = url;
	 *
	 */
	public $dialogDetail = false;
	public $dialogWidth = '';
	public $dialogGroundUrl = '';
	
	/**
	 * Other Content
	 *	example (action in controller)
	 *
	 *	$this->contentOther = true;
	 *	$this->contentAttribute=array(
	 *		array('type' => 0, 'id' => '1', 'data' => '1'),			//content
	 *		array('type' => 1, 'id' => '2', 'url' => '2'),			//render partial
	 *	);
	 *
	 */
	public $contentType = false;
	public $contentOther = false;
	public $contentAttribute = array();

	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();

	/**
	 * Custom Variable
	 *
	 *	language condition
	 */
	public $langOptions = array();
	public $lang;
	
	public $pageTitleShow = false;
	public $pageDescriptionShow = false;
	public $pageGuest = false;
	public $dialogFixed = false;
	public $dialogFixedClosed = array();
	
	public $ownerId = '';	
	public $adsSidebar = true;

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();
	public $pageDescription;
	public $pageMeta;
	public $pageImage;

	public function render($view, $data = null, $return = false) {
		if ($this->beforeRender($view)) {
			/**
			 * Custom condition
			 ** 
			 * guest page
			 * registers all meta tags
			 * unset session user_id (after register)
			 * set theme is active
			 * Set comment plugin_id
			 * Set owner and user info
			 *
			 */
			 
			// set language sessions
			if(isset($_GET['lang']) && $_GET['lang'] != '')
				Yii::app()->session['language'] = $_GET['lang'];
		
			// guest page
			if($this->dialogFixed == true)
				$this->pageGuest = true;
			
			// registers all meta tags
			if(!Yii::app()->request->isAjaxRequest) {
				$meta = OmmuMeta::model()->findByPk(1,array(
					'select' => 'office_on, google_on, twitter_on, facebook_on'
				));
				if($meta->office_on == 1)
					Yii::app()->meta->renderGoogleOwnerMetaTags();
				if($meta->google_on == 1)
					Yii::app()->meta->renderGooglePlusMetaTags();
				if($meta->facebook_on == 1)
					Yii::app()->meta->renderFacebookMetaTags();
				if($meta->twitter_on == 1)
					Yii::app()->meta->renderTwitterMetaTags();
			}
			
			// unset session user_id (after register)
			if(isset(Yii::app()->session['signup_user_id']) && ($currentModule != 'users/signup' || $currentModuleAction == 'users/signup/success'))
				unset(Yii::app()->session['signup_user_id']);
			
			// set theme is active
			if(!Yii::app()->request->isAjaxRequest) {
				Yii::app()->session['theme_active'] = Yii::app()->theme->name;
				if($this->dialogDetail == true)
					Yii::app()->session['current_url'] = $this->dialogGroundUrl;
			}
			
			// Set owner and user info
			if (empty($this->ownerId)) {
				$owner = !Yii::app()->user->isGuest ? 'Hi, '.Yii::app()->user->displayname : 'Hi, Guest';
				Yii::app()->params['owner_id'] = '';
			} else {
				$user = Users::model()->findByPk($this->ownerId, array(
					'select' => 'displayname',
				));
				$owner = $user->displayname;
				Yii::app()->params['owner_id'] = $this->ownerId;
			}
			Yii::app()->params['owner'] = $owner;
			
			parent::render($view, $data, $return);
		}
	}
 
	/**
	 * Meta description and keyword generate
	 */
	protected function beforeRender($view)
	{
		$model = OmmuSettings::model()->findByPk(1,array(
			'select' => 'site_title, site_keywords, site_description'
		));
		if(!Yii::app()->request->isAjaxRequest) {
			if(parent::beforeRender($view)) {
				// Ommu custom description and keyword
				if (!empty($this->pageDescription))
					$description = $this->pageDescription;
				else
					$description = $model->site_description;
				Yii::app()->clientScript->registerMetaTag(Utility::hardDecode($description), 'description');
		
				if (!empty($this->pageMeta))
					$keywords = $model->site_keywords.','.$this->pageMeta;
				else
					$keywords = $model->site_keywords;
				Yii::app()->clientScript->registerMetaTag(Utility::hardDecode($keywords), 'keywords');
				
				/**
				 * Facebook open graph and all custom metatags
				 * @title
				 * @description
				 * @image
				 */ 
				// title
				Yii::app()->meta->googlePlusTags['name'] = 
				Yii::app()->meta->facebookTags['og:title'] = 
				Yii::app()->meta->twitterTags['twitter:title'] = 
				CHtml::encode($this->pageTitle).' | '.$model->site_title; 
				// description
				Yii::app()->meta->googlePlusTags['description'] = 
				Yii::app()->meta->facebookTags['og:description'] = 
				Yii::app()->meta->twitterTags['twitter:description'] = 
				ucfirst(strtolower($description));
				// image
				if (!empty($this->pageImage)) {
					Yii::app()->meta->facebookTags['og:image'] = 
					Yii::app()->meta->googlePlusTags['image'] = 
					Yii::app()->meta->twitterTags['twitter:image:src'] = 
					Utility::getProtocol().'://'.Yii::app()->request->serverName.$this->pageImage; 
				}
				// language
				$this->lang = Utility::getLanguage();
				Yii::app()->setLanguage($this->lang);
			}
			
		} else {
			$this->pageDescription = $this->pageDescription != '' ? ucfirst(strtolower($this->pageDescription)) : $model->site_description;
			$this->pageMeta = $this->pageMeta != '' ? $model->site_keywords.', '.$this->pageMeta : $model->site_keywords;
		}
		$this->pageTitle = $this->pageTitle != '' ? $this->pageTitle : 'Titlenya Lupa..';
		return true;
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$this->pageGuest = true;
		$this->adsSidebar = false;
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('application.webs.site.front_error', $error);
		} else {
			$this->render('application.webs.site.front_error', $error);
		}
	}
}
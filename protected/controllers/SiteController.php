<?php
/**
* SiteController
* Handle SiteController
* Copyright (c) 2013, Ommu Platform (ommu.co). All rights reserved.
* version: 2.0.0
* Reference start
*
* TOC :
*	Error
*	Index
*	Login
*	Logout
*	Contact
*	SendEmail
*
*	LoadModel
*	performAjaxValidation
*
* @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
* @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
* @link http://company.ommu.co
* @contact (+62)856-299-4114
*
*----------------------------------------------------------------------------------------------------------
*/

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * Initialize public template
	 */
	public function init() 
	{
		$arrThemes = Utility::getCurrentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
		//$this->pageGuest = true;
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('front_error', $error);
		} else {
			$this->render('front_error', $error);
		}
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'

		//$this->ownerId = 2;
		$setting = OmmuSettings::model()->findByPk(1,array(
			'select' => 'online, construction_date',
		));
		//$this->redirect(Yii::app()->createUrl('project/site/index'));

		if(($setting->online == 0 && date('Y-m-d', strtotime($setting->construction_date)) > date('Y-m-d')) && (Yii::app()->user->isGuest || (!Yii::app()->user->isGuest && in_array(!Yii::app()->user->level, array(1,2))))) {
			$this->redirect(Yii::app()->createUrl('maintenance/index'));

		} else {
			/* if(!Yii::app()->user->isGuest) {
				$this->redirect(Yii::app()->createUrl('pose/site/index'));
			} else {
				$render = 'front_index';
			} */

			$this->pageTitle = '';
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('front_index', array(
				'setting'=>$setting,
			));
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if(!Yii::app()->user->isGuest) {
			$this->redirect(array('site/index'));

		} else {
			$setting = OmmuSettings::getInfo('site_type');
			if($setting == 1) {
				$arrThemes = Utility::getCurrentTemplate('public');
				Yii::app()->theme = $arrThemes['folder'];
				$this->layout = $arrThemes['layout'];
				
				$model=new LoginForm;
				$modelForm = 'LoginForm';
				$title = Phrase::trans(411,0);
				$desc = '';
				$render = 'front_login';
			} else {
				$arrThemes = Utility::getCurrentTemplate('admin');
				Yii::app()->theme = $arrThemes['folder'];
				$this->layout = $arrThemes['layout'];
				
				$model=new LoginFormAdmin;
				$modelForm = 'LoginFormAdmin';
				$title = Phrase::trans(411,0);
				$desc = '';
				$render = 'admin_login';
			}

			// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='login-form') {
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}

			// collect user input data
			if(isset($_POST[$modelForm]))
			{
				$model->attributes=$_POST[$modelForm];
				
				if($setting == 1) {
					if(!isset($_GET['email'])) {
						$model->scenario = 'loginemail';
					} else {
						$model->scenario = 'loginpassword';
					}
				}

				$jsonError = CActiveForm::validate($model);
				if(strlen($jsonError) > 2) {
					echo $jsonError;

				} else {
					if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
						if($setting == 1) {
							if(!isset($_GET['email'])) {
								if($model->validate()) {
									echo CJSON::encode(array(
										'type' => 5,
										'get' => Yii::app()->createUrl('site/login', array('email'=>$model->email)),
									));
								} else {
									print_r($model->getErrors());
								}
							} else {
								// validate user input and redirect to the previous page if valid
								if($model->validate() && $model->login()) {
									Users::model()->updateByPk(Yii::app()->user->id, array(
										'lastlogin_date'=>date('Y-m-d H:i:s'), 
										'lastlogin_ip'=>$_SERVER['REMOTE_ADDR'],
									));
									
									echo CJSON::encode(array(
										'redirect' => Yii::app()->user->level == 1 ? Yii::app()->createUrl('admin/index') : Yii::app()->user->returnUrl,
									));
								} else {
									print_r($model->getErrors());
								}
							}
						
						} else {
							// validate user input and redirect to the previous page if valid
							if($model->validate() && $model->login()) {
								Users::model()->updateByPk(Yii::app()->user->id, array(
									'lastlogin_date'=>date('Y-m-d H:i:s'), 
									'lastlogin_ip'=>$_SERVER['REMOTE_ADDR'],
								));
								if(isset($_GET['type'])) {
									echo CJSON::encode(array(
										'type' => 6,
									));
								} else {
									echo CJSON::encode(array(
										'redirect' => Yii::app()->user->level == 1 ? Yii::app()->createUrl('admin/index') : Yii::app()->user->returnUrl,
									));
								}
								//$this->redirect(Yii::app()->user->returnUrl);
							} else {
								print_r($model->getErrors());
							}
						}
					}
				}
				Yii::app()->end();
				
			}
			
			if($setting == 1) {
				// display the login form
				$this->dialogDetail = true;
				$this->dialogGroundUrl = Yii::app()->createUrl('site/index');

				$this->dialogFixed = true;
				if(!isset($_GET['email'])) {
					$this->dialogFixedClosed=array(
						Phrase::trans(596,0)=>Yii::app()->createUrl('users/signup/index'),
					);
				} else {
					$this->dialogFixedClosed=array(
						Phrase::trans(597,0)=>Yii::app()->createUrl('users/forgot/get'),
					);
				}		
				
			} else {
				// display the login form
				$this->dialogDetail = true;
				$this->dialogWidth = 600;
			}
			
			$this->pageTitle = $title;
			$this->pageDescription = $desc;
			$this->pageMeta = '';
			$this->render($render,array(
				'model'=>$model,
			));
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionSendEmail()
	{
		SupportMailSetting::sendEmail('putra.sudaryanto@gmail.com', 'Putra Sudaryanto', 'testing', 'testing', 1);	
	}
}
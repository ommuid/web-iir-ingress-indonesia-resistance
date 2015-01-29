<?php
/**
* ForgotController
* Handle ForgotController
* Copyright (c) 2013, Ommu Platform (ommu.co). All rights reserved.
* version: 2.0.0
* Reference start
*
* TOC :
*	Index
*	Photo
*	Invite
*	Success
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

class SignupController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $defaultAction = 'index';

	/**
	 * Initialize admin page theme
	 */
	public function init() 
	{
		$setting = OmmuSettings::model()->findByPk(1, array(
			'select' => 'site_type',
		));
		
		if($setting->site_type == 0) {
			$this->redirect(Yii::app()->createUrl('site/index'));
		} else {
			if(!Yii::app()->user->isGuest) {
				$this->redirect(Yii::app()->createUrl('site/login'));
			}
		}

		$arrThemes = Utility::getCurrentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
		$this->dialogFixed = true;
	}	

	/**
	 * @return array action filters
	 */
	public function filters() 
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() 
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','photo','invite','success'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level == 1)',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex() 
	{
		$setting = OmmuSettings::model()->findByPk(1, array(
			'select' => 'signup_username, signup_photo, signup_random, signup_invitepage, signup_inviteonly, signup_checkemail',
		));

		$model=new Users;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users'])) {
			$model->attributes=$_POST['Users'];
			$model->scenario = 'signup';

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						Yii::app()->session['signup_user_id'] = $model->user_id;
						if($setting->signup_photo == 0 && $setting->signup_invitepage == 0) {
							$url = Yii::app()->controller->createUrl('success',array('name'=>urlencode($model->displayname), 'email'=>$model->email));
						} else {
							if($setting->signup_photo == 1) {
								$url = Yii::app()->controller->createUrl('photo');
							} else {
								if($setting->signup_invitepage == 1) {
									$url = Yii::app()->controller->createUrl('invite');
								}
							}
						}
						echo CJSON::encode(array(
							'type' => 5,
							'get' => $url,
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
		}

		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->createUrl('site/index');
		
		$this->pageTitle = Phrase::trans(16193,1);
		$this->pageDescription = ''; //Phrase::trans(16194,1)
		$this->pageMeta = '';
		$this->render('front_index',array(
			'model'=>$model,
			'setting'=>$setting,
		));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionPhoto() 
	{
		$setting = OmmuSettings::model()->findByPk(1, array(
			'select' => 'signup_invitepage',
		));
		$model = Users::model()->findByPk(Yii::app()->session['signup_user_id'], array(
			'select' => 'user_id, email, displayname, photo_id',
		));
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->createUrl('site/index');
		
		if($setting->signup_invitepage == 1) {
			$this->dialogFixedClosed=array(
				'Skip, Next to invite'=>Yii::app()->controller->createUrl('invite'),
			);
		} else {
			$this->dialogFixedClosed=array(
				'Skip Add Photo'=>Yii::app()->controller->createUrl('success', array('name'=>urlencode($model->displayname), 'email'=>$model->email)),
			);
		}
		
		$this->pageTitle = Phrase::trans(16225,1);
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('front_photo',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionInvite() 
	{
		$model = Users::model()->findByPk(Yii::app()->session['signup_user_id'], array(
			'select' => 'user_id, email, displayname, photo_id',
		));
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->createUrl('site/index');
		
		$this->dialogFixedClosed=array(
			'Skip Invite'=>Yii::app()->controller->createUrl('success', array('name'=>urlencode($model->displayname), 'email'=>$model->email)),
		);
		
		$this->pageTitle = '';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('front_invite',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionSuccess() 
	{
		unset(Yii::app()->session['signup_user_id']);
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->createUrl('site/index');
		
		$this->pageTitle = Phrase::trans(16227,1);
		$this->pageDescription = Phrase::trans(16226,1, array($_GET['name'], $_GET['email']));
		$this->pageMeta = '';
		$this->render('front_success');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404, Phrase::trans(193,0));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) 
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

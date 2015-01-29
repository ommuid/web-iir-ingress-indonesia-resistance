<?php
/**
* VerifyController
* Handle VerifyController
* Copyright (c) 2013, Ommu Platform (ommu.co). All rights reserved.
* version: 2.0.0
* Reference start
*
* TOC :
*	Index
*	Code
*	Get
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

class VerifyController extends Controller
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
				'actions'=>array('index','code','get'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
				//'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level != 1)',
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
		$this->redirect(Yii::app()->createUrl('site/index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionCode() 
	{
		/**
		 * example get link
		 * http://localhost/nirwasita_20130123/users/verify/code/key/hiHIDEdefgqrwxstwxBCfgnorsFGbckmbcmnnouvfgabzAEFfgophiqrFGqrpqab/secret/ijyzBCGHwxopcddeCDuvwxtufgzAuvst
		 * secret = salt[Users]
		 * key = code[UserVerify]
		 */

		if(isset($_GET['key']) && isset($_GET['secret'])) {
			$secret = Users::model()->findByAttributes(array('salt' => $_GET['secret']), array(
				'select' => 'user_id, email',
			));
			$key = UserVerify::model()->findByAttributes(array('code' => $_GET['key']), array(
				'select' => 'verify_id, user_id, verify_date',
			));

			if($key == null || $secret == null) {
				$render = 1;
			} else {
				if($secret->email == $key->user->email) {
					if(Utility::getDifferenceDay($key->verify_date, date('Y-m-d H:i:s')) > 3) {
						$key->delete();
						$render = 3;
					} else {
						if($key->delete()) {
							$user = Users::model()->findByPk($secret->user_id, array(
								'select' => 'user_id, email, displayname',
							));
							$user->verified = 1;
							if($user->update()) {
								$render = 4;
							}
						}
					}
				} else {
					$render = 2;
				}
			}

			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->createUrl('site/index');
			
			$this->pageTitle = '';
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('front_code', array(
				'render'=>$render,
			));

		} else {
			$this->redirect(Yii::app()->createUrl('site/index'));
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionGet() 
	{
		$model=new UserVerify;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['UserVerify'])) {
			$model->attributes=$_POST['UserVerify'];
			$model->scenario = 'get';

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('get',array('name'=>$model->user->displayname, 'email'=>$model->user->email)),
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
		
		$this->pageTitle = 'Create User Verifies';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('front_get',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = UserVerify::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-verify-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

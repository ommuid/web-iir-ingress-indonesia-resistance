<?php
/**
* LocaleController
* Handle LocaleController
* Copyright (c) 2013, Ommu Platform (ommu.co). All rights reserved.
* version: 2.0.0
* Reference start
*
* TOC :
*	Index
*	Setting
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

class LocaleController extends Controller
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
		if(!Yii::app()->user->isGuest) {
			if(Yii::app()->user->level == 1) {
				$arrThemes = Utility::getCurrentTemplate('admin');
				Yii::app()->theme = $arrThemes['folder'];
				$this->layout = $arrThemes['layout'];
			} else {
				throw new CHttpException(404, Phrase::trans(193,0));
			}
		} else {
			$this->redirect(Yii::app()->createUrl('site/login'));
		}
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
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('setting'),
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
		$this->redirect(array('settings'));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionSetting() 
	{
		$model=new OmmuLocale;
		$setting = OmmuSettings::model()->findByPk(1);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['OmmuLocale'])) {
			$model->attributes=$_POST['OmmuLocale'];

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;
			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->validate()) {
						$locale = OmmuLocale::model()->findByPk($model->default_locale);
						$timezone = OmmuTimezone::model()->findByPk($model->timezone);
						
						$setting->site_dateformat = $model->dateformat;
						$setting->site_timeformat = $model->timeformat;
						
						if($locale->update() && $timezone->update() && $setting->update()) {
							echo CJSON::encode(array(
								'type' => 0,
								'msg' => '<div class="errorSummary success"><strong>'.Phrase::trans(242,0).'</strong></div>',
							));
						}
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();

		} else {
			$this->pageTitle = Phrase::trans(241,0);
			$this->pageDescription = Phrase::trans(243,0);
			$this->pageMeta = '';
			$this->render('admin_setting',array(
				'model'=>$model,
				'setting'=>$setting,
			));
		}

	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = OmmuLocale::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='ommu-locale-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

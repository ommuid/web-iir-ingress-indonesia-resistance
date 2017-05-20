<?php
/**
 * ThemeController
 * @var $this ThemeController
 * @var $model OmmuThemes
 * @var $form CActiveForm
 * version: 1.2.0
 * Reference start
 *
 * TOC :
 *	Index
 *	Manage
 *	Add
 *	Edit
 *	Delete
 *	Default
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class ThemeController extends Controller
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
			} else
				throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		} else
			$this->redirect(Yii::app()->createUrl('site/login'));
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
				'actions'=>array('manage','add','edit','delete','default'),
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
		$this->redirect(array('manage'));
	}

	/**
	 * Manages all models.
	 */
	public function actionManage() 
	{
		$model=new OmmuThemes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OmmuThemes'])) {
			$model->attributes=$_GET['OmmuThemes'];
		}

		$columnTemp = array();
		if(isset($_GET['GridColumn'])) {
			foreach($_GET['GridColumn'] as $key => $val) {
				if($_GET['GridColumn'][$key] == 1) {
					$columnTemp[] = $key;
				}
			}
		}
		$columns = $model->getGridColumn($columnTemp);

		$this->pageTitle = Yii::t('phrase', 'Manage Themes');
		$this->pageDescription = Yii::t('phrase', 'You have complete control over the look and feel of your social network. The PHP code that powers your social network is completely separate from the HTML code used for presentation. Your HTML code is stored in the templates listed below, which can be edited directly on this page. To edit a template, simply click it\'s name.');
		$this->pageMeta = '';
		$this->render('admin_manage',array(
			'model'=>$model,
			'columns' => $columns,
		));

	}	
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAdd() 
	{
		$model=new OmmuThemes;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['OmmuThemes'])) {
			$model->attributes=$_POST['OmmuThemes'];

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;
			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('manage'),
							'id' => 'partial-ommu-themes',
							'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Theme success created.').'</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 500;
			
			$this->pageTitle = Yii::t('phrase', 'Add Theme');
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_add',array(
				'model'=>$model,
			));
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionEdit($id) 
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['OmmuThemes'])) {
			$model->attributes=$_POST['OmmuThemes'];

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;
			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('manage'),
							'id' => 'partial-ommu-themes',
							'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Theme success updated.').'</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 500;
			
			$this->pageTitle = Yii::t('phrase', 'Update Theme: {theme}', array('{theme}'=>$model->name));
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_edit',array(
				'model'=>$model,
			));
		}
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) 
	{
		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				$this->loadModel($id)->delete();

				echo CJSON::encode(array(
					'type' => 5,
					'get' => Yii::app()->controller->createUrl('manage'),
					'id' => 'partial-ommu-themes',
					'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Theme success deleted.').'</strong></div>',
				));
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = Yii::t('phrase', 'Delete Theme');
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_delete');
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDefault($id) 
	{
		$model=$this->loadModel($id);

		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				//change value active or publish
				$model->default_theme = 1;

				if($model->save()) {
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage'),
						'id' => 'partial-ommu-themes',
						'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Theme success updated.').'</strong></div>',
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = Yii::t('phrase', 'Defaults');
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_default',array(
				'model'=>$model,
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
		$model = OmmuThemes::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) 
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ommu-themes-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

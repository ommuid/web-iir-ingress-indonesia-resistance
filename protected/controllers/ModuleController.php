<?php
/**
* ModuleController
* Handle ModuleController
* Copyright (c) 2013, Ommu Platform (ommu.co). All rights reserved.
* version: 2.0.0
* Reference start
*
* TOC :
*	updateModule
*	Index
*	Manage
*	Add
*	Edit
*	Delete
*	Active
*	Default
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

class ModuleController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $defaultAction = 'index';	
	public $moduleHandle;

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
				
				$this->moduleHandle = Yii::app()->moduleHandle;
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
				'actions'=>array('manage','upload','add','edit','install','delete','active','default'),
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
	 * Cache module, update and install to file
	 */
	public function updateModule($deleted=false)
	{
		$this->moduleHandle->cacheModuleConfig();
		if(!$deleted) {
			$this->moduleHandle->updateModuleAddonFromDir();
			$this->moduleHandle->setModuleToDb();
		}
		$this->moduleHandle->updateModuleAddon();
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
		//Update module add-on
		$this->updateModule();
		
		$model=new OmmuPlugins('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OmmuPlugins'])) {
			$model->attributes=$_GET['OmmuPlugins'];
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

		$this->pageTitle = Phrase::trans(213,0);
		$this->pageDescription = Phrase::trans(214,0);
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
	public function actionUpload() 
	{
		$runtimePath = Yii::app()->runtimePath;

		// Upload and extract yii module
		if(isset($_FILES['module_file'])) {
			$fileName = CUploadedFile::getInstanceByName('module_file');
			echo $fileName->type;

			if(strpos($fileName->type, 'zip') !== false) {
				if($fileName->saveAs($runtimePath.'/'.$fileName->name)) {
					$zip        = new ZipArchive;
					$zipFile    = $zip->open($runtimePath.'/'.$fileName->name);
					$extractTo  = explode('.', $fileName->name);
					@chmod($runtimePath.'/'.$fileName->name, 0777);

					if($zipFile == true) {
						if($zip->extractTo(Yii::getPathOfAlias('application.modules'))) {
							Utility::chmodr(Yii::getPathOfAlias('application.modules').'/'.$extractTo[0], 0777);
							$this->redirect(array('manage','type'=>'all'));
							Yii::app()->user->setFlash('success', Phrase::trans(504,0));
						}
						$zip->close();
						Utility::recursiveDelete($runtimePath.'/'.$fileName->name);
					}

				} else {
					Yii::app()->user->setFlash('error', Phrase::trans(503,0));				
				}
			} else {
				Yii::app()->user->setFlash('error', Phrase::trans(502,0));
			}
		}
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
		$this->dialogWidth = 400;
		
		$this->pageTitle = Phrase::trans(501,0);
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_upload');
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAdd() 
	{
		$model=new OmmuPlugins;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['OmmuPlugins'])) {
			$model->attributes=$_POST['OmmuPlugins'];
			$model->scenario = 'adminadd';

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;
			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('manage'),
							'id' => 'partial-ommu-plugins',
							'msg' => '<div class="errorSummary success"><strong>'.Phrase::trans(220,0).'</strong></div>',
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
			
			$this->pageTitle = Phrase::trans(219,0);
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

		if(isset($_POST['OmmuPlugins'])) {
			$model->attributes=$_POST['OmmuPlugins'];

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;
			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('manage'),
							'id' => 'partial-ommu-plugins',
							'msg' => '<div class="errorSummary success"><strong>'.Phrase::trans(218,0).'</strong></div>',
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
			
			$this->pageTitle = Phrase::trans(217,0).': '.$model->name;
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_edit',array(
				'model'=>$model,
			));
		}

	}

	/**
	 * Install module
	 */
	public function actionInstall($id)
	{
		$model=$this->loadModel($id);
		
		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				//change value install
				$model->install = 1;

				if($model->update()) {
					$this->moduleHandle->installModule($model->plugin_id, $model->folder);					
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage'),
						'id' => 'partial-ommu-plugins',
						'msg' => '<div class="errorSummary success"><strong>'.Phrase::trans(507,0).'</strong></div>',
					));
				}
			}
		
		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = Phrase::trans(506,0);
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_install');			
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
				$model = $this->loadModel($id);
				if($model->delete()) {
					$this->moduleHandle->deleteModule($model->folder);
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage'),
						'id' => 'partial-ommu-plugins',
						'msg' => '<div class="errorSummary success"><strong>'.Phrase::trans(216,0).'</strong></div>',
					));					
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = Phrase::trans(215,0);
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
	public function actionActive($id) 
	{
		$model=$this->loadModel($id);
		if($model->actived == 1) {
			$title = Phrase::trans(278,0);
			$replace = 0;
		} else {
			$title = Phrase::trans(277,0);
			$replace = 1;
		}

		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				//change value active or publish
				$model->actived = $replace;

				if($model->save()) {
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage'),
						'id' => 'partial-ommu-plugins',
						'msg' => '<div class="errorSummary success"><strong>'.Phrase::trans(218,0).'</strong></div>',
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = $title;
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_active',array(
				'title'=>$title,
				'model'=>$model,
			));
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
				$model->defaults = 1;

				if($model->update()) {
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage'),
						'id' => 'partial-ommu-plugins',
						'msg' => '<div class="errorSummary success"><strong>'.Phrase::trans(218,0).'</strong></div>',
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = Phrase::trans(156,0);
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
		$model = OmmuPlugins::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='ommu-plugins-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

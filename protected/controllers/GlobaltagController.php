<?php
/**
* GlobaltagController
* Handle GlobaltagController
* Copyright (c) 2013, Ommu Platform (ommu.co). All rights reserved.
* version: 2.0.0
* Reference start
*
* TOC :
*	Index
*	Suggest
*	Manage
*	Add
*	Edit
*	RunAction
*	Delete
*	Publish
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

class GlobaltagController extends Controller
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
			if(in_array(Yii::app()->user->level, array(1,2))) {
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
				'actions'=>array('suggest'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
				//'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level != 1)',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('manage','add','edit','runaction','delete','publish'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level) && in_array(Yii::app()->user->level, array(1,2))',
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
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionSuggest($limit=10) {
		if(isset($_GET['term'])) {
			$criteria = new CDbCriteria;
			$criteria->condition = 'publish = 1 AND body LIKE :body';
			$criteria->select	= "tag_id, body";
			$criteria->limit = $limit;
			$criteria->order = "tag_id ASC";
			$criteria->params = array(':body' => '%' . strtolower($_GET['term']) . '%');
			$model = OmmuTags::model()->findAll($criteria);

			if($model) {
				foreach($model as $items) {
					$result[] = array('id' => $items->tag_id, 'value' => $items->body);
				}
			} else {
				$result[] = array('id' => 0, 'value' => $_GET['term']);
			}
		}
		echo CJSON::encode($result);
		Yii::app()->end();
	}

	/**
	 * Manages all models.
	 */
	public function actionManage() 
	{
		$model=new OmmuTags('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OmmuTags'])) {
			$model->attributes=$_GET['OmmuTags'];
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

		$this->pageTitle = Phrase::trans(487,0);
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('/global_tag/admin_manage',array(
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
		$model=new OmmuTags;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['OmmuTags'])) {
			$model->attributes=$_POST['OmmuTags'];
			
			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('manage'),
							'id' => 'partial-ommu-tags',
							'msg' => '<div class="errorSummary success"><strong>'.Phrase::trans(489,0).'</strong></div>',
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
			
			$this->pageTitle = Phrase::trans(488,0);
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('/global_tag/admin_add',array(
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

		if(isset($_POST['OmmuTags'])) {
			$model->attributes=$_POST['OmmuTags'];
			
			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('manage'),
							'id' => 'partial-ommu-tags',
							'msg' => '<div class="errorSummary success"><strong>'.Phrase::trans(491,0).'</strong></div>',
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
			
			$this->pageTitle = Phrase::trans(490,0);
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('/global_tag/admin_edit',array(
				'model'=>$model,
			));
		}
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionRunAction() {
		$id       = $_POST['trash_id'];
		$criteria = null;
		$actions  = $_GET['action'];

		if(count($id) > 0) {
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id', $id);

			if($actions == 'publish') {
				OmmuTags::model()->updateAll(array(
					'published' => 1,
				),$criteria);
			} elseif($actions == 'unpublish') {
				OmmuTags::model()->updateAll(array(
					'published' => 0,
				),$criteria);
			} elseif($actions == 'trash') {
				OmmuTags::model()->updateAll(array(
					'published' => 2,
				),$criteria);
			} elseif($actions == 'delete') {
				OmmuTags::model()->deleteAll($criteria);
			}
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('manage'));
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
					'id' => 'partial-ommu-tags',
					'msg' => '<div class="errorSummary success"><strong>'.Phrase::trans(493,0).'</strong></div>',
				));
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = Phrase::trans(492,0);
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('/global_tag/admin_delete');
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionPublish($id) 
	{
		$model=$this->loadModel($id);
		if($model->publish == 1) {
			$title = Phrase::trans(276,0);
			$replace = 0;
		} else {
			$title = Phrase::trans(275,0);
			$replace = 1;
		}

		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				//change value active or publish
				$model->publish = $replace;

				if($model->update()) {
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage'),
						'id' => 'partial-ommu-tags',
						'msg' => '<div class="errorSummary success"><strong>'.Phrase::trans(491,0).'</strong></div>',
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
			$this->render('/global_tag/admin_publish',array(
				'title'=>$title,
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
		$model = OmmuTags::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='ommu-tags-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

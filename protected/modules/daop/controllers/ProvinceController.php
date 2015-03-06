<?php
/**
 * ProvinceController
 * @var $this ProvinceController
 * @var $model DaopProvince
 * @var $form CActiveForm
 * Copyright (c) 2013, Ommu Platform (ommu.co). All rights reserved.
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	View
 *	Manage
 *	Edit
 *	Delete
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2015 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class ProvinceController extends Controller
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
			$arrThemes = Utility::getCurrentTemplate('admin');
			Yii::app()->theme = $arrThemes['folder'];
			$this->layout = $arrThemes['layout'];
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
				'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
				//'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level != 1)',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('manage','edit','delete'),
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
		$arrThemes = Utility::getCurrentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
		Utility::applyCurrentTheme($this->module);

		$criteria=new CDbCriteria;
		$criteria->order = 'creation_date DESC';

		$dataProvider = new CActiveDataProvider('DaopProvince', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>10,
			),
		));
			
		$data = '';
		$province = $dataProvider->getData();
		if(!empty($province)) {
			foreach($province as $key => $item) {
				$data .= Utility::otherDecode($this->renderPartial('_view', array('data'=>$item), true, false));
			}
		}
		$pager = OFunction::getDataProviderPager($dataProvider);
		if($pager[nextPage] != '0') {
			$summaryPager = '[1-'.($pager[currentPage]*$pager[pageSize]).' of '.$pager[itemCount].']';
		} else {
			$summaryPager = '[1-'.$pager[itemCount].' of '.$pager[itemCount].']';
		}
		$nextPager = $pager['nextPage'] != 0 ? Yii::app()->controller->createUrl('index', array($pager['pageVar']=>$pager['nextPage'])) : 0;	
		
		if(Yii::app()->request->isAjaxRequest && isset($_GET[$pager['pageVar']])) {
			$return = array(
				'type'=>1,
				'data'=>$data,
				'pager'=>$pager,
				'renderType'=>1,
				'renderSelector'=>'#daop-province .boxed.province .list-view .items',
				'summaryPager'=>$summaryPager,
				'summaryPagerSelector'=>'#daop-member .boxed h2.specific span',
				'nextPage'=>$nextPager,
				'nextPageSelector'=>'#daop-province .boxed.province .list-view a.pager',
			);
			echo CJSON::encode($return);
				
		} else {
			$this->pageTitle = 'Operation Provinces';
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('front_index',array(
				'data'=>$data,
				'pager'=>$pager,
				'summaryPager'=>$summaryPager,
				'nextPage'=>$nextPager,
			));			
		}
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) 
	{
		$arrThemes = Utility::getCurrentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
		Utility::applyCurrentTheme($this->module);
		
		$model = DaopProvince::model()->find(array(
			//'select'=>'folder, layout',
			'condition' => 'province_id = :id',
			'params' => array(
				':id' => $id,
			),
		));

		$this->pageTitle = $model->province_relation->province;
		$this->pageDescription = Utility::shortText(Utility::hardDecode($model->province_desc),300);
		$this->pageMeta = '';
		$this->render('front_view',array(
			'model'=>$model,
		));
	}	

	/**
	 * Manages all models.
	 */
	public function actionManage() 
	{
		$model=new DaopProvince('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DaopProvince'])) {
			$model->attributes=$_GET['DaopProvince'];
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

		$this->pageTitle = 'Daop Provinces Manage';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_manage',array(
			'model'=>$model,
			'columns' => $columns,
		));
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

		if(isset($_POST['DaopProvince'])) {
			$model->attributes=$_POST['DaopProvince'];
			$model->scenario = 'form';
			
			if($model->save()) {
				Yii::app()->user->setFlash('success', 'DaopProvince success updated.');
				$this->redirect(array('manage'));
			}
		}
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
		$this->dialogWidth = 600;

		$this->pageTitle = 'Update Daop Provinces';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_edit',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) 
	{
		$model=$this->loadModel($id);
		
		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				if($model->delete()) {
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage'),
						'id' => 'partial-daop-province',
						'msg' => '<div class="errorSummary success"><strong>DaopProvince success deleted.</strong></div>',
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = 'DaopProvince Delete.';
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_delete');
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = DaopProvince::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='daop-province-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

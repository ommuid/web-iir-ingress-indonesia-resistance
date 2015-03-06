<?php
/**
 * CityController
 * @var $this CityController
 * @var $model DaopCity
 * @var $form CActiveForm
 * Copyright (c) 2013, Ommu Platform (ommu.co). All rights reserved.
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	View
 *	Member
 *	Another
 *	Update
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

class CityController extends Controller
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
				'actions'=>array('index','view',
					'member','another',
					'update',
				),
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

		$dataProvider = new CActiveDataProvider('DaopCity', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>10,
			),
		));

		$this->pageTitle = 'Operation Citys';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('front_index',array(
			'dataProvider'=>$dataProvider,
		));
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
		
		$model = DaopCity::model()->find(array(
			//'select'=>'folder, layout',
			'condition' => 'city_id = :id',
			'params' => array(
				':id' => $id,
			),
		));
		
		$this->contentOther = true;
		$this->contentAttribute=array(
			array(
				'type' => 1, 
				'id' => '#daop-city .boxed #agents .list-view', 
				'url' => Yii::app()->controller->createUrl('member',array('id'=>$model->city_id,'t'=>Utility::getUrlTitle($model->city_relation->city))),
			),
			array(
				'type' => 1, 
				'id' => '#daop-city .boxed #anothers .list-view', 
				'url' => Yii::app()->controller->createUrl('another',array('id'=>$model->city_id,'t'=>Utility::getUrlTitle($model->city_relation->city))),
			),
		);

		$this->pageTitle = $model->city_relation->city;
		$this->pageDescription = Utility::shortText(Utility::hardDecode($model->city_desc),300);
		$this->pageMeta = '';
		$this->render('front_view',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionMember($id) 
	{
		$arrThemes = Utility::getCurrentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
		Utility::applyCurrentTheme($this->module);
		
		$model = DaopCity::model()->find(array(
			//'select'=>'folder, layout',
			'condition' => 'city_id = :id',
			'params' => array(
				':id' => $id,
			),
		));
		
		$criteria=new CDbCriteria;
		$criteria->condition = 'city_id = :city';
		$criteria->params = array(
			':city'=>$id,
		);
		$criteria->order = 'creation_date DESC';

		$dataProvider = new CActiveDataProvider('DaopUsers', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>15,
			),
		));
			
		$data = '';
		$agent = $dataProvider->getData();
		if(!empty($agent)) {
			foreach($agent as $key => $item) {
				$data .= Utility::otherDecode($this->renderPartial('_view_member', array('data'=>$item), true, false));
			}
		}
		$pager = OFunction::getDataProviderPager($dataProvider);
		if($pager[nextPage] != '0') {
			$summaryPager = '[1-'.($pager[currentPage]*$pager[pageSize]).' of '.$pager[itemCount].']';
		} else {
			$summaryPager = '[1-'.$pager[itemCount].' of '.$pager[itemCount].']';
		}
		$nextPager = $pager['nextPage'] != 0 ? Yii::app()->controller->createUrl('member', array('id'=>$model->city_id, 't'=>Utility::getUrlTitle($model->city_relation->city), $pager['pageVar']=>$pager['nextPage'])) : 0;	
		
		if(Yii::app()->request->isAjaxRequest) {
			if(!isset($_GET[$pager['pageVar']])) {
				echo '<div class="items">';
				echo $data;
				echo '</div>';
				$class = ($pager['itemCount'] == '0' || $pager['nextPage'] == '0') ? 'hide' : '';
				echo '<a class="pager '.$class.'" href="'.$nextPager.'" title="Readmore..">Readmore..</a>';
				
			} else {			
				$return = array(
					'type'=>1,
					'data'=>$data,
					'pager'=>$pager,
					'renderType'=>1,
					'renderSelector'=>'#daop-city .boxed #agents .list-view .items',
					'summaryPager'=>$summaryPager,
					'summaryPagerSelector'=>'#daop-member .boxed h2.specific span',
					'nextPage'=>$nextPager,
					'nextPageSelector'=>'#daop-city .boxed #agents .list-view a.pager',
				);
				echo CJSON::encode($return);
			}
		
		} else {		
			$this->contentOther = true;
			$this->contentAttribute=array(
				array(
					'type' => 1, 
					'id' => '#daop-city .boxed #anothers .list-view', 
					'url' => Yii::app()->controller->createUrl('another',array('id'=>$model->city_id, 't'=>Utility::getUrlTitle($model->city_relation->city))),
				),
			);
		
			$this->pageTitle = $model->city_relation->city.' Agent\'s';
			$this->pageDescription = Utility::shortText(Utility::hardDecode($model->city_desc),300);
			$this->pageMeta = '';
			$this->render('front_view',array(
				'model'=>$model,
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
	public function actionAnother($id) 
	{
		$arrThemes = Utility::getCurrentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
		Utility::applyCurrentTheme($this->module);
		
		$model = DaopCity::model()->find(array(
			//'select'=>'folder, layout',
			'condition' => 'city_id = :id',
			'params' => array(
				':id' => $id,
			),
		));
		
		$criteria=new CDbCriteria;
		$criteria->condition = 'city_id = :city';
		$criteria->params = array(
			':city'=>$id,
		);
		$criteria->order = 'creation_date DESC';

		$dataProvider = new CActiveDataProvider('DaopAnothers', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>15,
			),
		));
			
		$data = '';
		$another = $dataProvider->getData();
		if(!empty($another)) {
			foreach($another as $key => $item) {
				$data .= Utility::otherDecode($this->renderPartial('_view_another', array('data'=>$item), true, false));
			}
		}
		$pager = OFunction::getDataProviderPager($dataProvider);
		if($pager[nextPage] != '0') {
			$summaryPager = '[1-'.($pager[currentPage]*$pager[pageSize]).' of '.$pager[itemCount].']';
		} else {
			$summaryPager = '[1-'.$pager[itemCount].' of '.$pager[itemCount].']';
		}
		$nextPager = $pager['nextPage'] != 0 ? Yii::app()->controller->createUrl('another', array('id'=>$model->city_id, 't'=>Utility::getUrlTitle($model->city_relation->city), $pager['pageVar']=>$pager['nextPage'])) : 0;
		
		if(Yii::app()->request->isAjaxRequest) {
			if(!isset($_GET[$pager['pageVar']])) {
				echo '<div class="items clearfix">';
				echo $data;
				echo '</div>';
				$class = ($pager['itemCount'] == '0' || $pager['nextPage'] == '0') ? 'hide' : '';
				echo '<a class="pager '.$class.'" href="'.$nextPager.'" title="Readmore..">Readmore..</a>';
				
			} else {
				$return = array(
					'type'=>1,
					'data'=>$data,
					'pager'=>$pager,
					'renderType'=>1,
					'renderSelector'=>'#daop-city .boxed #anothers .list-view .items',
					'summaryPager'=>$summaryPager,
					'summaryPagerSelector'=>'#daop-member .boxed h2.specific span',
					'nextPage'=>$nextPager,
					'nextPageSelector'=>'#daop-city .boxed #anothers .list-view a.pager',
				);
				echo CJSON::encode($return);
			}
		
		} else {	
			$this->contentOther = true;
			$this->contentAttribute=array(
				array(
					'type' => 1, 
					'id' => '#daop-city .boxed #agents .list-view', 
					'url' => Yii::app()->controller->createUrl('member',array('id'=>$model->city_id, 't'=>Utility::getUrlTitle($model->city_relation->city))),
				),
			);
			$this->pageTitle = $model->city_relation->city.' Specific Area\'s';
			$this->pageDescription = Utility::shortText(Utility::hardDecode($model->city_desc),300);
			$this->pageMeta = '';
			$this->render('front_view',array(
				'model'=>$model,
				'data'=>$data,
				'pager'=>$pager,
				'summaryPager'=>$summaryPager,
				'nextPage'=>$nextPager,
			));
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) 
	{
		$arrThemes = Utility::getCurrentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
		Utility::applyCurrentTheme($this->module);
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['DaopCity'])) {
			$model->attributes=$_POST['DaopCity'];
			$model->scenario = 'form';
			
			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('view',array('id'=>$model->city_id,'t'=>Utility::getUrlTitle($model->city_relation->city))),
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
			
		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('view',array('id'=>$model->city_id,'t'=>Utility::getUrlTitle($model->city_relation->city)));

			$this->pageTitle = 'Update City Information: '.$model->city_relation->city;
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('front_update',array(
				'model'=>$model,
			));
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionManage() 
	{
		$model=new DaopCity('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DaopCity'])) {
			$model->attributes=$_GET['DaopCity'];
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

		$this->pageTitle = 'Operation City\'s Manage';
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

		if(isset($_POST['DaopCity'])) {
			$model->attributes=$_POST['DaopCity'];
			$model->scenario = 'form';
			
			if($model->save()) {
				Yii::app()->user->setFlash('success', 'DaopCity success updated.');
				$this->redirect(array('manage'));
			}
		}
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
		$this->dialogWidth = 600;

		$this->pageTitle = 'Operation City\'s Update';
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
						'id' => 'partial-daop-city',
						'msg' => '<div class="errorSummary success"><strong>DaopCity success deleted.</strong></div>',
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = 'Operation City\'s Delete';
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
		$model = DaopCity::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='daop-city-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

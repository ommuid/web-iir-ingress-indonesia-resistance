<?php
/**
 * MemberController
 * @var $this MemberController
 * @var $model DaopUsers
 * @var $form CActiveForm
 * Copyright (c) 2013, Ommu Platform (ommu.co). All rights reserved.
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	CityGet
 *	CitySuggest
 *	CityPost
 *	AnotherGet
 *	AnotherSuggest
 *	AnotherPost
 *	Manage
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

class MemberController extends Controller
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
				'actions'=>array('index',
					'cityget','citysuggest','citypost',
					'anotherget','anothersuggest','anotherpost',
				),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('manage','delete'),
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
		$model=new DaopUsers;
		$another=new DaopAnotherUser;
		
		$arrThemes = Utility::getCurrentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
		Utility::applyCurrentTheme($this->module);
		
		$this->contentOther = true;
		$this->contentAttribute=array(
			array(
				'type' => 1, 
				'id' => '#daop-member .list-view.city .items', 
				'url' => Yii::app()->controller->createUrl('cityget')
			),
			array(
				'type' => 1, 
				'id' => '#daop-member .list-view.specific .items', 
				'url' => Yii::app()->controller->createUrl('anotherget')
			),
		);

		$this->pageTitle = 'Operation Area';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('front_index', array(
			'model'=>$model,
			'another'=>$another,
		));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionCityGet() 
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria=new CDbCriteria;
			$criteria->condition = 'user_id = :id';
			$criteria->params = array(
				':id'=>Yii::app()->user->id,
			);
			$criteria->order = 'creation_date DESC';

			$dataProvider = new CActiveDataProvider('DaopUsers', array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>10,
				),
			));
			
			$data = '';
			$daops = $dataProvider->getData();
			if(!empty($daops)) {
				foreach($daops as $key => $item) {
					$data .= Utility::otherDecode($this->renderPartial('_view_city', array('data'=>$item), true, false));
				}
			}
			$pager = OFunction::getDataProviderPager($dataProvider);
			if($pager[nextPage] != '0') {
				$summaryPager = '[1-'.($pager[currentPage]*$pager[pageSize]).' of '.$pager[itemCount].']';
			} else {
				$summaryPager = '[1-'.$pager[itemCount].' of '.$pager[itemCount].']';
			}
			$nextPager = $pager['nextPage'] != 0 ? Yii::app()->controller->createUrl('cityget', array($pager['pageVar']=>$pager['nextPage'])) : 0;	
			
			if(empty($_GET)) {
				$class = ($pager['itemCount'] == '0' || $pager['nextPage'] == '0') ? 'hide' : '';
				$data .= '<a class="pager '.$class.'" href="'.$nextPager.'" title="Readmore.."><span>Readmore..</span></a>';
				echo $data;
				
			} else {			
				$return = array(
					'type'=>1,
					'data'=>$data,
					'pager'=>$pager,
					'renderType'=>4,
					'renderSelector'=>'#daop-member .list-view.city .items a.pager',
					'summaryPager'=>$summaryPager,
					'summaryPagerSelector'=>'#daop-member .boxed h2.city span',
					'nextPage'=>$nextPager,
					'nextPageSelector'=>'#daop-member .list-view.city .items a.pager',
				);
				echo CJSON::encode($return);				
			}
			
		} else {
			throw new CHttpException(404, Phrase::trans(193,0));
		}
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionCitySuggest($limit=10) 
	{
		if(Yii::app()->request->isAjaxRequest && isset($_GET['term'])) {
			$criteria = new CDbCriteria;
			$criteria->join = 'LEFT JOIN `ommu_daop_users` `b` ON `t`.`city_id`=`b`.`city_id` AND `b`.`user_id`=:user';
			$criteria->condition = '`t`.`city` LIKE :city AND b.`city_id` IS NULL';
			//$criteria->select	= "city_id, city";
			$criteria->limit = $limit;
			$criteria->order = 'city_id ASC';
			$criteria->params = array(
				':user' => Yii::app()->user->id,
				':city' => '%' . strtolower($_GET['term']) . '%'
			);
			$model = OmmuZoneCity::model()->findAll($criteria);

			if($model) {
				foreach($model as $items) {
					$result[] = array('id' => $items->city_id, 'value' => $items->city);
				}
			}
			echo CJSON::encode($result);
			Yii::app()->end();
			
		} else {
			throw new CHttpException(404, Phrase::trans(193,0));
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCityPost() 
	{
		$model=new DaopUsers;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['user_id'], $_POST['city_id'])) {
			$model->user_id = $_POST['user_id'];
			$model->city_id = $_POST['city_id'];

			if($model->save()) {
				echo CJSON::encode(array(
					'data' => Utility::otherDecode($this->renderPartial('_view_city', array('data'=>$model), true, false)),
				));
			}
		}
	}
	
	/**
	 * Lists all models.
	 */
	public function actionAnotherGet() 
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria=new CDbCriteria;
			$criteria->condition = 'user_id = :id';
			$criteria->params = array(
				':id'=>Yii::app()->user->id,
			);
			$criteria->order = 'creation_date DESC';

			$dataProvider = new CActiveDataProvider('DaopAnotherUser', array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>10,
				),
			));
			
			$data = '';
			$daops = $dataProvider->getData();
			if(!empty($daops)) {
				foreach($daops as $key => $item) {
					$data .= Utility::otherDecode($this->renderPartial('_view_specific', array('data'=>$item), true, false));
				}
			}
			$pager = OFunction::getDataProviderPager($dataProvider);
			if($pager[nextPage] != '0') {
				$summaryPager = '[1-'.($pager[currentPage]*$pager[pageSize]).' of '.$pager[itemCount].']';
			} else {
				$summaryPager = '[1-'.$pager[itemCount].' of '.$pager[itemCount].']';
			}
			$nextPager = $pager['nextPage'] != 0 ? Yii::app()->controller->createUrl('anotherget', array($pager['pageVar']=>$pager['nextPage'])) : 0;	
			
			if(empty($_GET)) {
				$class = ($pager['itemCount'] == '0' || $pager['nextPage'] == '0') ? 'hide' : '';
				$data .= '<a class="pager '.$class.'" href="'.$nextPager.'" title="Readmore.."><span>Readmore..</span></a>';
				echo $data;
				
			} else {			
				$return = array(
					'type'=>1,
					'data'=>$data,
					'pager'=>$pager,
					'renderType'=>4,
					'renderSelector'=>'#daop-member .list-view.specific .items a.pager',
					'summaryPager'=>$summaryPager,
					'summaryPagerSelector'=>'#daop-member .boxed h2.specific span',
					'nextPage'=>$nextPager,
					'nextPageSelector'=>'#daop-member .list-view.specific .items a.pager',
				);
				echo CJSON::encode($return);				
			}
			
		} else {
			throw new CHttpException(404, Phrase::trans(193,0));
		}
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionAnotherSuggest($limit=10) 
	{
		if(Yii::app()->request->isAjaxRequest && isset($_GET['term'])) {
			$criteria = new CDbCriteria;
			$criteria->join = 'LEFT JOIN `ommu_daop_another_user` `b` ON `t`.`another_id`=`b`.`another_id` AND `b`.`user_id`=:user';
			$criteria->condition = '`t`.`another_name` LIKE :another AND b.`another_id` IS NULL';
			//$criteria->select	= "city_id, city";
			$criteria->limit = $limit;
			$criteria->order = 'another_name ASC';
			$criteria->params = array(
				':user' => Yii::app()->user->id,
				':another' => '%' . strtolower($_GET['term']) . '%'
			);
			$model = DaopAnothers::model()->findAll($criteria);

			if($model) {
				foreach($model as $items) {
					$result[] = array('id' => $items->another_id, 'value' => $items->another_name);
				}
			} else {
				$result[] = array('id' => 0, 'value' => $_GET['term']);
			}
			echo CJSON::encode($result);
			Yii::app()->end();
			
		} else {
			throw new CHttpException(404, Phrase::trans(193,0));
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAnotherPost() 
	{
		$model=new DaopAnotherUser;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['another_id'], $_POST['user_id'], $_POST['another'])) {
			$model->another_id = $_POST['another_id'];
			$model->user_id = $_POST['user_id'];
			$model->another_input = $_POST['another'];

			if($model->save()) {
				echo CJSON::encode(array(
					'data' => Utility::otherDecode($this->renderPartial('_view_specific', array('data'=>$model), true, false)),
				));
			}
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionManage() 
	{
		$model=new DaopUsers('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DaopUsers'])) {
			$model->attributes=$_GET['DaopUsers'];
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

		$this->pageTitle = 'Daop Users Manage';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_manage',array(
			'model'=>$model,
			'columns' => $columns,
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
						'id' => 'partial-daop-users',
						'msg' => '<div class="errorSummary success"><strong>DaopUsers success deleted.</strong></div>',
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = 'DaopUsers Delete.';
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
		$model = DaopUsers::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='daop-users-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

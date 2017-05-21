<?php
/**
 * MemberController
 * @var $this MemberController
 * @var $model DaopUsers
 * @var $form CActiveForm
 * version: 0.0.1
 * Reference start
 *
 * TOC :
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
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2015 Ommu Platform (opensource.ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class MemberController extends Controller
{
	public $defaultAction = 'index';

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() 
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index',
					'cityget',
				),
				'users'=>array('*'),
			),
			/* array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(,
					,'citysuggest','citypost','citydrop',
					'anotherget','anothersuggest','anotherpost',
				),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
			), */
		);
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex() 
	{
		$this->_sendResponse(404, Phrase::trans(193,0));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionCityGet() 
	{
		$this->_checkAuth();
		
		$criteria=new CDbCriteria;
		$criteria->condition = 'user_id = :id';
		$criteria->params = array(
			':id'=>Yii::app()->user->id,
		);
		$criteria->order = 'creation_date DESC';

		//$dependecy = new CDbCacheDependency('SELECT MAX(creation_date) FROM ommu_daop_users WHERE user_id='.Yii::app()->user->id.'');
		//$dataProvider = new CActiveDataProvider(DaopUsers::model()->cache(3600, $dependency, 2), array(		
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
				$cityName = str_replace('Kabupaten ', '', $item->city_relation->city); //name
				$model = DaopCity::model()->findByAttributes(array('city_id'=>$item->city_id)); //load data
				if($model == null || ($model != null && $model->city_photo == ''))
					$cityPhoto = OFunction::validHostURL(Yii::app()->request->baseUrl.'/public/daop/daop_default.png');
				else
					$cityPhoto = OFunction::validHostURL(Yii::app()->request->baseUrl.'/public/daop/city/'.$model->city_photo);
				$data[] = array(
					'id'=>$item->daop_id,
					'city_id'=>$item->city_id,
					'city_name'=>$cityName,
					'city_province'=>$item->province_relation->province,
					'city_photo'=>Utility::getTimThumb($cityPhoto, 100, 100, 2),
					'city_agent'=>$model != null ? $model->users : 0,
				);
			}
		} else {
			$data = array();
		}
		$pager = OFunction::getDataProviderPager($dataProvider);
		$get = array_merge($_GET, array($pager['pageVar']=>$pager['nextPage']));
		$nextPager = $pager['nextPage'] != 0 ? OFunction::validHostURL(Yii::app()->controller->createUrl('cityget', $get)) : '-';
		$return = array(
			'data' => $data,
			'pager' => $pager,
			'nextPager' => $nextPager,
		);
		echo CJSON::encode($return);
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionCitySuggest() 
	{
		$this->_checkAuth();
		
		$criteria=new CDbCriteria;
		$criteria->join = 'LEFT JOIN `ommu_daop_users` `b` ON `t`.`city_id`=`b`.`city_id` AND `b`.`user_id`=:user';
		if(!isset($_POST['province']) || (isset($_POST['province']) && $_POST['province'] == ''))
			$criteria->condition = '`t`.`city` LIKE :city AND b.`city_id` IS NULL';				
		else
			$criteria->condition = '`t`.`province_id` = :province AND `t`.`city` LIKE :city AND b.`city_id` IS NULL';
		$criteria->params = array(
			':user' => Yii::app()->user->id,
			':city' => '%' . strtolower($_POST['city_input']) . '%'
		);
		if(isset($_POST['province']) && $_POST['province'] != '')
			$criteria->params[':province'] = $_POST['province'];
		
		$criteria->order = 'city ASC';

		$dataProvider = new CActiveDataProvider('OmmuZoneCity', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>10,
			),
		));
		
		$data = '';
		$daops = $dataProvider->getData();
		if(!empty($daops)) {
			foreach($daops as $key => $item) {
				$cityName = str_replace('Kabupaten ', '', $item->city); //name
				$model = DaopCity::model()->findByAttributes(array('city_id'=>$item->city_id)); //load data
				if($model == null || ($model != null && $model->city_photo == ''))
					$cityPhoto = OFunction::validHostURL(Yii::app()->request->baseUrl.'/public/daop/daop_default.png');
				else
					$cityPhoto = OFunction::validHostURL(Yii::app()->request->baseUrl.'/public/daop/city/'.$model->city_photo);
				$data[] = array(
					'city_id'=>$item->city_id,
					'city_name'=>$cityName,
					'city_province'=>$item->province->province,
					'city_photo'=>Utility::getTimThumb($cityPhoto, 100, 100, 2),
					'city_agent'=>$model != null ? $model->users : 0,
				);
			}
		} else {
			$data = array();
		}
		$pager = OFunction::getDataProviderPager($dataProvider);
		$get = array_merge($_GET, array($pager['pageVar']=>$pager['nextPage']));
		$nextPager = $pager['nextPage'] != 0 ?  OFunction::validHostURL(Yii::app()->controller->createUrl('citysuggest', $get)) : '-';
		$return = array(
			'data' => $data,
			'pager' => $pager,
			'nextPager' => $nextPager,
		);
		echo CJSON::encode($return);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCityAdd() 
	{
		$this->_checkAuth();
		
		if(isset($_POST['city'])) {
			$model = DaopUsers::model()->find(array(
				'condition' => 'user_id = :id AND city_id = :city',
				'params' => array(
					':id' => Yii::app()->user->id,
					':city' => $_POST['city'],
				),
			));
			
			if($model == null) {
				$daop=new DaopUsers;
				$daop->scenario = 'cityadd';
				$daop->user_id = Yii::app()->user->id;
				$daop->city_id = $_POST['city'];
				
				if($daop->save()) {
					/* $cityID = (int)$daop->city_id;
					$cityName = str_replace('Kabupaten ', '', $daop->city_relation->city); //name
					$model = DaopCity::model()->findByAttributes(array('city_id'=>$cityID)); //load data
					if($model == null || ($model != null && $model->city_photo == ''))
						$cityPhoto = OFunction::validHostURL(Yii::app()->request->baseUrl.'/public/daop/daop_default.png');
					else
						$cityPhoto = OFunction::validHostURL(Yii::app()->request->baseUrl.'/public/daop/city/'.$model->city_photo); */
					echo CJSON::encode(array(
						'success'=>'true',
						/* 'daop_id'=>$daop->daop_id,
						'city_id'=>''.$cityID.'',
						'city_name'=>$cityName,
						'city_province'=>$model->city_relation->province->province,
						'city_photo'=>Utility::getTimThumb($cityPhoto, 100, 100, 2),
						'city_agent'=>$model != null ? $model->users : 0, */
					));
				} else {
					foreach ($daop->getErrors() as $val) {
						$message .= $val[0];
					}
					$this->_sendResponse(500, 'Error: '.$message.'' );					
				}
			} else {
				$this->_sendResponse(500, 'Error: duplicate entry operation area' );
			}
		} else {
			$this->_sendResponse(500, 'Error: city input is missing' );
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCityDrop() 
	{
		$this->_checkAuth();
		
		if(isset($_POST['daop'])) {
			$model=DaopUsers::model()->findByPk($_POST['daop']);			
			
			if($model != null) {
				if($model->user_id == Yii::app()->user->id) {
					if($model->delete()) {
						/* $cityName = str_replace('Kabupaten ', '', $model->city_relation->city); */ //name
						$count = DaopUsers::model()->countByAttributes(array('user_id'=>Yii::app()->user->id));
						echo CJSON::encode(array(
							'success'=>'true',
							'daop_count'=>$count,
							/* 'city_id'=> $model->city_id,
							'city_name'=> $cityName,
							'city_province'=>$model->city_relation->province->province, */
						));
					} else {
						foreach ($model->getErrors() as $val) {
							$message .= $val[0];
						}
						$this->_sendResponse(500, 'Error: '.$message.'' );
					}

				} else {
					$this->_sendResponse(500, 'Error: daop autentifikasi trouble' );
				}
			} else {
				$this->_sendResponse(500, 'Error: daop data is missing' );
			}
		} else {
			$this->_sendResponse(500, 'Error: daop input is missing' );
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
					'pageSize'=>14,
				),
			));
			
			$data = '';
			$daops = $dataProvider->getData();
			if(!empty($daops)) {
				foreach($daops as $key => $item) {
					$data .= Utility::otherDecode($this->renderPartial('_view_specific', array('data'=>$item,'render'=>1), true, false));
				}
			} else {
				$data .= Utility::otherDecode($this->renderPartial('_view_specific', array('render'=>0), true, false));
			}
			$pager = OFunction::getDataProviderPager($dataProvider);
			if($pager[nextPage] != '0') {
				$summaryPager = '[1-'.($pager[currentPage]*$pager[pageSize]).' of '.$pager[itemCount].']';
			} else {
				$summaryPager = '[1-'.$pager[itemCount].' of '.$pager[itemCount].']';
			}
			$nextPager = $pager['nextPage'] != 0 ? Yii::app()->controller->createUrl('anotherget', array($pager['pageVar']=>$pager['nextPage'])) : 0;	
			
			if(!isset($_GET[$pager['pageVar']])) {
				$class = ($pager['itemCount'] == '0' || $pager['nextPage'] == '0') ? 'hide' : '';
				$page = '<div class="items specific clearfix">';
				$page .= $data;
				$page .= '</div>';
				$page .= '<div class="pager '.$class.'"><a id="specific-pager" class="button" href="'.$nextPager.'" title="Readmore..">Readmore</a></div>';
				$return = array(
					'type'=>2,
					'id'=>'#specific-data',
					'data'=>$page,
					'summaryPager'=>$pager[itemCount],
					'summaryPagerSelector'=>'#specific-title span',
				);
				
			} else {			
				$return = array(
					'type'=>1,
					'data'=>$data,
					'pager'=>$pager,
					'renderType'=>1,
					'renderSelector'=>'#specific-data .items',
					//'summaryPager'=>$summaryPager,
					//'summaryPagerSelector'=>'#daop-member .boxed.specific h2 span',
					'nextPage'=>$nextPager,
					'nextPageParent'=>'true',
					'nextPageSelector'=>'a#specific-pager',
				);			
			}
			echo CJSON::encode($return);	
			
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
		//if(Yii::app()->request->isAjaxRequest && isset($_GET['term'])) {
			/*
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
			*/

			$criteria=new CDbCriteria;
			$criteria->join = 'LEFT JOIN `ommu_daop_another_user` `b` ON `t`.`another_id`=`b`.`another_id` AND `b`.`user_id`=:user';
			//if(!isset($_GET['DaopUsers']['province_id']) || (isset($_GET['DaopUsers']['province_id']) && $_GET['DaopUsers']['province_id'] == ''))
				$criteria->condition = '`t`.`another_name` LIKE :another AND b.`another_id` IS NULL';				
			//else
			//	$criteria->condition = '`t`.`province_id` = :province AND `t`.`city` LIKE :city AND b.`city_id` IS NULL';
			$criteria->params = array(
				':user' => Yii::app()->user->id,
				':another' => '%' . strtolower($_GET['DaopAnotherUser']['another_input']) . '%'
			);
			//if(isset($_GET['DaopUsers']['province_id']) && $_GET['DaopUsers']['province_id'] != '')
			//	$criteria->params[':province'] = $_GET['DaopUsers']['province_id'];
			
			$criteria->order = 'users DESC';

			$dataProvider = new CActiveDataProvider('DaopAnothers', array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>7,
				),
			));
			
			$data = '';
			$daops = $dataProvider->getData();
			//echo '<pre>';
			//print_r($daops);
			//echo '</pre>';
			//exit();
			if(!empty($daops)) {
				foreach($daops as $key => $item) {
					$data .= Utility::otherDecode($this->renderPartial('_view_specific_suggest', array('data'=>$item,'render'=>1), true, false));
				}
			} else {
				$data .= Utility::otherDecode($this->renderPartial('_view_specific_suggest', array('render'=>0), true, false));
			}
			$pager = OFunction::getDataProviderPager($dataProvider);
			if($pager[nextPage] != '0') {
				$summaryPager = '[1-'.($pager[currentPage]*$pager[pageSize]).' of '.$pager[itemCount].']';
			} else {
				$summaryPager = '[1-'.$pager[itemCount].' of '.$pager[itemCount].']';
			}
			$get = array_merge($_GET, array($pager['pageVar']=>$pager['nextPage']));
			$nextPager = $pager['nextPage'] != 0 ? Yii::app()->controller->createUrl('anothersuggest', $get) : 0;
			
			if(!isset($_GET[$pager['pageVar']])) {
				$class = ($pager['itemCount'] == '0' || $pager['nextPage'] == '0') ? 'hide' : '';
				$page = '<div class="items specific clearfix">';
				$page .= $data;
				$page .= '</div>';
				$page .= '<div class="pager '.$class.'"><a id="specific-suggest-pager" class="button" href="'.$nextPager.'" title="Readmore..">Readmore</a></div>';
				$return = array(
					'type' => 2,
					'id' => '#specific-suggest-data',
					'data' => $page,
				);
				
			} else {			
				$return = array(
					'type' => 1,
					'data' => $data,
					'pager' => $pager,
					'renderType' => 1,
					'renderSelector' => '#specific-suggest-data .items',
					//'summaryPager' => $summaryPager,
					//'summaryPagerSelector' => '#daop-member .boxed.city h2 span',
					'nextPage' => $nextPager,
					'nextPageParent' => 'true',
					'nextPageSelector' => 'a#specific-suggest-pager',
				);				
			}
			echo CJSON::encode($return);
			
		//} else {
		//	throw new CHttpException(404, Phrase::trans(193,0));
		//}
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAnotherDrop($id) 
	{
		$model=DaopAnotherUser::model()->findByPk($id);
		
		if(Yii::app()->request->isAjaxRequest && $model->user_id == Yii::app()->user->id) {
			// we only allow deletion via POST request
			if(isset($id)) {
				if($model->delete()) {
					$count = DaopAnotherUser::model()->countByAttributes(array('user_id'=>Yii::app()->user->id));
					$return = array(
						'type' => 2,
						'summaryPager' => $count,
						'summaryPagerSelector' => '#specific-title',
					);
					if($count != 0) {
						$return['parent'] = 'true';
						$return['element'] = 'div.sep';
					} else {
						$return['id'] = '#specific-data .items';
						$return['data'] = Utility::otherDecode($this->renderPartial('_view_specific', array('render'=>0), true, false));
					}
					echo CJSON::encode($return);
				}
			}

		} else {
			throw new CHttpException(404, Phrase::trans(193,0));
		}
		
		
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

		$this->pageTitle = 'User Operation Area Manage';
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

			$this->pageTitle = 'User Operation Area Delete';
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

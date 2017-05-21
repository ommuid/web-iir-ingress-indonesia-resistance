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
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2015 Ommu Platform (opensource.ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
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
					'cityget','citysuggest','citypost','citydrop',
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
				'id' => '#city-data', 
				'url' => Yii::app()->controller->createUrl('cityget')
			),
			array(
				'type' => 1, 
				'id' => '#city-suggest-data', 
				'url' => Yii::app()->controller->createUrl('citysuggest')
			),
			array(
				'type' => 1, 
				'id' => '#specific-data', 
				'url' => Yii::app()->controller->createUrl('anotherget')
			),
			array(
				'type' => 1, 
				'id' => '#specific-suggest-data', 
				'url' => Yii::app()->controller->createUrl('anothersuggest')
			),
		);

		$this->pageTitle = 'My Area';
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

			//$dependecy = new CDbCacheDependency('SELECT MAX(creation_date) FROM ommu_daop_users WHERE user_id='.Yii::app()->user->id.'');
			//$dataProvider = new CActiveDataProvider(DaopUsers::model()->cache(3600, $dependency, 2), array(		
			$dataProvider = new CActiveDataProvider('DaopUsers', array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>8,
				),
			));
			
			$data = '';
			$daops = $dataProvider->getData();
			if(!empty($daops)) {
				foreach($daops as $key => $item) {
					$data .= Utility::otherDecode($this->renderPartial('_view_city', array('data'=>$item,'render'=>1), true, false));
				}
			} else {
				$data .= Utility::otherDecode($this->renderPartial('_view_city', array('render'=>0), true, false));
			}
			$pager = OFunction::getDataProviderPager($dataProvider);
			if($pager[nextPage] != '0') {
				$summaryPager = '[1-'.($pager[currentPage]*$pager[pageSize]).' of '.$pager[itemCount].']';
			} else {
				$summaryPager = '[1-'.$pager[itemCount].' of '.$pager[itemCount].']';
			}
			$nextPager = $pager['nextPage'] != 0 ? Yii::app()->controller->createUrl('cityget', array($pager['pageVar']=>$pager['nextPage'])) : 0;	
			
			if(!isset($_GET[$pager['pageVar']])) {
				$class = ($pager['itemCount'] == '0' || $pager['nextPage'] == '0') ? 'hide' : '';
				$page = '<div class="items city clearfix">';
				$page .= $data;
				$page .= '</div>';
				$page .= '<div class="pager '.$class.'"><a id="city-pager" class="button" href="'.$nextPager.'" title="Readmore..">Readmore</a></div>';
				$return = array(
					'type'=>2,
					'id'=>'#city-data',
					'data'=>$page,
					'summaryPager'=>$pager[itemCount],
					'summaryPagerSelector'=>'#city-title span',
				);
				
			} else {
				$return = array(
					'type' => 1,
					'data' => $data,
					'pager' => $pager,
					'renderType' => 1,
					'renderSelector' => '#city-data .items',
					//'summaryPager' => $summaryPager,
					//'summaryPagerSelector' => '#daop-member .boxed.city h2 span',
					'nextPage' => $nextPager,
					'nextPageParent' => 'true',
					'nextPageSelector' => 'a#city-pager',
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
	public function actionCitySuggest() 
	{
		if(Yii::app()->request->isAjaxRequest) {
			/*
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
			*/
			
			$criteria=new CDbCriteria;
			$criteria->join = 'LEFT JOIN `ommu_daop_users` `b` ON `t`.`city_id`=`b`.`city_id` AND `b`.`user_id`=:user';
			if(!isset($_GET['DaopUsers']['province_id']) || (isset($_GET['DaopUsers']['province_id']) && $_GET['DaopUsers']['province_id'] == ''))
				$criteria->condition = '`t`.`city` LIKE :city AND b.`city_id` IS NULL';				
			else
				$criteria->condition = '`t`.`province_id` = :province AND `t`.`city` LIKE :city AND b.`city_id` IS NULL';
			$criteria->params = array(
				':user' => Yii::app()->user->id,
				':city' => '%' . strtolower($_GET['DaopUsers']['city_input']) . '%'
			);
			if(isset($_GET['DaopUsers']['province_id']) && $_GET['DaopUsers']['province_id'] != '')
				$criteria->params[':province'] = $_GET['DaopUsers']['province_id'];
			
			$criteria->order = 'city ASC';

			$dataProvider = new CActiveDataProvider('OmmuZoneCity', array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>7,
				),
			));
			
			$data = '';
			$daops = $dataProvider->getData();
			if(!empty($daops)) {
				foreach($daops as $key => $item) {
					$data .= Utility::otherDecode($this->renderPartial('_view_city_suggest', array('data'=>$item,'render'=>1), true, false));
				}
			} else {
				$data .= Utility::otherDecode($this->renderPartial('_view_city_suggest', array('render'=>0), true, false));
			}
			$pager = OFunction::getDataProviderPager($dataProvider);
			if($pager[nextPage] != '0') {
				$summaryPager = '[1-'.($pager[currentPage]*$pager[pageSize]).' of '.$pager[itemCount].']';
			} else {
				$summaryPager = '[1-'.$pager[itemCount].' of '.$pager[itemCount].']';
			}
			$get = array_merge($_GET, array($pager['pageVar']=>$pager['nextPage']));
			$nextPager = $pager['nextPage'] != 0 ? Yii::app()->controller->createUrl('citysuggest', $get) : 0;
			
			if(!isset($_GET[$pager['pageVar']])) {
				$class = ($pager['itemCount'] == '0' || $pager['nextPage'] == '0') ? 'hide' : '';
				$page = '<div class="items city clearfix">';
				$page .= $data;
				$page .= '</div>';
				$page .= '<div class="pager '.$class.'"><a id="city-suggest-pager" class="button" href="'.$nextPager.'" title="Readmore..">Readmore</a></div>';
				$return = array(
					'type' => 2,
					'id' => '#city-suggest-data',
					'data' => $page,
					'summaryPager' => $pager[itemCount],
					'summaryPagerSelector' => '#city-suggest-title span',
				);
				
			} else {			
				$return = array(
					'type' => 1,
					'data' => $data,
					'pager' => $pager,
					'renderType' => 1,
					'renderSelector' => '#city-suggest-data .items',
					//'summaryPager' => $summaryPager,
					//'summaryPagerSelector' => '#daop-member .boxed.city h2 span',
					'nextPage' => $nextPager,
					'nextPageParent' => 'true',
					'nextPageSelector' => 'a#city-suggest-pager',
				);				
			}
			echo CJSON::encode($return);
			
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCityDrop($id) 
	{
		$model=$this->loadModel($id);
		
		if(Yii::app()->request->isAjaxRequest && $model->user_id == Yii::app()->user->id) {
			// we only allow deletion via POST request
			if(isset($id)) {
				if($model->delete()) {
					$count = DaopUsers::model()->countByAttributes(array('user_id'=>Yii::app()->user->id));
					$return = array(
						'type' => 2,
						'summaryPager' => $count,
						'summaryPagerSelector' => '#city-title span',
					);
					if($count != 0) {
						$return['parent'] = 'true';
						$return['element'] = 'div.sep';
					} else {
						$return['id'] = '#city-data .items';
						$return['data'] = Utility::otherDecode($this->renderPartial('_view_city', array('render'=>0), true, false));
					}
					echo CJSON::encode($return);
				}
			}

		} else {
			throw new CHttpException(404, Phrase::trans(193,0));
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCityAdd($id) 
	{
		$model = DaopUsers::model()->find(array(
			'condition' => 'user_id = :id AND city_id = :city',
			'params' => array(
				':id' => Yii::app()->user->id,
				':city' => $id,
			),
		));
		
		if(Yii::app()->request->isAjaxRequest && $model == null) {
			// we only allow deletion via POST request
			if(isset($id)) {
				$daop=new DaopUsers;
				$daop->user_id = Yii::app()->user->id;
				$daop->city_id = $id;
				
				if($daop->save()) {
					echo CJSON::encode(array(
						'type' => 1,
						'data' => Utility::otherDecode($this->renderPartial('_view_city', array('data'=>$daop,'render'=>1), true, false)),
						'renderType' => 2,
						'renderSelector' => '#city-data .items',
						'summaryPager' => DaopUsers::model()->countByAttributes(array('user_id'=>Yii::app()->user->id)),
						'summaryPagerSelector' => '#city-title span',
						
						'parent' => 'true',
						'element' => 'div.sep',
						'replaceHtml' => 'true',
						'replaceClass' => 'sep active',
						'replaceUrl' => 'javascript:void(0);',
					));
				}
			}

		} else {
			throw new CHttpException(404, Phrase::trans(193,0));
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

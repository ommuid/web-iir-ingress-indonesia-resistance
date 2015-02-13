<?php
/**
* ContactController
* Handle ContactController
* Copyright (c) 2013, Ommu Platform (ommu.co). All rights reserved.
* version: 1.5.0
* Reference start
*
* TOC :
*	Index
*	AjaxSend
*	Success
*	Office
*	Manage
*	Add
*	Edit
*	RunAction
*	Delete
*	Publish
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

class ContactController extends Controller
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
				$this->redirect(Yii::app()->createUrl('site/login'));
			}
		} else {
			$arrThemes = Utility::getCurrentTemplate('public');
			Yii::app()->theme = $arrThemes['folder'];
			$this->layout = $arrThemes['layout'];
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
				'actions'=>array('index','feedback','success','office'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
				//'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level != 1)',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('manage','add','edit','runaction','delete','publish','setting'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level == 1)',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('manage','edit','setting'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level == 2)',
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
		
		$model = OmmuMeta::model()->findByPk(1, array(
			'select' => 'office_name, office_place, office_village, office_district, office_city, office_country, office_zipcode, office_phone, office_fax, office_hotline, office_email'
		));
		$contact = SupportContacts::model()->findAll(array(
			'condition' => 'publish = :publish',
			'params' => array(
				':publish' => 1,
			),
		));

		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->createUrl('site/index');
		//$this->pageGuest = true;
		
		$this->pageTitle = Phrase::trans(23038,1);
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('front_index',array(
			'model'=>$model,
			'contact'=>$contact,
		));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionFeedback() 
	{
		$arrThemes = Utility::getCurrentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
		Utility::applyCurrentTheme($this->module);

		$model=new SupportMails;
		if(!Yii::app()->user->isGuest) {
			$user = Users::model()->findByPk(Yii::app()->user->id, array(
				'select' => 'user_id, email, displayname, photo_id',
			));
		}

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['SupportMails'])) {
			$model->attributes=$_POST['SupportMails'];
			$model->scenario = 'contactus';

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;
			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						if($model->user_id != 0)
							$url = Yii::app()->controller->createUrl('feedback', array('email'=>$model->email, 'name'=>$model->displayname));
						else
							$url = Yii::app()->controller->createUrl('feedback', array('email'=>$model->email, 'name'=>$model->displayname));
						echo CJSON::encode(array(
							'type' => 5,
							'get' => $url,
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
			
		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->createUrl('site/index');
			
			$this->pageTitle = isset($_GET['email']) ? Phrase::trans(23121,1) : Phrase::trans(23102,1);
			$this->pageDescription = isset($_GET['email']) ? (isset($_GET['name']) ? Phrase::trans(23123,1, array($_GET['name'], $_GET['email'])) : Phrase::trans(23122,1, array($_GET['email']))) : '';
			$this->pageMeta = '';
			$this->render('front_feedback',array(
				'model'=>$model,
				'user'=>$user,
			));
		}
	}
	
	/**
	 * Lists all models.
	 */
	public function actionOffice() 
	{
		$this->layout = false;
		$model = OmmuMeta::model()->findAll(array(
			//'select' => 'office_on, google_on, twitter_on, facebook_on'
		));
		$setting = OmmuSettings::model()->findByPk(1,array(
			'select' => 'site_title'
		));
		
		$return = array();
		$return['maps'] = array(
			'icon'=>Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->request->baseUrl.'/public/marker_default.png',
			'width'=>42,
			'height'=>48,
		);
		$i = 0;
		foreach($model as $val){
			$i++;
			$point = explode(',', $val->office_location);
			$return['data'][] = array(
				'id'=>$i,
				'lat'=>$point[0],
				'lng'=>$point[1],
				'name'=>$val->office_name != '' ? $val->office_name : $setting->site_title,
				'address'=>$val->office_place.'. '.$val->office_village.', '.$val->office_district.', '.OmmuZoneCity::getInfo($val->office_city, 'city').', '.OmmuZoneCountry::getInfo($val->office_country, 'country').', '.$val->office_zipcode,
			);
		}
		
		echo CJSON::encode($return);
	}

	/**
	 * Lists all models.
	 */
	public function actionSuccess()
	{
		$arrThemes = Utility::getCurrentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
		Utility::applyCurrentTheme($this->module);
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
		$this->dialogWidth = 400;
		
		$this->pageTitle = Phrase::trans(23075,1);
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_success');
	}


	/**
	 * Manages all models.
	 */
	public function actionManage() 
	{
		$model=new SupportContacts('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SupportContacts'])) {
			$model->attributes=$_GET['SupportContacts'];
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

		$this->pageTitle = Phrase::trans(23061,1);
		$this->pageDescription = '';
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
		$model=new SupportContacts;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['SupportContacts'])) {
			$model->attributes=$_POST['SupportContacts'];

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				$errors = $model->getErrors();
				$summary['msg'] = "<div class='errorSummary'><strong>".Phrase::trans(163,0)."</strong>";
				$summary['msg'] .= "<ul>";
				foreach($errors as $key => $value) {
					$summary['msg'] .= "<li>{$value[0]}</li>";
				}
				$summary['msg'] .= "</ul></div>";

				$message = json_decode($jsonError, true);
				$merge = array_merge_recursive($summary, $message);
				$encode = json_encode($merge);
				echo $encode;
			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('manage'),
							'id' => 'partial-support-contacts',
							'msg' => '<div class="errorSummary success"><strong>'.Phrase::trans(23072,1).'</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
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

		if(isset($_POST['SupportContacts'])) {
			$model->attributes=$_POST['SupportContacts'];
			$model->scenario = 'default';

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;
			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('manage'),
							'id' => 'partial-support-contacts',
							'msg' => '<div class="errorSummary success"><strong>'.Phrase::trans(23073,1).'</strong></div>',
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
			
			$this->pageTitle = Phrase::trans(23074,1);
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_edit',array(
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
				SupportContacts::model()->updateAll(array(
					'published' => 1,
				),$criteria);
			} elseif($actions == 'unpublish') {
				SupportContacts::model()->updateAll(array(
					'published' => 0,
				),$criteria);
			} elseif($actions == 'trash') {
				SupportContacts::model()->updateAll(array(
					'published' => 2,
				),$criteria);
			} elseif($actions == 'delete') {
				SupportContacts::model()->deleteAll($criteria);
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
					'id' => 'partial-support-contacts',
					'msg' => '<div class="errorSummary success"><strong>'.Phrase::trans(23076,1).'</strong></div>',
				));
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = Phrase::trans(23075,1);
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
						'id' => 'partial-support-contacts',
						'msg' => '<div class="errorSummary success"><strong>'.Phrase::trans(23073,1).'</strong></div>',
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
			$this->render('admin_publish',array(
				'title'=>$title,
				'model'=>$model,
			));
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionSetting() 
	{
		$model = OmmuMeta::model()->findByPk(1);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['OmmuMeta'])) {
			$model->attributes=$_POST['OmmuMeta'];
			$model->scenario = 'contact';

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				$errors = $model->getErrors();
				$summary['msg'] = "<div class='errorSummary'><strong>".Phrase::trans(163,0)."</strong>";
				$summary['msg'] .= "<ul>";
				foreach($errors as $key => $value) {
					$summary['msg'] .= "<li>{$value[0]}</li>";
				}
				$summary['msg'] .= "</ul></div>";

				$message = json_decode($jsonError, true);
				$merge = array_merge_recursive($summary, $message);
				$encode = json_encode($merge);
				echo $encode;

			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 0,
							'msg' => '<div class="errorSummary success"><strong>'.Phrase::trans(23077,1).'</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();

		} else {
			$this->pageTitle = Phrase::trans(23063,1);
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_setting',array(
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
		$model = SupportContacts::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='support-contacts-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}

<?php
/**
 * AdminController
 * @var $this AdminController
 * @var $model Users
 * @var $form CActiveForm
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	Password
 *	Manage
 *	Add
 *	Edit
 *	View
 *	Delete
 *	Enable
 *	Verify
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Users
 * @contact (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class AdminController extends Controller
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
				//'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level != 1)',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('edit','password','photo'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level) && in_array(Yii::app()->user->level, array(1,2))',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('manage','add','delete','enable','verify'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionPassword() 
	{
		$model=$this->loadModel(Yii::app()->user->id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Users'])) {
			$model->attributes=$_POST['Users'];
			$model->scenario = 'formChangePassword';

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;
			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('password',array('type'=>'success')),
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
		}

		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->createUrl('admin/dashboard');
		$this->dialogWidth = 500;
		
		$this->pageTitle = 'Change Password';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_password',array(
			'model'=>$model,
		));
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionPhoto($id=null) 
	{
		$condition = 1;
		if($id == null) {
			$condition = 0;
			$id = Yii::app()->user->id;
		}
		
		$model = Users::model()->findByPk($id);
		$photo_exts = unserialize($model->level->photo_exts);
		if(empty($photo_exts))
			$photo_exts = array();
		
		if(!$model->getErrors())
			$photos = $model->photos;
		
		if($condition == 0) {
			$user_path = 'public/users/'.$id;
			if(!file_exists($user_path)) {
				mkdir($user_path, 0755, true);

				// Add File in User Folder (index.php)
				$newFile = $user_path.'/index.php';
				$FileHandle = fopen($newFile, 'w');
			} else
				@chmod($user_path, 0755, true);
			
			$userPhoto = CUploadedFile::getInstanceByName('namaFile');
			$fileName = time().'_'.Utility::getUrlTitle($model->displayname).'.'.strtolower($userPhoto->extensionName);
			if($userPhoto->saveAs($user_path.'/'.$fileName)) {
				if(Users::model()->updateByPk($model->user_id, array('photos'=>$fileName,'update_date'=>date('Y-m-d H:i:s')))) {
					if($photos != '')
						rename($user_path.'/'.$photos, 'public/users/verwijderen/'.$model->user_id.'_'.$photos);
					echo CJSON::encode(array(
						'id' => 'div.account a.photo img',
						'image' => Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/users/'.$model->user_id.'/'.$fileName, 82, 82, 1),
					));					
				}
			}
			
		} else {
			// Uncomment the following line if AJAX validation is needed
			$this->performAjaxValidation($model);

			if(isset($_POST['Users'])) {
				$model->attributes=$_POST['Users'];
				
				if($model->save()) {
					Yii::app()->user->setFlash('success', Yii::t('phrase', 'Users success updated.'));
					$this->redirect(array('manage'));
				}
			}
			
			$this->dialogDetail = true;
			$this->dialogGroundUrl = $condition == 1 ? Yii::app()->controller->createUrl('manage') : Yii::app()->createUrl('admin/dashboard');
			$this->dialogWidth = 600;

			$this->pageTitle = 'Photo Users';
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_photo',array(
				'model'=>$model,
				'photo_exts'=>$photo_exts,
			));
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionManage() 
	{
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users'])) {
			$model->attributes=$_GET['Users'];
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

		$this->pageTitle = Yii::t('phrase', 'Manage Administrator');
		$this->pageDescription = Yii::t('phrase', 'Your social network can have more than one administrator. This is useful if you want to have a staff of admins who maintain your social network. However, the first admin to be created (upon installation) is the "superadmin" and cannot be deleted. The superadmin can create and delete other admin accounts. All admin accounts on your system are listed below.');
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
	public function actionAdd() 
	{
		$model=new Users;
		$setting = OmmuSettings::model()->findByPk(1, array(
			'select'=>'signup_username, signup_approve, signup_verifyemail, signup_photo, signup_random',
		));
		if($model->isNewRecord)
			$model->level_id = 1;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Users'])) {
			$model->attributes=$_POST['Users'];
			$model->scenario = 'formAdd';

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('manage'),
							'id' => 'partial-users',
							'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Administrator success created.').'</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
		}
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
		$this->dialogWidth = 600;
		
		$this->pageTitle = Yii::t('phrase', 'Add Administrator');
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_add',array(
			'model'=>$model,
			'setting'=>$setting,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionEdit($id=null) 
	{
		$condition = 1;
		if($id == null) {
			$condition = 0;
			$id = Yii::app()->user->id;
		}
		
		$model=$this->loadModel($id);
		$setting = OmmuSettings::model()->findByPk(1, array(
			'select'=>'signup_username, signup_approve, signup_verifyemail, signup_photo, signup_random',
		));

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Users'])) {
			$model->attributes=$_POST['Users'];
			$model->scenario = 'formEdit';

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => $condition == 1 ? Yii::app()->controller->createUrl('manage') : Yii::app()->createUrl('admin/dashboard'),
							'id' => 'partial-users',
							'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Administrator success updated.').'</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
		}
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = $condition == 1 ? Yii::app()->controller->createUrl('manage') : Yii::app()->createUrl('admin/dashboard');
		$this->dialogWidth = 600;
		
		$this->pageTitle = Yii::t('phrase', 'Update Administrator : {displayname}', array('{displayname}'=>$model->displayname));
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_edit',array(
			'model'=>$model,
			'setting'=>$setting,
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) 
	{
		$model=$this->loadModel($id);
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
		$this->dialogWidth = 600;

		$this->pageTitle = 'View Users';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_view',array(
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
						'id' => 'partial-users',
						'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Administrator success deleted.').'</strong></div>',
					));
				}
				Yii::app()->end();
			}
		}

		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
		$this->dialogWidth = 350;

		$this->pageTitle = Yii::t('phrase', 'Delete Administrator');
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_delete');
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionEnable($id) 
	{
		$model=$this->loadModel($id);
		if($model->enabled == 1) {
			$title = Yii::t('phrase', 'Disabled');
			$replace = 0;
		} else {
			$title = Yii::t('phrase', 'Enabled');
			$replace = 1;
		}

		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				//change value active or publish
				$model->enabled = $replace;

				if($model->update()) {
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage'),
						'id' => 'partial-users',
						'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Administrator success updated.').'</strong></div>',
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
			$this->render('admin_enabled',array(
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
	public function actionVerify($id) 
	{
		$model=$this->loadModel($id);
		if($model->verified == 1) {
			$title = Yii::t('phrase', 'Unverified');
			$replace = 0;
		} else {
			$title = Yii::t('phrase', 'Verified');
			$replace = 1;
		}

		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				//change value active or publish
				$model->verified = $replace;

				if($model->update()) {
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage'),
						'id' => 'partial-users',
						'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Administrator success updated.').'</strong></div>',
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
			$this->render('admin_verify',array(
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
		$model = Users::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

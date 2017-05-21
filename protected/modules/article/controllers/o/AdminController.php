<?php
/**
 * AdminController
 * @var $this AdminController
 * @var $model Articles
 * @var $form CActiveForm
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	Manage
 *	Add
 *	Edit
 *	RunAction
 *	Delete
 *	Publish
 *	Headline
 *	Getcover
 *	Insertcover
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/mod-article
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
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('manage','add','edit','runaction','delete','publish','headline','getcover','insertcover'),
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
	 * Manages all models.
	 */
	public function actionManage() 
	{
		$model=new Articles('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Articles'])) {
			$model->attributes=$_GET['Articles'];
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
		
		if(isset($_GET['category'])) {
			$category = ArticleCategory::model()->findByPk($_GET['category']);
			$title = ': '.Phrase::trans($category->name);
		} else {
			$title = '';
		}

		$this->pageTitle = Yii::t('phrase', 'View Articles').$title;
		$this->pageDescription = Yii::t('phrase', 'Use this page to search for and manage article entries. To Approve or Feature an article, just click on the icon, it will automate turn on and off per that setting. To edit, delete, or manage an article, please login as that user, and perform your actions.');
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
		$setting = ArticleSetting::model()->findByPk(1,array(
			'select' => 'meta_keyword, type_active, headline, media_file_type, upload_file_type',
		));	
		$media_file_type = unserialize($setting->media_file_type);
		if(empty($media_file_type))
			$media_file_type = array();
		$upload_file_type = unserialize($setting->upload_file_type);
		if(empty($upload_file_type))
			$upload_file_type = array();
		
		$model=new Articles;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Articles'])) {
			$model->attributes=$_POST['Articles'];
			
			if($model->article_type == 'standard')
				$model->scenario = 'formStandard';
			else if($model->article_type == 'video')
				$model->scenario = 'formVideo';

			if($model->save()) {
				Yii::app()->user->setFlash('success', Yii::t('phrase', 'Article success created.'));
				$this->redirect(array('manage'));
			}
		}

		$this->pageTitle = Yii::t('phrase', 'Create Article');
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_add',array(
			'model'=>$model,
			'setting'=>$setting,
			'media_file_type'=>$media_file_type,
			'upload_file_type'=>$upload_file_type,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionEdit($id) 
	{
		$setting = ArticleSetting::model()->findByPk(1,array(
			'select' => 'meta_keyword, type_active, headline, media_limit, media_file_type, upload_file_type',
		));
		$media_file_type = unserialize($setting->media_file_type);
		if(empty($media_file_type))
			$media_file_type = array();
		$upload_file_type = unserialize($setting->upload_file_type);
		if(empty($upload_file_type))
			$upload_file_type = array();
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Articles'])) {
			$model->attributes=$_POST['Articles'];
			
			if($model->article_type == 'standard')
				$model->scenario = 'formStandard';
			else if($model->article_type == 'video')
				$model->scenario = 'formVideo';

			/*
			if($model->article_type == 'standard' && $setting->media_limit != 1) {
				$jsonError = CActiveForm::validate($model);
				if(strlen($jsonError) > 2) {
					$errors = $model->getErrors();
					$summary['msg'] = "<div class='errorSummary'><strong>".Yii::t('phrase', 'Please fix the following input errors:')."</strong>";
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
								'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Article success updated.').'</strong></div>',
							));
						} else {
							print_r($model->getErrors());
						}
					}
				}
				Yii::app()->end();
			
			} else {
			*/
				if($model->save()) {
					Yii::app()->user->setFlash('success', Yii::t('phrase', 'Article success updated.'));
					$this->redirect(array('edit','id'=>$model->article_id));
				}
			//}
		}

		$this->pageTitle = Yii::t('phrase', 'Update Article').': '.$model->title;
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_edit',array(
			'model'=>$model,
			'setting'=>$setting,
			'media_file_type'=>$media_file_type,
			'upload_file_type'=>$upload_file_type,
		));
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
				Articles::model()->updateAll(array(
					'publish' => 1,
				),$criteria);
			} elseif($actions == 'unpublish') {
				Articles::model()->updateAll(array(
					'publish' => 0,
				),$criteria);
			} elseif($actions == 'trash') {
				Articles::model()->updateAll(array(
					'publish' => 2,
				),$criteria);
			} elseif($actions == 'delete') {
				Articles::model()->deleteAll($criteria);
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
					'id' => 'partial-articles',
					'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Article success deleted.').'</strong></div>',
				));
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = Yii::t('phrase', 'Delete Article');
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
			$title = Yii::t('phrase', 'Unpublish');
			$replace = 0;
		} else {
			$title = Yii::t('phrase', 'Publish');
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
						'id' => 'partial-articles',
						'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Article success updated.').'</strong></div>',
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
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionHeadline($id) 
	{
		$model=$this->loadModel($id);

		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				//change value active or publish
				$model->headline = 1;
				$model->publish = 1;

				if($model->update()) {
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage'),
						'id' => 'partial-articles',
						'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Article success updated.').'</strong></div>',
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = Yii::t('phrase', 'Headline');
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_headline');
		}
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionGetcover($id) 
	{
		$setting = ArticleSetting::model()->findByPk(1,array(
			'select' => 'media_limit',
		));		
		$media_limit = $setting->media_limit;
		
		$model=$this->loadModel($id);
		$medias = $model->medias;

		$data = '';
		if(isset($_GET['replace']))
			$data .= $this->renderPartial('_form_cover', array('model'=>$model, 'medias'=>$medias, 'media_limit'=>$media_limit), true, false);
		
		if(!empty($medias)) {	
			foreach($medias as $key => $val)
				$data .= $this->renderPartial('_form_view_covers', array('data'=>$val), true, false);
		}
		
		$data .= '';
		$result['data'] = $data;
		echo CJSON::encode($result);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionInsertcover($id) 
	{
		$setting = ArticleSetting::model()->findByPk(1,array(
			'select' => 'media_limit, media_file_type',
		));
		$media_limit = $setting->media_limit;
		$media_file_type = unserialize($setting->media_file_type);
		
		$article_path = "public/article/".$id;
		// Add directory
		if(!file_exists($article_path)) {
			@mkdir($article_path, 0755, true);

			// Add file in directory (index.php)
			$newFile = $article_path.'/index.php';
			$FileHandle = fopen($newFile, 'w');
		} else
			@chmod($article_path, 0755, true);
			
		//if(Yii::app()->request->isAjaxRequest) {
			$model = $this->loadModel($id);
			
			$uploadPhoto = CUploadedFile::getInstanceByName('namaFile');
			$fileName = time().'_'.Utility::getUrlTitle($model->title).'.'.strtolower($uploadPhoto->extensionName);
			if($uploadPhoto->saveAs($article_path.'/'.$fileName)) {
				$photo = new ArticleMedia;
				$photo->cover = $model->medias == null ? '1' : '0';
				$photo->article_id = $model->article_id;
				$photo->media = $fileName;
				if($photo->save()) {
					$url = Yii::app()->controller->createUrl('getcover', array('id'=>$model->article_id,'replace'=>'true'));
					echo CJSON::encode(array(
						'id' => 'media-render',
						'get' => $url,
					));
				}
			}
			
		//} else
		//	throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = Articles::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='articles-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

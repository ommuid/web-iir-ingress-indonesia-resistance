<?php
/**
* MediaController
* Handle MediaController
* Copyright (c) 2013, Ommu Platform (ommu.co). All rights reserved.
* version: 2.5.0
* Reference start
*
* TOC :
*	Index
*	AjaxManage
*	AjaxAdd
*	AjaxEdit
*	AjaxDelete
*	Manage
*	Edit
*	Delete
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

class MediaController extends Controller
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
			if(Yii::app()->user->level == 1) {
				$arrThemes = Utility::getCurrentTemplate('admin');
				Yii::app()->theme = $arrThemes['folder'];
				$this->layout = $arrThemes['layout'];
			} else {
				$this->redirect(Yii::app()->createUrl('site/login'));
			}
		} else {
			if(ArticleSetting::getInfo('permission') == 1) {
				$arrThemes = Utility::getCurrentTemplate('public');
				Yii::app()->theme = $arrThemes['folder'];
				$this->layout = $arrThemes['layout'];
			} else {
				$this->redirect(Yii::app()->createUrl('site/index'));
			}
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
				'actions'=>array('ajaxmanage','ajaxadd','ajaxdelete','ajaxcover'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
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
		$this->redirect(array('manage'));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAjaxManage($id) 
	{
		if(!isset($_GET['type'])) {
			$arrThemes = Utility::getCurrentTemplate('public');
			Yii::app()->theme = $arrThemes['folder'];
			$this->layout = $arrThemes['layout'];
			Utility::applyCurrentTheme($this->module);
		}
		
		$model = ArticleMedia::getPhoto($id);
		$setting = ArticleSetting::model()->findByPk(1,array(
			'select' => 'media_limit',
		));

		$data = '';
		if($model != null) {			
			foreach($model as $key => $val) {
				$image = Yii::app()->request->baseUrl.'/public/article/'.$val->article_id.'/'.$val->media;
				if(isset($_GET['type'])) {
					$url = Yii::app()->controller->createUrl('ajaxdelete', array('id'=>$val->media_id,'type'=>'admin'));
					$urlCover = Yii::app()->controller->createUrl('ajaxcover', array('id'=>$val->media_id,'type'=>'admin'));
				} else {
					$url = Yii::app()->controller->createUrl('ajaxdelete', array('id'=>$val->media_id));
					$urlCover = Yii::app()->controller->createUrl('ajaxcover', array('id'=>$val->media_id));
				}
				$data .= '<li>';
				if($val->cover == 0) {
					$data .= '<a id="set-cover" href="'.$urlCover.'" title="'.Phrase::trans(26108,1).'">'.Phrase::trans(26108,1).'</a>';
				}
				$data .= '<a id="set-delete" href="'.$url.'" title="'.Phrase::trans(26055,1).'">'.Phrase::trans(26055,1).'</a>';
				$data .= '<img src="'.Utility::getTimThumb($image, 320, 250, 1).'" alt="'.$val->article->title.'" />';
				$data .= '</li>';
			}
		}
		if(isset($_GET['replace'])) {
			// begin.Upload Button
			$class = (count($model) == $setting->media_limit) ? 'class="hide"' : '';
			if(isset($_GET['type']))
				$url = Yii::app()->controller->createUrl('ajaxadd', array('id'=>$id,'type'=>'admin'));
			else 
				$url = Yii::app()->controller->createUrl('ajaxadd', array('id'=>$id));
			$data .= '<li id="upload" '.$class.'>';
			$data .= '<a id="upload-gallery" href="'.$url.'" title="'.Phrase::trans(26054,1).'">'.Phrase::trans(26054,1).'</a>';
			$data .= '<img src="'.Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/article/article_default.png', 320, 250, 1).'" alt="" />';
			$data .= '</li>';
			// end.Upload Button
		}
		
		$data .= '';
		$result['data'] = $data;
		echo CJSON::encode($result);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAjaxAdd($id) 
	{
		if(!isset($_GET['type'])) {
			$arrThemes = Utility::getCurrentTemplate('public');
			Yii::app()->theme = $arrThemes['folder'];
			$this->layout = $arrThemes['layout'];
			Utility::applyCurrentTheme($this->module);
		}
		
		$articlePhoto = CUploadedFile::getInstanceByName('namaFile');
		$article_path = "public/article/".$id;
		$fileName	= time().'_'.$id.'.'.strtolower($articlePhoto->extensionName);
		if($articlePhoto->saveAs($article_path.'/'.$fileName)) {
			$model = new ArticleMedia;
			$model->article_id = $id;
			$model->media = $fileName;
			if($model->save()) {
				if(isset($_GET['type']))
					$url = Yii::app()->controller->createUrl('ajaxmanage', array('id'=>$model->article_id,'type'=>'admin','replace'=>'true'));
				else 
					$url = Yii::app()->controller->createUrl('ajaxmanage', array('id'=>$model->article_id));
				echo CJSON::encode(array(
					'id' => 'media-render',
					'get' => $url,
				));
			}
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionAjaxCover($id) 
	{
		if(!isset($_GET['type'])) {
			$arrThemes = Utility::getCurrentTemplate('public');
			Yii::app()->theme = $arrThemes['folder'];
			$this->layout = $arrThemes['layout'];
			Utility::applyCurrentTheme($this->module);
		}
		
		$model = $this->loadModel($id);
		
		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {				
				$model->cover = 1;
				
				if($model->update()) {
					if(isset($_GET['type']))
						$url = Yii::app()->controller->createUrl('ajaxmanage', array('id'=>$model->article_id,'type'=>'admin','replace'=>'true'));
					else 
						$url = Yii::app()->controller->createUrl('ajaxmanage', array('id'=>$model->article_id));
					echo CJSON::encode(array(
						'type' => 2,
						'id' => 'media-render',
						'get' => $url,
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('admin/edit', array('id'=>$model->article_id));
			$this->dialogWidth = 350;

			$this->pageTitle = Phrase::trans(26105,1);
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_cover');
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionAjaxDelete($id) 
	{
		if(!isset($_GET['type'])) {
			$arrThemes = Utility::getCurrentTemplate('public');
			Yii::app()->theme = $arrThemes['folder'];
			$this->layout = $arrThemes['layout'];
			Utility::applyCurrentTheme($this->module);
		}
		$model=$this->loadModel($id);

		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				if($model->delete()) {
					if(isset($_GET['type']))
						$url = Yii::app()->controller->createUrl('ajaxmanage', array('id'=>$model->article_id,'type'=>'admin','replace'=>'true'));
					else 
						$url = Yii::app()->controller->createUrl('ajaxmanage', array('id'=>$model->article_id));
					echo CJSON::encode(array(
						'type' => 2,
						'id' => 'media-render',
						'get' => $url,
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('admin/edit', array('id'=>$model->article_id));
			$this->dialogWidth = 350;

			$this->pageTitle = Phrase::trans(26056,1);
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_delete');
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionManage() 
	{
		$model=new ArticleMedia('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ArticleMedia'])) {
			$model->attributes=$_GET['ArticleMedia'];
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
		
		if(isset($_GET['article'])) {
			$article = Articles::model()->findByPk($_GET['article']);
			$title = ': '.$article->title.' '.Phrase::trans(26062,1).' '.$article->user->displayname;
		} else {
			$title = '';
		}

		$this->pageTitle = Phrase::trans(26074,1).$title;
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

		if(isset($_POST['ArticleMedia'])) {
			$model->attributes=$_POST['ArticleMedia'];
			
			if($model->save()) {
				Yii::app()->user->setFlash('success', Phrase::trans(26075,1));
				$this->redirect(array('edit','id'=>$model->media_id));
			}
		}

		$this->pageTitle = Phrase::trans(26076,1).': '.$model->article->title;
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
		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				$this->loadModel($id)->delete();

				echo CJSON::encode(array(
					'type' => 5,
					'get' => Yii::app()->controller->createUrl('manage'),
					'id' => 'partial-article-media',
					'msg' => '<div class="errorSummary success"><strong>'.Phrase::trans(26078,1).'</strong></div>',
				));
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = Phrase::trans(26077,1);
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
		$model = ArticleMedia::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='article-media-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

<?php
/**
 * PageController
 * Handle PageController
 * version: 1.2.0
 * Reference start
 *
 * TOC :
 *	Index
 *	View
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
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class PageController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
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
		$this->redirect(array('view'));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id=null, $static=null, $picture=null)
	{
		$arrThemes = Utility::getCurrentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
		Utility::applyCurrentTheme($this->module);
		
		//$this->pageGuest = true;
		
		if($id == null) {
			$criteria=new CDbCriteria;
			$criteria->condition = 'publish = :publish';
			$criteria->params = array(':publish'=>1);
			$criteria->order = 'creation_date DESC';

			$dataProvider = new CActiveDataProvider('OmmuPages', array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>10,
				),
			));

			$this->pageTitle = '';
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('application.webs.page.front_index',array(
				'dataProvider'=>$dataProvider,
			));
			
		} else {
			if($static == null) {
				$model=$this->loadModel($id);
				
				$title = Phrase::trans($model->name);
				$description = Phrase::trans($model->desc);				
				$image = ($model->media != '' && $model->media_show == 1) ? Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->request->baseUrl.'/public/page/'.$model->media : '';
				
			} else {
				$server = Utility::getConnected(Yii::app()->params['server_options']['bpad']);
				if($server != 'neither-connected') {
					if(in_array($server, Yii::app()->params['server_options']['localhost']))
						$server = $server.'/bpadportal';			
					$url = $server.preg_replace('('.Yii::app()->request->baseUrl.')', '', Yii::app()->createUrl('api/page/detail'));
					
					$item = array(
						'id' => $id,
					);
					$items = http_build_query($item);
				
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					//curl_setopt($ch,CURLOPT_HEADER, true);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $items);
					$output=curl_exec($ch);	

					$model = json_decode($output);
				}
				
				$title = $model->success == '0' ? 'Page not found' : $model->title;
				$description = $model->success == '0' ? '' : $model->description;
				$image = $model->success == '0' ? '' : ($model->media_image != '-') ? $model->media_image : '';
			}
			
			if(($static == null && $model == null) || ($static != null && $model->success == '0'))
				throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
			
			$this->pageTitleShow = true;
			$this->pageTitle = $title;
			$this->pageDescription = Utility::shortText(Utility::hardDecode($description), 200);
			$this->pageMeta = '';
			$this->pageImage = $image;
			$this->render('application.webs.page.front_view',array(
				'model'=>$model,
				'static'=>$static,
				'picture'=>$picture,
			));
		}
	}
	
	/**
	 * Manages all models.
	 */
	public function actionManage() 
	{
		$model=new OmmuPages('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OmmuPages'])) {
			$model->attributes=$_GET['OmmuPages'];
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

		$this->pageTitle = Yii::t('phrase', 'Manage Pages');
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
		$model=new OmmuPages;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['OmmuPages'])) {
			$model->attributes=$_POST['OmmuPages'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', Yii::t('phrase', 'Pages success created.'));
				$this->redirect(array('manage'));
			}
		}

		$this->pageTitle = Yii::t('phrase', 'Add Pages');
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_add',array(
			'model'=>$model,
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

		if(isset($_POST['OmmuPages'])) {
			$model->attributes=$_POST['OmmuPages'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', Yii::t('phrase', 'Pages success updated.'));
				$this->redirect(array('manage'));
			}
		}

		$this->pageTitle = Yii::t('phrase', 'Update Pages');
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_edit',array(
			'model'=>$model,
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
			    OmmuPages::model()->updateAll(array(
			        'published' => 1,
			    ),$criteria);
			} elseif($actions == 'unpublish') {
			    OmmuPages::model()->updateAll(array(
			        'published' => 0,
			    ),$criteria);
			} elseif($actions == 'trash') {
			    OmmuPages::model()->updateAll(array(
			        'published' => 2,
			    ),$criteria);
			} elseif($actions == 'delete') {
			    OmmuPages::model()->deleteAll($criteria);
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
					'id' => 'partial-pages',
					'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Pages success deleted.').'</strong></div>',
				));
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = Yii::t('phrase', 'Delete Pages');
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
						'id' => 'partial-pages',
						'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Pages success updated.').'</strong></div>',
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
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = OmmuPages::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='ommu-pages-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

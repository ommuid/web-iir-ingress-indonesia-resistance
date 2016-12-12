<?php
/**
 * PageController
 * @var $this PageController
 * @var $model Articles
 * @var $form CActiveForm
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	Main
 *	List
 *	Detail
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 23 Juni 2016, 14:46 WIB
 * @link https://github.com/oMMu/Ommu-Articles
 * @contect (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class PageController extends ControllerApi
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $defaultAction = 'index';

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
				'actions'=>array('index','list','detail'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
				//'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level != 1)',
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
		$this->redirect(Yii::app()->createUrl('site/index'));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionList() 
	{
		if(Yii::app()->request->isPostRequest) {
			$paging = trim($_POST['paging']);
			$pagesize = trim($_POST['pagesize']);
			
			$criteria=new CDbCriteria;
			$criteria->compare('t.publish', 1);
			$criteria->order = 't.page_id DESC';
			
			if($paging != null && $paging != '' && $paging == 'false') {
				$criteria->limit = $pagesize != null && $pagesize != '' ? $pagesize : 5;
				$model = OmmuPages::model()->findAll($criteria);
			} else {
				$dataProvider = new CActiveDataProvider('OmmuPages', array(
					'criteria'=>$criteria,
					'pagination'=>array(
						'pageSize'=>$pagesize != null && $pagesize != '' ? $pagesize : 20,
					),
				));
				$model = $dataProvider->getData();
			}
			
			if(!empty($model)) {
				foreach($model as $key => $item) {
					$page_url = Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->request->baseUrl.'/';
					$page_path = 'public/page/';
					
					if($item->media != '' && file_exists($page_path.$item->media))
						$media_image = $page_url.$page_path.$item->media;
					
					$data[] = array(
						'id'=>$item->page_id,
						'title'=>ucwords(strtolower(Phrase::trans($item->name, 2))),
						'description'=>$item->desc != 0 ? Utility::shortText(Utility::hardDecode(Phrase::trans($item->desc, 2)),200) : '-',
						'quote'=>$item->quote != 0 ? Phrase::trans($item->quote, 2) : '-',
						'media_image'=>$item->media != '' ? $media_image : '-',
						'media_show'=>$item->media_show == 0 ? 'hide' : 'show',
						'media_type'=>$item->media_show != 0 ? (($item->media_type == 0 || $item->media_type == 1) ? 'large' : 'medium') : '-',
						'creation_date'=>Utility::dateFormat($item->creation_date),
					);					
				}
			} else
				$data = array();
			
			if($paging != null && $paging != '' && $paging == 'false')
				$this->_sendResponse(200, CJSON::encode($this->renderJson($data)));
				
			else {
				$pager = OFunction::getDataProviderPager($dataProvider);
				$get = array_merge($_GET, array($pager['pageVar']=>$pager['nextPage']));
				$nextPager = $pager['nextPage'] != 0 ? OFunction::validHostURL(Yii::app()->controller->createUrl('list', $get)) : '-';
				$return = array(
					'data' => $data,
					'pager' => $pager,
					'nextPager' => $nextPager,
				);
				$this->_sendResponse(200, CJSON::encode($this->renderJson($return)));					
			}
			
		} else 
			$this->redirect(Yii::app()->createUrl('site/index'));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionDetail() 
	{
		if(Yii::app()->request->isPostRequest) {
			$id = trim($_POST['id']);
			
			$model = OmmuPages::model()->findByPk($id);
			
			if($model != null) {
				$page_url = Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->request->baseUrl.'/';
				$page_path = 'public/page/';
					
				if($model->media != 0 && file_exists($page_path.'/'.$model->media))
					$media_image = $page_url.$page_path.'/'.$model->media;
				
				$return = array(
					'success'=>'1',
					'id'=>$model->page_id,
					'title'=>ucwords(strtolower(Phrase::trans($model->name, 2))),
					'description'=>$model->desc != 0 ? Utility::softDecode(Phrase::trans($model->desc, 2)) : '-',
					'quote'=>$model->quote != 0 ? Phrase::trans($model->quote, 2) : '-',
					'media_image'=>$model->media != '' ? $media_image : '-',
					'media_show'=>$model->media_show == 0 ? 'hide' : 'show',
					'media_type'=>$model->media_show != 0 ? (($model->media_type == 0 || $model->media_type == 1) ? 'large' : 'medium') : '-',
					'creation_date'=>Utility::dateFormat($model->creation_date),
				);
				
			} else {
				$return = array(
					'success'=>'0',
					'error'=>'NULL',
					'message'=>Yii::t('phrase', 'error, halaman tidak ditemukan'),
				);
			}
			$this->_sendResponse(200, CJSON::encode($this->renderJson($return)));
			
		} else 
			$this->redirect(Yii::app()->createUrl('site/index'));
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

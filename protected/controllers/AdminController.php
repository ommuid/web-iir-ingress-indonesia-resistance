<?php
/**
* AdminController
* Handle AdminController
* Copyright (c) 2013, Ommu Platform (ommu.co). All rights reserved.
* version: 2.0.0
* Reference start
*
* TOC :
*	Index
*	Dashboard
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
			} else {
				throw new CHttpException(404, Phrase::trans(193,0));
			}
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
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('dashboard'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level) && in_array(Yii::app()->user->level, array(1,2))',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
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
		$this->redirect(array('dashboard'));
	}

	/**
	 * Manages all models.
	 */
	public function actionDashboard() 
	{
		/* Wall Post */
		$model=new OmmuWalls;

		/* Get Walll */
		$criteria=new CDbCriteria; 
		$criteria->condition = 'publish = :publish'; 
		$criteria->params = array(':publish'=>1); 
		$criteria->order = 'creation_date DESC'; 

		$dataProvider = new CActiveDataProvider('OmmuWalls', array( 
			'criteria'=>$criteria, 
			'pagination'=>array( 
				'pageSize'=>5, 
			), 
		));
		
		$data = '';
		$wall = $dataProvider->getData();
		if(!empty($wall)) {
			foreach($wall as $key => $item) {
				$data .= Utility::otherDecode($this->renderPartial('/wall/_view', array('data'=>$item), true, false));
			}
		}
		$pager = OFunction::getDataProviderPager($dataProvider);
		if($pager[nextPage] != '0') {
			$summaryPager = 'Displaying 1-'.($pager[currentPage]*$pager[pageSize]).' of '.$pager[itemCount].' results.';
		} else {
			$summaryPager = 'Displaying 1-'.$pager[itemCount].' of '.$pager[itemCount].' results.';
		}
		$nextPager = $pager['nextPage'] != 0 ? Yii::app()->createUrl('wall/get', array($pager['pageVar']=>$pager['nextPage'])) : 0;
		
		$this->pageTitle = Phrase::trans(248,0).', '.Yii::app()->user->displayname.'!';
		$this->pageDescription = Phrase::trans(247,0);
		$this->pageMeta = '';
		$this->render('admin_dashboard', array(
			'model'=>$model,			
			'data'=>$data,
			'pager'=>$pager,
			'summaryPager'=>$summaryPager,
			'nextPager'=>$nextPager,
		));
	}	
}

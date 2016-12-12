<?php
/**
 * SearchController
 * @var $this SearchController
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	Indexing
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contact (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class SearchController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $defaultAction = 'index';
	private $_indexFilesPath = 'application.runtime.search';

	/**
	 * Initialize public template
	 */
	public function init() 
	{
		$arrThemes = Utility::getCurrentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
		
		//load Lucene Library
		Yii::import('application.vendors.*');
		require_once('Zend/Search/Lucene.php');
		parent::init();
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionIndex()
	{
		$this->redirect(Yii::app()->createUrl('site/index'));
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndexing()
	{
		ini_set('max_execution_time', 0);
		ob_start();		
		
		$index = new Zend_Search_Lucene(Yii::getPathOfAlias($this->_indexFilesPath), true);
		
		$plugin = OmmuPlugins::model()->findAll(array(
			'select'    => 'folder, model',
			'condition' => 'actived= :actived AND search= :search',
			'params'    => array(
				':actived' => 1,
				':search' => 1,
			),
		));
		
		if($plugin != null) {
			$model = $data = '';
			foreach($plugin as $key => $val) {
				$model = $val->model;
				Yii::import('application.modules.'.$val->folder.'.models.*');
				$data = new $model();
				$data->searchIndexing($index);
			}
		}
		
		echo 'Lucene index created';
		$index->commit();
		$this->redirect(Yii::app()->createUrl('site/index'));
		
		ob_end_flush();		
	}
 
	public function actionResult()
	{
		if(isset($_GET)) {
			$term = $_GET['keyword'];
			$index = new Zend_Search_Lucene(Yii::getPathOfAlias($this->_indexFilesPath));
			$results = $index->find($term);			
			//print_r($results);
			//exit();
			
			if(isset($_GET['type'])) {
				$dataProvider = new CPagination(count($results));
				$currentPage = Yii::app()->getRequest()->getQuery('page', 1);
				$dataProvider->pageSize = 10;
				
				$pager = OFunction::getDataProviderPager($dataProvider, false);
				$get = array_merge($_GET, array($pager['pageVar']=>$pager['nextPage']));
				$nextPager = $pager['nextPage'] != 0 ? OFunction::validHostURL(Yii::app()->controller->createUrl('result', $get)) : '-';
				//print_r($pager);	
				
				$data = '';
				if(!empty($results)) {
					$i = $currentPage * $dataProvider->pageSize - $dataProvider->pageSize;
					$end = $currentPage * $dataProvider->pageSize;
					//foreach($results as $key => $item) {
					for($i=$i; $i<$end; $i++) {
						$data[] = array(						
							'id'=>CHtml::encode($results[$i]->id),
							'category'=>CHtml::encode($results[$i]->category),
							'media'=>CHtml::encode($results[$i]->media),
							'title'=>CHtml::encode($results[$i]->title),
							'body'=>CHtml::encode($results[$i]->body),
							'date'=>CHtml::encode($results[$i]->date),
							'view'=>CHtml::encode($results[$i]->view),
						);			
					}
				} else
					$data = array();
				
				$return = array(
					'data' => $data,
					'pager' => $pager,
					'nextPager' => $nextPager,
				);
				echo CJSON::encode($return);
				
			} else {
				$query = Zend_Search_Lucene_Search_QueryParser::parse($term);
		
				$this->pageTitleShow = true;
				$this->pageTitle = 'Hasil Pencarian: '.$_GET['keyword'];
				$this->pageDescription = '';
				$this->pageMeta = '';				
				$this->render('application.webs.search.front_result', compact(
					'results', 
					'term', 
					'query'
				));
			}
			
		} else
			$this->redirect(Yii::app()->createUrl('site/index'));
	}
}
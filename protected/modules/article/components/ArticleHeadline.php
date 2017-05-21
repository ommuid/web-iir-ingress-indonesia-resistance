<?php
/**
 * ArticleHeadline
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/mod-article
 * @contact (+62)856-299-4114
 *
 */

class ArticleHeadline extends CWidget
{

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() 
	{
		$module = strtolower(Yii::app()->controller->module->id);
		$controller = strtolower(Yii::app()->controller->id);
		$action = strtolower(Yii::app()->controller->action->id);
		$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		$currentModule = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id);
		$currentModuleAction = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		
		//import model
		Yii::import('application.modules.article.models.Articles');
		Yii::import('application.modules.article.models.ArticleMedia');
		Yii::import('application.modules.article.models.ArticleSetting');
		
		//$cat = ($controller == 'site') ? 1 : 2;
		$model = Articles::model()->findAll(array(
			'condition' => 'publish = :publish AND headline = :headline AND published_date <= curdate()',
			//'condition' => 'publish = :publish AND cat_id = :cat AND headline = :headline AND published_date <= curdate()',
			'params' => array(
				':publish' => 1,
				':headline' => 1,
				//':cat' => $cat,
			),
			'order' => 'article_id DESC',
			'limit' => 1,
		));

		$this->render('article_headline',array(
			'model' => $model,
			'module'=>$module,
			'controller'=>$controller,
			'action'=>$action,
			'currentAction'=>$currentAction,
			'currentModule'=>$currentModule,
			'currentModuleAction'=>$currentModuleAction,
		));
	}
}

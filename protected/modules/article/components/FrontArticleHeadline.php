<?php

class FrontArticleHeadline extends CWidget
{

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() {
		$module = strtolower(Yii::app()->controller->module->id);
		$controller = strtolower(Yii::app()->controller->id);
		$action = strtolower(Yii::app()->controller->action->id);
		$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		
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

		$this->render('front_article_headline',array(
			'model' => $model,
		));
	}
}

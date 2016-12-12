<?php

class FrontArticlePopular extends CWidget
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
		Yii::import('application.modules.article.models.ArticleCategory');
		
		//Category
		//$cat = ($controller == 'site') ? 1 : 2 ;
		$model = Articles::model()->findAll(array(
			//'condition' => 'publish = :publish AND published_date <= curdate()',
			//'condition' => 'publish = :publish AND cat_id = :category AND headline = :headline AND published_date <= curdate()',
			'condition' => 'publish = :publish AND headline = :headline AND published_date <= curdate()',
			'params' => array(
				':publish' => 1,
				//':category'=> $cat,
				':headline'=> 0,
			),
			'order' => 'comment DESC',
			'limit' => 5,
		));

		$this->render('front_article_popular',array(
			'model' => $model,
		));	
	}
}

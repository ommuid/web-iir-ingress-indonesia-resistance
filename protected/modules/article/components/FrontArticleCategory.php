<?php

class FrontArticleCategory extends CWidget
{

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() {
		//import model
		Yii::import('application.modules.article.models.ArticleCategory');

		$model = ArticleCategory::model()->findAll(array(
			'condition' => 'publish = :publish',
			'params' => array(
				':publish' => 1,
			),
		));

		$this->render('front_article_category',array(
			'model' => $model,
		));	
	}
}

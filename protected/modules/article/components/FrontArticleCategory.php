<?php

class FrontArticleCategory extends CWidget
{
	public $publish = null;

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() {
		//import model
		Yii::import('application.modules.article.models.ArticleCategory');

		$criteria=new CDbCriteria;
		if($this->publish != null) {
			$criteria->condition = 'publish = :publish';
			$criteria->params = array(
				':publish'=>$this->publish,
			);			
		}
		$model = ArticleCategory::model()->findAll($criteria);

		$this->render('front_article_category',array(
			'model' => $model,
		));	
	}
}

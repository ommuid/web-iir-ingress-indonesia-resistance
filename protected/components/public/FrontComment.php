<?php

class FrontComment extends CWidget
{

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() {
		$model=new OmmuComment;

		$criteria=new CDbCriteria;
		$criteria->condition = 'publish = :publish AND dependency = :dependency AND plugin_id = :plugin AND content_id = :content';
		$criteria->params = array(
			':publish'=>1,
			':dependency'=>0,
			':plugin'=>Yii::app()->params['plugin'],
			':content'=>$_GET['id'],
		);
		$criteria->order = 'comment_id ASC';

		$comment = new CActiveDataProvider('OmmuComment', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>5,
			),
		));

		$this->render('front_comment', array(
			'model'=>$model,
			'comment'=>$comment,
		));	
	}

}
?>
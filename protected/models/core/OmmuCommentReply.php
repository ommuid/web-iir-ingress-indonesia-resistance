<?php

/**
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 *
 * --------------------------------------------------------------------------------------
 *
 * This is the model class for table "ommu_core_comment_reply".
 *
 * The followings are the available columns in table 'ommu_core_comment_reply':
 * @property string $reply_id
 * @property integer $publish
 * @property string $comment_id
 * @property string $reply
 *
 * The followings are the available model relations:
 * @property OmmuCoreComment $comment
 */
class OmmuCommentReply extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $user_search;
	public $author_search;
	public $comment_search;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OmmuCommentReply the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ommu_core_comment_reply';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('publish, comment_id, reply', 'required'),
			array('publish', 'numerical', 'integerOnly'=>true),
			array('comment_id, reply', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('reply_id, publish, comment_id, reply,
				user_search, author_search, comment_search', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'comment' => array(self::BELONGS_TO, 'OmmuComment', 'reply'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'reply_id' => Phrase::trans(371,0),
			'publish' => Phrase::trans(192,0),
			'comment_id' => Phrase::trans(361,0),
			'reply' => Phrase::trans(371,0),
			'user_search' => Phrase::trans(191,0),
			'author_search' => Phrase::trans(191,0),
			'comment_search' => Phrase::trans(361,0),
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.reply_id',$this->reply_id);
		if(isset($_GET['type']) && $_GET['type'] == 'publish') {
			$criteria->compare('t.publish',1);
		} elseif(isset($_GET['type']) && $_GET['type'] == 'unpublish') {
			$criteria->compare('t.publish',0);
		} elseif(isset($_GET['type']) && $_GET['type'] == 'trash') {
			$criteria->compare('t.publish',2);
		} else {
			$criteria->addInCondition('t.publish',array(0,1));
			$criteria->compare('t.publish',$this->publish);
		}
		if(isset($_GET['comment'])) {
			$criteria->compare('t.comment_id',$_GET['id']);
		} else {
			$criteria->compare('t.comment_id',$this->comment_id);
		}
		$criteria->compare('t.reply',$this->reply);
		
		// Custom Search
		$criteria->with = array(
			'comment.user' => array(
				'alias'=>'user',
				'select'=>'displayname'
			),
			'comment.author' => array(
				'alias'=>'author',
				'select'=>'name'
			),
			'comment' => array(
				'alias'=>'comment',
				'select'=>'comment'
			),
		);
		$criteria->compare('user.displayname',strtolower($this->user_search), true);
		$criteria->compare('author.name',strtolower($this->author_search), true);
		$criteria->compare('comment.comment_search',strtolower($this->comment_search), true);

		if(!isset($_GET['OmmuCommentReply_sort']))
			$criteria->order = 'reply_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>30,
			),
		));
	}


	/**
	 * Get column for CGrid View
	 */
	public function getGridColumn($columns=null) {
		if($columns !== null) {
			foreach($columns as $val) {
				/*
				if(trim($val) == 'enabled') {
					$this->defaultColumns[] = array(
						'name'  => 'enabled',
						'value' => '$data->enabled == 1? "Ya": "Tidak"',
					);
				}
				*/
				$this->defaultColumns[] = $val;
			}
		}else {
			//$this->defaultColumns[] = 'reply_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'comment_id';
			$this->defaultColumns[] = 'reply';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			/*
			$this->defaultColumns[] = array(
				'class' => 'CCheckBoxColumn',
				'name' => 'id',
				'selectableRows' => 2,
				'checkBoxHtmlOptions' => array('name' => 'trash_id[]')
			);
			*/
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			$this->defaultColumns[] = array(
				'name' => 'comment_search',
				'value' => '$data->comment->comment',
			);
			$this->defaultColumns[] = array(
				'name' => 'user_search',
				'value' => '$data->comment->user_id != 0 ? $data->comment->user->displayname."<br/><span>".$data->comment->user->email."</span>" : $data->comment->author->name."<br/><span>".$data->comment->author->email."</span>"',
				'htmlOptions' => array(
					'class' => 'bold',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'header' => Phrase::trans(365,0),
				'value' => 'Utility::dateFormat($data->comment->creation_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
			);
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->reply_id)), $data->publish, 1)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>Phrase::trans(588,0),
						0=>Phrase::trans(589,0),
					),
					'type' => 'raw',
				);
			}
		}
		parent::afterConstruct();
	}

	/**
	 * get update link
	 */
	public static function getReply($id, $count) {
		$reply = '<a href="'.Yii::app()->createUrl('reply/manage', array('comment'=>$id)).'" title="'.$count.' '.Phrase::trans(371,0).'">'.$count.'</a>';

		return $reply;
	}
	
	/**
	 * After save attributes
	 */
	protected function afterSave() {
		parent::afterSave();
		if($this->isNewRecord) {
			$comment = OmmuComment::model()->findByPk($this->comment_id);
			OmmuComment::model()->updateByPk($this->comment_id, array('reply'=>$comment->reply + 1));
		}
	}

	/**
	 * After delete attributes
	 */
	protected function afterDelete() {
		parent::afterDelete();
		$reply = OmmuComment::model()->findByPk($this->reply);
		if($reply->delete()) {
			$comment = OmmuComment::model()->findByPk($this->comment_id);
			OmmuComment::model()->updateByPk($this->comment_id, array('reply'=>$comment->reply - 1));
		}
	}

}
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
 * This is the model class for table "ommu_core_comment".
 *
 * The followings are the available columns in table 'ommu_core_comment':
 * @property string $comment_id
 * @property integer $publish
 * @property integer $dependency
 * @property integer $plugin_id
 * @property string $content_id
 * @property string $user_id
 * @property string $author_id
 * @property integer $reply
 * @property string $comment
 * @property string $creation_date
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property OmmuCorePlugins $plugin
 * @property OmmuCoreCommentReply[] $ommuCoreCommentReplies
 */
class OmmuComment extends CActiveRecord
{
	public $defaultColumns = array();
	public $name;
	public $email;
	public $website;
	public $parent;
	
	// Variable Search
	public $user_search;
	public $author_search;
	public $plugin_search;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OmmuComment the static model class
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
		return 'ommu_core_comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content_id, user_id, comment, 
				name, email', 'required'),
			array('publish, dependency, plugin_id, reply', 'numerical', 'integerOnly'=>true),
			array('content_id, user_id, author_id, modified_id', 'length', 'max'=>11),
			array('email', 'email'),
			array('publish, author_id, reply, modified_id, creation_date, modified_date,
				website, parent', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('comment_id, publish, dependency, plugin_id, content_id, user_id, author_id, reply, comment, creation_date, modified_date, modified_id,
				user_search, author_search, plugin_search', 'safe', 'on'=>'search'),
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
			'plugin' => array(self::BELONGS_TO, 'OmmuPlugins', 'plugin_id'),
			'author' => array(self::BELONGS_TO, 'OmmuAuthorComment', 'author_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'reply' => array(self::HAS_MANY, 'OmmuCommentReply', 'comment_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'comment_id' => Phrase::trans(361,0),
			'publish' => Phrase::trans(192,0),
			'dependency' => Phrase::trans(370,0),
			'plugin_id' => Phrase::trans(368,0),
			'content_id' => Phrase::trans(136,0),
			'user_id' => Phrase::trans(369,0),
			'author_id' => Phrase::trans(191,0),
			'reply' => Phrase::trans(371,0),
			'comment' => Phrase::trans(361,0),
			'creation_date' => Phrase::trans(365,0),
			'modified_date' => Phrase::trans(366,0),
			'modified_id' => Phrase::trans(367,0),
			'name' => Phrase::trans(362,0),
			'email' => Phrase::trans(363,0),
			'website' => Phrase::trans(364,0),
			'parent' => Phrase::trans(370,0),
			'user_search' => Phrase::trans(369,0),
			'author_search' => Phrase::trans(191,0),
			'plugin_search' => Phrase::trans(368,0),
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

		$criteria->compare('t.comment_id',$this->comment_id);
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
		if(isset($_GET['type']) && $_GET['type'] == 'all') {
			$criteria->compare('t.dependency',$this->dependency);
		} else {			
			$criteria->compare('t.dependency',0);
		}
		if(isset($_GET['module'])) {
			$criteria->compare('t.plugin_id',$_GET['module']);
		} else {			
			$criteria->compare('t.plugin_id',$this->plugin_id);
		}		
		$criteria->compare('t.content_id',$this->content_id);
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.author_id',$this->author_id);
		$criteria->compare('t.reply',$this->reply);
		$criteria->compare('t.comment',strtolower($this->comment),true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id',$this->modified_id,true);
		
		// Custom Search
		$criteria->with = array(
			'user' => array(
				'alias'=>'user',
				'select'=>'displayname'
			),
			'author' => array(
				'alias'=>'author',
				'select'=>'name'
			),
			'plugin' => array(
				'alias'=>'plugin',
				'select'=>'name'
			),	
		);
		$criteria->compare('user.displayname',strtolower($this->user_search), true);
		$criteria->compare('author.name',strtolower($this->author_search), true);
		$criteria->compare('plugin.name',strtolower($this->plugin_search), true);

		if(!isset($_GET['OmmuComment_sort']))
			$criteria->order = 'comment_id DESC';

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
			//$this->defaultColumns[] = 'comment_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'dependency';
			$this->defaultColumns[] = 'plugin_id';
			$this->defaultColumns[] = 'content_id';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'author_id';
			$this->defaultColumns[] = 'reply';
			$this->defaultColumns[] = 'comment';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'modified_date';
			$this->defaultColumns[] = 'modified_id';
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
			$this->defaultColumns[] = 'comment';
			$this->defaultColumns[] = array(
				'name' => 'user_search',
				'value' => '$data->user_id != 0 ? $data->user->displayname."<br/><span>".$data->user->email."</span>" : OmmuAuthorComment::getAuthor($data->author->author_id, $data->author->name)."<br/><span>".$data->author->email."</span>"',
				'htmlOptions' => array(
					'class' => 'bold',
				),
				'type' => 'raw',
			);
			if(!isset($_GET['module'])) {
				$this->defaultColumns[] = array(
					'name' => 'plugin_search',
					'value' => '$data->plugin->folder',
					'htmlOptions' => array(
						'class' => 'center',
					),
				);
			}
			$this->defaultColumns[] = array(
				'name' => 'reply',
				'value' => '$data->dependency == 0 ? OmmuCommentReply::getReply($data->comment_id, $data->reply) : "-"',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Utility::dateFormat($data->creation_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this, 
					'attribute'=>'creation_date', 
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'creation_date_filter',
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'dd-mm-yy',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
			);
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->comment_id)), $data->publish, 1)',
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
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->isNewRecord) {
				if(Yii::app()->user->isGuest) {
					$this->user_id = 0;
					$model = OmmuAuthorComment::model()->find(array(
						'select' => 'author_id, email',
						'condition' => 'email = :email',
						'params' => array(
							':email' => $this->email,
						),
					));
					if($model != null) {
						$this->author_id = $model->author_id;
					} else {
						$author = new OmmuAuthorComment;
						$author->name = $this->name;
						$author->email = $this->email;
						$author->website = $this->website;
						if($author->save()) {
							$this->author_id = $author->author_id;
						}
					}

				} else {
					$this->user_id = Yii::app()->user->id;
					$this->author_id = 0;
				}
				$this->reply = 0;
				$this->modified_id = 0;
			} else {
				$this->modified_id = Yii::app()->user->id;
			}			
		}
		return true;
	}
	
	/**
	 * After save attributes
	 */
	protected function afterSave() {
		parent::afterSave();
		if($this->isNewRecord) {
			if($this->dependency == 0) {
				/* $module = strtolower(Yii::app()->controller->module->id);
				$controller = strtolower(Yii::app()->controller->id);
				$action = strtolower(Yii::app()->controller->action->id);
				file_put_contents('tes.txt', $module.'_'.$controller.'_'.$action); */
				/* Yii::import('application.modules.'.$this->plugin->folder.'.models.'.$this->plugin->model);
				$model = $this->plugin->model::model()->findByPk($this->content_id);
				$this->plugin->model::model()->updateByPk($this->content_id, array('comment'=>$model->comment + 1)); */
				if($this->plugin_id == 6) {
					Yii::import('application.modules.product.models.Products');
					$comment = Products::model()->findByPk($this->content_id);
					Products::model()->updateByPk($this->content_id, array('comment'=>$comment->comment + 1));
				
				} else if($this->plugin_id == 17) {
					Yii::import('application.modules.article.models.Articles');
					$comment = Articles::model()->findByPk($this->content_id);
					Articles::model()->updateByPk($this->content_id, array('comment'=>$comment->comment + 1));					
				}
				
			} else {
				$reply = new OmmuCommentReply;
				$reply->publish = 1;
				$reply->comment_id = $this->parent;
				$reply->reply = $this->comment_id;
				$reply->save();
			}
		}
	}

	/**
	 * After delete attributes
	 */
	protected function afterDelete() {
		parent::afterDelete();
		if($this->dependency == 0) {
			if($this->plugin_id == 6) {
				Yii::import('application.modules.product.models.Products');
				$comment = Products::model()->findByPk($this->content_id);
				Products::model()->updateByPk($this->content_id, array('comment'=>$comment->comment - 1));
			
			} else if($this->plugin_id == 17) {
				Yii::import('application.modules.article.models.Articles');
				$comment = Articles::model()->findByPk($this->content_id);
				Articles::model()->updateByPk($this->content_id, array('comment'=>$comment->comment - 1));				
			}
		}
	}

}
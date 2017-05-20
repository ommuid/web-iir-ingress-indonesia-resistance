<?php
/**
 * ArticleLikeDetail
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 7 February 2017, 02:26 WIB
 * @link https://github.com/ommu/Articles
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
 * This is the model class for table "ommu_article_like_detail".
 *
 * The followings are the available columns in table 'ommu_article_like_detail':
 * @property string $id
 * @property integer $publish
 * @property string $like_id
 * @property string $likes_date
 * @property string $likes_ip
 *
 * The followings are the available model relations:
 * @property ArticleLikes $like
 */
class ArticleLikeDetail extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $article_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArticleLikeDetail the static model class
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
		return 'ommu_article_like_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('publish, like_id, likes_ip', 'required'),
			array('publish', 'numerical', 'integerOnly'=>true),
			array('like_id', 'length', 'max'=>11),
			array('likes_ip', 'length', 'max'=>20),
			array('likes_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, publish, like_id, likes_date, likes_ip,
				article_search', 'safe', 'on'=>'search'),
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
			'like' => array(self::BELONGS_TO, 'ArticleLikes', 'like_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('attribute', 'ID'),
			'publish' => Yii::t('attribute', 'Publish'),
			'like_id' => Yii::t('attribute', 'Like'),
			'likes_date' => Yii::t('attribute', 'Likes Date'),
			'likes_ip' => Yii::t('attribute', 'Likes Ip'),
			'article_search' => Yii::t('attribute', 'Article'),
		);
		/*
			'ID' => 'ID',
			'Publish' => 'Publish',
			'Like' => 'Like',
			'Likes Date' => 'Likes Date',
			'Likes Ip' => 'Likes Ip',
		
		*/
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		
		// Custom Search
		$criteria->with = array(
			'like' => array(
				'alias'=>'like',
			),
			'like.article' => array(
				'alias'=>'article',
				'select'=>'title'
			),
		);

		$criteria->compare('t.id',strtolower($this->id),true);
		if(isset($_GET['type']) && $_GET['type'] == 'publish')
			$criteria->compare('t.publish',1);
		elseif(isset($_GET['type']) && $_GET['type'] == 'unpublish')
			$criteria->compare('t.publish',0);
		elseif(isset($_GET['type']) && $_GET['type'] == 'trash')
			$criteria->compare('t.publish',2);
		else {
			$criteria->addInCondition('t.publish',array(0,1));
			$criteria->compare('t.publish',$this->publish);
		}
		if(isset($_GET['like']))
			$criteria->compare('t.like_id',$_GET['like']);
		else
			$criteria->compare('t.like_id',$this->like_id);
		if($this->likes_date != null && !in_array($this->likes_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.likes_date)',date('Y-m-d', strtotime($this->likes_date)));
		$criteria->compare('t.likes_ip',strtolower($this->likes_ip),true);

		$criteria->compare('article.title',strtolower($this->article_search), true);

		if(!isset($_GET['ArticleLikeDetail_sort']))
			$criteria->order = 't.id DESC';

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
		} else {
			//$this->defaultColumns[] = 'id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'like_id';
			$this->defaultColumns[] = 'likes_date';
			$this->defaultColumns[] = 'likes_ip';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			if(!isset($_GET['like'])) {
				$this->defaultColumns[] = array(
					'name' => 'article_search',
					'value' => '$data->like->article->title',
				);				
			}
			$this->defaultColumns[] = array(
				'name' => 'likes_date',
				'value' => 'Utility::dateFormat($data->likes_date)',
				'htmlOptions' => array(
					//'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.components.system.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'likes_date',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'likes_date_filter',
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
			$this->defaultColumns[] = array(
				'name' => 'likes_ip',
				'value' => '$data->likes_ip',
				'htmlOptions' => array(
					//'class' => 'center',
				),
			);
			$this->defaultColumns[] = array(
				'name' => 'publish',
				'value' => '$data->publish == 1 ? Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/unpublish.png\')',
				'htmlOptions' => array(
					//'class' => 'center',
				),
				'type' => 'raw',
			);
		}
		parent::afterConstruct();
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::model()->findByPk($id,array(
				'select' => $column
			));
			return $model->$column;
			
		} else {
			$model = self::model()->findByPk($id);
			return $model;			
		}
	}

}
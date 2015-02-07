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
 * This is the model class for table "ommu_core_page".
 *
 * The followings are the available columns in table 'ommu_core_page':
 * @property integer $page_id
 * @property integer $publish
 * @property string $user_id
 * @property string $name
 * @property string $desc
 * @property string $media
 * @property integer $media_show
 * @property integer $media_type
 * @property string $creation_date
 * @property string $modified_date
 */
class OmmuPages extends CActiveRecord
{
	public $defaultColumns = array();
	public $title;
	public $description;
	public $old_media;
	
	// Variable Search
	public $user_search;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OmmuPages the static model class
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
		return 'ommu_core_pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id,
				title, description', 'required'),
			array('publish, media_show, media_type', 'numerical', 'integerOnly'=>true),
			array('media,
				old_media', 'length', 'max'=>64),
			array('
				title', 'length', 'max'=>256),
			array('media', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			array('media, creation_date, modified_date, 
				old_media', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('page_id, publish, user_id, name, desc, media, media_show, media_type, creation_date, modified_date,
				title, description, user_search', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'title' => array(self::BELONGS_TO, 'OmmuSystemPhrase', 'name'),
			'description' => array(self::BELONGS_TO, 'OmmuSystemPhrase', 'desc'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'page_id' => Phrase::trans(134,0),
			'publish' => Phrase::trans(192,0),
			'user_id' => Phrase::trans(191,0),
			'name' => Phrase::trans(189,0),
			'desc' => Phrase::trans(190,0),
			'title' => Phrase::trans(189,0),
			'media' => Phrase::trans(341,0),
			'media_show' => Phrase::trans(342,0),
			'media_type' => Phrase::trans(343,0),
			'description' => Phrase::trans(190,0),
			'creation_date' => Phrase::trans(365,0),
			'modified_date' => Phrase::trans(446,0),
			'user_search' => Phrase::trans(191,0),
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

		$criteria->compare('t.page_id',$this->page_id);
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
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.name',$this->name);
		$criteria->compare('t.desc',$this->desc);
		$criteria->compare('t.media',strtolower($this->media),true);
		$criteria->compare('t.media_show',$this->media_show);
		$criteria->compare('t.media_type',$this->media_type);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		
		// Custom Search
		$criteria->with = array(
			'user' => array(
				'alias'=>'user',
				'select'=>'displayname'
			),
			'title' => array(
				'alias'=>'title',
				'select'=>'en'
			),
			'description' => array(
				'alias'=>'description',
				'select'=>'en'
			),
		);
		$criteria->compare('user.displayname',strtolower($this->user_search), true);
		$criteria->compare('title.en',strtolower($this->title), true);
		$criteria->compare('description.en',strtolower($this->description), true);
		
		if(!isset($_GET['OmmuPages_sort']))
			$criteria->order = 'page_id DESC';

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
			//$this->defaultColumns[] = 'page_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'name';
			$this->defaultColumns[] = 'desc';
			$this->defaultColumns[] = 'media';
			$this->defaultColumns[] = 'media_show';
			$this->defaultColumns[] = 'media_type';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'modified_date';
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
				'name' => 'title',
				'value' => 'Phrase::trans($data->name, 2)."<br/><span>".Utility::shortText(Utility::hardDecode(Phrase::trans($data->desc, 2)),150)."</span>"',
				'htmlOptions' => array(
					'class' => 'bold',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'user_search',
				'value' => '$data->user->displayname',
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
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->page_id)), $data->publish, 1)',
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
				$this->user_id = Yii::app()->user->id;
			} else {
				$this->modified_id = Yii::app()->user->id;	
			}
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
			$action = strtolower(Yii::app()->controller->action->id);
			if($this->isNewRecord) {
				$title=new OmmuSystemPhrase;
				$title->location = $currentAction;
				$title->en = $this->title;
				if($title->save()) {
					$this->name = $title->phrase_id;
				}

				$desc=new OmmuSystemPhrase;
				$desc->location = $currentAction;
				$desc->en = $this->description;
				if($desc->save()) {
					$this->desc = $desc->phrase_id;
				}
			} else {
				if($action == 'edit') {
					$title = OmmuSystemPhrase::model()->findByPk($this->name);
					$title->en = $this->title;
					$title->save();

					$desc = OmmuSystemPhrase::model()->findByPk($this->desc);
					$desc->en = $this->description;
					$desc->save();
				}
			}
		}
		return true;
	}	
	
	/**
	 * After save attributes
	 */
	protected function afterSave() {
		parent::afterSave();
		$page_path = "public/page";
		$this->media = CUploadedFile::getInstance($this, 'media');
		if($this->media instanceOf CUploadedFile) {
			$fileName = $this->page_id.'_'.time().'.'.$this->media->extensionName;
			if($this->media->saveAs($page_path.'/'.$fileName)) {
				if(!$this->isNewRecord && $this->old_media != ''){
					rename($page_path.'/'.$this->old_media, 'public/page/verwijderen/'.$this->old_media);
				}

				//create thumb image
				Yii::import('ext.phpthumb.PhpThumbFactory');
				$pageImg = PhpThumbFactory::create($page_path.'/'.$fileName, array('jpegQuality' => 90, 'correctPermissions' => true));
				$pageImg->resize(700);
				$pageImg->save($page_path.'/'.$fileName);

				/* Update cover */
				$media = self::model()->findByPk($this->page_id);
				$media->media = $fileName;
				if($this->isNewRecord){
					$media->media_show = 1;
					$media->media_type = 1;
				}
				$media->update();

			}
		}
	}

	/**
	 * After delete attributes
	 */
	protected function afterDelete() {
		parent::afterDelete();
		//delete page image
		$page_path = "public/page";
		if($this->media != '') {
			rename($page_path.'/'.$this->media, 'public/page/verwijderen/'.$this->media);
		}
	}

}
<?php
/**
 * OmmuPages
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
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
 * @property string $quote
 * @property string $media
 * @property integer $media_show
 * @property integer $media_type
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 */
class OmmuPages extends CActiveRecord
{
	public $defaultColumns = array();
	public $title_i;
	public $description_i;
	public $quote_i;
	public $old_media_i;
	
	// Variable Search
	public $user_search;
	public $creation_search;
	public $modified_search;

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
				title_i, description_i', 'required'),
			array('publish, media_show, media_type', 'numerical', 'integerOnly'=>true),
			array('
				title_i', 'length', 'max'=>256),
			//array('media', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			array('media, creation_date, modified_date, 
				quote_i, old_media_i', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('page_id, publish, user_id, name, desc, quote, media, media_show, media_type, creation_date, creation_id, modified_date, modified_id,
				title_i, description_i, quote_i, user_search, creation_search, modified_search', 'safe', 'on'=>'search'),
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
			'view' => array(self::BELONGS_TO, 'ViewPages', 'page_id'),
			'title' => array(self::BELONGS_TO, 'OmmuSystemPhrase', 'name'),
			'description' => array(self::BELONGS_TO, 'OmmuSystemPhrase', 'desc'),
			'quote' => array(self::BELONGS_TO, 'OmmuSystemPhrase', 'quote'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'page_id' => Yii::t('attribute', 'Page'),
			'publish' => Yii::t('attribute', 'Publish'),
			'user_id' => Yii::t('attribute', 'User'),
			'name' => Yii::t('attribute', 'Name'),
			'desc' => Yii::t('attribute', 'Desc'),
			'quote' => Yii::t('attribute', 'Quote'),
			'media' => Yii::t('attribute', 'Media'),
			'media_show' => Yii::t('attribute', 'Media Show'),
			'media_type' => Yii::t('attribute', 'Media Type'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'title_i' => Yii::t('attribute', 'Title'),
			'description_i' => Yii::t('attribute', 'Description'),
			'quote_i' => Yii::t('attribute', 'Quote'),
			'old_media_i' => Yii::t('attribute', 'Old Media'),
			'user_search' => Yii::t('attribute', 'User'),
			'creation_search' => Yii::t('attribute', 'Creation'),
			'modified_search' => Yii::t('attribute', 'Modified'),
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
		
		// Custom Search
		$defaultLang = OmmuLanguages::getDefault('code');
		if(isset(Yii::app()->session['language']))
			$language = Yii::app()->session['language'];
		else 
			$language = $defaultLang;
		
		$criteria->with = array(
			'view' => array(
				'alias'=>'view',
			),
			'title' => array(
				'alias'=>'title',
				'select'=>$language,
			),
			'description' => array(
				'alias'=>'description',
				'select'=>$language,
			),
			'quote' => array(
				'alias'=>'quote',
				'select'=>$language,
			),
			'user' => array(
				'alias'=>'user',
				'select'=>'displayname'
			),
			'creation' => array(
				'alias'=>'creation',
				'select'=>'displayname'
			),
			'modified' => array(
				'alias'=>'modified',
				'select'=>'displayname'
			),
		);

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
		$criteria->compare('t.quote',$this->quote);
		$criteria->compare('t.media',strtolower($this->media),true);
		$criteria->compare('t.media_show',$this->media_show);
		$criteria->compare('t.media_type',$this->media_type);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.creation_id',$this->creation_id);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id',$this->modified_id);
		
		$criteria->compare('title.'.$language,strtolower($this->title_i), true);
		$criteria->compare('description.'.$language,strtolower($this->description_i), true);
		$criteria->compare('quote.'.$language,strtolower($this->quote_i), true);
		$criteria->compare('user.displayname',strtolower($this->user_search), true);
		$criteria->compare('creation.displayname',strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname',strtolower($this->modified_search), true);
		
		if(!isset($_GET['OmmuPages_sort']))
			$criteria->order = 't.page_id DESC';

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
			$this->defaultColumns[] = 'quote';
			$this->defaultColumns[] = 'media';
			$this->defaultColumns[] = 'media_show';
			$this->defaultColumns[] = 'media_type';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'creation_id';
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
			$this->defaultColumns[] = array(
				'name' => 'title_i',
				'value' => 'Phrase::trans($data->name)',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_search',
				'value' => '$data->creation->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Utility::dateFormat($data->creation_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.components.system.CJuiDatePicker', array(
					'model'=>$this, 
					'attribute'=>'creation_date', 
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
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
						1=>Yii::t('phrase', 'Yes'),
						0=>Yii::t('phrase', 'No'),
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
			if($this->isNewRecord)
				$this->user_id = Yii::app()->user->id;
			else
				$this->modified_id = Yii::app()->user->id;
			
			$media = CUploadedFile::getInstance($this, 'media');		
			if($media->name != '') {
				$extension = pathinfo($media->name, PATHINFO_EXTENSION);
				if(!in_array(strtolower($extension), array('bmp','gif','jpg','png')))
					$this->addError('media', 'The file "'.$media->name.'" cannot be uploaded. Only files with these extensions are allowed: bmp, gif, jpg, png.');
			}
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() 
	{
		$action = strtolower(Yii::app()->controller->action->id);
		$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		$location = Utility::getUrlTitle($currentAction);
		
		if(parent::beforeSave()) {
			if($this->isNewRecord || (!$this->isNewRecord && $this->name == 0)) {
				$title=new OmmuSystemPhrase;
				$title->location = $location.'_title';
				$title->en_us = $this->title_i;
				if($title->save())
					$this->name = $title->phrase_id;
				
			} else {
				$title = OmmuSystemPhrase::model()->findByPk($this->name);
				$title->en_us = $this->title_i;
				$title->save();
			}
			
			if($this->isNewRecord || (!$this->isNewRecord && $this->desc == 0)) {
				$desc=new OmmuSystemPhrase;
				$desc->location = $location.'_description';
				$desc->en_us = $this->description_i;
				if($desc->save())
					$this->desc = $desc->phrase_id;
				
			} else {
				$desc = OmmuSystemPhrase::model()->findByPk($this->desc);
				$desc->en_us = $this->description_i;
				$desc->save();
			}
			
			if($this->isNewRecord || (!$this->isNewRecord && $this->quote == 0)) {
				$quote=new OmmuSystemPhrase;
				$quote->location = $location.'_quotes';
				$quote->en_us = $this->quote_i;
				if($quote->save())
					$this->quote = $quote->phrase_id;
				
			} else {
				$quote = OmmuSystemPhrase::model()->findByPk($this->quote);
				$quote->en_us = $this->quote_i;
				$quote->save();	
			}
				
			//upload new photo
			if(in_array($action, array('add','edit'))) 
			{
				$page_path = "public/page";
				// Add directory
				if(!file_exists($page_path)) {
					@mkdir($page_path, 0755, true);

					// Add file in directory (index.php)
					$newFile = $page_path.'/index.php';
					$FileHandle = fopen($newFile, 'w');
				} else
					@chmod($page_path, 0755, true);
				
				$this->media = CUploadedFile::getInstance($this, 'media');
				if($this->media instanceOf CUploadedFile) {
					$fileName = time().'_'.Utility::getUrlTitle(Phrase::trans($this->name)).'.'.strtolower($this->media->extensionName);
					if($this->media->saveAs($page_path.'/'.$fileName)) {
						//create thumb image
						Yii::import('ext.phpthumb.PhpThumbFactory');
						$pageImg = PhpThumbFactory::create($page_path.'/'.$fileName, array('jpegQuality' => 90, 'correctPermissions' => true));
						$pageImg->resize(700);
						if($pageImg->save($page_path.'/'.$fileName)) {
							$this->media_show = 1;
							$this->media_type = 1;
						}
						
						if(!$this->isNewRecord && $this->old_media_i != '' && file_exists($page_path.'/'.$this->old_media_i))
							rename($page_path.'/'.$this->old_media_i, 'public/page/verwijderen/'.$this->page_id.'_'.$this->old_media_i);
						$this->media = $fileName;
					}
				}
				
				if(!$this->isNewRecord && $this->media == '')
					$this->media = $this->old_media_i;
			}
		}
		return true;
	}

	/**
	 * After delete attributes
	 */
	protected function afterDelete() {
		parent::afterDelete();
		//delete page image
		$page_path = "public/page";
		if($this->media != '' && file_exists($page_path.'/'.$this->media)) {
			rename($page_path.'/'.$this->media, 'public/page/verwijderen/'.$this->page_id.'_'.$this->media);
		}
	}

}
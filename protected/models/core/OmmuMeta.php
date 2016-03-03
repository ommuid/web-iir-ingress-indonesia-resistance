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
 * This is the model class for table "ommu_core_meta".
 *
 * The followings are the available columns in table 'ommu_core_meta':
 * @property integer $id
 * @property string $meta_image
 * @property integer $office_on
 * @property string $office_name
 * @property string $office_location
 * @property string $office_place
 * @property integer $office_country
 * @property integer $office_province
 * @property integer $office_city
 * @property string $office_district
 * @property string $office_village
 * @property string $office_zipcode
 * @property string $office_hour
 * @property string $office_phone
 * @property string $office_fax
 * @property string $office_email
 * @property string $office_hotline
 * @property string $office_website
 * @property integer $google_on
 * @property integer $twitter_on
 * @property integer $twitter_card
 * @property string $twitter_site
 * @property string $twitter_creator
 * @property string $twitter_photo_width
 * @property string $twitter_photo_height
 * @property string $twitter_iphone_id
 * @property string $twitter_iphone_url
 * @property string $twitter_ipad_name
 * @property string $twitter_ipad_url
 * @property string $twitter_googleplay_id
 * @property string $twitter_googleplay_url
 * @property integer $facebook_on
 * @property integer $facebook_type
 * @property string $facebook_profile_firstname
 * @property string $facebook_profile_lastname
 * @property string $facebook_profile_username
 * @property string $facebook_sitename
 * @property string $facebook_see_also
 * @property string $facebook_admins
 */
class OmmuMeta extends CActiveRecord
{
	public $defaultColumns = array();
	
	public $old_meta_image;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OmmuMeta the static model class
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
		return 'ommu_core_meta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('office_location, office_place, office_city, office_district, office_village, office_zipcode, office_email', 'required', 'on'=>'contact, google'),
			array('office_on', 'required', 'on'=>'setting, google'),
			array('office_province, office_village, office_hour, office_hotline', 'required', 'on'=>'contact'),
			array('office_website', 'required', 'on'=>'google'),
			array('google_on', 'required', 'on'=>'setting'),
			array('facebook_on', 'required', 'on'=>'setting, facebook, facebook_profile'),
			array('facebook_type', 'required', 'on'=>'facebook, facebook_profile'),
			array('facebook_profile_firstname, facebook_profile_lastname, facebook_profile_username', 'required', 'on'=>'facebook_profile'),
			array('twitter_on', 'required', 'on'=>'setting, twitter, twitter_photo'),
			array('twitter_card, twitter_site, twitter_creator', 'required', 'on'=>'twitter, twitter_photo'),
			array('twitter_photo_width, twitter_photo_height', 'required', 'on'=>'twitter_photo'),
			array('id, office_on, office_country, office_province, office_city, google_on, twitter_on, twitter_card, facebook_on, facebook_type', 'numerical', 'integerOnly'=>true),
			array('meta_image, office_hour,
				old_meta_image', 'length', 'max'=>64),
			array('office_location, office_district, office_village, office_phone, office_fax, office_email, office_hotline, office_website, twitter_site, twitter_creator, twitter_iphone_id, twitter_ipad_name, twitter_googleplay_id, facebook_profile_firstname, facebook_profile_lastname, facebook_profile_username, facebook_sitename, facebook_admins', 'length', 'max'=>32),
			array('office_zipcode', 'length', 'max'=>6),
			array('twitter_photo_width, twitter_photo_height', 'length', 'max'=>3),
			array('twitter_iphone_url, twitter_ipad_url, twitter_googleplay_url, facebook_see_also', 'length', 'max'=>256),
			array('meta_image', 'file', 'allowEmpty' => true, 'types' => 'jpg, jpeg, png, gif'),
			array('office_email', 'email'),
			array('meta_image, office_name, office_province, office_district, office_village, office_phone, office_fax, twitter_photo_width, twitter_photo_height, twitter_iphone_id, twitter_iphone_url, twitter_ipad_name, twitter_ipad_url, twitter_googleplay_id, twitter_googleplay_url, facebook_sitename, facebook_see_also, facebook_admins,
				old_meta_image', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, meta_image, office_on, office_name, office_location, office_place, office_country, office_province, office_city, office_district, office_village, office_zipcode, office_hour, office_phone, office_fax, office_email, office_hotline, office_website, google_on, twitter_on, twitter_card, twitter_site, twitter_creator, twitter_photo_width, twitter_photo_height, twitter_iphone_id, twitter_iphone_url, twitter_ipad_name, twitter_ipad_url, twitter_googleplay_id, twitter_googleplay_url, facebook_on, facebook_type, facebook_profile_firstname, facebook_profile_lastname, facebook_profile_username, facebook_sitename, facebook_see_also, facebook_admins', 'safe', 'on'=>'search'),
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
			'country' => array(self::BELONGS_TO, 'OmmuZoneCountry', 'office_country'),			
			'province' => array(self::BELONGS_TO, 'OmmuZoneProvince', 'office_province'),			
			'city' => array(self::BELONGS_TO, 'OmmuZoneCity', 'office_city'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'meta_image' => Phrase::trans(515,0),
			'office_on' => Phrase::trans(516,0),
			'office_name' => Phrase::trans(595,0),
			'office_location' => Phrase::trans(517,0),
			'office_place' => Phrase::trans(518,0),
			'office_country' => Phrase::trans(519,0),
			'office_province' => Phrase::trans(520,0),
			'office_city' => Phrase::trans(521,0),
			'office_district' => Phrase::trans(522,0),
			'office_village' => Phrase::trans(523,0),
			'office_zipcode' => Phrase::trans(524,0),
			'office_hour' => Phrase::trans(525,0),
			'office_phone' => Phrase::trans(526,0),
			'office_fax' => Phrase::trans(527,0),
			'office_email' => Phrase::trans(528,0),
			'office_hotline' => Phrase::trans(529,0),
			'office_website' => Phrase::trans(530,0),
			'google_on' => Phrase::trans(531,0),
			'twitter_on' => Phrase::trans(532,0),
			'twitter_card' => Phrase::trans(533,0),
			'twitter_site' => Phrase::trans(534,0),
			'twitter_creator' => Phrase::trans(535,0),
			'twitter_photo_width' => Phrase::trans(536,0),
			'twitter_photo_height' => Phrase::trans(537,0),
			'twitter_iphone_id' => Phrase::trans(538,0),
			'twitter_iphone_url' => Phrase::trans(539,0),
			'twitter_ipad_name' => Phrase::trans(540,0),
			'twitter_ipad_url' => Phrase::trans(541,0),
			'twitter_googleplay_id' => Phrase::trans(542,0),
			'twitter_googleplay_url' => Phrase::trans(543,0),
			'facebook_on' => Phrase::trans(544,0),
			'facebook_type' => Phrase::trans(533,0),
			'facebook_profile_firstname' => Phrase::trans(545,0),
			'facebook_profile_lastname' => Phrase::trans(546,0),
			'facebook_profile_username' => Phrase::trans(547,0),
			'facebook_sitename' => Phrase::trans(548,0),
			'facebook_see_also' => Phrase::trans(549,0),
			'facebook_admins' => Phrase::trans(550,0),
			'old_meta_image' => Phrase::trans(587,0),
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

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.meta_image',$this->meta_image,true);
		$criteria->compare('t.office_on',$this->office_on);
		$criteria->compare('t.office_name',$this->office_name,true);
		$criteria->compare('t.office_location',$this->office_location,true);
		$criteria->compare('t.office_place',$this->office_place,true);
		$criteria->compare('t.office_country',$this->office_country);
		$criteria->compare('t.office_province',$this->office_province);
		$criteria->compare('t.office_city',$this->office_city);
		$criteria->compare('t.office_district',$this->office_district);
		$criteria->compare('t.office_village',$this->office_village);
		$criteria->compare('t.office_zipcode',$this->office_zipcode,true);
		$criteria->compare('t.office_hour',$this->office_hour,true);
		$criteria->compare('t.office_phone',$this->office_phone,true);
		$criteria->compare('t.office_fax',$this->office_fax,true);
		$criteria->compare('t.office_email',$this->office_email,true);
		$criteria->compare('t.office_hotline',$this->office_hotline,true);
		$criteria->compare('t.office_website',$this->office_website,true);
		$criteria->compare('t.google_on',$this->google_on);
		$criteria->compare('t.twitter_on',$this->twitter_on);
		$criteria->compare('t.twitter_card',$this->twitter_card);
		$criteria->compare('t.twitter_site',$this->twitter_site,true);
		$criteria->compare('t.twitter_creator',$this->twitter_creator,true);
		$criteria->compare('t.twitter_photo_width',$this->twitter_photo_width,true);
		$criteria->compare('t.twitter_photo_height',$this->twitter_photo_height,true);
		$criteria->compare('t.twitter_iphone_id',$this->twitter_iphone_id,true);
		$criteria->compare('t.twitter_iphone_url',$this->twitter_iphone_url,true);
		$criteria->compare('t.twitter_ipad_name',$this->twitter_ipad_name,true);
		$criteria->compare('t.twitter_ipad_url',$this->twitter_ipad_url,true);
		$criteria->compare('t.twitter_googleplay_id',$this->twitter_googleplay_id,true);
		$criteria->compare('t.twitter_googleplay_url',$this->twitter_googleplay_url,true);
		$criteria->compare('t.facebook_on',$this->facebook_on);
		$criteria->compare('t.facebook_type',$this->facebook_type);
		$criteria->compare('t.facebook_profile_firstname',$this->facebook_profile_firstname,true);
		$criteria->compare('t.facebook_profile_lastname',$this->facebook_profile_lastname,true);
		$criteria->compare('t.facebook_profile_username',$this->facebook_profile_username,true);
		$criteria->compare('t.facebook_sitename',$this->facebook_sitename,true);
		$criteria->compare('t.facebook_see_also',$this->facebook_see_also,true);
		$criteria->compare('t.facebook_admins',$this->facebook_admins,true);

		if(!isset($_GET['OmmuMeta_sort']))
			$criteria->order = 'id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
			//$this->defaultColumns[] = 'id';
			$this->defaultColumns[] = 'meta_image';
			$this->defaultColumns[] = 'office_on';
			$this->defaultColumns[] = 'office_name';
			$this->defaultColumns[] = 'office_location';
			$this->defaultColumns[] = 'office_place';
			$this->defaultColumns[] = 'office_country';
			$this->defaultColumns[] = 'office_province';
			$this->defaultColumns[] = 'office_city';
			$this->defaultColumns[] = 'office_district';
			$this->defaultColumns[] = 'office_village';
			$this->defaultColumns[] = 'office_zipcode';
			$this->defaultColumns[] = 'office_hour';
			$this->defaultColumns[] = 'office_phone';
			$this->defaultColumns[] = 'office_fax';
			$this->defaultColumns[] = 'office_email';
			$this->defaultColumns[] = 'office_hotline';
			$this->defaultColumns[] = 'office_website';
			$this->defaultColumns[] = 'google_on';
			$this->defaultColumns[] = 'twitter_on';
			$this->defaultColumns[] = 'twitter_card';
			$this->defaultColumns[] = 'twitter_site';
			$this->defaultColumns[] = 'twitter_creator';
			$this->defaultColumns[] = 'twitter_photo_width';
			$this->defaultColumns[] = 'twitter_photo_height';
			$this->defaultColumns[] = 'twitter_iphone_id';
			$this->defaultColumns[] = 'twitter_iphone_url';
			$this->defaultColumns[] = 'twitter_ipad_name';
			$this->defaultColumns[] = 'twitter_ipad_url';
			$this->defaultColumns[] = 'twitter_googleplay_id';
			$this->defaultColumns[] = 'twitter_googleplay_url';
			$this->defaultColumns[] = 'facebook_on';
			$this->defaultColumns[] = 'facebook_type';
			$this->defaultColumns[] = 'facebook_profile_firstname';
			$this->defaultColumns[] = 'facebook_profile_lastname';
			$this->defaultColumns[] = 'facebook_profile_username';
			$this->defaultColumns[] = 'facebook_sitename';
			$this->defaultColumns[] = 'facebook_see_also';
			$this->defaultColumns[] = 'facebook_admins';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			$this->defaultColumns[] = 'id';
			$this->defaultColumns[] = 'meta_image';
			$this->defaultColumns[] = 'office_on';
			$this->defaultColumns[] = 'office_name';
			$this->defaultColumns[] = 'office_location';
			$this->defaultColumns[] = 'office_place';
			$this->defaultColumns[] = 'office_country';
			$this->defaultColumns[] = 'office_province';
			$this->defaultColumns[] = 'office_city';
			$this->defaultColumns[] = 'office_district';
			$this->defaultColumns[] = 'office_village';
			$this->defaultColumns[] = 'office_zipcode';
			$this->defaultColumns[] = 'office_hour';
			$this->defaultColumns[] = 'office_phone';
			$this->defaultColumns[] = 'office_fax';
			$this->defaultColumns[] = 'office_email';
			$this->defaultColumns[] = 'office_hotline';
			$this->defaultColumns[] = 'office_website';
			$this->defaultColumns[] = 'google_on';
			$this->defaultColumns[] = 'twitter_on';
			$this->defaultColumns[] = 'twitter_card';
			$this->defaultColumns[] = 'twitter_site';
			$this->defaultColumns[] = 'twitter_creator';
			$this->defaultColumns[] = 'twitter_photo_width';
			$this->defaultColumns[] = 'twitter_photo_height';
			$this->defaultColumns[] = 'twitter_iphone_id';
			$this->defaultColumns[] = 'twitter_iphone_url';
			$this->defaultColumns[] = 'twitter_ipad_name';
			$this->defaultColumns[] = 'twitter_ipad_url';
			$this->defaultColumns[] = 'twitter_googleplay_id';
			$this->defaultColumns[] = 'twitter_googleplay_url';
			$this->defaultColumns[] = 'facebook_on';
			$this->defaultColumns[] = 'facebook_type';
			$this->defaultColumns[] = 'facebook_profile_firstname';
			$this->defaultColumns[] = 'facebook_profile_lastname';
			$this->defaultColumns[] = 'facebook_profile_username';
			$this->defaultColumns[] = 'facebook_sitename';
			$this->defaultColumns[] = 'facebook_see_also';
			$this->defaultColumns[] = 'facebook_admins';
		}
		parent::afterConstruct();
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->office_place == '' && $this->office_district == '' && $this->office_village == '') {
				$this->addError('office_place', Phrase::trans(594,0));
			}
		}
		return true;
	}
	
	/**
	 * After save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			$meta_path = "public";
			$this->meta_image = CUploadedFile::getInstance($this, 'meta_image');
			if($this->meta_image instanceOf CUploadedFile) {
				$fileName = 'meta_'.time().'.'.$this->meta_image->extensionName;
				if($this->meta_image->saveAs($meta_path.'/'.$fileName)) {
					@unlink($meta_path.'/'.$this->old_meta_image);
					$this->meta_image = $fileName;

					//create thumb image
					Yii::import('ext.phpthumb.PhpThumbFactory');
					$pageImg = PhpThumbFactory::create($meta_path.'/'.$fileName, array('jpegQuality' => 90, 'correctPermissions' => true));
					$pageImg->resize(700);
					$pageImg->save($meta_path.'/'.$fileName);
				}
			}
		}
		return true;
	}

}
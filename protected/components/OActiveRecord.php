<?php
/**
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contect (+62)856-299-4114
 *
 */
class OActiveRecord extends CActiveRecord 
{
	private static $otherDB = null;
 
	protected static function getAdvertDbConnection()
	{
		if (self::$otherDB !== null) {
			return self::$otherDB;
			
		} else {
			//self::$otherDB = Yii::app()->inlis;
			if (self::$otherDB instanceof CDbConnection) {
				self::$otherDB->setActive(true);
				return self::$otherDB;
			} else {
				throw new CDbException(Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));
			}
		}
	}
}
?>
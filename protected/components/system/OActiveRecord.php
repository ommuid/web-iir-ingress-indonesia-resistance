<?php
class OActiveRecord extends CActiveRecord 
{
	private static $otherDB = null;
 
	protected static function getAdvertDbConnection()
	{
		if (self::$otherDB !== null) {
			return self::$otherDB;
			
		} else {
			self::$otherDB = Yii::app()->inlis;
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
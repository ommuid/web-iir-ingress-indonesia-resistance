<?php
/**
 * Phrase class file
 * version: 1.2.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 * Generate phrase to print
 */

class Phrase
{
	/**
	 * @var boolean whether to HTML encode the link labels. Defaults to true.
	 */
	public $encodeLabel;
	
	/*
	public function getEncodeLabel() {
		$this->encodeLabel = true;
		return $this->encodeLabel;
	} */
	
	public static function trans($id, $other=null) 
	{
		$model = OmmuSystemPhrase::model()->findByPk($id);
		
		$defaultLang = OmmuLanguages::getDefault('code');
		if(isset(Yii::app()->session['language'])) {
			$language = Yii::app()->session['language'];
			if($model->$language == '')
				$language = $defaultLang;
		} else
			$language = $defaultLang;
		
		if(!empty($other)) {
			$replace = array();
			$search = array();
			$i = 0;
			foreach($other as $label=>$url) {
				$i++;
				if(is_string($label) || is_array($url))
					//$replace[] = CHtml::link($this->getEncodeLabel() ? CHtml::encode($label) : $label, $url, array('title'=>$label));
					$replace[] = CHtml::link($label, $url, array('title'=>$label));
				else
					//$replace[] = $this->getEncodeLabel() ? CHtml::encode($url) : $url;
					$replace[] = $url;
				$search[] = '$'.$i.'';
			}
			$phrase = str_replace($search, $replace, $model->$language);
			
		} else
			$phrase = $model->$language;
		
		return $phrase;
	}
	
	/**
	 * backup old function
	 * 
	public static function trans($id, $type, $other=null) {
		if($type == 1) {
			$model = OmmuPluginPhrase::model()->findByPk($id);
		} else if($type == 2) {
			$model = OmmuSystemPhrase::model()->findByPk($id);
		}
		
		if(isset(Yii::app()->session['language'])) {
			$language = Yii::app()->session['language'];
			$language = 'en_us';
			if($model->$language == '') {
				$language = 'en_us';
			}
		} else {
			$language = 'en_us';
		}
		
		if(!empty($other)) {
			$replace = array();
			$search = array();
			$i = 0;
			foreach($other as $label=>$url) {
				$i++;
				if(is_string($label) || is_array($url))
					//$replace[] = CHtml::link($this->getEncodeLabel() ? CHtml::encode($label) : $label, $url, array('title'=>$label));
					$replace[] = CHtml::link($label, $url, array('title'=>$label));
				else
					//$replace[] = $this->getEncodeLabel() ? CHtml::encode($url) : $url;
					$replace[] = $url;
				$search[] = '$'.$i.'';
			}
			$phrase = str_replace($search, $replace, $model->$language);
			
		} else
			$phrase = $model->$language;
		
		return $phrase;
	}
	*/


}

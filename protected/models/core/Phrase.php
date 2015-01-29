<?php
/**
 * Phrase class file
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
	
	public static function trans($id, $type, $other=null) {
		if($type == 0) {
			$model = OmmuPhrases::model()->findByPk($id);
		} else if($type == 1) {
			$model = OmmuPluginPhrase::model()->findByPk($id);
		} else if($type == 2) {
			$model = OmmuSystemPhrase::model()->findByPk($id);
		}
		
		if(isset(Yii::app()->session['language'])) {
			$language = Yii::app()->session['language'];
			if($model->$language == '') {
				$language = 'en';
			}
		} else {
			$language = 'en';
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


}

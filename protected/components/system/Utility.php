<?php
/**
 * Utility class file
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @create date November 27, 2013 15:02 WIB
 * @version 1.0
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 *
 * Contains many function that most used
 * 
 * getCurrentTemplate
 * applyCurrentTheme
 * getProtocol
 * flashSuccess
 * flashError
 * getDifferenceDay
 * getLocalDayName
 * getLocalMonthName
 * dateFormat
 * getTimThumb
 * replaceSpaceWithUnderscore
 * getUrlTitle
 * deleteFolder
 * getPublish
 * shortText
 * convert_smart_quotes
 * softDecode
 * hardDecode
 * cleanImageContent
 * chmodr
 * recursiveDelete
 * formatSizeUnits
 *
 */

class Utility
{
	/**
	* Return setting template with typePage: public, admin_sweeto or back_office
	*/
	public static function getCurrentTemplate($typePage) {
		$model = OmmuThemes::model()->find(array(
			'select'=>'folder, layout',
			'condition' => 'group_page = :group AND default_theme = "1"',
			'params' => array(':group' => $typePage)
		));
		if($model != null) {
			return array('folder' => $model->folder, 'layout' => $model->layout);
		}
	}

	/**
	 * Refer layout path to current applied theme.
	 *
	 * @param object $module that currently active [optional]
	 * @return void
	 */
	public static function applyCurrentTheme($module = null) {
		$theme = Yii::app()->theme->name;
		Yii::app()->theme = $theme;

		if($module !== null) {
			$themePath = Yii::getPathOfAlias('webroot.themes.'.$theme.'.views.layouts');
			$module->setLayoutPath($themePath);
		}
	}

	/**
	 * Get the proper http URL prefix depending on if this was a secure page request or not
	 *
	 * @return string https or https
	 */
	public static function getProtocol() {
		if(Yii::app()->request->isSecureConnection)
			return 'https';
		return 'http';
	}

	/**
	 * Provide style for success message
	 *
	 * @param mixed $msg
	 */
	 public static function flashSuccess($msg) {
		$result  = '<div class="errorSummary success"><p>';
		$result .= $msg.'</p></div>';
		return $result;
	}

	/**
	 * Provide style for error message
	 *
	 * @param mixed $msg
	 */
	public static function flashError($msg) {
		if($msg != ''){
			$result  = '<div class="errorSummary"><p>';
			$result .= $msg.'</p></div>';
		}
		return $result;
	}

	/**
	 * Difference day
	 */
	public static function getDifferenceDay($date1, $date2)
	{
		$date1 = date('Y-m-d', strtotime($date1));
		$date2 = date('Y-m-d', strtotime($date2));

		$old_splite = explode("-", $date1);
		$old_date = $old_splite[2];
		$old_month = $old_splite[1];
		$old_year = $old_splite[0];

		$new_splite = explode("-", $date2);
		$new_date = $new_splite[2];
		$new_month = $new_splite[1];
		$new_year =  $new_splite[0];

		$old_day = GregorianToJD($old_month, $old_date, $old_year);
		$new_day = GregorianToJD($new_month, $new_date, $new_year);

		$difference = $new_day - $old_day;

		return $difference;
	}

	/**
	Mengembalikan nama hari dalam bahasa indonesia.
	@params short=true, tampilkan dalam 3 huruf, JUM, SAB
	*/
	public static function getLocalDayName($dayName, $short=true) {
		switch($dayName) {
			case 0:
				return ($short ? Phrase::trans(478,0) : Phrase::trans(471,0));
				break;

			case 1:
				return ($short ? Phrase::trans(479,0) : Phrase::trans(472,0));
				break;

			case 2:
				return ($short ? Phrase::trans(480,0): Phrase::trans(473,0));
				break;

			case 3:
				return ($short ? Phrase::trans(481,0) : Phrase::trans(474,0));
				break;

			case 4:
				return ($short ? Phrase::trans(482,0) : Phrase::trans(475,0));
				break;

			case 5:
				return ($short ? Phrase::trans(483,0) : Phrase::trans(476,0));
				break;

			case 6:
				return ($short ? Phrase::trans(484,0) : Phrase::trans(477,0));
				break;
		}
	}

	/* Ubah bulan angka ke nama bulan */
	public static function getLocalMonthName($month, $short=false) {
		if(empty($month))
			return false;

		$bulan = array(
			Phrase::trans(447,0), Phrase::trans(448,0), Phrase::trans(449,0), Phrase::trans(450,0), Phrase::trans(451,0), Phrase::trans(452,0), Phrase::trans(453,0), Phrase::trans(454,0), Phrase::trans(455,0), Phrase::trans(456,0), Phrase::trans(457,0), Phrase::trans(458,0)
		);
		$shortBulan = array(
			Phrase::trans(459,0), Phrase::trans(460,0), Phrase::trans(461,0), Phrase::trans(462,0), Phrase::trans(463,0), Phrase::trans(464,0), Phrase::trans(465,0), Phrase::trans(466,0), Phrase::trans(467,0), Phrase::trans(468,0), Phrase::trans(469,0), Phrase::trans(470,0)
		);

		if($short == true)
			return $shortBulan[$month-1];
		else
			return $bulan[$month-1];
	}
	
	/**
	 * Get date format (general setting)
	 */
	public static function dateFormat($date, $time=false) {
		$setting = OmmuSettings::model()->findByPk(1,array(
			'select' => 'site_dateformat, site_timeformat',
		));
		
		if($time == true) {
			$date = date($setting->site_dateformat, strtotime($date)).' '.date($setting->site_timeformat, strtotime($date));
		} else{
			$date = date($setting->site_dateformat, strtotime($date));
		}
		return $date;
	}
	
	/**
	 * getTimThumb function
	 */
	public static function getTimThumb($src, $width, $height, $zoom, $crop='c') {
		if(isset(Yii::app()->session['timthumb_url_replace'])) {
			$src = str_replace(Yii::app()->request->baseUrl, Yii::app()->session['timthumb_url_replace'], $src);		
		}
		$image = self::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->request->baseUrl.'/timthumb.php?src='.$src.'&h='.$height.'&w='.$width.'&zc='.$zoom.'&a='.$crop;
        return $image;
    }

	/**
	 * replace space with underscore
	 */
	public static function replaceSpaceWithUnderscore($fileName) {
		return str_ireplace(' ', '_', strtolower(trim($fileName)));
	}
	
	/**
	 * Create URL Title
	 *
	 * Takes a "title" string as input and creates a
	 * human-friendly URL string with a "separator" string
	 * as the word separator.
	 *
	 * @todo    Remove old 'dash' and 'underscore' usage in 3.1+.
	 * @param   string  $str        Input string
	 * @param   string  $separator  Word separator
	 *          (usually '-' or '_')
	 * @param   bool    $lowercase  Wether to transform the output string to lowercase
	 * @return  string
	 */
	public static function getUrlTitle($str, $separator = '-', $lowercase = true) {
		if($separator === 'dash') {
			$separator = '-';
		}
		elseif($separator === 'underscore') {
			$separator = '_';
		}

		$qSeparator = preg_quote($separator, '#');
		$trans = array(
				'&.+?:;'         => '',
				'[^a-z0-9 _-]'      => '',
				'\s+'           => $separator,
				'('.$qSeparator.')+'   => $separator
			);

		$str = strip_tags($str);
		foreach ($trans as $key => $val) {
			$str = preg_replace('#'.$key.'#i', $val, $str);
		}

		if ($lowercase === true) {
			$str = strtolower($str);
		}

		return trim(trim($str, $separator));
	}

	/**
	 * remove folder and file
	 */
	public static function deleteFolder($path) {
		if(file_exists($path)) {
			$fh = dir($path);
			while (false !== ($files = $fh->read())) {
				@unlink($fh->path.'/'.$files);
			}
			$fh->close();
			@rmdir($path);
			return true;

		} else {
			return false;
		}
	}

	/**
	 * get publish status
	 * 1 = Publish
	 * 2 = Active
	 * 3 = Enabled
	 * 4 = Dialog
	 * 5 = BUG and Report
	 * 6 = Default
	 * 7 = Verify
	 * 8 = Subcribe
	 * 9 = Headline
	 * 10 = Install
	 */
	public static function getPublish($url, $id, $type) 
	{
		$class = '';
		$arrType = explode(',', $type);
		if(count($arrType) > 1 ) {
			$plus = $arrType[0];
			$min = $arrType[1];
		} else {
			if($type == '1') {
				$plus = Phrase::trans(275,0);
				$min = Phrase::trans(276,0);
			} else if($type == '2') {
				$plus = Phrase::trans(277,0);
				$min = Phrase::trans(278,0);
			} else if($type == '3') {
				$plus = Phrase::trans(283,0);
				$min = Phrase::trans(284,0);
			} else if($type == '4') {
				$plus = Phrase::trans(287,0);
				$min = Phrase::trans(288,0);
			} else if($type == '5') {
				$plus = Phrase::trans(292,0);
				$min = Phrase::trans(291,0);
			} else if($type == '6') {
				$plus = Phrase::trans(156,0);
				$min = Phrase::trans(156,0);
			} else if($type == '7') {
				$plus = Phrase::trans(303,0);
				$min = Phrase::trans(304,0);
			} else if($type == '8') {
				$plus = Phrase::trans(310,0);
				$min = Phrase::trans(309,0);
			} else if($type == '9') {
				$plus = Phrase::trans(338,0);
				$min = Phrase::trans(338,0);
			} else if($type == '9') {
				$plus = Phrase::trans(506,0);
				$min = Phrase::trans(506,0);
			}
		}
		if(!empty(Yii::app()->theme->name))
			$baseUrl = Yii::app()->theme->baseUrl;
		else
			$baseUrl = Yii::app()->request->baseUrl;

		if($id == '1') {
			$publish = '<a href="'.$url.'" title="'.$min.'"><img src="'.$baseUrl.'/images/icons/publish.png" alt="'.$plus.'"></a>';
		} else {
			$publish = '<a href="'.$url.'" title="'.$plus.'"><img src="'.$baseUrl.'/images/icons/unpublish.png" alt="'.$min.'"></a>';
		}

		return $publish;
	}

    /**
	 * shortText
	 */
	public static function shortText ($var, $len = 60, $dotted = "...") {
		if (strlen ($var) < $len) { return $var; }
		if (preg_match ("/(.{1,$len})\s/", $var, $match)) {  return $match [1] . $dotted;  }
		else { return substr ($var, 0, $len) . $dotted; }
	}

    /**
	 * replace smart quotes or franky ugly char by micrsooft word 'copas'
	 */
	public static function convert_smart_quotes($string) {
		$search = array(chr(145), chr(146), chr(147), chr(148), chr(151), chr(150), chr(133), chr(149));
		$replace = array("'", "'", '"', '"', '--', '-', '...', "&bull;");
		return str_replace($search, $replace, $string);
	}

    /**
	 * Cleaning html entities for detail view, so it still 
	 * html tag<p> or <strong>,etc
	 */
	public static function softDecode($string) {
		/*
		$data = htmlspecialchars_decode($string);
		$data= html_entity_decode($string);
		$data = ereg_replace("&quot;", chr(34),$data);
		$data = ereg_replace("&lt;", chr(60),$data);
		$data = ereg_replace("&gt;", chr(62),$data);
		$data = ereg_replace("&amp;", chr(38),$data);
		$data = ereg_replace("&nbsp;", chr(32),$data);
		$data = ereg_replace("&amp;nbsp;", "",$data);
		$data= html_entity_decode($data);
		*/

		$data = get_html_translation_table(HTML_SPECIALCHARS, ENT_QUOTES);
		$data = array_flip($data);
		$original = strtr($string, $data);

		return $original;
	}

    /**
	 * Super Cleaning for decode and strip all html tag
	 */
	public static function hardDecode($string) {
		$data = htmlspecialchars_decode($string);
		$data = html_entity_decode($data);
		$data = strip_tags($data);
		$data = chop(Utility::convert_smart_quotes($data));
		$data = str_replace(array("\r", "\n", "	"), "", $data);

		return ($data);
	}

    /**
	 * Super Cleaning for decode and strip all html tag
	 */
	public static function otherDecode($string) {
		$data = str_replace(array("\r", "\n", "	"), "", $string);

		return ($data);
	}
	
	// Ambil isi berita dan buang image darinya.
	public static function cleanImageContent($content) {
		$posImg = strpos($content, '<img');
		
		$result = $content;
		if($posImg !== false) {
			$posClosedImg = strpos($content, '/>', $posImg) + 2;
			$img = substr($content, $posImg, ($posClosedImg-$posImg));

			$result = str_replace($img, '', $content);
		}
		return $result;	
	}

	/**
	 * Recursively chmod file/folder
	 *
	 * @param string $path
	 * @param octal $fileMode
	 */
	public static function chmodr($path, $fileMode) {
		if (!is_dir($path))
			return chmod($path, $fileMode);

		$dh = opendir($path);
		while (($file = readdir($dh)) !== false) {
			if($file != '.' && $file != '..') {
				$fullpath = $path.'/'.$file;
				if(is_link($fullpath))
					return false;
				elseif(!is_dir($fullpath) && !@chmod($fullpath, $fileMode))
						return false;
				elseif(!self::chmodr($fullpath, $fileMode))
					return false;
			}
		}
		closedir($dh);

		if(@chmod($path, $fileMode))
			return true;
		else
			return false;
	}

	/**
	 * Delete files and folder recursively
	 *
	 * @param string $path path of file/folder
	 */
	public static function recursiveDelete($path) {
		if(is_file($path)) {
			@unlink($path);
		}else {
			$it = new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator($path),
				RecursiveIteratorIterator::CHILD_FIRST
			);

			foreach ($it as $file) {
				if (in_array($file->getBasename(), array('.', '..'))) {
					continue;
				}elseif ($file->isDir()) {
					rmdir($file->getPathname());
				}elseif ($file->isFile() || $file->isLink()) {
					unlink($file->getPathname());
				}
			}
			rmdir($path);
		}
	}

	/**
	 * PHP filesize MB/KB conversion
	 */
	public static function formatSizeUnits($path) {
		$bytes = sprintf('%u', filesize($_SERVER["DOCUMENT_ROOT"].'/'.$path));
		
		$units = explode(' ','B KB MB GB TB PB');
		$mod = 1024;
		for ($i = 0; $bytes > $mod; $i++) {
			 $bytes /= $mod;
		}
		$endIndex = strpos($bytes, ".")+3;
		return substr( $bytes, 0, $endIndex).' '.$units[$i];
	}
}

<?php
/**
 * OFunction class file
 *
 * @author Putra Sudaryanto <putra@sudaryanto.me>
 * @create date April 15, 2014 10:29 WIB
 * @version 1.0
 * @copyright &copy; 2012 Ommu Platform
 *
 * Contains many function that most used
 *
 */

class OFunction
{
	/**
	 * get data provider pager
	 */
	public static function getDataProviderPager($dataProvider)
	{
		$data = $dataProvider->getPagination();
		$pageCount = $data->itemCount >= $data->pageSize ? ($data->itemCount % $data->pageSize === 0 ? (int)($data->itemCount/$data->pageSize) : (int)($data->itemCount/$data->pageSize)+1) : 1;
		$currentPage = $data->itemCount != 0 ? $data->currentPage+1 : 0;
		$nextPage = (($pageCount != $currentPage) && ($pageCount > $currentPage)) ? $currentPage+1 : 0;
		$return = array(
			'pageVar'=>$data->pageVar,
			'itemCount'=>$data->itemCount,
			'pageSize'=>$data->pageSize,
			'pageCount'=>$pageCount,
			'currentPage'=>$currentPage,
			'nextPage'=>$nextPage,
		);
		
		return $return;
	}
	
	/**
	 * PHP Regex to Make Twitter Links Clickable
	 */
	public static function urlParse($data)
	{
		$return = preg_replace('@((https?|ftp)://([-\w\.]+)+(/([\w/_\.]*(\?\S+)?(#\S+)?)?)?)@', '<a off_address="" href="$1" rel="nofollow"target="_blank">$1</a>', $data);		
		return $return;
	}
	
	/**
	 * PHP Regex to Make Twitter Links Clickable
	 */
	public static function twitterParse($data)
	{
		$return = OFunction::urlParse($data);
		$return = preg_replace('#@([\\d\\w]+)#', '<a off_address="" href="https://twitter.com/$1" rel="nofollow" target="_blank">$0</a>', $return);
		$return = preg_replace('/#([\\d\\w]+)/', '<a off_address="" href="https://twitter.com/hashtag/$1?src=hash" rel="nofollow" target="_blank">$0</a>', $return);
		
		return $return;
	}
	
	/**
	 * PHP Regex to Make Twitter Links Clickable
	 */
	public static function OParse($data)
	{
		$return = OFunction::twitterParse($data);
		return $return;
	}

	/**
	 * Valid target api url, if application ecc3 datacenter is accessed from other place
	 * Defined host url + target url
	 */
	public static function validHostURL($targetUrl) {
		$req = Yii::app()->request;
		$url = ($req->port == 80? 'http://': 'https://') . $req->serverName;
		
		if(substr($targetUrl, 0, 1) != '/')
			$targetUrl = '/'.$targetUrl;
				
		return $url = $url.$targetUrl;
	}

	/**
	 * Valid target api url, if application ecc3 datacenter is accessed from other place
	 * Defined host url + target url
	 */
	public static function validFeedbackData($data) {
		return $data != null ? $data : '-';
	}
	
}

<?php
/**
 * MetaTags class file.
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @create date February 20, 2014 14:02 WIB
 * @updated date February 21, 2014 15:50 WIB
 * @version 1.0.1
 * @copyright &copy; 2014 Nirwasita Studio
 */
 
class MetaTags extends CApplicationComponent
{
	/**
	 * @var array Open Graph Meta Tags
	 */
	public $googleOwnerTags = array(); // google discoverability
	public $googlePlusTags = array(); // google plus
	public $facebookTags = array(); // facebook opengraph
	public $twitterTags = array(); // twitter

	/**
	 * Get the proper http URL prefix depending on if this was a secure page request or not
	 *
	 * @return string https or https
	 */
	public function getProtocol() {
		if(Yii::app()->request->isSecureConnection)
			return 'https';
		return 'http';
	}

	/**
	 * Google Discoverability
	 * Registers Google Discoverability meta tags declared
	 * @return void
	 *
	 * Register an Google Discoverability property.
	 * @param string $property
	 * @param string $data
	 */
	public function renderGoogleOwnerMetaTags() {
		foreach ($this->googleOwnerTags as $type => $value) { // loop through any other OG tags declared
			$this->registerGoogleOwner($type, $value);
		}
	}
	
	public function registerGoogleOwner($property, $data)
	{
		Yii::app()->clientScript->registerMetaTag($data, null, null, array('property' => $property));
	}

	/**
	 * Google Plus
	 * Registers Google Plus meta tags declared
	 * @return void
	 *
	 * Register an Google Plus property.
	 * @param string $property
	 * @param string $data
	 */
	public function renderGooglePlusMetaTags() {
		if (!isset($this->googlePlusTags['name']))
			$this->googlePlusTags['name'] = Yii::app()->name; // default to App name
		if (!isset($this->googlePlusTags['url']))
			$this->googlePlusTags['url'] = $this->getProtocol()."://".Yii::app()->request->serverName.Yii::app()->request->requestUri; // defaults to current URL
		foreach ($this->googlePlusTags as $type => $value) { // loop through any other OG tags declared
			$this->registerGooglePlus($type, $value);
		}
	}
	
	public function registerGooglePlus($property, $data)
	{
		Yii::app()->clientScript->registerMetaTag($data, null, null, array('itemprop' => $property));
	}

	/**
	 * Facebook
	 * Registers all of the Open Graph meta tags declared
	 * @return void
	 *
	 * Register an facebook opengraph property.
	 * @param string $property
	 * @param string $data
	 */
	public function renderFacebookMetaTags() {
		if (!isset($this->facebookTags['og:type']))
			$this->facebookTags['og:type'] = 'website'; // set website as the default type
		if (!isset($this->facebookTags['og:title']))
			$this->facebookTags['og:title'] = Yii::app()->name; // default to App name
		if (!isset($this->facebookTags['og:url']))
			$this->facebookTags['og:url'] = $this->getProtocol()."://".Yii::app()->request->serverName.Yii::app()->request->requestUri; // defaults to current URL
		foreach ($this->facebookTags as $type => $value) { // loop through any other OG tags declared
			$this->registerFacebook($type, $value);
		}
	}
	
	public function registerFacebook($property, $data)
	{
		Yii::app()->clientScript->registerMetaTag($data, null, null, array('property' => $property));
	}

	/**
	 * Twitter
	 * Registers Twitter meta tags declared
	 * @return void
	 *
	 * Register an Twitter property.
	 * @param string $property
	 * @param string $data
	 */
	public function renderTwitterMetaTags() {
		if (!isset($this->twitterTags['twitter:card']))
			$this->twitterTags['twitter:card'] = 'summary'; // set website as the default type
		if (!isset($this->twitterTags['twitter:title']))
			$this->twitterTags['twitter:title'] = Yii::app()->name; // default to App name
		if (!isset($this->twitterTags['twitter:url']))
			$this->twitterTags['twitter:url'] = $this->getProtocol()."://".Yii::app()->request->serverName.Yii::app()->request->requestUri; // defaults to current URL
		foreach ($this->twitterTags as $type => $value) { // loop through any other OG tags declared
			$this->registerTwitter($type, $value);
		}
	}
	
	public function registerTwitter($property, $data)
	{
		Yii::app()->clientScript->registerMetaTag($data, null, null, array('name' => $property));
	}
}

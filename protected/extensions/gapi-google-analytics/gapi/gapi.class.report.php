<?php
/**
 * Storage for individual gapi report entries
 *
 */
class gapiReportEntry 
{
	private $metrics = array();
	private $dimensions = array();

	/**
	 * Constructor function for all new gapiReportEntry instances
	 * 
	 * @param Array $metrics
	 * @param Array $dimensions
	 * @return gapiReportEntry
	 */
	public function __construct($metrics, $dimensions) 
	{
		$this->metrics = $metrics;
		$this->dimensions = $dimensions;
	}

	/**
	 * toString function to return the name of the result
	 * this is a concatented string of the dimensions chosen
	 * 
	 * For example:
	 * 'Firefox 3.0.10' from browser and browserVersion
	 *
	 * @return String
	 */
	public function __toString() 
	{
		return is_array($this->dimensions) ? 
			implode(' ', $this->dimensions) : '';
	}

	/**
	 * Get an associative array of the dimensions
	 * and the matching values for the current result
	 *
	 * @return Array
	 */
	public function getDimensions() 
	{
		return $this->dimensions;
	}

	/**
	 * Get an array of the metrics and the matchning
	 * values for the current result
	 *
	 * @return Array
	 */
	public function getMetrics() 
	{
		return $this->metrics;
	}

	/**
	 * Call method to find a matching metric or dimension to return
	 *
	 * @param String $name name of function called
	 * @param Array $parameters
	 * @return String
	 * @throws Exception if not a valid metric or dimensions, or not a 'get' function
	 */
	public function __call($name, $parameters) 
	{
		if(!preg_match('/^get/', $name))
			throw new Exception(Yii::t('phrase', 'No such function $name', array('$name'=>$name)));

		$name = preg_replace('/^get/', '', $name);
		$metric_key = gapi::ArrayKeyExists($name, $this->metrics);

		if($metric_key)
			return $this->metrics[$metric_key];

		$dimension_key = gapi::ArrayKeyExists($name, $this->dimensions);

		if($dimension_key)
			return $this->dimensions[$dimension_key];

		throw new Exception(Yii::t('phrase', 'No valid metric or dimesion called $name', array('$name'=>$name)));
	}
}
?>
<?php
/**
 * GAPI - Google Analytics PHP Interface
 * 
 * http://code.google.com/p/gapi-google-analytics-php-interface/
 * 
 * @copyright Stig Manning 2009
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.	If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author Stig Manning <stig@sdm.co.nz>
 * @author Joel Kitching <jkitching@mailbolt.com>
 * @author Cliff Gordon <clifton.gordon@gmail.com>
 * @version 2.0
 * 
 */

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'gapi.class.account.php'; 
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'gapi.class.report.php'; 
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'gapi.class.oauth.php'; 
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'gapi.class.request.php'; 

class gapi 
{
	const account_data_url = 'https://www.googleapis.com/analytics/v3/management/accountSummaries';
	const report_data_url = 'https://www.googleapis.com/analytics/v3/data/ga';
	const interface_name = 'GAPI-2.0';
	const dev_mode = false;

	private $auth_method = null;
	private $account_entries = array();
	private $report_aggregate_metrics = array();
	private $report_root_parameters = array();
	private $results = array();

	/**
	 * Constructor function for new gapi instances
	 *
	 * @param string $client_email Email of OAuth2 service account (XXXXX@developer.gserviceaccount.com)
	 * @param string $key_file Location/filename of .p12 key file
	 * @param string $delegate_email Optional email of account to impersonate
	 * @return gapi
	 */
	public function __construct($client_email, $key_file, $delegate_email = null) 
	{
		if(version_compare(PHP_VERSION, '5.3.0') < 0)
			throw new Exception(Yii::t('phrase', 'GAPI: PHP version $php is below minimum required 5.3.0.', array('$php'=>PHP_VERSION)));
		
		$this->auth_method = new gapiOAuth2();
		$this->auth_method->fetchToken($client_email, $key_file, $delegate_email);
	}

	/**
	 * Return the auth token string retrieved by Google
	 *
	 * @return String
	 */
	public function getToken() 
	{
		return $this->auth_method->getToken();
	}

	/**
	 * Return the auth token information from the Google service
	 *
	 * @return Array
	 */
	public function getTokenInfo() 
	{
		return $this->auth_method->getTokenInfo();
	}

	/**
	 * Revoke the current auth token, rendering it invalid for future requests
	 *
	 * @return Boolean
	 */
	public function revokeToken() 
	{
		return $this->auth_method->revokeToken();
	}

	/**
	 * Request account data from Google Analytics
	 *
	 * @param Int $start_index OPTIONAL: Start index of results
	 * @param Int $max_results OPTIONAL: Max results returned
	 */
	public function requestAccountData($start_index=1, $max_results=1000) 
	{
		$get_variables = array(
			'start-index' => $start_index,
			'max-results' => $max_results,
		);
		$url = new gapiRequest(gapi::account_data_url);
		$response = $url->get($get_variables, $this->auth_method->generateAuthHeader());

		if(substr($response['code'], 0, 1) == '2')
			return $this->accountObjectMapper($response['body']);
		else
			throw new Exception(Yii::t('phrase', 'GAPI: Failed to request account data. Error: $error', array('$error'=>strip_tags($response['body']))));
	}

	/**
	 * Request report data from Google Analytics
	 *
	 * $report_id is the Google report ID for the selected account
	 * 
	 * $parameters should be in key => value format
	 * 
	 * @param String $report_id
	 * @param Array $dimensions Google Analytics dimensions e.g. array('browser')
	 * @param Array $metrics Google Analytics metrics e.g. array('pageviews')
	 * @param Array $sort_metric OPTIONAL: Dimension or dimensions to sort by e.g.('-visits')
	 * @param String $filter OPTIONAL: Filter logic for filtering results
	 * @param String $start_date OPTIONAL: Start of reporting period
	 * @param String $end_date OPTIONAL: End of reporting period
	 * @param Int $start_index OPTIONAL: Start index of results
	 * @param Int $max_results OPTIONAL: Max results returned
	 */
	public function requestReportData($report_id, $dimensions=null, $metrics, $sort_metric=null, $filter=null, $start_date=null, $end_date=null, $start_index=1, $max_results=10000) 
	{
		$parameters = array('ids'=>'ga:' . $report_id);

		if(is_array($dimensions)) {
			$dimensions_string = '';
			foreach ($dimensions as $dimesion) {
				$dimensions_string .= ',ga:' . $dimesion;
			}
			$parameters['dimensions'] = substr($dimensions_string, 1);
		} elseif($dimensions !== null)
			$parameters['dimensions'] = 'ga:'.$dimensions;

		if(is_array($metrics)) {
			$metrics_string = '';
			foreach ($metrics as $metric) {
				$metrics_string .= ',ga:' . $metric;
			}
			$parameters['metrics'] = substr($metrics_string, 1);
		} else
			$parameters['metrics'] = 'ga:'.$metrics;

		if($sort_metric==null&&isset($parameters['metrics']))
			$parameters['sort'] = $parameters['metrics'];
		
		elseif(is_array($sort_metric)) {
			$sort_metric_string = '';

			foreach ($sort_metric as $sort_metric_value) {
				//Reverse sort - Thanks Nick Sullivan
				if(substr($sort_metric_value, 0, 1) == "-")
					$sort_metric_string .= ',-ga:' . substr($sort_metric_value, 1); // Descending
				else
					$sort_metric_string .= ',ga:' . $sort_metric_value; // Ascending
			}

			$parameters['sort'] = substr($sort_metric_string, 1);
		} else {
			if(substr($sort_metric, 0, 1) == "-")
				$parameters['sort'] = '-ga:' . substr($sort_metric, 1);
			else
				$parameters['sort'] = 'ga:' . $sort_metric;
		}

		if($filter!=null) {
			$filter = $this->processFilter($filter);
			if($filter!==false)
				$parameters['filters'] = $filter;
		}

		if($start_date==null)
			// Use the day that Google Analytics was released (1 Jan 2005).
			$start_date = '2005-01-01';
		elseif(is_int($start_date))
			// Perhaps we are receiving a Unix timestamp.
			$start_date = date('Y-m-d', $start_date);
		$parameters['start-date'] = $start_date;

		if($end_date==null)
			$end_date = date('Y-m-d');
		elseif(is_int($end_date))
			// Perhaps we are receiving a Unix timestamp.
			$end_date = date('Y-m-d', $end_date);
		$parameters['end-date'] = $end_date;


		$parameters['start-index'] = $start_index;
		$parameters['max-results'] = $max_results;

		$parameters['prettyprint'] = gapi::dev_mode ? 'true' : 'false';
		
		$url = new gapiRequest(gapi::report_data_url);
		$response = $url->get($parameters, $this->auth_method->generateAuthHeader());

		//HTTP 2xx
		if(substr($response['code'], 0, 1) == '2')
			return $this->reportObjectMapper($response['body']);
		else
			throw new Exception(Yii::t('phrase', 'GAPI: Failed to request report data. Error: $error', array('$error'=>$this->cleanErrorResponse($response['body']))));
	}
	
	/**
	 * Clean error message from Google API
	 * 
	 * @param String $error Error message HTML or JSON from Google API
	 */
	private function cleanErrorResponse($error) 
	{
		if(strpos($error, '<html') !== false) {
			$error = preg_replace('/<(style|title|script)[^>]*>[^<]*<\/(style|title|script)>/i', '', $error);
			return trim(preg_replace('/\s+/', ' ', strip_tags($error)));
			
		} else {
			$json = json_decode($error);
			return isset($json->error->message) ? strval($json->error->message) : $error;
		}
	}

	/**
	 * Process filter string, clean parameters and convert to Google Analytics
	 * compatible format
	 * 
	 * @param String $filter
	 * @return String Compatible filter string
	 */
	protected function processFilter($filter) 
	{
		$valid_operators = '(!~|=~|==|!=|>|<|>=|<=|=@|!@)';

		$filter = preg_replace('/\s\s+/', ' ', trim($filter)); //Clean duplicate whitespace
		$filter = str_replace(array(',', ';'), array('\,', '\;'), $filter); //Escape Google Analytics reserved characters
		$filter = preg_replace('/(&&\s*|\|\|\s*|^)([a-z0-9]+)(\s*' . $valid_operators . ')/i','$1ga:$2$3',$filter); //Prefix ga: to metrics and dimensions
		$filter = preg_replace('/[\'\"]/i', '', $filter); //Clear invalid quote characters
		$filter = preg_replace(array('/\s*&&\s*/','/\s*\|\|\s*/','/\s*' . $valid_operators . '\s*/'), array(';', ',', '$1'), $filter); //Clean up operators

		if(strlen($filter) > 0)
			return urlencode($filter);
		else
			return false;
	}

	/**
	 * Report Account Mapper to convert the JSON to array of useful PHP objects
	 *
	 * @param String $json_string
	 * @return Array of gapiAccountEntry objects
	 */
	protected function accountObjectMapper($json_string) 
	{
		$json = json_decode($json_string, true);
		$results = array();

		foreach ($json['items'] as $item) {
			foreach ($item['webProperties'] as $property) {
				if(isset($property['profiles'][0]['id']))
					$property['ProfileId'] = $property['profiles'][0]['id'];
				$results[] = new gapiAccountEntry($property);
			}
		}

		$this->account_entries = $results;

		return $results;
	}

	/**
	 * Report Object Mapper to convert the JSON to array of useful PHP objects
	 *
	 * @param String $json_string
	 * @return Array of gapiReportEntry objects
	 */
	protected function reportObjectMapper($json_string) 
	{
		$json = json_decode($json_string, true);

		$this->results = null;
		$results = array();

		$report_aggregate_metrics = array();

		//Load root parameters

		// Start with elements from the root level of the JSON that aren't themselves arrays.
		$report_root_parameters = array_filter($json, function($var){
			return !is_array($var);
		});

		// Get the items from the 'query' object, and rename them slightly.
		foreach($json['query'] as $index => $value) {
			$new_index = lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $index))));
			$report_root_parameters[$new_index] = $value;
		}

		// Now merge in the profileInfo, as this is also mostly useful.
		array_merge($report_root_parameters, $json['profileInfo']);

		//Load result aggregate metrics

		foreach($json['totalsForAllResults'] as $index => $metric_value) {
			//Check for float, or value with scientific notation
			if(preg_match('/^(\d+\.\d+)|(\d+E\d+)|(\d+.\d+E\d+)$/', $metric_value))
				$report_aggregate_metrics[str_replace('ga:', '', $index)] = floatval($metric_value);
			else
				$report_aggregate_metrics[str_replace('ga:', '', $index)] = intval($metric_value);
		}

		//Load result entries
		if(isset($json['rows'])){
			foreach($json['rows'] as $row) {
				$metrics = array();
				$dimensions = array();
				foreach($json['columnHeaders'] as $index => $header) {
					switch($header['columnType']) {
						case 'METRIC':
							$metric_value = $row[$index];
							//Check for float, or value with scientific notation
							if(preg_match('/^(\d+\.\d+)|(\d+E\d+)|(\d+.\d+E\d+)$/',$metric_value))
								$metrics[str_replace('ga:', '', $header['name'])] = floatval($metric_value);
							else
								$metrics[str_replace('ga:', '', $header['name'])] = intval($metric_value);
							break;
						case 'DIMENSION':
							$dimensions[str_replace('ga:', '', $header['name'])] = strval($row[$index]);
							break;
						default:
							throw new Exception("GAPI: Unrecognized columnType '{$header['columnType']}' for columnHeader '{$header['name']}'");
					}
				}
				$results[] = new gapiReportEntry($metrics, $dimensions);
			}
		}

		$this->report_root_parameters = $report_root_parameters;
		$this->report_aggregate_metrics = $report_aggregate_metrics;
		$this->results = $results;

		return $results;
	}

	/**
	 * Get current analytics results
	 *
	 * @return Array
	 */
	public function getResults() 
	{
		return is_array($this->results) ? $this->results : false;
	}

	/**
	 * Get current account data
	 *
	 * @return Array
	 */
	public function getAccounts() 
	{
		return is_array($this->account_entries) ? $this->account_entries : false;
	}

	/**
	 * Get an array of the metrics and the matching
	 * aggregate values for the current result
	 *
	 * @return Array
	 */
	public function getMetrics() 
	{
		return $this->report_aggregate_metrics;
	}

	/**
	 * Call method to find a matching root parameter or 
	 * aggregate metric to return
	 *
	 * @param $name String name of function called
	 * @return String
	 * @throws Exception if not a valid parameter or aggregate 
	 * metric, or not a 'get' function
	 */
	public function __call($name, $parameters) 
	{
		if(!preg_match('/^get/', $name))
			throw new Exception(Yii::t('phrase', 'No such function $name', array('$name'=>$name)));

		$name = preg_replace('/^get/', '', $name);

		$parameter_key = gapi::ArrayKeyExists($name, $this->report_root_parameters);

		if($parameter_key)
			return $this->report_root_parameters[$parameter_key];

		$aggregate_metric_key = gapi::ArrayKeyExists($name, $this->report_aggregate_metrics);

		if($aggregate_metric_key)
			return $this->report_aggregate_metrics[$aggregate_metric_key];

		throw new Exception(Yii::t('phrase', 'No valid root parameter or aggregate metric called $name', array('$name'=>$name)));
	}
	
	/**
	 * Case insensitive array_key_exists function, also returns
	 * matching key.
	 *
	 * @param String $key
	 * @param Array $search
	 * @return String Matching array key
	 */
	public static function ArrayKeyExists($key, $search) 
	{
		if(array_key_exists($key, $search))
			return $key;
		
		if(!(is_string($key) && is_array($search)))
			return false;
		
		$key = strtolower($key);
		foreach ($search as $k => $v) {
			if(strtolower($k) == $key)
				return $k;
		}
		return false;
	}
}




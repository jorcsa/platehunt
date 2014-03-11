<?php

	class Paypal {
	   /**
		* Last error message(s)
		* @var array
		*/
	   protected $_errors = array();
	
	   /**
		* API Version
		* @var string
		*/
	   protected $_version = '74.0';
	   
	   //// CREDENTIALS
	   public $_credentials;
	   public $endpoint;
	   
	   //// CONSTRUCT
	   public function __construct($user, $pwd, $signature, $endpoint) {
		   
		   $this->endpoint = $endpoint;
		   
		   $this->_credentials = array(
		   
		  	  'USER' => $user,
			  'PWD' => $pwd,
			  'SIGNATURE' => $signature,
		   
		   );
		   
	   }
	
	   /**
		* Make API request
		*
		* @param string $method string API method to request
		* @param array $params Additional request parameters
		* @return array / boolean Response array / boolean false on failure
		*/
	   public function request($method,$params = array()) {
		  $this -> _errors = array();
		  if( empty($method) ) { //Check if API method is not empty
			 $this -> _errors = array('API method is missing');
			 return false;
		  }
	
		  //Our request parameters
		  $requestParams = array(
			 'METHOD' => $method,
			 'VERSION' => $this -> _version
		  ) + $this -> _credentials;
	
		  //Building our NVP string
		  $request = http_build_query($requestParams + $params);
	
		  //cURL settings
		  $curlOptions = array (
			 CURLOPT_URL => $this -> endpoint,
			 CURLOPT_VERBOSE => 1,
			 CURLOPT_SSL_VERIFYPEER => false,
			 CURLOPT_SSL_VERIFYHOST => 2,
			 CURLOPT_RETURNTRANSFER => 1,
			 CURLOPT_POST => 1,
			 CURLOPT_POSTFIELDS => $request
		  );
	
		  $ch = curl_init();
		  curl_setopt_array($ch,$curlOptions);
	
		  //Sending our request - $response will hold the API response
		  $response = curl_exec($ch);
	
		  //Checking for cURL errors
		  if (curl_errno($ch)) {
			 $this -> _errors = curl_error($ch);
			 curl_close($ch);
			 return false;
			 //Handle errors
		  } else  {
			 curl_close($ch);
			 $responseArray = array();
			 parse_str($response,$responseArray); // Break the NVP string to an array
			 return $responseArray;
		  }
	   }
	}

?>
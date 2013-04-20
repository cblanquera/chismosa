<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Bayadpo order internal
 *
 * @package    Eden
 * @category   bayadpo
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Bayadpo_OrderInternal extends Eden_Bayadpo_Base {
	/* Constants
	-------------------------------*/
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the calculated price of an order.
	 *
	 * @return mixed
	 */
	public function calculate() {

		// initialize SOAP client
		$client	= new SoapClient(self::ORDERS_INTERNAL);
		
		$funcs	= $client->__getFunctions();
		
		// initialize SOAP header
		$headerbody	= array(self::SECURITY_KEY => $this->_securityKey);
		$header		= new SoapHeader(self::HEADER, self::AUTH, $headerbody);
		$client->__setSoapHeaders($header);
		
		// prepare parameters
		$query = array(
			'SecurityKey'				=> $this->_securityKey,
			'request'					=> array(
				'AccountNumber'				=> $this->_accountNumber,
				'TrackingNumber'			=> $this->_trackingNumber,
				'UTCSubmissionDate'			=> $this->_submissionDate,	//required
				'RequestedBy'				=> $this->_requestBy,
				'DepartmentName'			=> $this->_departmentName,
				'SubaccountName'			=> $this->_subaccountName,
				'PriceSetName'				=> $this->_priceSetName,
				'UTCPickupDate'				=> $this->_pickupDate, 		//required
				'UTCDeliveryDate'			=> $this->_deliveryDate,	//required
				'Description'				=> $this->_description,
				'Comments'					=> $this->_comments,
				'Weight'					=> $this->_weight,			
				'Quantity'					=> $this->_quantity,			
				'Length'					=> $this->_length,		
				'Height'					=> $this->_height,
				'Width'						=> $this->_width,
				'Distance'					=> $this->_distance,
				'ReferenceNumber'			=> $this->_referenceNumber,
				'PurchaseOrderNumber'		=> $this->_purchaseOrderNumber,
				'DeclaredValue'				=> $this->_declaredValue,
				'TriggerWorkflowEvents' 	=> $this->_triggerWorkflowEvents,
				'IncomingTrackingNumber'	=> $this->_incomingTrackingNumber,
				'OutgoingTrackingNumber'	=> $this->_outgoingTrackingNumber,
				'CollectionName'			=> $this->_collectionName,
				'CollectionContact'			=> $this->_collectionContact,
				'CollectionStreet1'			=> $this->_collectionStreet1,
				'CollectionStreet2'			=> $this->_collectionStreet2,
				'CollectionCity'			=> $this->_collectionCity,
				'CollectionState'			=> $this->_collectionState,
				'CollectionPostalCode'		=> $this->_collectionPostalCode,
				'CollectionCountry'			=> $this->_collectionCountry,
				'CollectionPhone'			=> $this->_collectionPhone,
				'CollectionEmail'			=> $this->_collectionEmail,
				'DeliveryName'				=> $this->_deliveryName,
				'DeliveryContact'			=> $this->_deliveryContact,
				'DeliveryStreet1'			=> $this->_deliveryStreet1,
				'DeliveryStreet2'			=> $this->_deliveryStreet2,
				'DeliveryCity'				=> $this->_deliveryCity,
				'DeliveryState'				=> $this->_deliveryState,
				'DeliveryPostalCode'		=> $this->_deliveryPostalCode,
				'DeliveryCountry'			=> $this->_deliveryCountry,
				'DeliveryPhone'				=> $this->_deliveryPhone,
				'DeliveryEmail'				=> $this->_deliveryEmail,
				'Options'					=> $this->_options,
				'Items' 					=> $this->_items
				)
		);	
		// execute SOAP method
		try {
			
			$result = $client->GetTotalPrice($query);
			
		//catch soap fault	
		} catch(SoapFault $soapfault) {
			$this->_exceptionFlag = true;
			$exception = $soapfault->getMessage();
			preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
			//Print error
			return $exception;	
		}
		
		return $result->GetTotalPriceResult;	
	}
	
	/**
	 * Submits an order and returns the tracking number of the order.
	 *	 
	 * @return mixed
	 */
	public function createOrder() {
	
		// initialize SOAP client
		$client	= new SoapClient(self::ORDERS_INTERNAL);
		
		$funcs	= $client->__getFunctions();
		
		// initialize SOAP header
		$headerbody	= array(self::SECURITY_KEY => $this->_securityKey);
		$header		= new SoapHeader(self::HEADER, self::AUTH, $headerbody);
		$client->__setSoapHeaders($header);
		
		
		// prepare parameters
		$query = array(
			'SecurityKey'				=> $this->_securityKey,
			'request'					=> array(
				'AccountNumber'				=> $this->_accountNumber,
				'TrackingNumber'			=> $this->_trackingNumber,
				'UTCSubmissionDate'			=> $this->_submissionDate,	//required
				'UTCDeliveryDate'			=> $this->_deliveryDate,	//required
				'UTCPickupDate'				=> $this->_pickupDate, 		//required
				'RequestedBy'				=> $this->_requestBy,
				'PriceSetName'				=> $this->_priceSetName,
				'Description'				=> $this->_description,
				'Comments'					=> $this->_comments,
				'Weight'					=> $this->_weight,			
				'Quantity'					=> $this->_quantity,			
				'Length'					=> $this->_length,		
				'Height'					=> $this->_height,
				'Width'						=> $this->_width,
				'Distance'					=> $this->_distance,
				'ReferenceNumber'			=> $this->_referenceNumber,
				'PurchaseOrderNumber'		=> $this->_purchaseOrderNumber,
				'DeclaredValue'				=> $this->_declaredValue,
				'TriggerWorkflowEvents' 	=> $this->_triggerWorkflowEvents,
				'IncomingTrackingNumber'	=> $this->_incomingTrackingNumber,
				'OutgoingTrackingNumber'	=> $this->_outgoingTrackingNumber,
				'CollectionName'			=> $this->_collectionName,
				'CollectionContact'			=> $this->_collectionContact,
				'CollectionStreet1'			=> $this->_collectionStreet1,
				'CollectionStreet2'			=> $this->_collectionStreet2,
				'CollectionCity'			=> $this->_collectionCity,
				'CollectionState'			=> $this->_collectionState,
				'CollectionPostalCode'		=> $this->_collectionPostalCode,
				'CollectionCountry'			=> $this->_collectionCountry,
				'CollectionPhone'			=> $this->_collectionPhone,
				'CollectionEmail'			=> $this->_collectionEmail,
				'DeliveryName'				=> $this->_deliveryName,
				'DeliveryContact'			=> $this->_deliveryContact,
				'DeliveryStreet1'			=> $this->_deliveryStreet1,
				'DeliveryStreet2'			=> $this->_deliveryStreet2,
				'DeliveryCity'				=> $this->_deliveryCity,
				'DeliveryState'				=> $this->_deliveryState,
				'DeliveryPostalCode'		=> $this->_deliveryPostalCode,
				'DeliveryCountry'			=> $this->_deliveryCountry,
				'DeliveryPhone'				=> $this->_deliveryPhone,
				'DeliveryEmail'				=> $this->_deliveryEmail,
				'Options'					=> $this->_options,
				'Items' 					=> $this->_items
				)
		);		
		// execute SOAP method
		try {
			$result = $client->CreateOrder($query);
		//catch soap fault	
		} catch(SoapFault $soapfault) {
			$this->_exceptionFlag = true;
			$exception = $soapfault->getMessage();
			preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
			//Print error
			return $error;	
		}
		
		return $result->CreateOrderResult;	
	}
	
	/**
	 * Returns a string array of tracking numbers belonging to a specified status 
	 * and within a specified date range (date the order was submitted). The dates 
	 * should be specified as UTC. A maximum of 10,000 tracking numbers (top sorted 
	 * by most recent date first) may be returned per call
	 *
	 * @param integer 1 = Submitted, 2 = In Transit, 3 = Completed, 4 = Cancelled
	 * @param string Datetime format of start date
	 * @param string Datetime format of end date
	 * @return array
	 */
	public function getOrderByStatus($status, $startDate, $endDate) {
		//argument test
		Eden_Bayadpo_Error::i()
			->argument(1, 'int')		//Argument 1 must be a integer
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string');	//Argument 3 must be a string
		
		// initialize SOAP client
		$client	= new SoapClient(self::ORDERS_INTERNAL);
		$funcs	= $client->__getFunctions();
		
		// initialize SOAP header
		$headerbody	= array(self::SECURITY_KEY => $this->_securityKey);
		$header		= new SoapHeader(self::HEADER, self::AUTH, $headerbody);
		$client->__setSoapHeaders($header);
		
		// prepare parameters
		$query = array(
			'SecurityKey'	=> $this->_securityKey,
			'Status'		=> $status,
			'StartDate'		=> $startDate,
			'EndDate'		=> $endDate);	

		// execute SOAP method
		try {
			$result = $client->GetOrdersByStatus($query);
		//catch soap fault	
		} catch(SoapFault $soapfault) {
			$this->_exceptionFlag = true;
			$exception = $soapfault->getMessage();
			preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
			//Print error
			return $error;	
		}
		
		return $result->GetOrdersByStatusResult;	
	}
	
	/**
	 * Returns the details of a location based on the specified ID. 
	 *
	 * @param string
	 * @return array
	 */
	public function getLocation($locationId) {
		//Argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');	
		
		// initialize SOAP client
		$client	= new SoapClient(self::ORDERS_INTERNAL);
		$funcs	= $client->__getFunctions();
		
		// initialize SOAP header
		$headerbody	= array(self::SECURITY_KEY => $this->_securityKey);
		$header		= new SoapHeader(self::HEADER, self::AUTH, $headerbody);
		$client->__setSoapHeaders($header);
		
		// prepare parameters
		$query = array(
			'SecurityKey'	=> $this->_securityKey,
			'LocationID'	=> $locationId);	

		// execute SOAP method
		try {
			$result = $client->GetLocationAsXML($query);
		//catch soap fault	
		} catch(SoapFault $soapfault) {
			$this->_exceptionFlag = true;
			$exception = $soapfault->getMessage();
			preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
			//Print error
			return $error;	
		}
		
		$response = $result->GetLocationAsXMLResult;
		
		if($this->isXml($response)) {
			//convert xml to array
			$response = json_decode(json_encode((array) simplexml_load_string($result->GetOrderAsXMLResult)), 1);
			
			return $response;
		}
		
		return $response;	
	}
	
	/**
	 * Returns contents of the specified order
	 *
	 * @param string
	 * @return array
	 */
	public function getOrder($trackingNumber) {
		//Argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');	
		
		// initialize SOAP client
		$client	= new SoapClient(self::ORDERS_INTERNAL);
		$funcs	= $client->__getFunctions();
		
		// initialize SOAP header
		$headerbody	= array(self::SECURITY_KEY => $this->_securityKey);
		$header		= new SoapHeader(self::HEADER, self::AUTH, $headerbody);
		$client->__setSoapHeaders($header);
		
		// prepare parameters
		$query = array(
			'SecurityKey'		=> $this->_securityKey,
			'TrackingNumber'	=> $trackingNumber);	

		// execute SOAP method
		try {
			$result = $client->GetOrderAsXML($query);
		//catch soap fault	
		} catch(SoapFault $soapfault) {
			$this->_exceptionFlag = true;
			$exception = $soapfault->getMessage();
			preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
			//Print error
			return $error;	
		}
		
		$response = json_decode(json_encode((array) simplexml_load_string($result->GetOrderAsXMLResult)), 1);
		
		return $response;	
	}
	
	/**
	 * Returns contents of the specified order
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getOrderColumnByName($trackingNumber, $columnName) {
		//Argument test
		Eden_Bayadpo_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string	
		
		// initialize SOAP client
		$client	= new SoapClient(self::ORDERS_INTERNAL);
		$funcs	= $client->__getFunctions();
		
		// initialize SOAP header
		$headerbody	= array(self::SECURITY_KEY => $this->_securityKey);
		$header		= new SoapHeader(self::HEADER, self::AUTH, $headerbody);
		$client->__setSoapHeaders($header);
		
		// prepare parameters
		$query = array(
			'SecurityKey'		=> $this->_securityKey,
			'TrackingNumber'	=> $trackingNumber,
			'ColumnName'		=> $columnName);	

		// execute SOAP method
		try {
			$result = $client->GetOrderColumnByName($query);
		//catch soap fault	
		} catch(SoapFault $soapfault) {
			$this->_exceptionFlag = true;
			$exception = $soapfault->getMessage();
			preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
			//Print error
			return $error;	
		}
		
		return $result->GetOrderColumnByNameResult;	
	}
	
	/**
	 * Sets the COD requirements on an order. Submit the tracking number of 
	 * the order, the amount to be collected, and then two Boolean values 
	 * indicating where collection should take place. When specifying the Boolean 
	 * values, do not set both to "True" since the COD can only be set for either 
	 * the collection or delivery location, not both. Set both Boolean values to 
	 * "False" to disable the COD on the order.
	 *
	 * @param string
	 * @param integer|float
	 * @param boolean
	 * @param boolean
	 * @return mixed
	 */
	public function setCODRequirement($trackingNumber, $amountToCollect, $requireCollectionCOD = true, $RequireDeliveryCOD = true) {
		//Argument test
		Eden_Bayadpo_Error::i()
			->argument(1, 'string')			//Argument 1 must be a string
			->argument(2, 'int', 'float')	//Argument 2 must be a integer or float
			->argument(3, 'string')			//Argument 3 must be a boolean
			->argument(4, 'string');		//Argument 4 must be a boolean	
		
		// initialize SOAP client
		$client	= new SoapClient(self::ORDERS_INTERNAL);
		$funcs	= $client->__getFunctions();
		
		// initialize SOAP header
		$headerbody	= array(self::SECURITY_KEY => $this->_securityKey);
		$header		= new SoapHeader(self::HEADER, self::AUTH, $headerbody);
		$client->__setSoapHeaders($header);
		
		// prepare parameters
		$query = array(
			'SecurityKey'			=> $this->_securityKey,
			'TrackingNumber'		=> $trackingNumber,
			'AmountToCollect'		=> $amountToCollect,
			'RequireCollectionCOD'	=> $requireCollectionCOD,
			'RequireDeliveryCOD'	=> $requireDeliveryCOD);	

		// execute SOAP method
		try {
			$result = $client->SetCODRequirement($query);
		//catch soap fault	
		} catch(SoapFault $soapfault) {
			$this->_exceptionFlag = true;
			$exception = $soapfault->getMessage();
			preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
			//Print error
			return $error;	
		}
		
		return (array) $result;	
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

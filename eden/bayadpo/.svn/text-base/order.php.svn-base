<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Bayadpo order
 *
 * @package    Eden
 * @category   bayadpo
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Bayadpo_Order extends Eden_Bayadpo_Base {
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
	 * Returns contents of the specified order 
	 *
	 * @return mixed
	 */
	public function createOrder() {
		
		// initialize SOAP client
		$client	= new SoapClient(self::ORDERS);
		$funcs	= $client->__getFunctions();
		
		// initialize SOAP header
		$headerbody	= array(self::SECURITY_KEY => $this->_securityKey);
		$header		= new SoapHeader(self::HEADER, self::AUTH, $headerbody);
		$client->__setSoapHeaders($header);
		
		// prepare parameters
		$query = array(
			'AccountNumber'				=> $this->_accountNumber,
			'RequestedBy'				=> $this->_requestBy,
			'UTCPickupDate'				=> $this->_pickupDate,				//required
			'UTCDeliveryDate'			=> $this->_deliveryDate,			//required
			'Description'				=> $this->_description,
			'Comments'					=> $this->_comments,
			'ReferenceNumber'			=> $this->_referenceNumber,
			'PurchaseOrderNumber'		=> $this->_purchaseOrderNumber,
			'IncomingTrackingNumber'	=> $this->_incomingTrackingNumber,
			'OutgoingTrackingNumber'	=> $this->_outgoingTrackingNumber,
			'DeclaredValue'				=> $this->_declaredValue,
			'Quantity'					=> $this->_quantity,
			'Weight'					=> $this->_weight,
			'Height'					=> $this->_height,
			'Width'						=> $this->_width,
			'Depth'						=> $this->_depth,
			'TriggerWrokflowEvents'		=> $this->_triggerWorkflowEvents,
			'PickupName'				=> $this->_pickupName,
			'PickupContact'				=> $this->_pickupContact,
			'PickupStreet1'				=> $this->_pickupStreet1,
			'PickupStreet2'				=> $this->_pickupStreet2,
			'PickupCity'				=> $this->_pickupCity,
			'PickupState'				=> $this->_pickupState,
			'PickupPostalCode'			=> $this->_pickupPostalCode,
			'PickupCountry'				=> $this->_pickupCountry,
			'PickupEmail'				=> $this->_pickupEmail,
			'PickupPhoneNumber'			=> $this->_pickupPhoneNumber,			
			'DeliveryName'				=> $this->_deliveryName,
			'DeliveryContact'			=> $this->_deliveryContact,	
			'DeliveryStreet1'			=> $this->_deliveryStreet1,
			'DeliveryStreet2'			=> $this->_deliveryStreet2,
			'DeliveryCity'				=> $this->_deliveryCity,
			'DeliveryState'				=> $this->_deliveryState,
			'DeliveryPostalCode'		=> $this->_deliveryPostalCode,
			'DeliveryCountry'			=> $this->_deliveryCountry,
			'DeliveryEmail'				=> $this->_deliveryEmail,
			'DeliveryPhoneNumber'		=> $this->_deliveryPhone
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
			return $soapfault;	
		}
		
		return $result->CreateOrderResult;	
	}
	
	/**
	 * Returns status of a tracking number 
	 *
	 * @param string
	 * @param string
	 * @return mixed
	 */
	public function getStatus($accountNumber, $trackingNumber) {
		//argument test
		Eden_Bayadpo_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		// initialize SOAP client
		$client	= new SoapClient(self::ORDERS);
		$funcs	= $client->__getFunctions();
		
		// initialize SOAP header
		$headerbody	= array(self::SECURITY_KEY => $this->_securityKey);
		$header		= new SoapHeader(self::HEADER, self::AUTH, $headerbody);
		$client->__setSoapHeaders($header);
		
		// prepare parameters
		$query = array(
			'AccountNumber'		=> $accountNumber,
			'TrackingNumber'	=> $trackingNumber);
		
		// execute SOAP method
		try {
			$result = $client->GetStatus($query);
		//catch soap fault	
		} catch(SoapFault $soapfault) {
			$this->_exceptionFlag = true;
			$exception = $soapfault->getMessage();
			preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
			//Print error
			return $error;	
		}
		
		return $result->GetStatusResult;
	}	
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Bayadpo base
 *
 * @package    Eden
 * @category   bayad po
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com 
 */
class Eden_Bayadpo_Base extends Eden_Oauth_Base {
	/* Constants
	-------------------------------*/
	const ORDERS 			= 'http://www.ontimesystem.com/sites/Bayadpo/ws/orders.asmx?wsdl';
	const ORDERS_INTERNAL 	= 'http://www.ontimesystem.com/sites/Bayadpo/ws/orders_internal.asmx?wsdl';
	const HEADER			= 'http://www.ontimesystem.com/sites/';
	const AUTH				= 'AuthHeader';
	const SECURITY_KEY		= 'SecurityKey';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_securityKey 			= NULL;
	protected $_accountNumber 			= NULL;
	protected $_trackingNumber 			= NULL;
	protected $_submissionDate 			= NULL;	 //'2013-01-05T08:33:46Z',
	protected $_deliveryDate 			= NULL;
	protected $_pickupDate 				= NULL;
	protected $_requestBy 				= NULL;
	protected $_priceSetName 			= NULL;
	protected $_description 			= NULL;
	protected $_comments 				= NULL;
	protected $_weight 					= 0;
	protected $_quantity 				= 0;
	protected $_length 					= 0;
	protected $_height 					= 0;
	protected $_width 					= 0;
	protected $_distance 				= 0;
	protected $_depth	 				= 0;
	protected $_referenceNumber 		= NULL;
	protected $_purchaseOrderNumber 	= NULL;
	protected $_declaredValue 			= 0;
	protected $_triggerWorkflowEvents 	= false;
	protected $_incomingTrackingNumber 	= NULL;
	protected $_outgoingTrackingNumber 	= NULL;
	protected $_subaccountName			= NULL;
	protected $_departmentName			= NULL;

	protected $_collectionName 			= NULL;
	protected $_collectionContact 		= NULL;
	protected $_collectionStreet1 		= NULL;
	protected $_collectionStreet2 		= NULL;
	protected $_collectionCity 			= NULL;
	protected $_collectionState 		= NULL;
	protected $_collectionPostalCode 	= NULL;
	protected $_collectionCountry 		= NULL;
	protected $_collectionPhone 		= NULL;
	protected $_collectionEmail 		= NULL;
	
	protected $_deliveryName 			= NULL;
	protected $_deliveryContact 		= NULL;
	protected $_deliveryStreet1 		= NULL;
	protected $_deliveryStreet2 		= NULL;
	protected $_deliveryCity 			= NULL;
	protected $_deliveryState 			= NULL;
	protected $_deliveryPostalCode 		= NULL;
	protected $_deliveryCountry 		= NULL;
	protected $_deliveryPhone 			= NULL;
	protected $_deliveryEmail 			= NULL;
	
	protected $_pickupName					= NULL;
	protected $_pickupContact				= NULL;
	protected $_pickupStreet1				= NULL;
	protected $_pickupStreet2				= NULL;
	protected $_pickupCity					= NULL;
	protected $_pickupState					= NULL;
	protected $_pickupPostalCode			= NULL;
	protected $_pickupCountry				= NULL;
	protected $_pickupEmail					= NULL;
	protected $_pickupPhoneNumber			= NULL;
	
	protected $_options 				= array();
	protected $_items		 			= array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __construct($securityKey) {
		//argument test
		Eden_Bayadpo_Error::i()->argument(1, 'string');		
		
		$this->_securityKey = $securityKey; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * 
	 *
	 * @param string
	 * @return this
	 */
	public function setAccountNumber($accountNumber) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_accountNumber = $accountNumber;
		
		return $this;
	}
       
        /**
         *
         *
         * @param string
         * @return this
         */
        public function setCollectionPostalCode($postalCode) {
                //argument 1 must be a string
                Eden_Bayadpo_Error::i()->argument(1, 'string');

                $this->_collectionPostalCode = $postalCode;

                return $this;
        }

	
	/**
	 * Set tracking number
	 *
	 * @param string
	 * @return this
	 */
	public function setTrackingNumber($trackingNumber) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_trackingNumber = $trackingNumber;
		
		return $this;
	}
	
	/**
	 * Set submission date
	 *
	 * @param string In date time format
	 * @return this
	 */
	public function setSubmissionDate($date) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		//convert date to datetime format
		$date = date('Y-m-d\TH:i:s\Z', strtotime($date));
		
		$this->_submissionDate = $date;
		
		return $this;
	}
	
	/**
	 * Set delivery date
	 *
	 * @param string In date time format
	 * @return this
	 */
	public function setDeliveryDate($date) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		//convert date to datetime format
		$date = date('Y-m-d\TH:i:s\Z', strtotime($date));
		
		$this->_deliveryDate = $date;
		
		return $this;
	}
	
	/**
	 * Set pickup date
	 *
	 * @param string In date time format
	 * @return this
	 */
	public function setPickupDate($date) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		//convert date to datetime format
		$date = date('Y-m-d\TH:i:s\Z', strtotime($date));
		
		$this->_pickupDate = $date;
		
		return $this;
	}
	
	/**
	 * Set who request by
	 *
	 * @param string 
	 * @return this
	 */
	public function requestBy($requestBy) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_requestBy = $requestBy;
		
		return $this;
	}
	
	/**
	 * Set price set name
	 *
	 * @param string
	 * @return this
	 */
	public function setPriceSetName($priceSetName) {
		//argument 1 must be a integer
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_priceSetName = $priceSetName;
		
		return $this;
	}
	
	/**
	 * Set description
	 *
	 * @param string
	 * @return this
	 */
	public function setDescription($description) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_description = $description;
		
		return $this;
	}
	
	/**
	 * Set comment
	 *
	 * @param string
	 * @return this
	 */
	public function setComment($comment) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_comments = $comment;
		
		return $this;
	}
	
	/**
	 * Set distance
	 *
	 * @param integer
	 * @return this
	 */
	public function setDistance($distance) {
		//argument 1 must be a integer
		Eden_Bayadpo_Error::i()->argument(1, 'int', 'float');
		
		$this->_distance = $distance;
		
		return $this;
	}
	
	/**
	 * Set reference number
	 *
	 * @param string|integer
	 * @return this
	 */
	public function setReferenceNumber($referenceNumber) {
		//argument 1 must be a integer or string
		Eden_Bayadpo_Error::i()->argument(1, 'int', 'string');
		
		$this->_referenceNumber = $referenceNumber;
		
		return $this;
	}
	
	/**
	 * Set Purchase Order Number
	 *
	 * @param string|integer
	 * @return this
	 */
	public function setPurchaseOrderNumber($purchaseOrderNumber) {
		//argument 1 must be a integer or string
		Eden_Bayadpo_Error::i()->argument(1, 'int', 'string');
		
		$this->_purchaseOrderNumber = $purchaseOrderNumber;
		
		return $this;
	}
	
	/**
	 * Set declared value
	 *
	 * @param integer
	 * @return this
	 */
	public function setDeclaredValue($declaredValue) {
		//argument 1 must be a integer
		Eden_Bayadpo_Error::i()->argument(1, 'int');
		
		$this->_declaredValue = $declaredValue;
		
		return $this;
	}
	
	/**
	 * Set Trigger Workflow Events
	 *
	 * @return this
	 */
	public function setTriggerWorkflowEvents() {
		
		$this->_triggerWorkflowEvents = true;
		
		return $this;
	}
	
	/**
	 * Set incoming tracking number
	 *
	 * @param integer
	 * @return this
	 */
	public function setIncomingTrackingNumber($trackingNumber) {
		//argument 1 must be a integer
		Eden_Bayadpo_Error::i()->argument(1, 'int');
		
		$this->_incomingTrackingNumber = $trackingNumber;
		
		return $this;
	}
	
	/**
	 * Set outgoing tracking number
	 *
	 * @param integer
	 * @return this
	 */
	public function setOutgoingTrackingNumber($trackingNumber) {
		//argument 1 must be a integer
		Eden_Bayadpo_Error::i()->argument(1, 'int');
		
		$this->_outgoingTrackingNumber = $trackingNumber;
		
		return $this;
	}
	
	/**
	 * Set collection name
	 *
	 * @param string
	 * @return this
	 */
	public function setCollectionName($collectionName) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_collectionName = $collectionName;
		
		return $this;
	}
	
	/**
	 * Set collection contact
	 *
	 * @param string
	 * @return this
	 */
	public function setCollectionContact($collectionContact) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_collectionContact = $collectionContact;
		
		return $this;
	}
	
	/**
	 * Set collection street 1
	 *
	 * @param string
	 * @return this
	 */
	public function setCollectionStreet1($collectionStreet1) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_collectionStreet1 = $collectionStreet1;
		
		return $this;
	}
	
	/**
	 * Set collection street 2
	 *
	 * @param string
	 * @return this
	 */
	public function setCollectionStreet2($collectionStreet2) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_collectionStreet2 = $collectionStreet2;
		
		return $this;
	}
	
	/**
	 * Set collection city
	 *
	 * @param string
	 * @return this
	 */
	public function setCollectionCity($collectionCity) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_collectionCity = $collectionCity;
		
		return $this;
	}
	
	/**
	 * Set collection city
	 *
	 * @param string
	 * @return this
	 */
	public function setCollectionState($collectionState) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_collectionState = $collectionState;
		
		return $this;
	}
	
	/**
	 * Set collection postal code
	 *
	 * @param string
	 * @return this
	 */
	public function setCollectionPostal($collectionPostalCode) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_collectionPostalCode = $collectionPostalCode;
		
		return $this;
	}
	
	/**
	 * Set collection country
	 *
	 * @param string
	 * @return this
	 */
	public function setCollectionCountry($collectionCountry) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_collectionCountry = $collectionCountry;
		
		return $this;
	}
	
	/**
	 * Set collection phone
	 *
	 * @param string
	 * @return this
	 */
	public function setCollectionPhone($collectionPhone) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_collectionPhone = $collectionPhone;
		
		return $this;
	}
	
	/**
	 * Set collection email
	 *
	 * @param string
	 * @return this
	 */
	public function setCollectionEmail($collectionEmail) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_collectionEmail = $collectionEmail;
		
		return $this;
	}
	
	/**
	 * Set delivery name
	 *
	 * @param string
	 * @return this
	 */
	public function setDeliveryName($deliveryName) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_deliveryName = $deliveryName;
		
		return $this;
	}
	
	/**
	 * Set delivery contact
	 *
	 * @param string
	 * @return this
	 */
	public function setDeliveryContact($deliveryContact) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_deliveryContact = $deliveryContact;
		
		return $this;
	}
	
	/**
	 * Set delivery street1
	 *
	 * @param string
	 * @return this
	 */
	public function setDeliveryStreet1($deliveryStreet1) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_deliveryStreet1 = $deliveryStreet1;
		
		return $this;
	}
	
	/**
	 * Set delivery street2
	 *
	 * @param string
	 * @return this
	 */
	public function setDeliveryStreet2($deliveryStreet2) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_deliveryStreet2 = $deliveryStreet2;
		
		return $this;
	}
	
	/**
	 * Set delivery city
	 *
	 * @param string
	 * @return this
	 */
	public function setDeliveryCity($deliveryCity) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_deliveryCity = $deliveryCity;
		
		return $this;
	}
	
	/**
	 * Set delivery state
	 *
	 * @param string
	 * @return this
	 */
	public function setDeliveryState($deliveryState) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_deliveryState = $deliveryState;
		
		return $this;
	}
	
	/**
	 * Set delivery state
	 *
	 * @param string
	 * @return this
	 */
	public function setDeliveryPostalCode($deliveryPostalCode) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_deliveryPostalCode = $deliveryPostalCode;
		
		return $this;
	}
	
	/**
	 * Set delivery Country
	 *
	 * @param string
	 * @return this
	 */
	public function setDeliveryCountry($deliveryCountry) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_deliveryCountry = $deliveryCountry;
		
		return $this;
	}
	
	/**
	 * Set delivery phone
	 *
	 * @param string
	 * @return this
	 */
	public function setDeliveryPhone($deliveryPhone) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_deliveryPhone = $deliveryPhone;
		
		return $this;
	}
	
	/**
	 * Set delivery email
	 *
	 * @param string
	 * @return this
	 */
	public function setDeliveryEmail($deliveryEmail) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_deliveryEmail = $deliveryEmail;
		
		return $this;
	}
	
	/**
	 * Set items
	 *
	 * @param string
	 * @param string
	 * @param integer
	 * @param integer
	 * @param integer
	 * @param integer
	 * @return this
	 */
	public function setItems($description, $comments, $height, $width, $depth, $weight) {
		//argument testing
		Eden_Bayadpo_Error::i()
			->argument(1, 'string')	//argument 1 must be a string
			->argument(2, 'string')	//argument 2 must be a string
			->argument(3, 'int','float' )	//argument 3 must be a integer
			->argument(4, 'int','float' )	//argument 4 must be a integer
			->argument(5, 'int','float' )	//argument 5 must be a integer
			->argument(6, 'int','float' );	//argument 6 must be a integer
		
		$this->_items[]	= array(
			'Description'	=> $description,
			'Comments'		=> $comments,
			'Height'		=> $height,
			'Width'			=> $width,
			'Depth'			=> $depth,
			'Weight'		=> $weight);
		
		$this->_height		= $this->_height + $height;
		$this->_width		= $this->_width + $width;
		$this->_weight		= $this->_weight + $weight;
		$this->_length		= $this->_length + $depth;
		$this->_quantity	= count($this->_items);

		return $this;
	}
	
	/**
	 * Set options
	 *
	 * @param string
	 * @param string
	 * @return this
	 */
	public function setOptions($name, $value) {
		//argument testing
		Eden_Bayadpo_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string', 'int');	//argument 2 must be a string
		
		$this->_options[]	= array(
			'Name'			=> $name,
			'CustomValue'	=> $value);
		
		return $this;
	}
	
	/**
	 * Set pickup number
	 *
	 * @param string
	 * @return this
	 */
	public function setPickupName($pickupName) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_pickupName	= $pickupName;
		
		return $this;
	}
	
	/**
	 * Set pickup contact
	 *
	 * @param string
	 * @return this
	 */
	public function setPickupContact($pickupContact) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_pickupContact	= $pickupContact;
		
		return $this;
	}
	
	/**
	 * Set pickup street1
	 *
	 * @param string
	 * @return this
	 */
	public function setPickupStreet1($pickupStreet1) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_pickupStreet1	= $pickupStreet1;
		
		return $this;
	}
	
	/**
	 * Set pickup street2
	 *
	 * @param string
	 * @return this
	 */
	public function setPickupStreet2($pickupStreet2) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_pickupStreet2	= $pickupStreet2;
		
		return $this;
	}
	
	/**
	 * Set pickup city
	 *
	 * @param string
	 * @return this
	 */
	public function setPickupCity($pickupCity) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_pickupCity	= $pickupCity;
		
		return $this;
	}
	
	/**
	 * Set pickup state
	 *
	 * @param string
	 * @return this
	 */
	public function setPickupState($pickupState) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_pickupState	= $pickupState;
		
		return $this;
	}
	
	/**
	 * Set pickup postal code
	 *
	 * @param string
	 * @return this
	 */
	public function setPickupPostalCode($pickupPostalCode) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_pickupPostalCode	= $pickupPostalCode;
		
		return $this;
	}
	
	/**
	 * Set pickup country
	 *
	 * @param string
	 * @return this
	 */
	public function setPickupCountry($pickupCountry) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_pickupCountry	= $pickupCountry;
		
		return $this;
	}
	
	/**
	 * Set pickup email
	 *
	 * @param string
	 * @return this
	 */
	public function setPickupEmail($pickupEmail) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_pickupEmail	= $pickupEmail;
		
		return $this;
	}
	
	/**
	 * Set pickup phone number
	 *
	 * @param string
	 * @return this
	 */
	public function setPickupPhoneNumber($pickupPhoneNumber) {
		//argument 1 must be a string
		Eden_Bayadpo_Error::i()->argument(1, 'string');
		
		$this->_pickupPhoneNumber	= $pickupPhoneNumber;
		
		return $this;
	}
	
	/**
	 * Check if the response is xml
	 *
	 * @param string|array|object|null
	 * @return bollean
	 */
	public function isXml($xml) {
		//argument 1 must be a string, array,  object or null
		Eden_Bayadpo_Error::i()->argument(1, 'string', 'array', 'object', 'null');
		
		if(is_array($xml) || is_null($xml)) {
			return false;
		}
		libxml_use_internal_errors( true );
		$doc = new DOMDocument('1.0', 'utf-8');
		$doc->loadXML($xml);
		$errors = libxml_get_errors();
		
		return empty($errors);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

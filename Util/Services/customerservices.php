<?php

	require_once(BASE_PATH."/Conf/service_conf.php");
   	//require_once(BASE_PATH."/Util/logger.php");
	require_once(BASE_PATH."/Conf/resultobject.php");
	
	class customerservices{
		
		function customerservices(){
			
			global $SERVICE_URl, $WEBSERVICE_USERNAME, $WEBSERVICE_PASSWORD;
			
			$WEBSERVICE_USERNAME = "MotorHappy";
			$WEBSERVICE_PASSWORD = "MotorHappy";
			
			$this->params 	= array('cache_wsdl' => WSDL_CACHE_NONE,"soap_version"=> SOAP_1_1, "trace"=>1, "exceptions"=>0, "login"=>$WEBSERVICE_USERNAME, "password"=>$WEBSERVICE_PASSWORD);
			
			/*$opts = array(
            'ssl' => array('ciphers'=>'RC4-SHA', 'verify_peer'=>false, 'verify_peer_name'=>false)
			);
			 
			$this->params 	= array(//"soap_version"=> SOAP_1_1,
									//"trace"=>1,
									//"exceptions"=>1,
									"login"=>$WEBSERVICE_USERNAME,
									"password"=>$WEBSERVICE_PASSWORD,
									//'encoding' => 'UTF-8',
									'verifypeer' => false,
									'verifyhost' => false,
									'soap_version' => SOAP_1_1,
									'trace' => 1,
									'exceptions' => 1,
									"connection_timeout" => 180,
									'stream_context' => stream_context_create($opts)
									
									);*/
			
			$this->wsdl 	= $SERVICE_URl.'/PinkElephant/CustomerService.svc?wsdl';
            //$this->log = new logger();
		}
		
		// To Check if Customer is Exist with telesure
		function fn_CustomerExist($idno, $passportno){
			
            $params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = array();
			try{
				$soap = new SoapClient($wsdl,$params);								
				$args = array('identificationNo'=> $idno, 'passportNo' => $passportno);
				$responce = $soap->CustomerExist($args);
			} 
			catch (SoapFault $e){
				$responce['faultcode'] 		= $e->faultcode;
			    $responce['faultstring'] 	= $e->faultstring;
			    $responce['faultactor'] 	= $e->faultactor;
			    $responce['faultname'] 		= $e->faultname;
			    $responce['headerfault'] 	= $e->headerfault;
			}

          
			return $responce;
		}
		
		// Get Customer details 
		function fn_CustomerDataGet(){
			$params = $this->params;
			$wsdl 	= $this->wsdl;   
			$responce = "";
			try{
				$responce['data'] =  $this->token;
				$soap = new SoapClient($wsdl,$params);
				$args = array('token' => $this->token);
				$responce = $soap->CustomerDataGet($args);
			} 
			catch (SoapFault $e) {
				//$responce = "";
			   	//$responce = 'Caught exception:'.$e->getMessage()."\n";
			   	
			   	$responce['faultcode'] 		= $e->faultcode;
			    $responce['faultstring'] 	= $e->faultstring;
			    $responce['faultactor'] 	= $e->faultactor;
			    $responce['faultname'] 		= $e->faultname;
			    $responce['headerfault'] 	= $e->headerfault;
			}
			return $responce;
		}

		// Create Customer to telesure with null token.
		function fn_CustomerCreate($customerModel){
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try{
				$soap = new SoapClient($wsdl,$params);								
				$args = array('token'=> null, 'customerModel' => $customerModel);
				$responce = $soap->CustomerCreate($args);
				
			} 
			catch (SoapFault $e){				
			   	$responce['faultcode'] 		= $e->faultcode;
			    $responce['faultstring'] 	= $e->faultstring;
			    $responce['faultactor'] 	= $e->faultactor;
			    $responce['faultname'] 		= $e->faultname;
			    $responce['headerfault'] 	= $e->headerfault;
			}
			return $responce;
		}
		
		#Update any changes to the CustomerModel for the specific CustomerID. 
		#Remarks: the customer must exist. A customer cannot be created using this method.
		#Param token: the security token of the user. The token cannot be empty.
		#Param customerModel: the data of the customer to be updated.
		#Returns a CustomerModel upon successful execution.
		function fn_InsuranceCustomerUpdate($insuranceCustomerModel){
			$params = $this->params;
			$wsdl 	= $this->wsdl; 
			$responce = "";
			try{
				$soap = new SoapClient($wsdl,$params);
                $args = array(
                    'token'     => $this->token,
                    'insuranceCustomerModel'  => $insuranceCustomerModel
                );
                $responce = $soap->InsuranceCustomerUpdate($args);
			} 
			catch (SoapFault $e) {
				//$responce = "";
			   	//$responce = 'Caught exception:'.$e->getMessage()."\n";
			   	
			   	$responce['faultcode'] 		= $e->faultcode;
			    $responce['faultstring'] 	= $e->faultstring;
			    $responce['faultactor'] 	= $e->faultactor;
			    $responce['faultname'] 		= $e->faultname;
			    $responce['headerfault'] 	= $e->headerfault;
			}
			return $responce;
		}
		
		function fn_InsuranceCustomerAdd($customerId,$insuranceCustomerModel){
			$params = $this->params;
			$wsdl 	= $this->wsdl; 
			$responce = "";
			try{
				$soap = new SoapClient($wsdl,$params);
                $args = array(
                    'token'     => $this->token,
					'customerId' => $customerId,
                    'insuranceCustomerModel'  => $insuranceCustomerModel
                );
                $responce = $soap->InsuranceCustomerAdd($args);
			} 
			catch (SoapFault $e){
				//$responce = "";
			   	//$responce = 'Caught exception:'.$e->getMessage()."\n";
			   	
			   	$responce['faultcode'] 		= $e->faultcode;
			    $responce['faultstring'] 	= $e->faultstring;
			    $responce['faultactor'] 	= $e->faultactor;
			    $responce['faultname'] 		= $e->faultname;
			    $responce['headerfault'] 	= $e->headerfault;
			}
			return $responce;
		}
		
		function fn_InsuranceCustomerVehicleAdd($customerVehicleId,$InsuranceCustomerModel){
			$params = $this->params;
			$wsdl 	= $this->wsdl; 
			$responce = "";
			try {
				$soap = new SoapClient($wsdl,$params);
                $args = array(
                    'token'     => $this->token,
					'customerVehicleId' => $customerVehicleId,
                    'insuranceCustomerModel'  => $InsuranceCustomerModel
                );
                $responce = $soap->InsuranceCustomerVehicleAdd($args);
			} 
			catch (SoapFault $e) {
				//$responce = "";
			   	//$responce = 'Caught exception:'.$e->getMessage()."\n";
			   	
			   	$responce['faultcode'] 		= $e->faultcode;
			    $responce['faultstring'] 	= $e->faultstring;
			    $responce['faultactor'] 	= $e->faultactor;
			    $responce['faultname'] 		= $e->faultname;
			    $responce['headerfault'] 	= $e->headerfault;
			}
			return $responce;
		}
		
		function fn_CustomerVehicleAdd($customerVehicleModel, $CustomerID) {
            $params = $this->params;
            $wsdl 	= $this->wsdl;
            $response = "";
            try{
                $args = array(
                    'token' => $this->token,
                    'customerID' => $CustomerID,
                    'customerVehicleModel'=> $customerVehicleModel
                );

                $soap = new SoapClient($wsdl,$params);
                $response = $soap->CustomerVehicleAdd($args);

            }
            catch (SoapFault $e) {
				//$responce = "";
			   	//$responce = 'Caught exception:'.$e->getMessage()."\n";
			   	
			   	$responce['faultcode'] 		= $e->faultcode;
			    $responce['faultstring'] 	= $e->faultstring;
			    $responce['faultactor'] 	= $e->faultactor;
			    $responce['faultname'] 		= $e->faultname;
			    $responce['headerfault'] 	= $e->headerfault;
			}
            return $response;
        }
        
		
		function fn_InsuranceCustomerVehicleUpdate($insuranceCustomerVehicleModel){
			$params = $this->params;
			$wsdl 	= $this->wsdl; 
			$responce = "";
			try	{
				$soap = new SoapClient($wsdl,$params);
                $args = array(
                    'token'     => $this->token,
					'insuranceCustomerVehicleModel'  => $insuranceCustomerVehicleModel
                );
                $responce = $soap->InsuranceCustomerVehicleUpdate($args);
			} 
			catch (SoapFault $e) {
				//$responce = "";
			   	//$responce = 'Caught exception:'.$e->getMessage()."\n";
			   	
			   	$responce['faultcode'] 		= $e->faultcode;
			    $responce['faultstring'] 	= $e->faultstring;
			    $responce['faultactor'] 	= $e->faultactor;
			    $responce['faultname'] 		= $e->faultname;
			    $responce['headerfault'] 	= $e->headerfault;
			}
			return $responce;
		}
		
		function fn_CustomerVehicleRemove($customerID, $customerVehicleID) {
			$params = $this->params;
			$wsdl 	= $this->wsdl; 
			$responce = "";
			try	{
				$soap = new SoapClient($wsdl,$params);
                $args = array(
                    'token'     => $this->token,
					'customerID' => $customerID,
                    'customerVehicleID'  => $customerVehicleID
                );
                $responce = $soap->CustomerVehicleRemove($args);
			} 
			catch (SoapFault $e) {
				//$responce = "";
			   	//$responce = 'Caught exception:'.$e->getMessage()."\n";
			   	
			   	$responce['faultcode'] 		= $e->faultcode;
			    $responce['faultstring'] 	= $e->faultstring;
			    $responce['faultactor'] 	= $e->faultactor;
			    $responce['faultname'] 		= $e->faultname;
			    $responce['headerfault'] 	= $e->headerfault;
			}
			return $responce;
		}
		
		// To set customer's details
		function fn_CustomerUpdate($customerModel){
			$params = $this->params;
			$wsdl 	= $this->wsdl; 
			$responce = array();
			try	{
				$soap = new SoapClient($wsdl,$params);
                $args = array(
                    'token'				=> $this->token,
                    'customerModel'		=> $customerModel
                );
                $responce['resultData'] 	= $soap->CustomerUpdate($args);
				$responce['resultStatus'] 	= resultConstant::Success;
				
			} 
			catch (SoapFault $e) {
				$responce['resultStatus'] 	= resultConstant::Error;
			   	$responce['faultcode'] 		= $e->faultcode;
			    $responce['faultstring'] 	= $e->faultstring;
			    $responce['faultactor'] 	= $e->faultactor;
			    $responce['faultname'] 		= $e->faultname;
			    $responce['headerfault'] 	= $e->headerfault;
			}
			return $responce;
		}
		
		
		// To get customer's vehicle details
		function fn_CustomerVehicleGet($customerID)	{
			$params = $this->params;
			$wsdl 	= $this->wsdl;   
			$responce = "";
			try	{
				$soap = new SoapClient($wsdl,$params);								
				$args = array('token' => $this->token, 'customerID'=> $customerID);
				$responce = $soap->CustomerVehicleGet($args);
			} 
			catch (SoapFault $e) {
				//$responce = "";
			   	//$responce = 'Caught exception:'.$e->getMessage()."\n";
			   	
			   	$responce['faultcode'] 		= $e->faultcode;
			    $responce['faultstring'] 	= $e->faultstring;
			    $responce['faultactor'] 	= $e->faultactor;
			    $responce['faultname'] 		= $e->faultname;
			    $responce['headerfault'] 	= $e->headerfault;
			}
			return $responce;
		}
		
		#Returns a list of customer action that is associated with the customer. 
		function fn_CustomerActionGet($CustomerID)	{
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try	{				
				$soap = new SoapClient($wsdl, $params);				
				$args = array('token' => $this->token, 'customerId' => $CustomerID);
				$responce = $soap->CustomerActionGet($args);
			} 
			catch (SoapFault $e) {
				//$responce = "";
			   	//$responce = 'Caught exception:'.$e->getMessage()."\n";
			   	
			   	$responce['faultcode'] 		= $e->faultcode;
			    $responce['faultstring'] 	= $e->faultstring;
			    $responce['faultactor'] 	= $e->faultactor;
			    $responce['faultname'] 		= $e->faultname;
			    $responce['headerfault'] 	= $e->headerfault;
			}
			return $responce;
		}
		
		#This action will submit the action which will trigger processing to start. This will either be 
		#items that the user wants to purchase (in basket), Policy cancellation or Call Me requests.

		function fn_CustomerActionSubmit($customerAction){
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try	{				
				$soap = new SoapClient($wsdl, $params);
                $customerAction['ChannelId'] = $this->channel_id;
                $customerAction['DealerId']  = $this->dealer_id;
				$args = array('token' => $this->token, 'customerAction' => $customerAction);
				$responce = $soap->CustomerActionSubmit($args);
			} 
			catch (SoapFault $e) {
				//$responce = "";
			   	//$responce = 'Caught exception:'.$e->getMessage()."\n";
			   	$responce['faultcode'] 		= $e->faultcode;
			    $responce['faultstring'] 	= $e->faultstring;
			    $responce['faultactor'] 	= $e->faultactor;
			    $responce['faultname'] 		= $e->faultname;
			    $responce['headerfault'] 	= $e->headerfault;
			}
			return $responce;
		}	

    }
?>
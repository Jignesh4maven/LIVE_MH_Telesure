<?php    
	require_once(BASE_PATH."/Conf/service_conf.php");
	class quoteservice
	{		
		function quoteservice(){
			$CHANNEL_ID = 	1;
			$DEALER_ID 	=	1;
			global $SERVICE_URl, $WEBSERVICE_USERNAME, $WEBSERVICE_PASSWORD,$CHANNEL_ID,$DEALER_ID;
			$this->params 	= array('cache_wsdl' => WSDL_CACHE_NONE,"soap_version"=> SOAP_1_1, "trace"=>1, "exceptions"=>0, "login"=>$WEBSERVICE_USERNAME, "password"=>$WEBSERVICE_PASSWORD,"connection_timeout"=> 300);
			$this->wsdl 	= $SERVICE_URl.'/PinkElephant/QuoteService.svc?wsdl';
            $this->token    = (isset($_SESSION['token']) && !empty($_SESSION['token'])) ? $_SESSION['token'] : "";
            /*$this->channel_id   = $CHANNEL_ID;
            $this->dealer_id    = $DEALER_ID;*/
		}

		function fn_GetTelesureAreaTypeItems(){
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try{

				$soap = new SoapClient($wsdl, $params);
				$args['format'] = "json";
				$responce = $soap->GetTelesureAreaTypeItems($args);
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

		function fn_GetTelesureVehiclePaintTypes(){
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try{

				$soap = new SoapClient($wsdl, $params);
				$args['format'] = "json";
				$responce = $soap->GetTelesureVehiclePaintTypes($args);
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


		function fn_GetTelesureVehicleUseItems(){
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try{

				$soap = new SoapClient($wsdl, $params);
				$args['format'] = "json";
				$responce = $soap->GetTelesureVehicleUseItems($args);
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

		function fn_GetTelesureOvernightParkingFacility(){
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try{

				$soap = new SoapClient($wsdl, $params);
				$args['format'] = "json";
				$responce = $soap->GetTelesureOvernightParkingFacility($args);
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


		function fn_GetTelesureAccessControlTypeItems(){
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try{

				$soap = new SoapClient($wsdl, $params);
				$args['format'] = "json";
				$responce = $soap->GetTelesureAccessControlTypeItems($args);
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


		// To create customer action of type call me back
		function fn_GetInsuranceCalculationCompanies(){
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try{
				$soap = new SoapClient($wsdl, $params);
				$responce = $soap->GetInsuranceCalculationCompanies();
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
		
		// To get single quote details
		function fn_QuoteGet($args){
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try{
				$soap = new SoapClient($wsdl, $params);
                $args['token'] = $this->token;
				$responce = $soap->QuoteGet($args);
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

		// To create customer action of type call me back
		function fn_QuoteSubmission($quoteRequest){
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try	{
				$soap = new SoapClient($wsdl, $params);
				$args = array('token' => $this->token, 'quoteRequest' => $quoteRequest);
				$responce = $soap->QuoteSubmission($args);
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
		
		function fn_InsuranceQuoteSubmission($insuranceQuoteRequest){
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try	{
				ini_set("default_socket_timeout", 300);
				$soap = new SoapClient($wsdl, $params);
				$args = array('token' => $this->token, 'insuranceQuoteRequest' => $insuranceQuoteRequest);
				$responce = $soap->InsuranceQuoteSubmission($args);
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
		
		//function fn_GetInsuranceCalculationCompanies()
		//{
		//	$params = $this->params;
		//	$wsdl 	= $this->wsdl;
		//	$responce = "";
		//	try
		//	{
		//		$soap = new SoapClient($wsdl, $params);
		//		#$args = array('token' => $this->token, 'insuranceQuoteRequest' => $insuranceQuoteRequest);
		//		$responce = $soap->GetInsuranceCalculationCompanies();
		//	} 
		//	catch (SoapFault $e) 
		//	{
		//		//$responce = "";
		//	   	//$responce = 'Caught exception:'.$e->getMessage()."\n";
		//	   	
		//	   	$responce['faultcode'] 		= $e->faultcode;
		//	    $responce['faultstring'] 	= $e->faultstring;
		//	    $responce['faultactor'] 	= $e->faultactor;
		//	    $responce['faultname'] 		= $e->faultname;
		//	    $responce['headerfault'] 	= $e->headerfault;
		//	}
		//	return $responce;
		//}
		//Get vehicle detail using registration number.
	    function fn_QuoteRequestGet($args){
	        $params = $this->params;
	        $wsdl 	= $this->wsdl;
	        $response = "";
	        try
	        {
	            $soap = new SoapClient($wsdl,$params);
                $args['token'] = $this->token;
	            $response = $soap->QuoteRequestGet($args);
	        }
	        catch (SoapFault $e) 
			{
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

        // To get Document Id
        function fn_QuoteDocumentListGet($args)
        {
            $params = $this->params;
            $wsdl 	= $this->wsdl;
            $responce = "";
            try
            {
                $soap = new SoapClient($wsdl, $params);
                $args['token'] = $this->token;
                $responce = $soap->QuoteDocumentListGet($args);
            }
            catch (SoapFault $e)
            {
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

        // To retrieve a list of dealers associated with a user.
        function fn_DealerGet()
        {
            $params = $this->params;
            $wsdl 	= $this->wsdl;
            $responce = "";
            try
            {
                $soap = new SoapClient($wsdl, $params);
                $args = array('token' => $this->token);
                $responce = $soap->DealerGet($args);
            }
            catch (SoapFault $e)
            {
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
		
		function fn_InsuranceLeadSubmission($InsuranceLeadSubmissionRequestModel){
            $params = $this->params;
            $wsdl 	= $this->wsdl;
            $responce = "";
            try{
                $soap = new SoapClient($wsdl, $params);
                $args = array('token' => $this->token , 'insuranceLeadRequest' => $InsuranceLeadSubmissionRequestModel);
                $responce = $soap->InsuranceLeadSubmission($args);
            }
            catch (SoapFault $e)
            {
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
		
		function fn_InsuranceCallMeSubmission($InsuranceCallMeSubmissionRequestModel){
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try{
				$soap = new SoapClient($wsdl, $params);
				$args = array('token' => $this->token , 'insuranceCallMeRequest' => $InsuranceCallMeSubmissionRequestModel);
				$responce = $soap->InsuranceCallMeSubmission($args);
			}
			catch (SoapFault $e)
			{
				$responce['faultcode'] 		= $e->faultcode;
				$responce['faultstring'] 	= $e->faultstring;
				$responce['faultactor'] 	= $e->faultactor;
				$responce['faultname'] 		= $e->faultname;
				$responce['headerfault'] 	= $e->headerfault;
			}
			return $responce;
		}
		
		function fn_InsuranceCallMeNoIdSubmission($InsuranceCallMeNoIdModel){
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try{
				$soap = new SoapClient($wsdl, $params);
				$args = array('token' => $this->token , 'insuranceCallMeRequest' => $InsuranceCallMeNoIdModel);
				$responce = $soap->InsuranceCallMeNoIdSubmission($args);
			}
			catch (SoapFault $e)
			{
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
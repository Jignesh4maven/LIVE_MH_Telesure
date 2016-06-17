<?php    
	require_once(BASE_PATH."/Conf/service_conf.php");
	class quotedataservice
	{		
		function quotedataservice(){
			$CHANNEL_ID = 	1;
			$DEALER_ID 	=	1;
			global $SERVICE_URl, $WEBSERVICE_USERNAME, $WEBSERVICE_PASSWORD,$CHANNEL_ID,$DEALER_ID;
			$opts = array(
            'ssl' => array('cache_wsdl' => WSDL_CACHE_NONE,'ciphers'=>'RC4-SHA', 'verify_peer'=>false, 'verify_peer_name'=>false)
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
									
									);
			//$this->params 	= array("soap_version"=> SOAP_1_1, "trace"=>1, "exceptions"=>0, "login"=>$WEBSERVICE_USERNAME, "password"=>$WEBSERVICE_PASSWORD,"connection_timeout"=> 160);
			$this->wsdl 	= $SERVICE_URl.'/PinkElephant/QuoteDataService.svc?wsdl';
            $this->token    = (isset($_SESSION['token']) && !empty($_SESSION['token'])) ? $_SESSION['token'] : "";
            /*$this->channel_id   = $CHANNEL_ID;
            $this->dealer_id    = $DEALER_ID;*/
		}

		function fn_GetTelesureCoverTypeItemsFull($args){
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try{

				$soap = new SoapClient($wsdl, $params);
				$args['format'] = "json";
				$responce = $soap->GetTelesureCoverTypeItemsFull($args);
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

		
    }
?>
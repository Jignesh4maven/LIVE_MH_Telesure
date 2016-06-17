<?php

require_once("/../../Conf/service_conf.php");

class vehicleinformationservice
{
    function vehicleinformationservice()
    {
        global $SERVICE_URl, $WEBSERVICE_USERNAME, $WEBSERVICE_PASSWORD;
        //$this->params = array("soap_version" => SOAP_1_1, "trace" => 1, "exceptions" => 0, "login" => $WEBSERVICE_USERNAME, "password" => $WEBSERVICE_PASSWORD);
        $opts = array(
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
									
									);
        $this->wsdl = $SERVICE_URl . '/PinkElephant/VehicleInformationService.svc?wsdl';
    }

    function fn_VehicleInformationService($vehicleRegistrationNo, $pemissionToSearch = 1)
    {
        $params = $this->params;
        $wsdl 	= $this->wsdl;
        $responce = "";
        try
        {
            $soap = new SoapClient($wsdl,$params);
            $args = array('vehicleRegistrationNo'   => $vehicleRegistrationNo,
                           'pemissionToSearch'      => $pemissionToSearch);
            $responce = $soap->VehicleInformationService($args);
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
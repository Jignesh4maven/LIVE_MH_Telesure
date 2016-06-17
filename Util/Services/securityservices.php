<?php
	require_once(BASE_PATH."/Conf/service_conf.php");
	
	class securityservices{
		function securityservices()	{
			global $SERVICE_URl, $WEBSERVICE_USERNAME, $WEBSERVICE_PASSWORD;
			$this->params 	= array('cache_wsdl' => WSDL_CACHE_NONE,"soap_version"=> SOAP_1_1, "trace"=>1, "exceptions"=>0, "login"=>$WEBSERVICE_USERNAME, "password"=>$WEBSERVICE_PASSWORD);
			$this->wsdl 	= $SERVICE_URl.'/PinkElephant/SecurityService.svc?wsdl';
		}
		
		// To call Login web service
		function fn_Login($email, $password){
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try{
				$soap = new SoapClient($wsdl,$params);								
				$args = array('email'=> $email, 'password' => $password);
				$responce = $soap->Login($args);
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

		// To call Register web service
		function fn_Register($firstname, $surname, $identificationNo, $passportNo, $email,
							 $cellphoneNo, $otherContactNo, $password, $AcceptTermsAndCondition,
							 $Title, $dob, $BVemailVerified)
		{			
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try{
				$soap = new SoapClient($wsdl,$params);
				$obj = new stdClass();
				$obj->firstname 		= $firstname;
				$obj->surname 			= $surname;
				$obj->identificationNo 	= $identificationNo;
				$obj->passportNo 		= $passportNo;
				$obj->email 			= $email;
				$obj->emailVerified 	= $BVemailVerified;
				$obj->cellphoneNo 		= $cellphoneNo;
				$obj->otherContactNo 	= $otherContactNo;
				$obj->password 			= $password;
				$obj->acceptTermsAndCondition = $AcceptTermsAndCondition;
				$obj->titleId 			= $Title;
				$obj->dateOfBirth 		= $dob;
				
				$responce = $soap->Register($obj);
			}
			catch (SoapFault $e) 
			{
			   	
			   	$responce['faultcode'] 		= $e->faultcode;
			    $responce['faultstring'] 	= $e->faultstring;
			    $responce['faultactor'] 	= $e->faultactor;
			    $responce['faultname'] 		= $e->faultname;
			    $responce['headerfault'] 	= $e->headerfault;
			}  
			
			//catch (Exception $e) 
			//{				
			//   	$responce = 'Caught exception:'.$e->getMessage()."\n";
			//}
			return $responce;
		}   
		
		// To call Reset Password web service
		function fn_ResetPassword($email)
		{
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try{				
				$soap = new SoapClient($wsdl,$params);
				$obj = new stdClass();
				$obj->email 	= $email;
				$responce = $soap->ResetPassword($obj);
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
		
		// To call Request Password web service
		function fn_RequestPassword($email)
		{
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try{				
				$soap = new SoapClient($wsdl,$params);
				$obj = new stdClass();
				$obj->email 	= $email;
				$responce = $soap->RequestPassword($obj);
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
		
		// To call Change Password web service
		function fn_ChangePassword($email, $oldPassword, $newPassword)
		{
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try{
				$soap = new SoapClient($wsdl,$params);
				$obj = new stdClass();
				$obj->email 		= $email;
				$obj->oldPassword 	= $oldPassword;
				$obj->newPassword 	= $newPassword;
				$responce = $soap->ChangePassword($obj);
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
		// To call DecryptString web service
		function fn_DecryptString($encryptedStr)
		{
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try{
				$soap = new SoapClient($wsdl,$params);
				$obj = new stdClass();
				$obj->str = $encryptedStr;
				$responce = $soap->DecryptString($obj);
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
		
		// To call EncryptString web service
		function fn_EncryptString($str)
		{
			$params = $this->params;
			$wsdl 	= $this->wsdl;
			$responce = "";
			try{
				$soap = new SoapClient($wsdl,$params);
				$obj = new stdClass();
				$obj->str = $str;
				$responce = $soap->EncryptString($obj);
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
	}
	
?>
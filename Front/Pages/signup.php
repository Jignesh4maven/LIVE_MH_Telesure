<?php
require_once(BASE_PATH."/Util/util.php");
require_once(BASE_PATH."/Util/Services/securityservices.php");
require_once(BASE_PATH."/Util/Services/customerservices.php");
require_once(BASE_PATH."/Util/Services/service_util.php");
require_once(BASE_PATH."/Front/Pages/personal_details.php");
require_once(BASE_PATH."/Dbaccess/commondao.php");


class signup{
	private $module = 'signup';
	private $log;
	private $util;
	public function __construct(){
		$this->log		= new logger();
		$this->util 	= new util();
		$this->securityservices = new securityservices();
		$this->customerservices = new customerservices();
		$this->service_util = new service_util();
		$this->commondao = new commondao();
	}

	# @author: Vihang Joshi <vihang@mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-03-08
	# @definition: Initiate template view
	public function load(){
		try{

			$today =  gmdate("Y-m-d\ H:i:s");
			$this->log->logIt($today." ".$this->module."-"."Page Load");
			global $tpl;
			global $config;
				 
			$data = array();
			if( isset($_SESSION['Front']['user']) && !empty($_SESSION['Front']['user']) ){
				$data = $this->service_util->get_userinfo_session();
				
			}
			else{
				
				//$data['IdentificationNo'] = "";
				if( array_key_exists('Front',$_SESSION) ){
					if( array_key_exists('personal_details',$_SESSION['Front']) ){
						$posted_session_data 	= $_SESSION['Front']['personal_details'];
						$data['IdentificationNo'] 	= $_SESSION['Front']['personal_details']['identity_number'];
						$data['PassportNo'] 	= $_SESSION['Front']['personal_details']['passport_number'];
						$data['OtherContactNo'] = $_SESSION['Front']['personal_details']['passport_number'];
						$data['Title'] 			= $_SESSION['Front']['personal_details']['person_title'];
						$data['BirthDate'] 		= $_SESSION['Front']['personal_details']['person_dob'];
						$data['id_type'] 		= $_SESSION['Front']['personal_details']['id_type'];
					}
				}
				
			}
			
			$title_data_str 	= $this->commondao->get_data_service_json('TitleData');
			$title_data			= json_decode($title_data_str);
			
		 
			$tpl->assign(array(
							"T_BODY"			=>	'signup'.$config['tplEx'],
							"page_name"			=>  'Signup',
							'data'				=>  $data,
							"title_data"		=>	$title_data->value,
							)
						);
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."load".Insurance.$e);
		}
	}

	# @author: Vihang Joshi <vihang@mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-03-09
	# @definition: Register Customer
	public function register(){
		try{
			$_SESSION['token'] = "";
			$today =  gmdate("Y-m-d\ H:i:s");
			$this->log->logIt($today." ".$this->module."-"."Register Customer");
			
			
			/* Customer Details */
			$firstname 				  = $this->util->strip_unsafe_tags( trim($_POST['name']) );
			$surname 				  = $this->util->strip_unsafe_tags( trim($_POST['surname']) );
			$identificationNo		  = $this->util->strip_unsafe_tags( trim($_POST['identification_no']) );
			$passportNo				  = $this->util->strip_unsafe_tags( trim($_POST['passport_no']) ) ;
			$email					  = $this->util->strip_unsafe_tags( trim($_POST['email']) );
			$confirm_email			  = $this->util->strip_unsafe_tags( trim($_POST['confirm_email']) );
			$cellphoneNo			  = $this->util->strip_unsafe_tags( trim($_POST['contact_no']) );
			$otherContactNo     	  = $this->util->strip_unsafe_tags( trim($_POST['other_contact_no']) );
			$password				  = $this->util->strip_unsafe_tags( trim($_POST['password']));
			$AcceptTermsAndCondition  = 1;
			$Title 					  = $this->util->strip_unsafe_tags( trim($_POST['title']) );
			$dob 					  = $this->util->strip_unsafe_tags( trim($_POST['dob']) );
			$dob					  = date('Y-m-d',strtotime( $dob ));
			$BVemailVerified		  =  1;
			
			if( trim($_POST['chkIdNoPassport']) == "1" ){
				$identificationNo = "";
			}
			else{
				$passportNo = "";
			}
			
			$data_array = array();
			if ( !$this->util->mandatoryField($firstname)) {
			 
				$error_array['name'] = "Name is required.";
			}
			if ( !$this->util->mandatoryField($identificationNo) && !$this->util->mandatoryField($passportNo)) {
			 
				$error_array['Id'] = "Id Number or Passport Number is required.";
			}
			if ( !$this->util->mandatoryField($surname)) {
			 
				$error_array['surname'] = "Surname is required.";
			}
			if ( !$this->util->mandatoryField($email)) {
			 
				$error_array['email'] = "email is required.";
			}
			if ( !$this->util->mandatoryField($confirm_email)) {
			 
				$error_array['confirm_email'] = "Confirm email is required.";
			}
			if ( !$this->util->mandatoryField($cellphoneNo)) {
			 
				$error_array['contact_no'] = "Contact No is required.";
			}
			
		 
			if ( empty($error_array) ) {
				
				$response = $this->securityservices->fn_Register($firstname, $surname, $identificationNo, $passportNo, $email,
																 $cellphoneNo, $otherContactNo, $password, $AcceptTermsAndCondition,
																 $Title, $dob, $BVemailVerified);
				
				if( array_key_exists('RegisterResult',$response) ){
					
					$_SESSION['token'] = $response->RegisterResult;
	
					if($_SESSION['token'] != ""){
						
						$response_array['resultStatus'] = resultConstant::Success;
						
						$response_array['resultData']['message'] = "Registration completed successfully.";
						
						$redirect_str = "";
						
						if( isset( $_SESSION['Front']['personal_details']) ){
							$redirect_str = "car-insurance-quote?action=personal_details";
						}else{
							$redirect_str = "car-insurance-quote?action=personal_details";
						}
	
						$response_array['resultData']['redirect'] = $redirect_str;
						
						#$customer_data = $this->customer_data_get();
						#$response_array['resultData']['customer_data'] = $customer_data;
						
						#$this->customerservices->token = $_SESSION['token'];
						#$result = $this->customerservices->fn_CustomerDataGet();
						#$_SESSION['Front']['customer_info_obj']  = $result->CustomerDataGetResult;
						#$_SESSION['Front']['user'] = $result->CustomerDataGetResult->FirstName;
						$this->service_util->refresh_customer_data(); // get and update customer data from token
						
						$obj_personal_details = new personal_details();
						$obj_personal_details->update_customer(1);
						
						
						
					}
					else{
						$response_array['resultStatus'] = resultConstant::Warning;
						$response_array['resultData']['message'] = "Error while registration.";
					}
	
				}
				else if( array_key_exists('faultstring',$response) ){
	
					$response_array['resultStatus'] = resultConstant::Warning;
					$response_array['resultData']['message'] = $response->faultstring;
				}
			}
			else{
				$response_array['resultStatus'] = resultConstant::Warning;
				$response_array['resultData']['message'] = $error_array;
				$response_array['resultData']['formData'] = array();
				
			}
			
			print_r(json_encode($response_array));
			
			exit(0);
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."load".register.$e);
		}
	}

	# @author: Vihang Joshi <vihang@mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-03-09
	# @definition: Login Customer
	public function login(){
		try{
			$today =  gmdate("Y-m-d\ H:i:s");
			$this->log->logIt($today." ".$this->module."-"."Login Customer");

			/* Customer Details */
			$email		= $_POST['email'];
			$password	= $_POST['password'];
			$response 	= $this->securityservices->fn_Login($email,$password);
			
			//$this->log->logIt( array($response) );
	
			if(array_key_exists('LoginResult',$response))
			{

				if( $response->LoginResult != "" )
				{

					$this->log->logIt($today."Login ".$response->LoginResult);
					$_SESSION['Front']['isGuest'] = false;

					$_SESSION['token'] = $response->LoginResult;
					$response_array['resultStatus'] = resultConstant::Success;
					$response_array['resultData']['message']  = "Login successfully completed.";
					#$response_array['resultData']['redirect'] =  $_SERVER['HTTP_REFERER']; //"car-insurance-quote?action=vehicle_details";
					$redirect_str = "";
					
					if( isset( $_SESSION['Front']['personal_details']) ){
						$redirect_str = "car-insurance-quote?action=personal_details";
					}

					$response_array['resultData']['redirect'] = $redirect_str;


					
					if( !isset( $_SESSION['Front']['customer_info_obj']  ) ){
						$this->service_util->refresh_customer_data(); // get and update customer data from token
					}
					
					//if( !isset( $_SESSION['Front']['customer_info_obj']  ) ){
					//
					//	$this->log->logIt($today." ".$this->module."-"."----------customer_info_obj ");
					//	$this->customerservices->token = $_SESSION['token'];
					//	$result = $this->customerservices->fn_CustomerDataGet();
					//	$_SESSION['Front']['customer_info_obj']  = $result->CustomerDataGetResult;
					//	$_SESSION['Front']['user'] = $result->CustomerDataGetResult->FirstName;
					//}


				}else{
					$response_array['resultStatus'] = resultConstant::Warning;
					$response_array['resultData']['message'] = "Error while login.";
				}

			}else if(array_key_exists('faultstring',$response)){

				$response_array['resultStatus'] = resultConstant::Warning;
				$response_array['resultData']['message'] = $response->faultstring;
			}
			print_r(json_encode($response_array));
			exit(0);
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."load".Insurance.$e);
		}
	}
	
	public function customer_data_get(){
		try{
			$today =  gmdate("Y-m-d\ H:i:s");
			$this->log->logIt($today." ".$this->module."-"."customer_data_get");

			$this->customerservices->token = $_SESSION['token'];
			$response 	= $this->customerservices->fn_CustomerDataGet();
			
			$response_array['resultStatus'] = resultConstant::Success;
			$response_array['resultData']['message'] = $response->faultstring;
			
			return $response_array;
		
			#print_r(json_encode($response_array));
			#exit(0);
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."load".Insurance.$e);
		}
	}

}				
?>
<?php
require_once(BASE_PATH."/Util/util.php");
require_once(BASE_PATH."/Util/Services/securityservices.php");
require_once(BASE_PATH."/Util/Services/customerservices.php");
require_once(BASE_PATH."/Util/Services/service_util.php");
require_once(BASE_PATH."/Front/Pages/personal_details.php");

class login{

	private $module = 'login';
	private $log;
	private $util;

	public function __construct(){
		$this->log		= new logger();
		$this->util 	= new util();
		$this->securityservices = new securityservices();
		$this->customerservices = new customerservices();
		$this->service_util = new service_util();

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
					}
				}
				
			}
			
			$tpl->assign(array(
							"T_BODY"			=>	'login'.$config['tplEx'],
							"page_name"			=>  'Login',
							'data'				=>   $data,
							)
						);
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."load".$e);
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
			$firstname 				  = $_POST['name'];
			$surname 				  = $_POST['surname'];
			$identificationNo		  = $_POST['identification_no'];
			$passportNo				  = $_POST['passport_no'];
			$email					  = $_POST['email'];
			$cellphoneNo			  = $_POST['contact_no'];
			$otherContactNo     	  = $_POST['other_contact_no'];
			$password				  = $_POST['password'];
			$AcceptTermsAndCondition  = 1;
			$Title 					  = $_POST['title'];
			$dob					  = date('Y-m-d',strtotime($_POST['dob']));
			$BVemailVerified		  =  1;

			$response = $this->securityservices->fn_Register($firstname, $surname, $identificationNo, $passportNo, $email,
															 $cellphoneNo, $otherContactNo, $password, $AcceptTermsAndCondition,
															 $Title, $dob, $BVemailVerified);

			$this->log->logIt(array($response));
			
			if( array_key_exists('RegisterResult',$response) ){
				
				$_SESSION['token'] = $response->RegisterResult;

				if($_SESSION['token'] != ""){
					
					$response_array['resultStatus'] = resultConstant::Success;
					
					$response_array['resultData']['message'] = "Registration completed successfully.";
					
					$redirect_str = "";
					
					if( isset( $_SESSION['Front']['personal_details']) ){
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
			
			#$response_array['resultStatus'] = resultConstant::Warning;
			#$response_array['resultData']['message'] = "";
			
			print_r(json_encode($response_array));
			
			exit(0);
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."load".$e);
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

					$_SESSION['token'] = $response->LoginResult;
					$response_array['resultStatus'] = resultConstant::Success;
					$response_array['resultData']['message']  = "Login successfully completed.";
					#$response_array['resultData']['redirect'] =  $_SERVER['HTTP_REFERER']; //"car-insurance-quote?action=vehicle_details";
					$redirect_str = "";
					
					if( isset( $_SESSION['Front']['personal_details']) ){
						$redirect_str = "car-insurance-quote?action=personal_details";
					}

					$response_array['resultData']['redirect'] = $redirect_str;
					
					if( isset($_SESSION['Front']['isGuest']) && $_SESSION['Front']['isGuest'] == 1){
						$_SESSION['Front'] = "";
					}
					#if( !isset( $_SESSION['Front']['customer_info_obj']  ) ){
						$this->service_util->refresh_customer_data(); // get and update customer data from token
					#}
					
				
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
			$this->log->logIt($this->module."-"."load".$e);
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
			$this->log->logIt($this->module."-"."load".$e);
		}
	}

}				
?>
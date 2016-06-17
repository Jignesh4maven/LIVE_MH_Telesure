<?php
require_once(BASE_PATH."/Util/util.php");
require_once(BASE_PATH."/Util/Services/customerservices.php");
require_once(BASE_PATH."/Util/Services/data_curl.php");
require_once(BASE_PATH."/Util/Services/quoteservice.php");
require_once(BASE_PATH."/Util/Services/service_util.php");
require_once(BASE_PATH."/Dbaccess/servicedao.php");
require_once(BASE_PATH."/Util/Services/quotedataservice.php");


require_once(BASE_PATH."/Dbaccess/commondao.php");
	require_once(BASE_PATH."/Conf/service_conf.php");



class car_insurance{
	
	private $module = 'car_insurance';
	private $log;
	private $util;
	private $securityservices;
	private $service;
	
	public function __construct(){
		$this->log 	= new logger();
		$this->util = new util();
		$this->customerservices = new customerservices();
		$this->quoteservice = new quoteservice();
		$this->data_curl = new data_curl();
		$this->service_util = new service_util();
		$this->service = new servicedao();
		$this->quotedataservice = new quotedataservice();
		
		$this->commondao = new commondao();
		$static = new staticarray();
		//print_r($static::$MotorInsuredItems);
		
	}
	
	public function test(){
		
		print_r($_SESSION);
		exit(0);
	}

	# @author: Jignesh Rana <mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: Initiate template view on first blog loading
	public function load()
	{
		try {
			$today = gmdate("Y-m-d\ H:i:s");
			$this->log->logIt($today . " " . $this->module . "-" . "Page Load");
			global $tpl;
			global $config;
			print_r($_SESSION['Front']);
			exit;
			
			print_r( $_SESSION['Front']['vehicle_details']);
			exit(0);
			$customer_model 	= $this->service_util->refresh_customer_data(); // get and up
			
			print_r($customer_model);
			exit(0);
				
			$registration_number = "Test2";
			
			//$vehicle_result = $this->service_util->fetch_vehicle("'".$registration_number."'",'');
			
			//exit(0);
			
			$vehicle_list_by_id = $_SESSION['Front']['tmp'];
			
			//print_r($vehicle_list_by_id["'TEST2'"]);
			
			echo array_key_exists( "'".$registration_number."'",$vehicle_list_by_id );
			
			#print_r($vehicle_list_by_id);
			//echo array_key_exists( $regno,$vehicle_list_by_id );
			
			
			//$registration_number = "MH0007";
			//$vehicle_result = $this->service_util->fetch_vehicle("'".$registration_number."'",'');
			//
			//print_r($vehicle_result);
			
			exit();
			echo 123;
			print_r($_SESSION['Front']);
			exit(0);
			//$args = array(
			//	'vehicleRegistrationNo' 		 => "MH007",
			//	'pemissionToSearch' 		     => true
			//);
			//
			//
			//$response          	= $this->quoteservice->fn_QuoteRequestGet($args);
			//print_r($response);
			//exit(0);
			
			//print_r($_SESSION['Front']);
		 
			$customer_model 	= $this->service_util->refresh_customer_data();
			
			print_r($customer_model);
			exit(0);
			//
			//$DriverDateOfBirth = "";
			//if( isset( $_SESSION['Front']['personal_details']['driver_dob']) ){
			//		$DriverDateOfBirth = $_SESSION['Front']['personal_details']['driver_dob'];
			//}
			//
			//echo $DriverDateOfBirth ;
			////exit(0);
			
			$vehicle_list 	= $this->service_util->fetch_vehicle('MH007','list'); // get and up
			
			print_r( $vehicle_list );
			
			exit(0);
			$vehicles_details = array();
			foreach( $vehicle_list->resultData as $key => $val ){
				
				print_r( $vehicle_list->resultData[$key]["CustomerVehicleID"] );
				$tmp_array = array();
				$tmp_array["CustomerVehicleID"] = $vehicle_list->resultData[$key]["CustomerVehicleID"];
				$tmp_array["DateOfFirstRegistration"] = $vehicle_list->resultData[$key]["DateOfFirstRegistration"];
				$tmp_array["RegistrationNo"] = $vehicle_list->resultData[$key]["RegistrationNo"];
				$tmp_array["Make"] = $vehicle_list->resultData[$key]["Make"];
				$tmp_array["MakeDesc"] = $vehicle_list->resultData[$key]["MakeDesc"];
				$tmp_array["Model"] = $vehicle_list->resultData[$key]["Model"];
				$tmp_array["ModelDesc"] = $vehicle_list->resultData[$key]["ModelDesc"];
				$tmp_array["RegistrationNo"] = $vehicle_list->resultData[$key]["RegistrationNo"];
				$tmp_array["Series"] = $vehicle_list->resultData[$key]["Series"];
				$tmp_array["SeriesDesc"] = $vehicle_list->resultData[$key]["SeriesDesc"];
				$tmp_array["Year"] = $vehicle_list->resultData[$key]["Year"];
				array_push($vehicles_details,$tmp_array);
			}
			
			print_r( json_encode($vehicles_details));
			
			exit(0);
			$customer_model 	= $this->service_util->refresh_customer_data(); // get and up
			
			
			exit(0); 
			#cover type
			$cover_type_str 	= $this->commondao->get_data_service_json('CoverTypeItems');
			$cover_type			= json_decode($cover_type_str);
			
			#yes no indecator
			$static = new staticarray();
			$yesno =  json_encode( $static::$YesNoIndicator ) ;
			
			#insured value type
			$insured_type_str 	= $this->commondao->get_data_service_json('MotorInsuredItems');
			$insured_type		= json_decode($insured_type_str);
			
			#insured value type
			$car_hire_options_str 	= $this->commondao->get_data_service_json('CarHireOptions');
			$car_hire_options		= json_decode($car_hire_options_str);
			
			#insured value type
			$sound_insured_str 	= $this->commondao->get_data_service_json('SoundSystemInsuredValues');
			$sound_insured		= json_decode($sound_insured_str);
			
			#insured value type
			$voluntary_access_items_str 	= $this->commondao->get_data_service_json('VoluntaryExcessItems');
			$voluntary_access_items			= json_decode($voluntary_access_items_str);
			
			exit(0);
		 
		
			$customer_model 	= $this->service_util->refresh_customer_data(); // get and up
			print_r($customer_model);
			//print_r($customer_model->InsuranceCustomer->EmploymentStatus);
			
			exit(0);
		//	$vehicle_list 		= $customer_model->CustomerVehicleList->CustomerVehicleModel;
		//	//print_r($cutomer_vehicles);
		//	
		//	$vehicle_data = array();
		//	if( count($vehicle_list)  == 1){
		//		$vehicle_data[0]	= $vehicle_list;
		//	}
		//	else if( count($vehicle_list) > 1){
		//		$vehicle_data	= $vehicle_list;
		//	}
		//	
		//	//print_r($vehicle_data);
		//	$vehicle_id = 863;
		//	
		//	for( $vehicle = 0 ; $vehicle < count($vehicle_data); $vehicle++){
		//		
		//		echo $vehicle_data[$vehicle]->CustomerVehicleID."</br>";
		//		
		//		//$customer_vehicles[$vehicle_data[$vehicle]->CustomerVehicleID]
		//		
		//		if( $vehicle_data[$vehicle]->CustomerVehicleID ==  $vehicle_id ){
		//			
		//			  $vehicle_data[$vehicle]->Year = 23;
		//			  $vehicle_data[$vehicle]->DateOfFirstRegistration = "2012-02-01";
		//			  $vehicle_data[$vehicle]->InsuranceCustomerVehicle->DriverLicenseDate = "2008-02-01";
		//			  
		//			  break;
		//		}
		//		
		//	}
		//	
		//	$customer_model->CustomerVehicleList->CustomerVehicleModel = $vehicle_data;
		// 	$this->customerservices->token = $_SESSION['token'];
			//$response = $this->customerservices->fn_CustomerUpdate($customer_model);
			//print_r($response);
			
			
			//$this->customerservices->token = $_SESSION['token'];
			//$result = $this->customerservices->fn_CustomerVehicleGet(798);
			
			//Remove Vehichle
			//$this->customerservices->token = $_SESSION['token'];
			//$result = $this->customerservices->fn_CustomerVehicleRemove(820,865);
			//print_r($result);
			
			// $args = array(
			//	'vehicleRegistrationNo' 		 => "GJ5HC8844",
			//	'pemissionToSearch' 		     => true
			//);
			// 
			//$result = $this->quoteservice->fn_QuoteRequestGet($args);
			//
			//print_r($result);
			//
			
			//$res = $this->service_util->refresh_customer_data();
			//print_r($res);
			//exit(0);
			
			//$CustomerVehicleModel  = $this->customer_vehicle_model();
			//print_r($CustomerVehicleModel);
			//
			//$this->update_customer($CustomerVehicleModel);
			//exit(0);
			//
			/*$res = $this->service_util->refresh_customer_data();
			print_r($res);
		 
			echo "-----------------";
			*/
		 
			$args = array(
				'vehicleFinanced'	=> 1,
				'vehicleKey'	=> 863,
			);
			
			$res = $this->quotedataservice->fn_GetTelesureCoverTypeItemsFull($args);
			
			print_r($res);
			
			exit(0);
			
			$insuranceQuoteRequest = array(
			'InsuranceCustomerVehicleId'	=> 433,
			'ExpressQuote'		 => 1,
			'IncludeMotorSasria' => 1,
			);
			$result 	= $this->quoteservice->fn_InsuranceQuoteSubmission($insuranceQuoteRequest);
			#$result 	= $this->quoteservice->fn_GetInsuranceCalculationCompanies();
			print_r($result);
			exit(0);
			$insuranceQuoteRequest =
			array(
			'InsuranceCustomerVehicleId'	=> 433,
			'ExpressQuote'		 => 1,
			'IncludeMotorSasria' => 1,
			);
			$result 	= $this->quoteservice->fn_InsuranceQuoteSubmission($insuranceQuoteRequest);
			#$result 	= $this->quoteservice->fn_GetInsuranceCalculationCompanies();
			print_r($result);
			
			$insuranceLeadRequest = array(
				'InsuranceCustomerLeadId' 	=> 1,
				'InsuranceQuoteId'			=> 1,
				
			);
			
			$result 	= $this->quoteservice->fn_InsuranceLeadSubmission($insuranceLeadRequest);
			
			exit(0);
			
			// Get Customer
			$this->customerservices->token = $_SESSION['token'];
			$result = $this->customerservices->fn_CustomerDataGet();
			$_SESSION['Front']['customer_info_obj']  = $result->CustomerDataGetResult;
			 
			$user_info = array();
			if( isset($_SESSION['Front']['customer_info_obj']->CustomerVehicleList->CustomerVehicleModel) ){
				$vehicle_list =   $_SESSION['Front']['customer_info_obj']->CustomerVehicleList->CustomerVehicleModel;
				$vehicle_data = array();
				if( count($vehicle_list)  == 1){
					$vehicle_data	= $vehicle_list;
				}
				else if( count($vehicle_list) > 1){
					$vehicle_data	= $vehicle_list[0];
				}
				//print_r( $vehicle_data );
				
				if( isset($vehicle_data->CustomerVehicleID) ){
					$user_info['CustomerVehicleID'] 		= $vehicle_data->CustomerVehicleID;
					$user_info['DateOfFirstRegistration'] 	= $vehicle_data->DateOfFirstRegistration;
					$user_info['EngineNo'] 					= $vehicle_data->EngineNo;
					$user_info['CurrentMileage'] 			= $vehicle_data->InsuranceCustomerVehicle->CurrentMileage;
					$user_info['DayAccessControl'] 			= $vehicle_data->InsuranceCustomerVehicle->DayAccessControl;
					$user_info['DayAddressType'] 			= $vehicle_data->InsuranceCustomerVehicle->DayAddressType;
					$user_info['DayAreaType'] 				= $vehicle_data->InsuranceCustomerVehicle->DayAreaType;
					$user_info['DayParking'] 				= $vehicle_data->InsuranceCustomerVehicle->DayParking;
					$user_info['DayParkingSame'] 			= $vehicle_data->InsuranceCustomerVehicle->DayParkingSame;
					$user_info['DayPostalCode'] 			= $vehicle_data->InsuranceCustomerVehicle->DayPostalCode;
					$user_info['DaySuburbName'] 			= $vehicle_data->InsuranceCustomerVehicle->DaySuburbName;
					$user_info['DriverAccessControl'] 		= $vehicle_data->InsuranceCustomerVehicle->DriverAccessControl;
					$user_info['DriverAreaType'] 			= $vehicle_data->InsuranceCustomerVehicle->DriverAreaType;
					$user_info['DriverDateOfBirth'] 		= $vehicle_data->InsuranceCustomerVehicle->DriverDateOfBirth;
					$user_info['DriverEmploymentStatus'] 	= $vehicle_data->InsuranceCustomerVehicle->DriverEmploymentStatus;
					$user_info['DriverGender'] 				= $vehicle_data->InsuranceCustomerVehicle->DriverGender;
					$user_info['DriverLicenseDate'] 		= $vehicle_data->InsuranceCustomerVehicle->DriverLicenseDate;
					$user_info['DriverLicenseType'] 		= $vehicle_data->InsuranceCustomerVehicle->DriverLicenseType;
					$user_info['DriverPostalCode'] 			= $vehicle_data->InsuranceCustomerVehicle->DriverPostalCode;
					$user_info['DriverSuburbName'] 			= $vehicle_data->InsuranceCustomerVehicle->DriverSuburbName;
					$user_info['InsuranceCustomeVehicleID'] = $vehicle_data->InsuranceCustomerVehicle->InsuranceCustomeVehicleID;
					$user_info['InsuredOption'] 			= $vehicle_data->InsuranceCustomerVehicle->InsuredOption;
					$user_info['NCB'] 						= $vehicle_data->InsuranceCustomerVehicle->NCB;
					$user_info['NightAccessControl'] 		= $vehicle_data->InsuranceCustomerVehicle->NightAccessControl;
					$user_info['NightAddressType'] 			= $vehicle_data->InsuranceCustomerVehicle->NightAddressType;
					$user_info['NightAreaType'] 			= $vehicle_data->InsuranceCustomerVehicle->NightAreaType;
					$user_info['NightParkingSame'] 			= $vehicle_data->InsuranceCustomerVehicle->NightParkingSame;
					$user_info['NightPostalCode'] 			= $vehicle_data->InsuranceCustomerVehicle->NightPostalCode;
					$user_info['NightSuburbName'] 			= $vehicle_data->InsuranceCustomerVehicle->NightSuburbName;
					$user_info['OvernightParking'] 			= $vehicle_data->InsuranceCustomerVehicle->OvernightParking;
					$user_info['PublicLiability'] 			= $vehicle_data->InsuranceCustomerVehicle->PublicLiability;
					$user_info['VehicleColour'] 			= $vehicle_data->InsuranceCustomerVehicle->VehicleColour;
					$user_info['VehicleDescription'] 		= $vehicle_data->InsuranceCustomerVehicle->VehicleDescription;
					$user_info['VehicleFinanced'] 			= $vehicle_data->InsuranceCustomerVehicle->VehicleFinanced;
					$user_info['VehicleKey'] 				= $vehicle_data->InsuranceCustomerVehicle->VehicleKey;
					$user_info['VehiclePaintType'] 			= $vehicle_data->InsuranceCustomerVehicle->VehiclePaintType;
					$user_info['VehicleUse'] 				= $vehicle_data->InsuranceCustomerVehicle->VehicleUse;
					$user_info['MMCode'] 					= $vehicle_data->MMCode;
					$user_info['Make'] 						= $vehicle_data->Make;
					$user_info['MakeDesc'] 					= $vehicle_data->MakeDesc;
					$user_info['Model'] 					= $vehicle_data->Model;
					$user_info['ModelDesc'] 				= $vehicle_data->ModelDesc;
					$user_info['PermissionToSearch'] 		= $vehicle_data->PermissionToSearch;
					$user_info['PreviousOwned'] 			= $vehicle_data->PreviousOwned;
					$user_info['RegistrationNo'] 			= $vehicle_data->RegistrationNo;
					$user_info['Series'] 					= $vehicle_data->Series;
					$user_info['SeriesDesc'] 				= $vehicle_data->SeriesDesc;
					$user_info['ServiceHistory'] 			= $vehicle_data->ServiceHistory;
					$user_info['Warranty'] 					= $vehicle_data->Warranty;
					$user_info['Year'] 						= $vehicle_data->Year;
					
				}
				
				//print_r($user_info);
			}
			//exit();
			
			
			
			//
			$InsuranceCustomerVehicleModel = array (
				"VehicleKey" 			=> "", // String
				"VehicleDescription" 	=> "", // String
				"VehicleFinanced" 		=> 1,
				"NCB" 					=> "", // dropdown string
				"CoverType" 			=> "", // String
				"VehicleUse" 			=> "", // String
				"HailCover"				=> "Yes", //YesNoIndicator
				"RadioCover"			=> "Yes", //YesNoIndicator
				"VehicleUse" 			=> "", //dropdown string
				"RadioCoverValue"		=> 1, //int
				"OvernightParking"		=> "", //string
				"NightAddressType"		=> $AddressType, //AddressType
				"DayParking"			=> "", //string
				"DayAddressType"		=> $AddressType, //AddressType
				"TrackingDeviceInstalled"=> "Yes", //YesNoIndicator
				"TrackerDeviceType"		=>	"", //string
				"WindscreenCover"		=>	"Yes", //YesNoIndicator
				"CarHireIncluded"		=>	"Yes",//YesNoIndicator
				"CarHireOption"			=>  "", //string
				"CanopyCoverIncluded"	=>	"Yes", //YesNoIndicator
				"InsuredOption"			=>	"",//string
				"NightParkingSame"		=>  "Yes",//YesNoIndicator
				"NightPostalCode"		=>  "", //sting
				"NightSuburbName"		=>  "",//string
				"NightAreaType"			=>  "", //string
				"NightAccessControl"	=>  "", //string
				"DayParkingSame"		=>  "Yes", //YesNoIndicator
				"DaySuburbName"			=>  "", //string
				"DayAreaType"			=>  "", //string
				"DayAccessControl"			=>  "", //string
				"VoluntaryExcess"			=>  "", //string
				"IncludeTheftExcessBuster"		=>  "Yes", //YesNoIndicator
				"IncludeTheftExcessBuster"		=>  "Yes", //YesNoIndicator
				"SaverThirdPartyLiability"		=>  "Yes", //YesNoIndicator
				"SaverAccidentCover"			=>  "Yes", //YesNoIndicator
				"SaverAccidentOption"			=>  "", //string
				"SaverTotalLoss"				=>  "Yes", //YesNoIndicator
				"SaverAssist"					=>  "Yes", //YesNoIndicator
				"PublicLiability"				=>  "Yes", //YesNoIndicator
				"VehicleColour"					=>  "", //string
				"VehiclePaintType"				=>  "", //string
				"DriverDateOfBirth"  			=> $today,
				"DriverGender"					=>  "", //string
				"DriverMaritalStatus"			=>  "", //string
				"DriverEmploymentStatus"		=>  "", //string
				"DriverDateOfBirth"  			=> $today,
				"DriverLicenseType"				=>  "", //string
				"DriverPostalCode"				=>  "", //string
				"DriverSuburbName"				=>  "", //string
				"DriverAccessControl"			=>  "", //string
				"DriverAreaType"				=>  "", //string
				"CurrentMileage"				=>  100, //int				
			);
			
			$today =  gmdate("Y-m-d");
			$customerVehicleModel = array (
				"RegistrationNo" 		=> "123456",
				"Year"					=>  2010,
				"Make"					=>  69,
				"MakeDesc" 				=> 	"BMW",
				"Model"					=> 3725,
				"ModelDesc"				=> "M6",
				"Series"				=> 16863,
				"SeriesDesc"			=> "COUPE SMG",
				"Vehicle"				=> 101,// int,
				"VehicleDesc			" => '',// str
				"Warranty"				=> "Yes",
				"VINNo" 				=> "", //string
				"EngineNo"				=> "", //string
				"MMCode" 				=> "", //string
				"ServiceHistory"		=> 1,
				"PreviousOwned"			=> 1,
				"PermissionToSearch"	=> 1,
				"DateOfFirstRegistration"  => $today,
				"InsuranceCustomerVehicle" => $InsuranceCustomerVehicleModel
			);
			
			
	 
			
			#CustomerVehicleGet
			
			

			$tpl->assign(array(
					"T_BODY" => 'car_insurance_quote' . $config['tplEx'],
					"T_FRM_PERSONAL" => 'car_insurace_frm_personal_details' . $config['tplEx'],
					"T_FRM_DETAILS" => 'car_insurace_frm_vehicle_details' . $config['tplEx'],
					"T_FRM_STORAGE" => 'car_insurace_frm_storage_details' . $config['tplEx'],
					"T_FRM_REUSLT" => 'car_insurace_frm_results' . $config['tplEx'],
					"T_FRM_REFINE" => 'car_insurace_frm_refine' . $config['tplEx'],
					"page_name" => 'Car Insurance',
					"step_name" => $this->step_name,
					'results' => $title_data->value,
				)
			);
			
		}
		catch (Exception $e) {
			echo $e;
			$this->log->logIt($this->module . "-" . "load" . Insurance . $e);
		}
	}
	
		public function customer_vehicle_model(){
		try {
			 
			$response_array = array();
			$RegistrationNo = $_SESSION['Front']['vehicle_details']['registration_number'];
			$Year 			= intval(23); //intval($_SESSION['Front']['vehicle_details']['year_of_registration']);
			$Make 			= intval($_SESSION['Front']['vehicle_details']['car_make']);
			$MakeDesc 		= $_SESSION['Front']['vehicle_details']['car_make'];
			$Model 			= intval($_SESSION['Front']['vehicle_details']['car_model']);
			$ModelDesc 		= $_SESSION['Front']['vehicle_details']['car_model'];
			$Series 		= intval($_SESSION['Front']['vehicle_details']['car_series']);
			$SeriesDesc 	= $_SESSION['Front']['vehicle_details']['car_series'];
			
			$ServiceHistory = false;
			if( isset( $_SESSION['Front']['vehicle_details']['service_history'])
			   && !empty( $_SESSION['Front']['vehicle_details']['service_history']) ){
				$ServiceHistory = $_SESSION['Front']['vehicle_details']['service_history'];
			}
			
			$DateOfFirstRegistration = '2012-02-01';//$_SESSION['Front']['vehicle_details']['vehicle_license_issue_date'];
			
			/*InsuranceCustomerVehicle Model data*/
			$VehicleFinanced = false;
			if( isset( $_SESSION['Front']['vehicle_details']['vehicle_finance'])
			   && !empty( $_SESSION['Front']['vehicle_details']['vehicle_finance']) ){				
				$VehicleFinanced = $_SESSION['Front']['vehicle_details']['vehicle_finance'];
			}
			
			$no_claim_bonus = "0";
			if( isset( $_SESSION['Front']['vehicle_details']['no_claim_bonus'])
			   && !empty( $_SESSION['Front']['vehicle_details']['no_claim_bonus']) ){
				$no_claim_bonus = $_SESSION['Front']['vehicle_details']['no_claim_bonus'];
			}
			
			$VehicleUse 		= $_SESSION['Front']['vehicle_details']['vehicle_use'];
			$OvernightParking 	= $_SESSION['Front']['storage_details']['vehicle_parking'];
			$NightAddressType 	= $_SESSION['Front']['storage_details']['night_address_type'];
			$DayParking 		=  $_SESSION['Front']['storage_details']['day_parking'];
			$DayAddressType 	= $_SESSION['Front']['storage_details']['day_address_type'];			
			$PermissionToSearch = "true";
			
			$TrackingDeviceInstalled = "N";
			if( isset( $_SESSION['Front']['storage_details']['tracking_device']) ){			
				if( $_SESSION['Front']['storage_details']['tracking_device'] == "0"){
					$TrackingDeviceInstalled = "Y";
				}
			}
						
			$TrackerDeviceType = "";
			if( isset( $_SESSION['Front']['storage_details']['tracking_device_type']) ){
				$TrackerDeviceType = $_SESSION['Front']['storage_details']['tracking_device_type'];
			}
			
			$InsuredOption = "";
			if( isset( $_SESSION['Front']['storage_details']['insure_type']) ){
					$InsuredOption = $_SESSION['Front']['storage_details']['insure_type'];
			}
			
			$DayAreaType  = "";
			if( isset( $_SESSION['Front']['storage_details']['day_area_type']) ){
					$DayAreaType = $_SESSION['Front']['storage_details']['day_area_type'];
			}
			
			$NightParkingSame = "N";
			if( isset( $_SESSION['Front']['storage_details']['night_address']) ){
				if( $_SESSION['Front']['storage_details']['night_address'] == 0){
					$NightParkingSame = "Y";
				}
			}
			
			$NightPostalCode  = "";
			if( isset( $_SESSION['Front']['storage_details']['postal_code']) ){
					$NightPostalCode = $_SESSION['Front']['storage_details']['postal_code'];
			}
			
			$NightSuburbName  = "";
			if( isset( $_SESSION['Front']['storage_details']['suburb']) ){
					$NightSuburbName = $_SESSION['Front']['storage_details']['suburb'];
			}
						
			$NightAreaType  = "";
			if( isset( $_SESSION['Front']['storage_details']['night_parking_area_type']) ){
					$NightAreaType = $_SESSION['Front']['storage_details']['night_parking_area_type'];
			}
			
			$NightAccessControl = "";
			if( isset( $_SESSION['Front']['storage_details']['night_address_access_control_type']) ){
					$NightAccessControl = $_SESSION['Front']['storage_details']['night_address_access_control_type'];
			}
			
			$DayAccessControl = "";
			if( isset( $_SESSION['Front']['vehicle_details']['access_control']) ){
					$DayAccessControl = $_SESSION['Front']['vehicle_details']['access_control'];
			}
			
			$VehicleColour = "";
			if( isset( $_SESSION['Front']['vehicle_details']['vehicle_colour']) ){
					$VehicleColour = $_SESSION['Front']['vehicle_details']['vehicle_colour'];
			}
			
			$VehiclePaintType = "";
			if( isset( $_SESSION['Front']['vehicle_details']['vehicle_paint_type']) ){
					$VehiclePaintType = $_SESSION['Front']['vehicle_details']['vehicle_paint_type'];
			}
			
			$DriverDateOfBirth = "";
			if( isset( $_SESSION['Front']['personal_details']['driver_dob']) ){
					$DriverDateOfBirth = $_SESSION['Front']['personal_details']['driver_dob'];
			}
			
			$DriverGender = "";
			if( isset( $_SESSION['Front']['personal_details']['person_gender']) ){
					$DriverGender = $_SESSION['Front']['personal_details']['person_gender'];
			}
			
			$DriverMaritalStatus = "";
			if( isset( $_SESSION['Front']['personal_details']['driver_marital_status']) ){
					$DriverMaritalStatus = $_SESSION['Front']['personal_details']['driver_marital_status'];
			}
			
			$DriverEmploymentStatus = "";
			if( isset( $_SESSION['Front']['personal_details']['driver_employment_status']) ){
					$DriverEmploymentStatus = $_SESSION['Front']['personal_details']['driver_employment_status'];
			}
			
			$DriverLicenseType = "";
			if( isset( $_SESSION['Front']['vehicle_details']['vehicle_license_issue_type']) ){
					$DriverLicenseType = $_SESSION['Front']['vehicle_details']['vehicle_license_issue_type'];
			}
			
			$DriverPostalCode = "";
			if( isset( $_SESSION['Front']['personal_details']['driver_postal_code']) ){
					$DriverPostalCode = $_SESSION['Front']['personal_details']['driver_postal_code'];
			}
			
			$DriverSuburbName = "";
			if( isset( $_SESSION['Front']['personal_details']['driver_suburb']) ){
					$DriverSuburbName = $_SESSION['Front']['personal_details']['driver_suburb'];
			}
			
			$DriverAccessControl = "No";
			if( isset( $_SESSION['Front']['vehicle_details']['access_control']) ){
				if( $_SESSION['Front']['vehicle_details']['access_control'] == "yes"){
						$DriverAccessControl = "Yes";
				}
			}
			
			$DriverAreaType = "";
			if( isset( $_SESSION['Front']['vehicle_details']['area_type']) ){
					$DriverAreaType = $_SESSION['Front']['vehicle_details']['area_type'];
			}
			
			$CurrentMileage = "";
			if( isset( $_SESSION['Front']['vehicle_details']['current_mileage']) ){
					$CurrentMileage = $_SESSION['Front']['vehicle_details']['current_mileage'];
			}
			
			$CoverType = "A";
			if( isset( $_SESSION['Front']['storage_details']['cover_type'])
			   && !empty( $_SESSION['Front']['storage_details']['cover_type']) ){
					$CoverType = $_SESSION['Front']['storage_details']['cover_type'];
			}
			
			$CarHireOption = "C";
			if( isset( $_SESSION['Front']['storage_details']['car_hire_option'])
				&& !empty( $_SESSION['Front']['storage_details']['car_hire_option']) ){
					$CarHireOption = $_SESSION['Front']['storage_details']['car_hire_option'];
			}
			
			$VoluntaryExcess  = "Y";
			if( isset( $_SESSION['Front']['storage_details']['voluntary_excess'])
			   && !empty($_SESSION['Front']['storage_details']['voluntary_excess']) ){
					$VoluntaryExcess = $_SESSION['Front']['storage_details']['voluntary_excess'];
			}
			
			$MMCode  = "";
			if( isset( $_SESSION['Front']['storage_details']['mm_code']) ){
					$MMCode = $_SESSION['Front']['storage_details']['mm_code'];
			}
			
			$InsuranceCustomerVehicleModel 	= array (
				//"VehicleKey" 				=>  "", // String
				//"VehicleDescription" 		=>  "", // String
				"VehicleFinanced" 			=>  $VehicleFinanced,
				"NCB" 						=>  intval($no_claim_bonus), // dropdown string
				"CoverType" 				=>  $CoverType, // String
				"VehicleUse" 				=> 	$VehicleUse, // String
				//HailCover"				=> "Yes", //YesNoIndicator
				//"RadioCover"				=> "Yes", //YesNoIndicator
				//"RadioCoverValue"			=>  1, //int
				"OvernightParking"			=>  $OvernightParking, //string
				"DayParking"				=>  $DayParking, //string
				"DayAddressType"			=>  $DayAddressType, //AddressType
				//"DayParkingSame"			=>  "Yes", //YesNoIndicator
				//"DaySuburbName"			=>  "", //string
				"DayAreaType"				=>  $DayAreaType, //string
				"DayAccessControl"			=>  $DayAccessControl, //string
				"TrackingDeviceInstalled" 	=>  $TrackingDeviceInstalled, //YesNoIndicator
				"TrackerDeviceType"			=>	$TrackerDeviceType, //string
				//"WindscreenCover"			=>	"Yes", //YesNoIndicator
				//"CarHireIncluded"			=>	"N",//YesNoIndicator
				"CarHireOption"				=>  $CarHireOption, //string
				//"CanopyCoverIncluded"		=>	"Yes", //YesNoIndicator
				"InsuredOption"				=>	$InsuredOption,//string
				"NightAddressType"			=>  $NightAddressType, //AddressType
				"NightParkingSame"			=>  $NightParkingSame,//YesNoIndicator
				"NightPostalCode"			=>  $NightPostalCode, //sting
				"NightSuburbName"			=>  'CAPE TOWN',//$NightSuburbName,//string
				"NightAreaType"				=>  $NightAreaType, //string
				"NightAccessControl"		=>  $NightAccessControl, //string
				
				"VoluntaryExcess"			=>  $VoluntaryExcess, //string
				//"IncludeTheftExcessBuster"=>  "Yes", //YesNoIndicator
				//"IncludeTheftExcessBuster"=>  "Yes", //YesNoIndicator
				//"SaverThirdPartyLiability"=>  "Yes", //YesNoIndicator
				//"SaverAccidentCover"		=>  "Yes", //YesNoIndicator
				//"SaverAccidentOption"		=>  "", //string
				//"SaverTotalLoss"			=>  "Yes", //YesNoIndicator
				//"SaverAssist"				=>  "Yes", //YesNoIndicator
				//"PublicLiability"			=>  "Yes", //YesNoIndicator
				"VehicleColour"				=>  $VehicleColour, //string
				"VehiclePaintType"			=>  $VehiclePaintType, //string
				"DriverDateOfBirth"  		=>  $DriverDateOfBirth,
				"DriverGender"				=>  $DriverGender, //string
				"DriverMaritalStatus"		=>  $DriverMaritalStatus, //string
				"DriverEmploymentStatus"	=>  $DriverEmploymentStatus, //string
				"DriverLicenseType"			=>  $DriverLicenseType, //string
				"DriverPostalCode"			=>  $DriverPostalCode, //string
				"DriverSuburbName"			=>  $DriverSuburbName, //string
				"DriverAccessControl"		=>  $DriverAccessControl, //string
				"DriverAreaType"			=>  $DriverAreaType, //string
				"CurrentMileage"			=>  $CurrentMileage, //int				
			);
			
			$InsuranceCustomeVehicleID = "";
			
			//$this->log->logIt( array($_SESSION['Front']['storage_details']) );
			
			if( isset( $_SESSION['Front']['storage_details']['insurance_customer_vehicle_id'])
				&& !empty( $_SESSION['Front']['storage_details']['insurance_customer_vehicle_id']) ){
				
					// Update Insurance Customer Vehicle Information	
					$InsuranceCustomeVehicleID = $_SESSION['Front']['storage_details']['insurance_customer_vehicle_id'];
					
					$InsuranceCustomerVehicleModel['InsuranceCustomeVehicleID'] = $InsuranceCustomeVehicleID;
					
					//$this->log->logIt( "InsuranceCustomeVehicleID-".$InsuranceCustomeVehicleID );
			}
			
			$customerVehicleModel = array (
				"RegistrationNo" 		=>	$RegistrationNo,
				"Year"					=>  $Year,
				"Make"					=>	$Make,
				"MakeDesc" 				=>	$MakeDesc,
				"Model"					=>	$Model,
				"ModelDesc"				=>  $ModelDesc,
				"Series"				=>	$Series,
				"SeriesDesc"			=>	$SeriesDesc,
				"ServiceHistory"		=>  $ServiceHistory, //bool
				"PermissionToSearch"	=> 	$PermissionToSearch, //bool
				"DateOfFirstRegistration"  => $DateOfFirstRegistration,
				"InsuranceCustomerVehicle" => $InsuranceCustomerVehicleModel,
				//"Vehicle"					=> 101,// int,
				//"VehicleDesc				=> '',// str
				//"Warranty"				=> "Yes",
				//"VINNo" 					=> "", //string
				//"EngineNo"				=> "", //string
				"MMCode" 					=> $MMCode, //string
				//"PreviousOwned"			=> 1, //bool
			);
			
			//$this->log->logIt( array($customerVehicleModel) );
			//
			//exit(0);
			
			return $customerVehicleModel;
			 
		}
		catch (Exception $e) {
			echo $e;
			$this->log->logIt($this->module . "-" . "form_add_edit" . "-" . $e);
		}
	}
	
	public function update_customer($CustomerVehicleModel){
		try {
			$this->log->logIt("update_customer");
			if($_SESSION['Front']['customer_info_obj']->CustomerID != "" && $_SESSION['token'] != ""){
				
				$this->log->logIt(array($_SESSION['Front']['personal_details']));
				$CustomerID 		= $_SESSION['Front']['customer_info_obj']->CustomerID;
				$ChannelId 			= $_SESSION['Front']['customer_info_obj']->ChannelId;
				$ChannelDescription = $_SESSION['Front']['customer_info_obj']->ChannelDescription;
				$DealerId 			= $_SESSION['Front']['customer_info_obj']->DealerId;
				$DealerDescription 	= $_SESSION['Front']['customer_info_obj']->DealerDescription;
				$Title 				= $_SESSION['Front']['customer_info_obj']->Title;
				$TitleDesc 			= $_SESSION['Front']['customer_info_obj']->TitleDesc;
				$FirstName 			= $_SESSION['Front']['customer_info_obj']->FirstName;
				$SurName 			= $_SESSION['Front']['customer_info_obj']->SurName;
				$IdentificationNo 	= $_SESSION['Front']['customer_info_obj']->IdentificationNo;
				$PassportNo 		= $_SESSION['Front']['customer_info_obj']->PassportNo;
				$BirthDate 			= $_SESSION['Front']['customer_info_obj']->BirthDate;
				$Email				= $_SESSION['Front']['customer_info_obj']->Email;
				$EmailVerified		= $_SESSION['Front']['customer_info_obj']->EmailVerified;
				$CellphoneNo		= $_SESSION['Front']['personal_details']['person_mobile'];
				$OtherContactNo		= $_SESSION['Front']['personal_details']['person_telephone'];
				$FaxNo				= $_SESSION['Front']['personal_details']['person_fax'];
				
				$phy_add_line1 = $_SESSION['Front']['personal_details']['person_street_address'];
				$phy_add_line2 = $_SESSION['Front']['personal_details']['person_street_address2'];
				$phy_add_line3 = $_SESSION['Front']['personal_details']['person_street_address3'];
				$phy_post_code = $_SESSION['Front']['personal_details']['person_postal_code'];
				//$phy_post_desc = $_SESSION['Front']['personal_details']['person_suburb']."|".$_SESSION['Front']['personal_details']['person_city'];
				
				$pos_add_line1 = $_SESSION['Front']['personal_details']['driver_street_address'];
				$pos_add_line2 = $_SESSION['Front']['personal_details']['driver_street_address2'];
				$pos_add_line3 = $_SESSION['Front']['personal_details']['driver_street_address3'];
				$pos_post_code = $_SESSION['Front']['personal_details']['driver_postal_code'];
				//$pos_post_desc = $_SESSION['Front']['personal_details']['driver_suburb']."|".$_SESSION['Front']['personal_details']['driver_city'];
	
	
				$personal_address_id 	= $_SESSION['Front']['personal_details']['personal_address_id'];
				$driver_address_id 		= $_SESSION['Front']['personal_details']['driver_address_id'];
				
			 		
				$PhysicalAddress = array(
					"AddressLine1"	=> 	$phy_add_line1,
					"AddressLine2"	=>	$phy_add_line2,
					"AddressLine3"	=>	$phy_add_line3,
					"PostCode"		=>	$personal_address_id,
				);
				
				$PostalAddress = array(
					"AddressLine1"	=> 	$pos_add_line1,
					"AddressLine2"	=>	$pos_add_line2,
					"AddressLine3"	=>	$pos_add_line3,
					"PostCode"		=>	$driver_address_id,
				);
				
						
				$CustomerModel = array(
					"CustomerID"		=>	$CustomerID,
					"ChannelId"			=> 	$ChannelId,
					"ChannelDescription"=>	$ChannelDescription,
					"DealerId"			=>	$DealerId,
					"DealerDescription"	=>	$DealerDescription,
					"Title"				=>	$Title,
					"TitleDesc"			=>	$TitleDesc,
					"FirstName"			=>	$FirstName,
					"SurName"			=>	$SurName,
					"IdentificationNo"	=>	$IdentificationNo,
					"PassportNo"		=>	$PassportNo,
					"BirthDate"			=>	$BirthDate,
					"Email"				=>	$Email,
					"EmailVerified"		=>	$EmailVerified,
					"CellphoneNo"		=>	$CellphoneNo,
					"OtherContactNo"	=> 	$OtherContactNo,
					"FaxNo"				=>	$FaxNo,
					"PhysicalAddress"	=> 	$PhysicalAddress,
					"PostalAddress"		=> 	$PostalAddress,
					"CustomerVehicleModel" =>  $CustomerVehicleModel ,
				);
				
				#print_r($CustomerModel);
				
				
				$this->customerservices->token = $_SESSION['token'];
				$response = $this->customerservices->fn_CustomerUpdate($CustomerModel);
				$this->log->logIt("update_customer:model");
				$this->log->logIt(array($CustomerModel));
				$this->log->logIt("update_customer:response");
				$this->log->logIt(array($response));
				//
				//if( $response['resultStatus'] == "Success"){
				//	$this->log->logIt("Successfuly updated----------- ");
				//	$_SESSION['Front']['customer_info_obj']  = $response['resultData']->CustomerUpdateResult;
				//}
				//
				//$response_array = array();
				//$response_array['resultStatus'] = resultConstant::Success;
				//print_r( json_encode($response_array) );
				//exit(0);
			
			}
			 
			
		}
		catch (Exception $e) {
			echo $e;
			$this->log->logIt($this->module . "-" . "get_userinfo_session" . "-" . $e);
		}
		
	}
		
}				
?>
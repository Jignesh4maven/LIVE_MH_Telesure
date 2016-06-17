<?php
require_once(BASE_PATH."/Util/util.php");
require_once(BASE_PATH."/Util/Services/customerservices.php");
require_once(BASE_PATH."/Util/Services/data_curl.php");
require_once(BASE_PATH."/Util/Services/service_util.php");
require_once(BASE_PATH."/Dbaccess/commondao.php");
require_once(BASE_PATH."/Dbaccess/servicedao.php");
require_once(BASE_PATH."/Util/Services/quoteservice.php");



class vehicle_details{
	private $module = 'vehicle_details';
	private $log;
	private $util;
	private $service;
	
	public function __construct(){
		$this->log = new logger();
		$this->util = new util();
		$this->customerservices = new customerservices();
		$this->service_util = new service_util();
		$this->data_curl = new data_curl();
		$this->commondao = new commondao();
		$this->service = new servicedao();
		$this->quoteservice = new quoteservice();

		if (isset($_REQUEST['action'])) {

			if ($_REQUEST['action'] != "") {

				$this->step_name = $_REQUEST['action'];
			}
		}

	}
	
	public function get_vehicle_formfeed(){
		
		$result = new resultobject();
		
		try {
			$response_array = array();
			$response_array["VehicleYearData"] 		=  $this->commondao->get_data_service_json('VehicleYearData');
			$response_array["VehicleMakeData"] 		=  $this->commondao->get_data_service_json('VehicleMakeData');
			$response_array["VehicleUseItems"] 		=  $this->commondao->get_data_service_json('VehicleUseItems');
			$response_array["VehiclePaintTypes"]	=  $this->commondao->get_data_service_json('VehiclePaintTypes');
			$response_array["MotorNCBItems"] 		=  $this->commondao->get_data_service_json('MotorNCBItems');
			$response_array["VehicleColours"] 		=  $this->commondao->get_data_service_json('VehicleColours');
			$response_array["DriverLicenceType"]	=  $this->commondao->get_data_service_json('DriverLicenceType');
			$vehicle_model_json 					=  $this->commondao->get_data_service_json('VehicleModelData');
			$response_array["AccessControlType"] 		= $this->commondao->get_data_service_json('AccessControlTypeItems');
			$response_array["TelesureAreaTypeItems"]	= $this->commondao->get_data_service_json('TelesureAreaTypeItems');

			$vehicle_list 	= $this->service_util->fetch_vehicle('','list');
			
			$vehicles_details = array();
			
			if( $vehicle_list->resultStatus == "Success" ){
				
				#$vehicle_list_data = $vehicle_list->resultData;
				
				foreach( $vehicle_list->resultData as $key => $val ){
					
					if( $key != null ){
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
				}
			}
			
			$response_array["VehiclesList"] 	=  $vehicles_details;
			
			$response_array['resultStatus'] = resultConstant::Success;
			
			print_r( json_encode($response_array) );
			
			exit(0);
		}
		catch (Exception $e) {
			echo $e;
			$this->log->logIt($this->module . "-" . "form_add_edit" . "-" . $e);
		}
	}
	
	
	public function get_storage_formfeed(){
		
		$result = new resultobject();
		
		try {
			$response_array = array();
			$this->data_curl = new data_curl();
	 		$response_array["TelesureAreaTypeItems"]	= $this->commondao->get_data_service_json('TelesureAreaTypeItems');
			$response_array["ParkingFacility"] 			= $this->commondao->get_data_service_json('OvernightParkingFacility');			
			$response_array["AddressType"] 				= $this->commondao->get_data_service_json('AddressType');
			$response_array["AccessControlType"] 		= $this->commondao->get_data_service_json('AccessControlTypeItems');			
			$response_array["MotorTrackerOptions"]		= $this->commondao->get_data_service_json('MotorTrackerOptions');
			$response_array["MotorInsuredItems"] 		= $this->commondao->get_data_service_json('MotorInsuredItems');
			$response_array['resultStatus'] 			= resultConstant::Success;
			print_r( json_encode($response_array) );
			
			exit(0);
		}
		catch (Exception $e) {
			echo $e;
			$this->log->logIt($this->module . "-" . "form_add_edit" . "-" . $e);
		}
	}
	
	
	// Moved to Util
	//public function customer_vehicle_model(){
	//	try {
	//		 
	//		$response_array = array();
	//		$RegistrationNo = $_SESSION['Front']['vehicle_details']['registration_number'];
	//		$Year 			= intval($_SESSION['Front']['vehicle_details']['year_of_registration']);
	//		$Make 			= intval($_SESSION['Front']['vehicle_details']['car_make']);
	//		$MakeDesc 		= $_SESSION['Front']['vehicle_details']['car_make'];
	//		$Model 			= intval($_SESSION['Front']['vehicle_details']['car_model']);
	//		$ModelDesc 		= $_SESSION['Front']['vehicle_details']['car_model'];
	//		$Series 		= intval($_SESSION['Front']['vehicle_details']['car_series']);
	//		$SeriesDesc 	= $_SESSION['Front']['vehicle_details']['car_series'];
	//		
	//		$ServiceHistory = false;
	//		if( isset( $_SESSION['Front']['vehicle_details']['service_history'])
	//		   && !empty( $_SESSION['Front']['vehicle_details']['service_history']) ){
	//			$ServiceHistory = $_SESSION['Front']['vehicle_details']['service_history'];
	//		}
	//		
	//		//$DateOfFirstRegistration = "2012-02-02";//$_SESSION['Front']['vehicle_details']['vehicle_license_issue_date'];
	//		$DateOfFirstRegistration = "";
	//		if( isset($_SESSION['Front']['vehicle_details']['year_of_registration']) ){
	//			
	//			//$yeardata_array =  $this->commondao->get_data_service_json('VehicleYearData');
	//			//
	//			//$year_data = json_decode($yeardata_array);
	//			//
	//			//$year_array = array();
	//			//
	//			//for($i=0; $i < count($year_data->value); $i++){
	//			//	
	//			//	$year_array[$year_data->value[$i]->ID] = $year_data->value[$i]->Year;
	//			//}
	//			//
	//			//$year_id = $_SESSION['Front']['vehicle_details']['year_of_registration'];
	//			
	//			$year = $_SESSION['Front']['vehicle_details']['year_of_registration'];
	//			
	//			$DateOfFirstRegistration = $year."-01-01";
	//			
	//			$DateOfFirstRegistration = date('Y-m-d',strtotime($DateOfFirstRegistration));
	//		}
	//		
	//		
	//		/*InsuranceCustomerVehicle Model data*/
	//		$VehicleFinanced = boolval(0);
	//		$this->log->logIt( "VehicleFinanced-----------------1---:".$VehicleFinanced);
	//		
	//		if( isset( $_SESSION['Front']['vehicle_details']['vehicle_finance'])
	//		   && !empty( $_SESSION['Front']['vehicle_details']['vehicle_finance']) ){				
	//			#$VehicleFinanced = $_SESSION['Front']['vehicle_details']['vehicle_finance'];
	//		
	//			$this->log->logIt( "VehicleFinanced-----------------2---:".$_SESSION['Front']['vehicle_details']['vehicle_finance']);
	//		
	//			if($_SESSION['Front']['vehicle_details']['vehicle_finance'] == "true"){
	//				$VehicleFinanced = 1;		
	//			}
	//			else{
	//				$VehicleFinanced = 0;	
	//			}
	//		}
	//		
	//		
	//		$this->log->logIt( "VehicleFinanced-----------------3---:".$VehicleFinanced);
	//		
	//		
	//		
	//		$no_claim_bonus = "0";
	//		if( isset( $_SESSION['Front']['vehicle_details']['no_claim_bonus'])
	//		   && !empty( $_SESSION['Front']['vehicle_details']['no_claim_bonus']) ){
	//			$no_claim_bonus = $_SESSION['Front']['vehicle_details']['no_claim_bonus'];
	//		}
	//		
	//		$VehicleUse 		= $_SESSION['Front']['vehicle_details']['vehicle_use'];
	//		$OvernightParking 	= $_SESSION['Front']['storage_details']['vehicle_parking'];
	//		$NightAddressType 	= $_SESSION['Front']['storage_details']['night_address_type'];
	//		$DayParking 		=  $_SESSION['Front']['storage_details']['day_parking'];
	//		$DayAddressType 	= $_SESSION['Front']['storage_details']['day_address_type'];			
	//		$PermissionToSearch = "true";
	//		
	//		$TrackingDeviceInstalled = "N";
	//		if( isset( $_SESSION['Front']['storage_details']['tracking_device']) ){			
	//			if( $_SESSION['Front']['storage_details']['tracking_device'] == "0"){
	//				$TrackingDeviceInstalled = "Y";
	//			}
	//		}
	//					
	//		$TrackerDeviceType = "";
	//		if( isset( $_SESSION['Front']['storage_details']['tracking_device_type']) ){
	//			$TrackerDeviceType = $_SESSION['Front']['storage_details']['tracking_device_type'];
	//		}
	//		
	//		$MotorSarsia = "";
	//		if( isset( $_SESSION['Front']['storage_details']['motor_sarsia']) ){
	//			$MotorSarsia = $_SESSION['Front']['storage_details']['motor_sarsia'];
	//		}
	//		
	//		$InsuredOption = "";
	//		if( isset( $_SESSION['Front']['storage_details']['insure_type']) ){
	//				$InsuredOption = $_SESSION['Front']['storage_details']['insure_type'];
	//		}
	//		
	//		$DayAreaType  = "";
	//		if( isset( $_SESSION['Front']['storage_details']['day_area_type']) ){
	//				$DayAreaType = $_SESSION['Front']['storage_details']['day_area_type'];
	//		}
	//		
	//		$NightParkingSame = "N";
	//		if( isset( $_SESSION['Front']['storage_details']['night_address']) ){
	//			if( $_SESSION['Front']['storage_details']['night_address'] == 0){
	//				$NightParkingSame = "Y";
	//			}
	//		}
	//		
	//		$NightPostalCode  = "";
	//		if( isset( $_SESSION['Front']['storage_details']['postal_code']) ){
	//				$NightPostalCode = $_SESSION['Front']['storage_details']['postal_code'];
	//		}
	//		
	//		$NightSuburbName  = "";
	//		if( isset( $_SESSION['Front']['storage_details']['suburb']) ){
	//				$NightSuburbName = $_SESSION['Front']['storage_details']['suburb'];
	//		}
	//					
	//		$NightAreaType  = "";
	//		if( isset( $_SESSION['Front']['storage_details']['night_parking_area_type']) ){
	//				$NightAreaType = $_SESSION['Front']['storage_details']['night_parking_area_type'];
	//		}
	//		
	//		$NightAccessControl = "";
	//		if( isset( $_SESSION['Front']['storage_details']['night_address_access_control_type']) ){
	//				$NightAccessControl = $_SESSION['Front']['storage_details']['night_address_access_control_type'];
	//		}
	//		
	//		$DayAccessControl = "01";
	//		if( isset( $_SESSION['Front']['vehicle_details']['access_control']) ){
	//				$DayAccessControl = $_SESSION['Front']['vehicle_details']['access_control'];
	//		}
	//		
	//		$VehicleColour = "";
	//		if( isset( $_SESSION['Front']['vehicle_details']['vehicle_colour']) ){
	//				$VehicleColour = $_SESSION['Front']['vehicle_details']['vehicle_colour'];
	//		}
	//		
	//		$VehiclePaintType = "";
	//		if( isset( $_SESSION['Front']['vehicle_details']['vehicle_paint_type']) ){
	//				$VehiclePaintType = $_SESSION['Front']['vehicle_details']['vehicle_paint_type'];
	//		}
	//		
	//		$DriverDateOfBirth = "";
	//		if( isset( $_SESSION['Front']['personal_details']['driver_dob']) ){
	//				$DriverDateOfBirth = $_SESSION['Front']['personal_details']['driver_dob'];
	//				$DriverDateOfBirth = date('Y-m-d',strtotime($DriverDateOfBirth));
	//		}
	//		
	//		
	//		$DriverGender = "";
	//		if( isset( $_SESSION['Front']['personal_details']['person_gender']) ){
	//				$DriverGender = $_SESSION['Front']['personal_details']['person_gender'];
	//		}
	//		
	//		$DriverMaritalStatus = "";
	//		if( isset( $_SESSION['Front']['personal_details']['driver_marital_status']) ){
	//				$DriverMaritalStatus = $_SESSION['Front']['personal_details']['driver_marital_status'];
	//		}
	//		
	//		$DriverEmploymentStatus = "";
	//		if( isset( $_SESSION['Front']['personal_details']['driver_employment_status']) ){
	//				$DriverEmploymentStatus = $_SESSION['Front']['personal_details']['driver_employment_status'];
	//		}
	//		
	//		$DriverLicenseType = "";
	//		if( isset( $_SESSION['Front']['vehicle_details']['vehicle_license_issue_type']) ){
	//				$DriverLicenseType = $_SESSION['Front']['vehicle_details']['vehicle_license_issue_type'];
	//		}
	//		
	//		$DriverPostalCode = "";
	//		if( isset( $_SESSION['Front']['personal_details']['driver_postal_code']) ){
	//				$DriverPostalCode = $_SESSION['Front']['personal_details']['driver_postal_code'];
	//		}
	//		
	//		$DriverSuburbName = "";
	//		if( isset( $_SESSION['Front']['personal_details']['driver_suburb']) ){
	//				$DriverSuburbName = $_SESSION['Front']['personal_details']['driver_suburb'];
	//		}
	//		
	//		$DriverAccessControl = "01";
	//		if( isset( $_SESSION['Front']['vehicle_details']['driver_access_control']) ){
	//					$DriverAccessControl = $_SESSION['Front']['vehicle_details']['driver_access_control'];
	//		}
	//		
	//		$DriverAreaType = "";
	//		if( isset( $_SESSION['Front']['vehicle_details']['driver_area_type']) ){
	//				$DriverAreaType = $_SESSION['Front']['vehicle_details']['driver_area_type'];
	//		}
	//		
	//		$DriverLicenseDate = date("Y-m-d");
	//		
	//		if( isset($_SESSION['Front']['vehicle_details']['vehicle_license_issue_date']) ){
	//			$DriverLicenseDate = $_SESSION['Front']['vehicle_details']['vehicle_license_issue_date'];
	//			$DriverLicenseDate = date('Y-m-d',strtotime($DriverLicenseDate));
	//		}
	//		
	//		
	//		
	//		$CurrentMileage = "";
	//		if( isset( $_SESSION['Front']['vehicle_details']['current_mileage']) ){
	//				$CurrentMileage = $_SESSION['Front']['vehicle_details']['current_mileage'];
	//		}
	//		
	//		$CoverType = "A";
	//		if( isset( $_SESSION['Front']['storage_details']['cover_type'])
	//		   && !empty( $_SESSION['Front']['storage_details']['cover_type']) ){
	//				$CoverType = $_SESSION['Front']['storage_details']['cover_type'];
	//		}
	//		
	//		$HailCover = "Y";
	//		if( isset( $_SESSION['Front']['storage_details']['hail_cover']) ){			
	//			if( $_SESSION['Front']['storage_details']['hail_cover'] == "N"){
	//				$HailCover = "N";
	//			}
	//		}
	//		
	//		$WindscreenCover = "Y";
	//		if( isset( $_SESSION['Front']['storage_details']['windscreen_cover']) ){			
	//			if( $_SESSION['Front']['storage_details']['windscreen_cover'] == "N"){
	//				$WindscreenCover = "N";
	//			}
	//		}
	//		
	//		$CarHireIncluded = "Y";
	//		if( isset( $_SESSION['Front']['storage_details']['car_hire_included']) ){			
	//			if( $_SESSION['Front']['storage_details']['car_hire_included'] == "N"){
	//				$CarHireIncluded = "N";
	//			}
	//		}
	//		
	//		$CarHireOption = "C";
	//		if( isset( $_SESSION['Front']['storage_details']['car_hire_option'])
	//			&& !empty( $_SESSION['Front']['storage_details']['car_hire_option']) ){
	//				$CarHireOption = $_SESSION['Front']['storage_details']['car_hire_option'];
	//		}
	//		
	//		$CanopyCoverIncluded = "Y";
	//		if( isset( $_SESSION['Front']['storage_details']['canopy_included']) ){			
	//			if( $_SESSION['Front']['storage_details']['canopy_included'] == "N"){
	//				$CanopyCoverIncluded = "N";
	//			}
	//		}
	//		
	//		$IncludeTheftExcessBuster = "Y";
	//		if( isset( $_SESSION['Front']['storage_details']['theft_access_include']) ){			
	//			if( $_SESSION['Front']['storage_details']['theft_access_include'] == "N"){
	//				$IncludeTheftExcessBuster = "N";
	//			}
	//		}
	//		
	//		$RadioCover = "Y";
	//		if( isset( $_SESSION['Front']['storage_details']['radio_cover']) ){			
	//			if( $_SESSION['Front']['storage_details']['radio_cover'] == "N"){
	//				$RadioCover = "N";
	//			}
	//		}
	//		
	//		$RadioCoverValue = "0";
	//		if( isset( $_SESSION['Front']['storage_details']['radio_cover_value']) ){			
	//				$RadioCoverValue = $_SESSION['Front']['storage_details']['radio_cover_value'] ;
	//		}
	//		
	//		$VoluntaryExcess  = "0";
	//		if( isset( $_SESSION['Front']['storage_details']['voluntary_excess'])
	//		   && !empty($_SESSION['Front']['storage_details']['voluntary_excess']) ){
	//				$VoluntaryExcess = $_SESSION['Front']['storage_details']['voluntary_excess'];
	//		}
	//		
	//		$MMCode  = "";
	//		if( isset( $_SESSION['Front']['storage_details']['mm_code']) && $_SESSION['Front']['storage_details']['mm_code'] != ""){
	//				$MMCode = $_SESSION['Front']['storage_details']['mm_code'];
	//		}
	//		
	//		$SaverAccidentCover = "Y";
	//		$SaverAccidentOption = "A";
	//		$SaverTotalLoss = "Y";
	//		$PublicLiability = "Y";
	//		
	//		$InsuranceCustomerVehicleModel 	= array (
	//			//"VehicleKey" 				=>  "", // String
	//			//"VehicleDescription" 		=>  "", // String
	//			"VehicleFinanced" 			=>  $VehicleFinanced,
	//			"NCB" 						=>  intval($no_claim_bonus), // dropdown string
	//			"CoverType" 				=>  $CoverType, // String
	//			"VehicleUse" 				=> 	$VehicleUse, // String
	//			"HailCover"					=>  $HailCover, //YesNoIndicator
	//			"RadioCover"				=>  $RadioCover, //YesNoIndicator
	//			"RadioCoverValue"			=>  $RadioCoverValue, //int
	//			"OvernightParking"			=>  $OvernightParking, //string
	//			"DayParking"				=>  $DayParking, //string
	//			"DayAddressType"			=>  $DayAddressType, //AddressType
	//			//"DayParkingSame"			=>  "Yes", //YesNoIndicator
	//			//"DaySuburbName"			=>  "", //string
	//			"DayAreaType"				=>  $DayAreaType, //string
	//			"DayAccessControl"			=>  $DayAccessControl, //string
	//			"TrackingDeviceInstalled" 	=>  $TrackingDeviceInstalled, //YesNoIndicator
	//			"TrackerDeviceType"			=>	$TrackerDeviceType, //string
	//			"WindscreenCover"			=>	$WindscreenCover, //YesNoIndicator
	//			"CarHireIncluded"			=>	$CarHireIncluded,//YesNoIndicator
	//			"CarHireOption"				=>  $CarHireOption, //string
	//			"CanopyCoverIncluded"		=>	$CanopyCoverIncluded, //YesNoIndicator
	//			"InsuredOption"				=>	$InsuredOption,//string
	//			"NightAddressType"			=>  $NightAddressType, //AddressType
	//			"NightParkingSame"			=>  $NightParkingSame,//YesNoIndicator
	//			"NightPostalCode"			=>  $NightPostalCode, //sting
	//			"NightSuburbName"			=>  $NightSuburbName,//string
	//			"NightAreaType"				=>  $NightAreaType, //string
	//			"NightAccessControl"		=>  $NightAccessControl, //string
	//			
	//			"VoluntaryExcess"			=>  $VoluntaryExcess, //string
	//			"IncludeTheftExcessBuster"=>  	$IncludeTheftExcessBuster, //YesNoIndicator
	//			//"SaverThirdPartyLiability"=>  "Yes", //YesNoIndicator
	//			"SaverAccidentCover"		=>  $SaverAccidentCover, //"Yes", //YesNoIndicator
	//			"SaverAccidentOption"		=>  $SaverAccidentOption, //string
	//			"SaverTotalLoss"			=>  $SaverTotalLoss,//"Yes", //YesNoIndicator
	//			//"SaverAssist"				=>  "Yes", //YesNoIndicator
	//			"PublicLiability"			=>  $PublicLiability,//"Yes", //YesNoIndicator
	//			"VehicleColour"				=>  $VehicleColour, //string
	//			"VehiclePaintType"			=>  $VehiclePaintType, //string
	//			//"DriverDateOfBirth"  		=>  $DriverDateOfBirth,
	//			"DriverGender"				=>  $DriverGender, //string
	//			"DriverMaritalStatus"		=>  $DriverMaritalStatus, //string
	//			"DriverEmploymentStatus"	=>  $DriverEmploymentStatus, //string
	//			"DriverLicenseType"			=>  $DriverLicenseType, //string
	//			"DriverPostalCode"			=>  $DriverPostalCode, //string
	//			"DriverSuburbName"			=>  $DriverSuburbName, //string
	//			"DriverAccessControl"		=>  $DriverAccessControl, //string
	//			"DriverAreaType"			=>  $DriverAreaType, //string
	//			"DriverLicenseDate"			=>  $DriverLicenseDate, //string
	//			"CurrentMileage"			=>  $CurrentMileage, //int				
	//		);
	//		if($DriverDateOfBirth != ""){
	//			$InsuranceCustomerVehicleModel["DriverDateOfBirth"] = $DriverDateOfBirth;
	//		}
	//		
	//		/*if($DriverLicenseDate != ""){
	//			$InsuranceCustomerVehicleModel["DriverLicenseDate"] = $DriverLicenseDate;
	//		}*/
	//	
	//		
	//		$InsuranceCustomeVehicleID = "";
	//		
	//		//$this->log->logIt( array($_SESSION['Front']['storage_details']) );
	//		
	//		if( isset( $_SESSION['Front']['storage_details']['insurance_customer_vehicle_id'])
	//			&& !empty( $_SESSION['Front']['storage_details']['insurance_customer_vehicle_id']) ){
	//			
	//				// Update Insurance Customer Vehicle Information	
	//				$InsuranceCustomeVehicleID = $_SESSION['Front']['storage_details']['insurance_customer_vehicle_id'];
	//				
	//				$InsuranceCustomerVehicleModel['InsuranceCustomeVehicleID'] = $InsuranceCustomeVehicleID;
	//				
	//				//$this->log->logIt( "InsuranceCustomeVehicleID-".$InsuranceCustomeVehicleID );
	//		}
	//		
	//		$customerVehicleModel = array (
	//			"RegistrationNo" 		=>	$RegistrationNo,
	//			"Year"					=>  $Year,
	//			"Make"					=>	$Make,
	//			"MakeDesc" 				=>	$MakeDesc,
	//			"Model"					=>	$Model,
	//			"ModelDesc"				=>  $ModelDesc,
	//			"Series"				=>	$Series,
	//			"SeriesDesc"			=>	$SeriesDesc,
	//			"ServiceHistory"		=>  $ServiceHistory, //bool
	//			"PermissionToSearch"	=> 	$PermissionToSearch, //bool
	//			//"DateOfFirstRegistration"  => $DateOfFirstRegistration,
	//			"InsuranceCustomerVehicle" => $InsuranceCustomerVehicleModel,
	//			//"Vehicle"				=> 101,// int,
	//			//"VehicleDesc			=> '',// str
	//			//"Warranty"			=> "Yes",
	//			//"VINNo" 				=> "", //string
	//			//"EngineNo"			=> "", //string
	//			"MMCode" 				=> $MMCode, //string
	//			//"PreviousOwned"		=> 1, //bool
	//		);
	//		
	//		//if( trim($MMCode) != ""){
	//		//	$customerVehicleModel["MMCode"] = trim($MMCode);
	//		//}
	//		if($DateOfFirstRegistration != ""){
	//			$customerVehicleModel["DateOfFirstRegistration"] = $DateOfFirstRegistration;
	//		}
	//		
	//		$this->log->logIt( "customer_vehicle_model----------------:".json_encode($customerVehicleModel) );
	//		//
	//		//exit(0);
	//		
	//		return $customerVehicleModel;
	//		 
	//	}
	//	catch (Exception $e) {
	//		echo $e;
	//		$this->log->logIt($this->module . "-" . "customer_vehicle_model" . "-" . $e);
	//	}
	//}
	
	# @author: Vihang Joshi <mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-03-17
	# @definition: Get Vehicle Details
	public function vehicle_details(){
		$this->log->logIt($this->module . "-" . "vehicle_details");
		try{
			
			#$area_type 					= $_POST['area_type'];
			#$access_control 			= $_POST['access_control'];
			$registration_number 		= $_POST['registration_number'];
			$year_of_registration 		= $_POST['year_of_registration'];
			$car_make 					= $_POST['car_make'];
			$car_model 					= $_POST['car_model'];
			$car_series 				= $_POST['car_series'];
			$vehicle_colour 			= $_POST['vehicle_colour'];
			$vehicle_paint_type 		= $_POST['vehicle_paint_type'];
			$service_history 			= $_POST['service_history'];
			$current_mileage 			= $_POST['current_mileage'];
			$vehicle_license_issue_date = $_POST['vehicle_license_issue_date'];
			$vehicle_license_issue_type = $_POST['vehicle_license_issue_type'];
			$vehicle_finance 			= $_POST['vehicle_finance'];
			$no_claim_bonus 			= $_POST['no_claim_bonus'];
			$vehicle_use				= $_POST['vehicle_use'];			
			$driver_access_control		= $_POST['driver_access_control'];
			$driver_area_type			= $_POST['driver_area_type'];
			$vehicle_info				= $_POST['vehicle_info'];
			
			$data_array['vehicle_info'] = $vehicle_info;
			
			if ($this->util->mandatoryField($service_history)) {
				$data_array['service_history'] = $service_history;
			}
			else {
				$error_array['service_history'] = "Area type is required.";
			}
			
			if ($this->util->mandatoryField($driver_access_control)) {
				$data_array['driver_access_control'] = $driver_access_control;
			}
			else {
				$error_array['driver_access_control'] = "Driver access control required.";
			}
			
			if ($this->util->mandatoryField($driver_area_type)) {
				$data_array['driver_area_type'] = $driver_area_type;
			}
			else {
				$error_array['driver_area_type'] = "Driver area type is required.";
			}
			
			if ($this->util->mandatoryField($registration_number)) {
				$data_array['registration_number'] = $registration_number;
			}
			else {
				$error_array['registration_number'] = "Registration number is required.";
			}
			
			if ($this->util->mandatoryField($year_of_registration)) {
				$data_array['year_of_registration'] = $year_of_registration;
			}
			else {
				$error_array['year_of_registration'] = "Year of first registration is required.";
			}
			
			if ($this->util->mandatoryField($car_make)) {
				$data_array['car_make'] = $car_make;
			}
			else {
				$error_array['car_make'] = "Car make is required.";
			}
			
			if ($this->util->mandatoryField($car_model)) {
				$data_array['car_model'] = $car_model;
			}
			else {
				$error_array['car_model'] = "Car model is required.";
			}
			
			if ($this->util->mandatoryField($car_series)) {
				$data_array['car_series'] = $car_series;
			}
			else {
				$error_array['car_series'] = "Car series is required.";
			}
			
			if ($this->util->mandatoryField($vehicle_colour)) {
				$data_array['vehicle_colour'] = $vehicle_colour;
			}
			else {
				$error_array['vehicle_colour'] = "Vehicle colour is required.";
			}
			
			if ($this->util->mandatoryField($vehicle_paint_type)) {
				$data_array['vehicle_paint_type'] = $vehicle_paint_type;
			}
			else {
				$error_array['vehicle_paint_type'] = "Vehicle paint type is required.";
			}
			
			if ($this->util->mandatoryField($current_mileage)) {
				$data_array['current_mileage'] = $current_mileage;
			}
			else {
				$error_array['current_mileage'] = "Current mileage is required.";
			}
			
			if ($this->util->mandatoryField($vehicle_license_issue_date)) {
				$data_array['vehicle_license_issue_date'] = $vehicle_license_issue_date;
			}
			else {
				$error_array['vehicle_license_issue_date'] = "Vehicle license issue date is required.";
			}
			
			if ($this->util->mandatoryField($vehicle_license_issue_type)) {
				$data_array['vehicle_license_issue_type'] = $vehicle_license_issue_type;
			}
			else {
				$error_array['vehicle_license_issue_type'] = "Vehicle license issue type is required.";
			}
			
			if ($this->util->mandatoryField($vehicle_finance)) {
				$data_array['vehicle_finance'] = $vehicle_finance;
			}
			else {
				$error_array['vehicle_finance'] = "Vehicle finance is required.";
			}
			
			if ($this->util->mandatoryField($no_claim_bonus)) {
				$data_array['no_claim_bonus'] = $no_claim_bonus; 
			}
			else {
				$error_array['no_claim_bonus'] = "No claim bonus is required.";
			}
			
			if ($this->util->mandatoryField($vehicle_use)) {
				$data_array['vehicle_use'] = $vehicle_use;
			}
			else {
				$error_array['vehicle_use'] = "Vehicle use is required.";
			}
			
			/* Set the values to final array */
			if (empty($error_array)) {
				$_SESSION['Front']['vehicle_details'] = $data_array;
				$response_array['resultData']['message'] = "";
				$response_array['resultStatus'] = resultConstant::Success;
				$response_array['resultData']['formData'] = $data_array;
				///* Prepare customer model call */
				//$user_session_data = $this->service_util->get_userinfo_session();//$this->get_userinfo_session();
				//
				//$PhysicalAddress = array(
				//	   'AddressLine1'	=> $user_session_data['AddressLine1'],
				//	   'AddressLine2'	=> $user_session_data['AddressLine2'],
				//	   'AddressLine3'	=> $user_session_data['AddressLine3'],
				//	   'PostCode'		=> $user_session_data['PostCode'],
				//	   'PostCodeDesc'	=> ''
				//   );
				// 
				// $PostalAddress = array(
				//		'AddressLine1'	=> $user_session_data['AddressLine1'],
				//		'AddressLine2'	=> $user_session_data['AddressLine2'],
				//		'AddressLine3'	=> $user_session_data['AddressLine3'],
				//		'PostCode'		=> $user_session_data['PostCode'],
				//		'PostCodeDesc'	=> ''
				//	);
				// 
				// $InsuranceCustomerModel  = array(
				//		//'InsuranceCustomerId' 	=> 1,
				//		'Gender'			=> ($user_session_data['Gender'] == 'M') ? 'Male' : 'Female',
				//		'MaritalStatus'		=> $user_session_data['MaritalStatus'],
				//		'EmploymentStatus'	=> $user_session_data['EmploymentStatus'],
				//		'LicenseDate'		=> $user_session_data['LicenseDate'],
				//		'LicenseType'		=> $user_session_data['LicenseType'],
				//		'AccessControl'		=> '',//$user_session_data['AccessControl'],//$driver_access_control,
				//		'AreaType' 			=> '',//$user_session_data['AreaType'],//$driver_area_type,
				//	);
				// 
				// $customerModel = array(
				//		//'CustomerID' 	=> 1,
				//		'Title'				=> $user_session_data['Title'],
				//		'FirstName'			=> $user_session_data['FirstName'],
				//		'SurName'			=> $user_session_data['SurName'],
				//		'IdentificationNo'	=> $user_session_data['IdentificationNo'],
				//		'PassportNo'		=> $user_session_data['PassportNo'],
				//		'BirthDate'			=> $user_session_data['BirthDate'],
				//		'Email' 			=> $user_session_data['Email'],
				//		'EmailVerified' 	=> '1',
				//		'CellphoneNo'		=> $user_session_data['CellphoneNo'],
				//		'OtherContactNo' 	=> $user_session_data['OtherContactNo'],
				//		'FaxNo'				=> $user_session_data['FaxNo'],
				//		'PhysicalAddress' 	=> $PhysicalAddress,
				//		'PostalAddress'		=> $PostalAddress,
				//		'InsuranceCustomer' => $InsuranceCustomerModel,
				//	 );
				///* End */
			}
			else {
				$response_array['resultStatus'] = resultConstant::Warning;
				$response_array['resultData']['message'] = $error_array;
				$response_array['resultData']['formData'] = array();
			}
			
			$this->log->logIt($this->module . "-" . "vehicle_details response:".json_encode($response_array));

			print_r( json_encode($response_array) );
			exit(0);	
		}
		catch (Exception $e) {
			echo $e;
			$this->log->logIt($this->module . "-" . "form_add_edit" . "-" . $e);
		}
		
	}
	
	public function get_car_details()
	{
		try{
			
			$registration_number  =  $_POST['registration_number'];
			
			$this->log->logIt("get_car_details" . "-" . $registration_number);
			
			$error_array = array();
			
			#echo $this->util->mandatoryField( $registration_number )."--";
			
			if ( !$this->util->mandatoryField( $registration_number ) ) {
				$error_array['registration_number'] = "Invalid registration number.";
			}
			
			#print_r($error_array);
			
			$vehicle_details = array();
			
			if ( empty($error_array) ) {
			
					$type = "";
					
					if ( $this->util->mandatoryField( trim($_POST['type']) ) ) {
						
						$type = trim($_POST['type']);
					}
				
					if( $type == "All"){
						
						$args = array(
							'vehicleRegistrationNo'	=> trim($_POST['registration_number']),
							'pemissionToSearch'		=> true
						);
					
					$response          	= $this->quoteservice->fn_QuoteRequestGet($args);
					
					$this->log->logIt(array($response) );
					
					if(isset( $response->faultcode )){
						$tmp_array = array();
						$tmp_array['ERR_MSG'] = $response->faultstring;
						$vehicle_details['resultStatus']  = resultConstant::Warning;
						$vehicle_details['resultData']  = $tmp_array;
					}	
					else{
						$tmp_array = array();
						$reg_date = $response->QuoteRequestGetResult->DateOfFirstRegistration;
						$year = explode("-",$reg_date)[0];
						$tmp_array['SUCC_FLAG'] 	            = 1;
						$tmp_array['Make']                   = $response->QuoteRequestGetResult->Make;
						$tmp_array['Model']                  = $response->QuoteRequestGetResult->Model;
						$tmp_array['Series']                 = $response->QuoteRequestGetResult->Series;
						$tmp_array['VINNo']                  = $response->QuoteRequestGetResult->VINNo;
						$tmp_array['VehicleRegistrationNo']  = $response->QuoteRequestGetResult->VehicleRegistrationNo;
						$tmp_array['EngineNo']               = $response->QuoteRequestGetResult->EngineNo;
						$tmp_array['DateOfFirstRegistration']= $response->QuoteRequestGetResult->DateOfFirstRegistration;
						$tmp_array['MMCode']                 = $response->QuoteRequestGetResult->MMCode;
						//$tmp_array['Year']                   = $response->QuoteRequestGetResult->Year;
						$tmp_array['Year']                   = $year;
						
						//$year = '0';
						//if($tmp_array['DateOfFirstRegistration'] != ""){
						//	
						//	 $pieces = explode("-", $tmp_array['DateOfFirstRegistration']);
						//	 
						//	 $year = $pieces[0];
						//	 $tmp_array['YearLabel'] = $year;
						//	 
						//}
						//
						//$yeardata_array =  $this->commondao->get_data_service_json('VehicleYearData');
						//
						//$year_data = json_decode($yeardata_array);
						//
						//$tmp_year_array = array();
						//$tmp_year_array[0] = 0;
						//for($i=0; $i < count($year_data->value); $i++){
						//	
						//	//$tmp_year_array ["ID"] 	= $year_data->value[$i]->ID;
						//	
						//	//$tmp_year_array ["Year"] = $year_data->value[$i]->Year;
						//	
						//	$tmp_year_array[$year_data->value[$i]->Year] = $year_data->value[$i]->ID ;
						//}
						//
						//$tmp_array['Year']   = $tmp_year_array[$year];
						
						$vehicle_details['resultStatus']  = resultConstant::Success;
						$vehicle_details['resultData']  = $tmp_array;
						$vehicle_details['resultAction']  = "All";
					}
				}
				else{
					
					#$vehicle_details = $this->service_util->fetch_vehicle($registration_number);
					$vehicle_details = $this->service_util->fetch_vehicle_from_session($registration_number);
				}
				
				#$vehicle_details = $this->service_util->fetch_vehicle($registration_number);
				
				$this->log->logIt(array($vehicle_details) );
				
				echo json_encode($vehicle_details);
				
				
			}
			else{
				
				$result=new resultobject();
				
				$result->resultStatus = resultConstant::Warning;
					
				$result->resultData = "Invalid registration number";
								
				echo json_encode($result);
				
			}
			
			exit(0);
		}
		catch(Exception $e){
			
			echo $e;
		}
	}
	
	
	
	# @author: Vihang Joshi <mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-03-18
	# @definition: Get Vehicle Storage Details
	public function vehicle_storage_details(){
		
		$this->log->logIt($this->module . "-" . "vehicle_storage_details");
		$data_array = array();
		$error_array = array();
		try{
			$vehicle_parking 					= $_POST['vehicle_parking'];
			$night_address_type 				= $_POST['night_address_type'];
			$night_address 						= $_POST['night_address'];
			$street_address 					= $_POST['street_address'];
			$suburb 							= $_POST['suburb'];
			$city 								= $_POST['city'];
			$postal_code 						= $_POST['postal_code'];
			$night_address_access_control_type	= $_POST['night_address_access_control_type'];
			$night_parking_area_type 			= $_POST['night_parking_area_type'];
			$day_parking 						= $_POST['day_parking'];
			$day_address_type 					= $_POST['day_address_type'];
			$tracking_device 					= $_POST['tracking_device'];
			$motor_sarsia 					    = $_POST['motor_sarsia'];
			$tracking_device_type 				= $_POST['tracking_device_type'];
			$insure_type 						= $_POST['insure_type'];
			$correct_info 						= $_POST['correct_info'];
			$day_area_type						= $_POST['area_type'];
			$day_access_control					= $_POST['day_access_control'];
			
			/*hidden values for default setting*/
			$hail_cover                         = $_POST['hail_cover'];
			$windscreen_cover                   = $_POST['windscreen_cover'];
			$cover_type							= $_POST['cover_type'];
			$car_hire_included                  = $_POST['car_hire_included'];
			$car_hire_option					= $_POST['car_hire_option'];
			$radio_cover                        = $_POST['radio_cover'];
			$radio_cover_value                  = $_POST['radio_cover_value'];
			$canopy_included                    = $_POST['canopy_included'];
			$theft_access_include               = $_POST['theft_access_include'];
			$voluntary_excess					= $_POST['voluntary_excess'];
			$mm_code							= $_POST['mm_code'];
			$insurance_customer_vehicle_id		= $_POST['insurance_customer_vehicle_id'];
			$correct_info                       = $_POST['correct_info'];
			
			$public_liability                   = $_POST['public_liability'];
			$saver_total_loss                   = $_POST['saver_total_loss'];
			$saver_accident_cover               = $_POST['saver_accident_cover'];
			$saver_accident_option               = $_POST['saver_accident_option'];
			$saver_assist                   	= $_POST['saver_assist'];
			$third_party_liability              = $_POST['third_party_liability'];
			
			if ($this->util->mandatoryField($vehicle_parking)) {
				$data_array['vehicle_parking'] = $vehicle_parking;
			}
			else {
				$error_array['vehicle_parking'] = "Vehicle parking is required.";
			}
			
			if ($this->util->mandatoryField($night_address_type)) {
				$data_array['night_address_type'] = $night_address_type;
			}
			else {
				$error_array['night_address_type'] = "Night address type is required.";
			}
			
			if ($this->util->mandatoryField($night_address)) {
				$data_array['night_address'] = $night_address;
			}
			else {
				$error_array['night_address'] = "Night address is required.";
			}
			
			if ($this->util->mandatoryField($day_area_type)) {
				$data_array['day_area_type'] = $day_area_type;
			}
			else {
				$error_array['day_area_type'] = "Dat Area type is required.";
			}
			
			if ($this->util->mandatoryField($day_access_control)) {
				$data_array['day_access_control'] = $day_access_control;
			}
			else {
				$error_array['day_access_control'] = "Day Access control is required.";
			}
			
			
			/* If night address is different then physical address then validate the address fields */
			if($night_address == "no"){
				
				if ($this->util->mandatoryField($street_address)) {
					$data_array['street_address'] = $street_address;
				}
				else {
					$error_array['street_address'] = "Street address is required.";
				}
				
				if ($this->util->mandatoryField($suburb)) {
					$data_array['suburb'] = $suburb;
				}
				else {
					$error_array['suburb'] = "Suburb is required.";
				}
				
				if ($this->util->mandatoryField($city)) {
					$data_array['city'] = $city;
				}
				else {
					$error_array['city'] = "City is required.";
				}
				
				if ($this->util->mandatoryField($postal_code)) {
					$data_array['postal_code'] = $postal_code;
				}
				else {
					$error_array['postal_code'] = "Postal code is required.";
				}
			}
			else{
				$data_array['street_address'] = $data_array['suburb'] = $data_array['city'] = $data_array['postal_code'] = "";
			}
			
			if ($this->util->mandatoryField($night_address_access_control_type)) {
				$data_array['night_address_access_control_type'] = $night_address_access_control_type;
			}
			else {
				$error_array['night_address_access_control_type'] = "Night address access control type is required.";
			}
			
			if ($this->util->mandatoryField($night_parking_area_type)) {
				$data_array['night_parking_area_type'] = $night_parking_area_type;
			}
			else {
				$error_array['night_parking_area_type'] = "Night parking area type is required.";
			}
			
			if ($this->util->mandatoryField($day_parking)) {
				$data_array['day_parking'] = $day_parking;
			}
			else {
				$error_array['day_parking'] = "Day parking is required.";
			}
			
			if ($this->util->mandatoryField($day_address_type)) {
				$data_array['day_address_type'] = $day_address_type;
			}
			else {
				$error_array['day_address_type'] = "Day address type is required.";
			}
			
			if ($this->util->mandatoryField($tracking_device)) {
				$data_array['tracking_device'] = $tracking_device;
			}
			else {
				$error_array['tracking_device'] = "Tracking device is required.";
			}
			
			if ($this->util->mandatoryField($motor_sarsia)) {
				$data_array['motor_sarsia'] = $motor_sarsia;
			}
			else {
				$error_array['motor_sarsia'] = "Motor sarsia is required.";
			}
			
			//$this->log->logIt("-----tracking_device-----".$tracking_device);
			if ( $this->util->mandatoryField($tracking_device_type) ) {
				$data_array['tracking_device_type'] = $tracking_device_type;
			}
			
			if( $tracking_device == 0 ){
				if ( !$this->util->mandatoryField($tracking_device_type) ) {
					
					$error_array['tracking_device_type'] = "Tracking device type is required.";
				}
			}
	 
			
			if ($this->util->mandatoryField($insure_type)) {
				$data_array['insure_type'] = $insure_type;
			}
			else {
				$error_array['insure_type'] = "Insure type is required.";
			}
			
			$this->log->logIt("Validation Error:".json_encode($error_array));
			
			/* set default values to session */
			$data_array['public_liability'] = "Y";
			if ($this->util->mandatoryField($public_liability)) {
				$data_array['public_liability'] = $public_liability;
			}
			
			$data_array['saver_total_loss'] = "Y";
			if ($this->util->mandatoryField($saver_total_loss)) {
				$data_array['saver_total_loss'] = $saver_total_loss ;
			}
			
			$data_array['saver_accident_cover'] = "Y";
			if ($this->util->mandatoryField($saver_accident_cover)) {
				$data_array['saver_accident_cover'] = $saver_accident_cover ;
			}
			
			$data_array['saver_accident_option'] = "A";
			if ($this->util->mandatoryField($saver_accident_option)) {
				$data_array['saver_accident_option'] = $saver_accident_option;
			}
			
			$data_array['saver_assist'] = "Y";
			if ($this->util->mandatoryField($saver_assist)) {
				$data_array['saver_assist'] = $saver_assist;
			}
			
			$data_array['third_party_liability'] = "Y";
			if ($this->util->mandatoryField($third_party_liability)) {
				$data_array['third_party_liability'] = $third_party_liability;
			}
			
			$data_array['hail_cover'] = "Y";
			if ($this->util->mandatoryField($hail_cover)) {
				$data_array['hail_cover'] = $hail_cover;
			}
			$data_array['windscreen_cover'] = "Y";
			if ($this->util->mandatoryField($windscreen_cover)) {
				$data_array['windscreen_cover'] = $windscreen_cover;
			}
			
			$data_array['cover_type'] = "A";
			if ($this->util->mandatoryField($cover_type)) {
				$data_array['cover_type'] = $cover_type;
			}
			
			$data_array['car_hire_included'] = "Y";
			if ($this->util->mandatoryField($car_hire_included)) {
				$data_array['car_hire_included'] = $car_hire_included;
			}
			
			$data_array['car_hire_option'] = "C";
			if ( $this->util->mandatoryField($car_hire_option)) {
				$data_array['car_hire_option'] = $car_hire_option;
			}
			
			$data_array['radio_cover'] = "Y";
			if ($this->util->mandatoryField($radio_cover)) {
				$data_array['radio_cover'] = $radio_cover;
			}
			
			$data_array['radio_cover_value'] = "0";
			if ($this->util->mandatoryField($radio_cover_value)) {
				$data_array['radio_cover_value'] = $radio_cover_value;
			}
			
			$data_array['canopy_included'] = "N";
			if ($this->util->mandatoryField($canopy_included)) {
				$data_array['canopy_included'] = $canopy_included;
			}
			
			$data_array['theft_access_include'] = "N";
			if ($this->util->mandatoryField($theft_access_include)) {
				$data_array['theft_access_include'] = $theft_access_include;
			}
			
			$data_array['voluntary_excess'] = "Y";
			if ($this->util->mandatoryField($voluntary_excess)) {
				$data_array['voluntary_excess'] = $voluntary_excess;
			}
			
			$data_array['mm_code'] = $mm_code;
			
			//if ($this->util->mandatoryField($mm_code)) {
			//	$data_array['mm_code'] = $mm_code;
			//}
			
			if ( $this->util->mandatoryField($insurance_customer_vehicle_id)) {
					$data_array['insurance_customer_vehicle_id'] = $insurance_customer_vehicle_id;
			}
			
			$data_array['correct_info'] = "";
			if ( $this->util->mandatoryField($correct_info)) {
					$data_array['correct_info'] = $correct_info;
			}
			
			/* Set the values to final array */
			if (empty($error_array)) {
				
				$_SESSION['Front']['storage_details'] = $data_array;
				 
				$response_array['resultData']['message'] = "";
				
				$response_array['resultStatus'] = resultConstant::Success;
				
				$response_array['resultData']['formData'] = $data_array;
				
				if( isset( $_SESSION['Front']['customer_info_obj']  ) ){
				
					if ( $this->util->mandatoryField($insurance_customer_vehicle_id)) {
						
						$this->service_util->update_customer_vehicle($insurance_customer_vehicle_id);
						
						$response_array['resultData']['message'] = "Vehicle Updated";
						
						$this->log->logIt($this->module . "-" . "vehicle_storage_details:CustomerVehicle Updated:".$insurance_customer_vehicle_id);
						
					}
					else{
						$this->log->logIt($this->module . "-" . "vehicle_storage_details:Add New Customer Vehicle");
						
						$customerVehicleModel = $this->service_util->customer_vehicle_model();
					
						if( array_key_exists('token',$_SESSION) ){
							$this->customerservices->token  = $_SESSION['token'];
						}
						else{
							$this->customerservices->token = NULL;
						}
						
						$CustomerID = $_SESSION['Front']['customer_info_obj']->CustomerID;
						
						$result = $this->customerservices->fn_CustomerVehicleAdd($customerVehicleModel, $CustomerID);
						
						$this->log->logIt( "Add New Vehicle Result:".json_encode($result) );
					
						if(isset( $result->faultstring )){
							$response_array['resultData']['message'] = $result->faultstring;
							
							$vehicle_details['resultStatus']  		 = resultConstant::Warning;
							
							$vehicle_details['resultData']  = $result;
						}
						else{
						
							$response_array['resultData']['message'] = "Vehicle Added";
							
							$response_array['resultData']['vehicle_data'] = $result;
							
							$_SESSION['Front']['guest_vehicle'] = $result->CustomerVehicleAddResult;
							
							// on add inject customer vehicle list to the customer info object
							// new registered guest without having any vehicle.: length = 0
							// =============================
							// [CustomerVehicleList] => stdClass Object
							// (
							// )
							//customer have only one vehicle : length = 1
							//=============================
							//[CustomerVehicleList] => stdClass Object
							//(
							//	[CustomerVehicleModel] => stdClass Object
							//		(
							//			[CustomerOfferList] => stdClass Object
							//				(
							//				)
							//
							//			[CustomerVehicleID] => 583
							//
							//customer have more that one vehicle : length > 1
							//============================= 
							//[CustomerVehicleList] => stdClass Object
							//(
							//	[CustomerVehicleModel] => Array
							//		(
							//			[0] => stdClass Object
							//				(
							//					[CustomerOfferList] => stdClass Object
							//						(
							//						)
	
							if( isset($_SESSION['Front']['customer_info_obj']->CustomerVehicleList->CustomerVehicleModel) ){
								if( count($_SESSION['Front']['customer_info_obj']->CustomerVehicleList->CustomerVehicleModel) == 0){
									$object = new stdClass();
									$object->CustomerVehicleList->CustomerVehicleModel = $result->CustomerVehicleAddResult;
									$_SESSION['Front']['customer_info_obj'] = $object;
								}
								elseif( count($_SESSION['Front']['customer_info_obj']->CustomerVehicleList->CustomerVehicleModel) == 1 ){
									$tmp_array = array();
									$tmp_array[0] = $_SESSION['Front']['customer_info_obj']->CustomerVehicleList->CustomerVehicleModel;
									$tmp_array[1] = $result->CustomerVehicleAddResult;
									$_SESSION['Front']['customer_info_obj']->CustomerVehicleList->CustomerVehicleModel = $tmp_array;
								}
								elseif( count($_SESSION['Front']['customer_info_obj']->CustomerVehicleList->CustomerVehicleModel) > 1 ){
									$tmp_array = $_SESSION['Front']['customer_info_obj']->CustomerVehicleList->CustomerVehicleModel;
									array_push($tmp_array,$result->CustomerVehicleAddResult);
									$_SESSION['Front']['customer_info_obj']->CustomerVehicleList->CustomerVehicleModel = $tmp_array;
									
								}
							}
							else{
								$object = new stdClass();
								$object->CustomerVehicleList = new stdClass();
								$object->CustomerVehicleList->CustomerVehicleModel = $result->CustomerVehicleAddResult;
								$_SESSION['Front']['customer_info_obj'] = $object;
							}
						
						}
						
					}
				}
				else{
					
					$response_array['resultStatus'] = resultConstant::Success;
					$response_array['resultData']['is_guest'] = true;
					
				}
			}
			else {
				$response_array['resultStatus'] = resultConstant::Warning;
				$response_array['resultData']['message'] = $error_array;
				$response_array['resultData']['formData'] = array();
			}
			
			$this->log->logIt($this->module . "-" . "vehicle_storage_details" . ":resonse". json_encode($response_array));
			print_r( json_encode($response_array) );
			exit(0);	
		}
		catch (Exception $e) {
			echo $e;
			$this->log->logIt($this->module . "-" . "vehicle_storage_details" . "-" . $e);
		}
		
	}
	
	public function get_vehicle_data(){
		
		try {
			$response_array = array();
			$url = "";
			
			if( isset($_REQUEST['ty']) && isset($_REQUEST['yr'])){
				
				if( $_REQUEST['ty'] == "make" &&  $_REQUEST['ty'] != "" ){
					$year = $_REQUEST['yr'];
					$url = '/ProductCatelog/VehicleDataService.svc/GetVehicleMake?vehicleYear='.$year.'&$orderby=Name&$format=json';
				}
				elseif( $_REQUEST['ty'] == "model" && isset($_REQUEST['yr']) && isset($_REQUEST['mk'])  ){
					
					if( $_REQUEST['yr'] != "" && $_REQUEST['mk'] != ""){
						$year = $_REQUEST['yr'];
						$make = $_REQUEST['mk'];
						$url='/ProductCatelog/VehicleDataService.svc/GetVehicleModel?vehicleYear='+$year+'&vehicleMake='.$make.'&$orderby=Name&$format=json';
					}
					
					#echo "model";
				}
				elseif( $_REQUEST['ty'] == "series" && isset($_REQUEST['yr']) && isset($_REQUEST['mk']) && isset($_REQUEST['mo']) ){
					echo "series";
					if( $_REQUEST['yr'] != "" && $_REQUEST['mk'] != "" &&  $_REQUEST['mo'] != ""){
						$year = $_REQUEST['yr'];
						$make = $_REQUEST['mk'];
						$model = $_REQUEST['mo'];
						$url = '/ProductCatelog/VehicleDataService.svc/GetVehicleSeries?vehicleYear='.$year.'&vehicleMake='.$make.'&vehicleModel='.$model.'&$orderby=Name&$format=json&$callback=?';
					}
				}
				
				if( $url != "" ){
					
					$json_data = exec("php /var/www/vhosts/maven.me/motorhappy.maven.me/test_call.php $url");
			
					echo $json_data;
					
				}
					
			}
			print_r( json_encode($response_array) );
			
			exit(0);
		}
		catch (Exception $e) {
			echo $e;
			$this->log->logIt($this->module . "-" . "form_add_edit" . "-" . $e);
		}
	}
	
	
	
	//public function set_customer_vehiclemodel(){
	//	try {
	//		$response_array = array();
	//		$RegistrationNo 	= $_SESSION['Front']['vehicle_details']['registration_number'];
	//		$Year 				= $_SESSION['Front']['vehicle_details']['year_of_registration'];
	//		$Make 				= $_SESSION['Front']['vehicle_details']['car_make'];
	//		$MakeDesc 			= $_SESSION['Front']['vehicle_details']['car_make'];
	//		$Model 				= $_SESSION['Front']['vehicle_details']['car_model'];
	//		$ModelDesc 			= $_SESSION['Front']['vehicle_details']['car_model'];
	//		$Series 			= $_SESSION['Front']['vehicle_details']['car_series'];
	//		$SeriesDesc 		= $_SESSION['Front']['vehicle_details']['car_series'];
	//		$ServiceHistory 	= 0;
	//		
	//		if( isset( $_SESSION['Front']['vehicle_details']['service_history']) ){
	//			$ServiceHistory = $_SESSION['Front']['vehicle_details']['service_history'];
	//		}
	//		
	//		$DateOfFirstRegistration = $_SESSION['Front']['vehicle_details']['vehicle_license_issue_date'];
	//		
	//		/*InsuranceCustomerVehicle Model data*/
	//		$VehicleFinanced = false;
	//		if( isset( $_SESSION['Front']['vehicle_details']['vehicle_finance']) ){				
	//			$VehicleFinanced = $_SESSION['Front']['vehicle_details']['vehicle_finance'];
	//		}
	//		
	//		//$no_claim_bonus = "No";
	//		if( isset( $_SESSION['Front']['vehicle_details']['no_claim_bonus']) ){
	//			$no_claim_bonus = $_SESSION['Front']['vehicle_details']['no_claim_bonus'];
	//			/*if( $_SESSION['Front']['vehicle_details']['no_claim_bonus'] == "Yes"){
	//				$no_claim_bonus = "Yes";
	//			}*/
	//		}
	//		
	//		$VehicleUse = $_SESSION['Front']['vehicle_details']['vehicle_use'];
	//		$OvernightParking = $_SESSION['Front']['storage_details']['vehicle_parking'];
	//		$NightAddressType = $_SESSION['Front']['storage_details']['night_address_type'];
	//		$DayParking =  $_SESSION['Front']['storage_details']['vehicle_parking] '];
	//		$DayAddressType = $_SESSION['Front']['storage_details']['day_address_type'];
	//		$PermissionToSearch = "true";
	//		
	//		$TrackingDeviceInstalled = "N";
	//		if( isset( $_SESSION['Front']['storage_details']['tracking_device']) ){
	//			if( $_SESSION['Front']['storage_details']['tracking_device'] == "0"){
	//				$TrackingDeviceInstalled = "Y";
	//			}
	//		}
	//		
	//		$TrackerDeviceType = "";
	//		if( isset( $_SESSION['Front']['storage_details']['tracking_device_type']) ){
	//				$TrackerDeviceType = $_SESSION['Front']['storage_details']['tracking_device_type'];
	//		}
	//		
	//		$InsuredOption = "";
	//		if( isset( $_SESSION['Front']['storage_details']['insure_option']) ){
	//				$InsuredOption = $_SESSION['Front']['storage_details']['insure_option'];
	//		}
	//		
	//		//$NightParkingSame = "N";
	//		if( isset( $_SESSION['Front']['storage_details']['night_address']) ){
	//			$NightParkingSame = $_SESSION['Front']['storage_details']['night_address'];
	//			/*if( $_SESSION['Front']['storage_details']['night_address'] == "yes"){
	//				$NightParkingSame = "Y";
	//			}*/
	//		}
	//		
	//		$NightPostalCode  = "";
	//		if( isset( $_SESSION['Front']['storage_details']['postal_code']) ){
	//				$NightPostalCode = $_SESSION['Front']['storage_details']['postal_code'];
	//		}
	//		
	//		$NightSuburbName  = "";
	//		if( isset( $_SESSION['Front']['storage_details']['suburb']) ){
	//				$NightSuburbName = $_SESSION['Front']['storage_details']['suburb'];
	//		}
	//					
	//		$NightAreaType  = "";
	//		if( isset( $_SESSION['Front']['storage_details']['night_parking_area_type']) ){
	//				$NightAreaType = $_SESSION['Front']['storage_details']['night_parking_area_type'];
	//		}
	//		
	//		$NightAccessControl = "";
	//		if( isset( $_SESSION['Front']['storage_details']['night_address_access_control_type']) ){
	//				$NightAccessControl = $_SESSION['Front']['storage_details']['night_address_access_control_type'];
	//		}
	//		
	//		$VehicleColour = "";
	//		if( isset( $_SESSION['Front']['vehicle_details']['vehicle_colour']) ){
	//				$VehicleColour = $_SESSION['Front']['vehicle_details']['vehicle_colour'];
	//		}
	//		
	//		$VehiclePaintType = "";
	//		if( isset( $_SESSION['Front']['vehicle_details']['vehicle_paint_type']) ){
	//				$VehiclePaintType = $_SESSION['Front']['vehicle_details']['vehicle_paint_type'];
	//		}
	//		
	//		$DriverDateOfBirth = "";
	//		if( isset( $_SESSION['Front']['personal_details']['driver_dob']) ){
	//				$DriverDateOfBirth = $_SESSION['Front']['personal_details']['driver_dob'];
	//		}
	//		
	//		$DriverGender = "";
	//		if( isset( $_SESSION['Front']['personal_details']['person_gender']) ){
	//				$DriverGender = $_SESSION['Front']['personal_details']['person_gender'];
	//		}
	//		
	//		$DriverMaritalStatus = "";
	//		if( isset( $_SESSION['Front']['personal_details']['driver_marital_status']) ){
	//				$DriverMaritalStatus = $_SESSION['Front']['personal_details']['driver_marital_status'];
	//		}
	//		
	//		$DriverEmploymentStatus = "";
	//		if( isset( $_SESSION['Front']['personal_details']['driver_employment_status']) ){
	//				$DriverEmploymentStatus = $_SESSION['Front']['personal_details']['driver_employment_status'];
	//		}
	//		
	//		$DriverLicenseType = "";
	//		if( isset( $_SESSION['Front']['vehicle_details']['vehicle_license_issue_type']) ){
	//				$DriverLicenseType = $_SESSION['Front']['vehicle_details']['vehicle_license_issue_type'];
	//		}
	//		
	//		$DriverPostalCode = "";
	//		if( isset( $_SESSION['Front']['personal_details']['driver_postal_code']) ){
	//				$DriverPostalCode = $_SESSION['Front']['personal_details']['driver_postal_code'];
	//		}
	//		
	//		$DriverSuburbName = "";
	//		if( isset( $_SESSION['Front']['personal_details']['driver_suburb']) ){
	//				$DriverSuburbName = $_SESSION['Front']['personal_details']['driver_suburb'];
	//		}
	//		
	//		$DriverAccessControl = "No";
	//		if( isset( $_SESSION['Front']['vehicle_details']['access_control']) ){
	//			if( $_SESSION['Front']['vehicle_details']['access_control'] == "yes"){
	//					$DriverAccessControl = "Yes";
	//			}
	//		}
	//		
	//		$DriverAreaType = "";
	//		if( isset( $_SESSION['Front']['vehicle_details']['area_type']) ){
	//				$DriverAreaType = $_SESSION['Front']['vehicle_details']['area_type'];
	//		}
	//		
	//		$CurrentMileage ="";
	//		if( isset( $_SESSION['Front']['vehicle_details']['current_mileage']) ){
	//				$CurrentMileage = $_SESSION['Front']['vehicle_details']['current_mileage'];
	//		}
	//		
	//		$InsuranceCustomerVehicleModel = array (
	//			//"VehicleKey" 			=> "", // String
	//			//"VehicleDescription" 	=> "", // String
	//			"VehicleFinanced" 		=> $VehicleFinanced,
	//			"NCB" 					=> $no_claim_bonus, // dropdown string
	//			//"CoverType" 			=> "", // String
	//			"VehicleUse" 			=> $VehicleUse, // String
	//			//HailCover"			=> "Yes", //YesNoIndicator
	//			//"RadioCover"			=> "Yes", //YesNoIndicator
	//			//"RadioCoverValue"		=> 1, //int
	//			"OvernightParking"		=> $OvernightParking, //string
	//			"NightAddressType"		=> $NightAddressType, //AddressType
	//			"DayParking"			=> $DayParking, //string
	//			"DayAddressType"		=> $DayAddressType, //AddressType
	//			"TrackingDeviceInstalled"=> $TrackingDeviceInstalled, //YesNoIndicator
	//			"TrackerDeviceType"		=>	$TrackerDeviceType, //string
	//			//"WindscreenCover"		=>	"Yes", //YesNoIndicator
	//			//"CarHireIncluded"		=>	"Yes",//YesNoIndicator
	//			//"CarHireOption"			=>  "", //string
	//			//"CanopyCoverIncluded"	=>	"Yes", //YesNoIndicator
	//			"InsuredOption"			=>	$InsuredOption,//string
	//			"NightParkingSame"		=>  $NightParkingSame,//YesNoIndicator
	//			"NightPostalCode"		=>  $NightPostalCode, //sting
	//			"NightSuburbName"		=>  $NightSuburbName,//string
	//			"NightAreaType"			=>  $NightAreaType, //string
	//			"NightAccessControl"	=>  $NightAccessControl, //string
	//			//"DayParkingSame"		=>  "Yes", //YesNoIndicator
	//			//"DaySuburbName"			=>  "", //string
	//			//"DayAreaType"			=>  "", //string
	//			//"DayAccessControl"			=>  "", //string
	//			//"VoluntaryExcess"				=>  "", //string
	//			//"IncludeTheftExcessBuster"		=>  "Yes", //YesNoIndicator
	//			//"IncludeTheftExcessBuster"		=>  "Yes", //YesNoIndicator
	//			//"SaverThirdPartyLiability"		=>  "Yes", //YesNoIndicator
	//			//"SaverAccidentCover"			=>  "Yes", //YesNoIndicator
	//			//"SaverAccidentOption"			=>  "", //string
	//			//"SaverTotalLoss"				=>  "Yes", //YesNoIndicator
	//			//"SaverAssist"					=>  "Yes", //YesNoIndicator
	//			//"PublicLiability"				=>  "Yes", //YesNoIndicator
	//			"VehicleColour"					=>  $VehicleColour, //string
	//			"VehiclePaintType"				=>  $VehiclePaintType, //string
	//			"DriverDateOfBirth"  			=>  $DriverDateOfBirth,
	//			"DriverGender"					=>  $DriverGender, //string
	//			"DriverMaritalStatus"			=>  $DriverMaritalStatus, //string
	//			"DriverEmploymentStatus"		=>  $DriverEmploymentStatus, //string
	//			"DriverLicenseType"				=>  $DriverLicenseType, //string
	//			"DriverPostalCode"				=>  $DriverPostalCode, //string
	//			"DriverSuburbName"				=>  $DriverSuburbName, //string
	//			"DriverAccessControl"			=>  $DriverAccessControl, //string
	//			"DriverAreaType"				=>  $DriverAreaType, //string
	//			"CurrentMileage"				=>  $CurrentMileage, //int				
	//		);
	//		
	//		$customerVehicleModel = array (
	//			"RegistrationNo" 		=>	$RegistrationNo,
	//			"Year"					=>  $Year,
	//			"Make"					=>	$Make,
	//			"MakeDesc" 				=>	$MakeDesc,
	//			"Model"					=>	$Model,
	//			"ModelDesc"				=>  $ModelDesc,
	//			"Series"				=>	$Series,
	//			"SeriesDesc"			=>	$SeriesDesc,
	//			"ServiceHistory"		=>  $ServiceHistory, //bool
	//			"PermissionToSearch"	=> 	1,//bool
	//			"DateOfFirstRegistration"  => $DateOfFirstRegistration,
	//			"InsuranceCustomerVehicle" => $InsuranceCustomerVehicleModel,
	//			//"Vehicle"					=> 101,// int,
	//			//"VehicleDesc				=> '',// str
	//			//"Warranty"				=> "Yes",
	//			//"VINNo" 					=> "", //string
	//			//"EngineNo"				=> "", //string
	//			//"MMCode" 					=> "", //string
	//			//"PreviousOwned"			=> 1, //bool
	//		);
	//		
	//		print_r($customerVehicleModel);
	//			
	//		return $customerVehicleModel;
	//	}
	//	catch (Exception $e) {
	//		echo $e;
	//		$this->log->logIt($this->module . "-" . "form_add_edit" . "-" . $e);
	//	}
	//}
	
	
	
}
<?php
require_once(BASE_PATH."/Conf/service_conf.php");
require_once(BASE_PATH."/Util/logger.php");
require_once(BASE_PATH."/Util/Services/customerservices.php");
require_once(BASE_PATH."/Dbaccess/commondao.php");

class service_util{
	private $module = 'service_util';
	function service_util(){
        $this->log = new logger();
		$this->customerservices = new customerservices();
		$this->commondao = new commondao();
    }
    
	/*
	 * Updated On 			: 2016-03-29 11:30 AM
	 * Updated By 			: VJ
	 * Updated Description : Added extra code that checks if the key is not exists in customer_info_obj session then assign
	 * 						 the missing key and value from the local session.
	 */
    function get_userinfo_session(){
		try {
			$this->log->logIt( "---------------get_userinfo_session" );
			$user_info = array ();
			if( isset($_SESSION['Front']['customer_info_obj']) && $_SESSION['Front']['customer_info_obj'] != "" ){
				
				$this->log->logIt(json_encode($_SESSION['Front']['customer_info_obj']));
				$user_info["CustomerID"] 		= $_SESSION['Front']['customer_info_obj']->CustomerID;
				$user_info["Title"] 			= $_SESSION['Front']['customer_info_obj']->Title;
				$user_info["FirstName"] 		= $_SESSION['Front']['customer_info_obj']->FirstName;
				$user_info["SurName"] 			= $_SESSION['Front']['customer_info_obj']->SurName;
				$user_info["IdentificationNo"] 	= $_SESSION['Front']['customer_info_obj']->IdentificationNo;
				$user_info["PassportNo"] 		= $_SESSION['Front']['customer_info_obj']->PassportNo;
				
				//date only
				$birthdate_time				= $_SESSION['Front']['customer_info_obj']->BirthDate;
				$date_array					= explode("T",$birthdate_time);
				$birth_date 				= $date_array[0];
				$user_info["BirthDate"]  	= $birth_date;
				$user_info["CellphoneNo"] 	= $_SESSION['Front']['customer_info_obj']->CellphoneNo;
				
				// Insurance customer details
				if(array_key_exists('InsuranceCustomer',$_SESSION['Front']['customer_info_obj'])){
					$user_info["EmploymentStatus"]  = $_SESSION['Front']['customer_info_obj']->InsuranceCustomer->EmploymentStatus;
					$user_info["MaritalStatus"] 	= $_SESSION['Front']['customer_info_obj']->InsuranceCustomer->MaritalStatus;
					$licensedate_time 			= $_SESSION['Front']['customer_info_obj']->InsuranceCustomer->LicenseDate;
					$license_array				= explode("T",$licensedate_time);
					$license_date 				= $license_array[0];
					$user_info["LicenseDate"]  	= $license_date;
					$user_info["LicenseType"]  	= $_SESSION['Front']['customer_info_obj']->InsuranceCustomer->LicenseType;
				}
				
				if(!array_key_exists('ContactNo',$_SESSION['Front']['customer_info_obj'])){
					if(!empty($_SESSION['Front']['customer_info_obj']->OtherContactNo)){
						$user_info["ContactNo"] = $_SESSION['Front']['customer_info_obj']->OtherContactNo;	
					}
					else{
						if( isset($_SESSION['Front']['personal_details']['telephone']) ){
							$user_info["ContactNo"] = $_SESSION['Front']['personal_details']['telephone'];
						}
					}
				}
				
				$user_info["Email"] 		= $_SESSION['Front']['customer_info_obj']->Email;
				$user_info["EmailVerified"] = $_SESSION['Front']['customer_info_obj']->EmailVerified;
				$user_info["FaxNo"] 		= $_SESSION['Front']['customer_info_obj']->FaxNo;
				$user_info["OtherContactNo"] = $_SESSION['Front']['customer_info_obj']->OtherContactNo;
				$user_info["AddressLine1"] 	= $_SESSION['Front']['customer_info_obj']->PhysicalAddress->AddressLine1;
				$user_info["AddressLine2"] 	= $_SESSION['Front']['customer_info_obj']->PhysicalAddress->AddressLine2;
				$user_info["AddressLine3"] 	= $_SESSION['Front']['customer_info_obj']->PhysicalAddress->AddressLine3;
				$user_info["PostCodeId"]	= $_SESSION['Front']['customer_info_obj']->PhysicalAddress->PostCode;
				
				$post_code_desc = $_SESSION['Front']['customer_info_obj']->PhysicalAddress->PostCodeDesc;
				if( $post_code_desc != "" ){
					$address_array = explode(',', $post_code_desc);
					$user_info["PostCode"] 	= $address_array[0];
					$user_info["Suburb"] 	= $address_array[2];
					$user_info["City"] 		= $address_array[3];
				}
				
				$user_info["PostCodeDesc"] = $_SESSION['Front']['customer_info_obj']->PhysicalAddress->PostCodeDesc;
				
				if( array_key_exists('Front',$_SESSION) ){
					
					if( array_key_exists('personal_details',$_SESSION['Front']) ){
						
						if(empty($_SESSION['Front']['customer_info_obj']->PhysicalAddress->AddressLine1)){
							$user_info["AddressLine1"] = $_SESSION['Front']['personal_details']['person_street_address'];
						}
						
						if(empty($_SESSION['Front']['customer_info_obj']->PhysicalAddress->AddressLine2)){
							$user_info["AddressLine2"] = $_SESSION['Front']['personal_details']['person_street_address2'];
						}
						
						if(empty($_SESSION['Front']['customer_info_obj']->PhysicalAddress->AddressLine2)){
							$user_info["AddressLine3"] = $_SESSION['Front']['personal_details']['person_street_address3'];
						}
						
						$user_info["Gender"] = $_SESSION['Front']['personal_details']['person_gender'];
						//if(!array_key_exists('Gender',$_SESSION['Front']['customer_info_obj']->InsuranceCustomer)){
						//	$user_info["Gender"] = $_SESSION['Front']['personal_details']['person_gender'];
						//}
						//else if(empty($_SESSION['Front']['customer_info_obj']->InsuranceCustomer->Gender)){
						//	$user_info["Gender"] = $_SESSION['Front']['personal_details']['person_gender'];
						//}
						
						$user_info["EmploymentStatus"] = $_SESSION['Front']['personal_details']['person_employment_status'];
						//if(!array_key_exists('EmploymentStatus',$_SESSION['Front']['customer_info_obj']->InsuranceCustomer)){
						//	$user_info["EmploymentStatus"] = $_SESSION['Front']['personal_details']['person_employment_status'];
						//}
						//else if(empty($_SESSION['Front']['customer_info_obj']->InsuranceCustomer->EmploymentStatus)){
						//	
						//	$user_info["EmploymentStatus"] = $_SESSION['Front']['personal_details']['person_employment_status'];
						//}
						
						$user_info["MaritalStatus"] = $_SESSION['Front']['personal_details']['person_marital_status'];
						//if(!array_key_exists('MaritalStatus',$_SESSION['Front']['customer_info_obj']->InsuranceCustomer)){
						//	$user_info["MaritalStatus"] = $_SESSION['Front']['personal_details']['person_marital_status'];
						//}
						//else if(empty($_SESSION['Front']['customer_info_obj']->InsuranceCustomer->MaritalStatus)){
						//	
						//	$user_info["MaritalStatus"] = $_SESSION['Front']['personal_details']['person_marital_status'];
						//}
					}
				}
				
				
				
				
			}
			
			return $user_info;
		}
		catch (Exception $e) {
			echo $e;
			$this->log->logIt($this->module . "-" . "get_userinfo_session" . "-" . $e);
		}
		
	}
	
	/*Get Customer Data from iscript and update in to the session.*/
	function refresh_customer_data(){
		
		try{
			
			$this->log->logIt("refresh_customer_data");
			
			$data_result = "";
			
			if( array_key_exists('token',$_SESSION) ){
				
				if( $_SESSION['token'] != "" ){
					
					$this->customerservices->token = $_SESSION['token'];
					
					$result = $this->customerservices->fn_CustomerDataGet();
					
					$_SESSION['Front']['customer_info_obj']  = $result->CustomerDataGetResult;
					
					$_SESSION['Front']['user'] = $result->CustomerDataGetResult->FirstName;
					
					$_SESSION['Front']['isGuest'] = 0;
					
					$data_result = $result->CustomerDataGetResult;
					
					/*Setup session for wp site*/
					$_SESSION['CustomerID'] = $_SESSION['Front']['customer_info_obj']->CustomerID;
					$_SESSION['CustomerNAME'] = $_SESSION['Front']['customer_info_obj']->FirstName." ".$_SESSION['Front']['customer_info_obj']->FirstName;
					$_SESSION['CustomerFname'] = $_SESSION['Front']['customer_info_obj']->FirstName;
					$_SESSION['CustomerLname'] = $_SESSION['Front']['customer_info_obj']->SurName;
					$_SESSION['CustomerEMAIL'] = $_SESSION['Front']['customer_info_obj']->Email;
					$_SESSION['CustomerContactNo'] = $_SESSION['Front']['customer_info_obj']->CellphoneNo;
					$_SESSION['CustomerActionId'] = '587';
					
					
				}
				
			}
			elseif( array_key_exists('Front',$_SESSION) ){
			$this->log->logIt("CustomerCreateResult");	
				if( array_key_exists('CustomerCreateResult',$_SESSION['Front']) ){
					$this->log->logIt("CustomerCreateResult:Found");
					$data_result = $_SESSION['Front']['CustomerCreateResult'];
					if( !isset($_SESSION['Front']['customer_info_obj']) ){
						$_SESSION['Front']['customer_info_obj']  = $_SESSION['Front']['CustomerCreateResult'];
						
						/*Setup session for wp site*/
						$_SESSION['CustomerID'] = $_SESSION['Front']['customer_info_obj']->CustomerID;
						$_SESSION['CustomerNAME'] = $_SESSION['Front']['customer_info_obj']->FirstName." ".$_SESSION['Front']['customer_info_obj']->FirstName;
						$_SESSION['CustomerFname'] = $_SESSION['Front']['customer_info_obj']->FirstName;
						$_SESSION['CustomerLname'] = $_SESSION['Front']['customer_info_obj']->SurName;
						$_SESSION['CustomerEMAIL'] = $_SESSION['Front']['customer_info_obj']->Email;
						$_SESSION['CustomerContactNo'] = $_SESSION['Front']['customer_info_obj']->CellphoneNo;
						$_SESSION['CustomerActionId'] = '587';
						// for guest user login is not require 
						//$_SESSION['Front']['user'] = $_SESSION['Front']['CustomerCreateResult']->FirstName." ".$_SESSION['Front']['CustomerCreateResult']->SurName;
					}
				}
				
			}
			
			$this->log->logIt("refresh_customer_data:".json_encode($data_result));
			return $data_result;
		
		}
		catch (Exception $e) {
			echo $e;
			$this->log->logIt("refresh_customer_data" . "-" . $e);
		}
	
	}
	
	function update_customer_vehicle( $vehicle_id = '' ){
		
		try{
			
			$this->log->logIt("update_customer_vehicle" . "-" . $vehicle_id);
			
			$customer_model 	= $this->refresh_customer_data();
			
			$vehicle_list 		= $customer_model->CustomerVehicleList->CustomerVehicleModel;
			
			$vehicle_data = array();
			
			if( count($vehicle_list)  == 1){
				
				$vehicle_data[0] = $vehicle_list;
				
			}
			else if( count($vehicle_list) > 1){
				
				$vehicle_data	= $vehicle_list;
			}
						
			for( $vehicle = 0; $vehicle < count($vehicle_data); $vehicle++ ){
				
				$this->log->logIt("vehicle" . "-" . $vehicle_data[$vehicle]->InsuranceCustomerVehicle->InsuranceCustomeVehicleID."===".$vehicle_id);
				
				if( $vehicle_data[$vehicle]->InsuranceCustomerVehicle->InsuranceCustomeVehicleID ==  $vehicle_id ){
					
					//Important : rebuild data from FRONT Input data session.
					/*$vehicle_data[$vehicle]->Year = 23;
					$vehicle_data[$vehicle]->DateOfFirstRegistration = "2012-02-01";
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->DriverLicenseDate = "2008-02-01";*/
					
					$driver_birth_date 		= date('Y-m-d',strtotime($_SESSION['Front']['personal_details']['driver_dob']));
					$driver_licence_date 	= date('Y-m-d',strtotime($_SESSION['Front']['vehicle_details']['vehicle_license_issue_date']));
					$service_history = 0;
					if( $_SESSION['Front']['vehicle_details']['service_history'] == "true"){
						$service_history = 1;
					}
					
					$driver_licence_type = $_SESSION['Front']['vehicle_details']['vehicle_license_issue_type'];
					
					$vehicle_data[$vehicle]->MMCode         =$_SESSION['Front']['storage_details']['mm_code'];
					$vehicle_data[$vehicle]->Make           =$_SESSION['Front']['vehicle_details']['car_make'];
				    $vehicle_data[$vehicle]->Model          =$_SESSION['Front']['vehicle_details']['car_model'];
					$vehicle_data[$vehicle]->RegistrationNo =$_SESSION['Front']['vehicle_details']['registration_number'];
					$vehicle_data[$vehicle]->Series         =$_SESSION['Front']['vehicle_details']['car_series'];
					$vehicle_data[$vehicle]->ServiceHistory =$service_history;
					$vehicle_data[$vehicle]->Year           =$_SESSION['Front']['vehicle_details']['year_of_registration'];
					
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->OvernightParking       =$_SESSION['Front']['storage_details']['vehicle_parking'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->NightAccessControl     =$_SESSION['Front']['storage_details']['night_address_access_control_type'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->NightAreaType          =$_SESSION['Front']['storage_details']['night_parking_area_type'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->DayAccessControl       =$_SESSION['Front']['storage_details']['day_access_control'];
					
					$tracking_device_installed = "N";
					$tracking_device_type = "";
					if( $_SESSION['Front']['storage_details']['tracking_device'] == "0"){
						$tracking_device_installed = "Y";
						$tracking_device_type = $_SESSION['Front']['storage_details']['tracking_device_type'];
					}
					
					$insure_type = "";
					if( $_SESSION['Front']['storage_details']['insure_type'] != ""){
						$insure_type = $_SESSION['Front']['storage_details']['insure_type'];
					}
					
					$VehicleFinanced = boolval(0);
					$this->log->logIt("VehicleFinanced" . "------1----".$VehicleFinanced);
					if($_SESSION['Front']['vehicle_details']['vehicle_finance'] == "true"){
						$VehicleFinanced = 1;		
					}
					else{
						$VehicleFinanced = 0;	
					}
					
					
					$this->log->logIt("VehicleFinanced" . "------2---".$VehicleFinanced);
					
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->TrackingDeviceInstalled  = $tracking_device_installed;
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->TrackerDeviceType  		= $tracking_device_type;
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->InsuredOption  			= $insure_type;
					
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->VehicleColour             =$_SESSION['Front']['vehicle_details']['vehicle_colour'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->VehicleFinanced           =$VehicleFinanced;
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->VehiclePaintType          =$_SESSION['Front']['vehicle_details']['vehicle_paint_type'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->VehicleUse                =$_SESSION['Front']['vehicle_details']['vehicle_use'];
					
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->CurrentMileage            =$_SESSION['Front']['vehicle_details']['current_mileage'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->DayAddressType            =$_SESSION['Front']['storage_details']['day_address_type'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->DayAreaType               =$_SESSION['Front']['storage_details']['day_area_type'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->DayParking                =$_SESSION['Front']['storage_details']['day_parking'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->DayPostalCode             =$_SESSION['Front']['storage_details']['postal_code'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->DaySuburbName             =$_SESSION['Front']['storage_details']['suburb'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->IncludeTheftExcessBuster  =$_SESSION['Front']['storage_details']['theft_access_include'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->InsuranceCustomeVehicleID =$_SESSION['Front']['storage_details']['insurance_customer_vehicle_id'];
					
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->VoluntaryExcess           =$_SESSION['Front']['storage_details']['voluntary_excess'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->DriverDateOfBirth         =$driver_birth_date;
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->DriverEmploymentStatus    =$_SESSION['Front']['personal_details']['driver_employment_status'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->DriverGender              =$_SESSION['Front']['personal_details']['driver_gender'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->DriverLicenseDate         =$driver_licence_date;
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->DriverLicenseType         =$driver_licence_type;
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->DriverMaritalStatus       =$_SESSION['Front']['personal_details']['driver_marital_status'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->DriverPostalCode          =$_SESSION['Front']['personal_details']['driver_postal_code'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->DriverSuburbName          =$_SESSION['Front']['personal_details']['driver_suburb'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->DriverAccessControl     	 =$_SESSION['Front']['vehicle_details']['driver_access_control'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->DriverAreaType 			 =$_SESSION['Front']['vehicle_details']['driver_area_type'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->CoverType                 =$_SESSION['Front']['storage_details']['cover_type'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->SaverThirdPartyLiability  =$_SESSION['Front']['storage_details']['third_party_liability'];
					
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->HailCover                 =$_SESSION['Front']['storage_details']['hail_cover'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->WindscreenCover           =$_SESSION['Front']['storage_details']['windscreen_cover'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->SaverAssist  			 =$_SESSION['Front']['storage_details']['saver_assist'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->CarHireIncluded           =$_SESSION['Front']['storage_details']['car_hire_included'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->CarHireOption             =$_SESSION['Front']['storage_details']['car_hire_option'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->RadioCover                =$_SESSION['Front']['storage_details']['radio_cover'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->RadioCoverValue           =$_SESSION['Front']['storage_details']['radio_cover_value'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->CanopyCoverIncluded       =$_SESSION['Front']['storage_details']['canopy_included'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->PublicLiability		= $_SESSION['Front']['storage_details']['public_liability'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->SaverTotalLoss		= $_SESSION['Front']['storage_details']['saver_total_loss'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->SaverAccidentCover	= $_SESSION['Front']['storage_details']['saver_accident_cover'];
					$vehicle_data[$vehicle]->InsuranceCustomerVehicle->SaverAccidentOption	= $_SESSION['Front']['storage_details']['saver_accident_option'];
					
					$this->log->logIt("update_customer_vehicle" . "matched vehicle" . json_encode($vehicle_data) );

					break;
				}
				
			}
			
			$customer_model->CustomerVehicleList->CustomerVehicleModel = $vehicle_data;
		 	
			#$this->customerservices->token = $_SESSION['token'];
			if( array_key_exists('token',$_SESSION) ){
				$this->customerservices->token  = $_SESSION['token'];
			}
			else{
				$this->customerservices->token = NULL;
			}
			$this->log->logIt("update_customer_vehicle" . "vehicle_details_session" . json_encode($_SESSION['Front']['vehicle_details']));
			$this->log->logIt("update_customer_vehicle" . "vehicle_storage_session" . json_encode($_SESSION['Front']['storage_details']));
			$this->log->logIt("update_customer_vehicle" . "Call fn_CustomerUpdate - Start" . json_encode($vehicle_data));
			$response = $this->customerservices->fn_CustomerUpdate($customer_model);
			$this->log->logIt("update_customer_vehicle" . "Call fn_CustomerUpdate - End" . json_encode($response));
			#$this->log->logIt(array($response) );
			
			$_SESSION['Front']['guest_vehicle'] = $response["resultData"]->CustomerUpdateResult;
			$_SESSION['Front']['customer_info_obj']->CustomerVehicleList = $response["resultData"]->CustomerUpdateResult->CustomerVehicleList;
			
			return $response;
		
		}
		catch (Exception $e) {
			echo $e;
			$this->log->logIt("update_customer_vehicle" . "-" . $e);
		}
	
	}
	
	function fetch_vehicle_for_guest( $regno = '' ){
		
		$this->log->logIt("fetch_vehicle_for_guest:".$regno);
		$result=new resultobject();
		try{
			if( isset($_SESSION['Front']['guest_vehicle']) ){
				
				$vehicle_data = $_SESSION['Front']['guest_vehicle'][$regno];
				
				$this->log->logIt( "vehicle list:".count($vehicle_data) );
				
				$this->log->logIt($vehicle_data);
				
				$vehicle_data_array = array();
				
				$vehicle_data_array["DateOfFirstRegistration"]  = $vehicle_data->DateOfFirstRegistration;
					
				$vehicle_data_array["CustomerVehicleID"]  = $vehicle_data->CustomerVehicleID;
				
				$vehicle_data_array["EngineNo"]  = $vehicle_data->EngineNo;
				
				$vehicle_data_array["InsuranceCustomerVehicle"]  = $vehicle_data->InsuranceCustomerVehicle;
				
				$vehicle_data_array["MMCode"]  = $vehicle_data->MMCode;
				
				$vehicle_data_array["Make"]  = $vehicle_data->Make;
				
				$vehicle_data_array["MakeDesc"]  = $vehicle_data->MakeDesc;
				
				$vehicle_data_array["Model"]  = $vehicle_data->Model;
				
				$vehicle_data_array["ModelDesc"]  = $vehicle_data->ModelDesc;
				
				$vehicle_data_array["PreviousOwned"]  = $vehicle_data->PreviousOwned;
				
				$vehicle_data_array["RegistrationNo"]  = $vehicle_data->RegistrationNo;
				
				$vehicle_data_array["Series"]  = $vehicle_data->Series;
				
				$vehicle_data_array["SeriesDesc"]  = $vehicle_data->SeriesDesc;
				
				$vehicle_data_array["ServiceHistory"]  = $vehicle_data->ServiceHistory;
				
				$vehicle_data_array["VINNo"]  = $vehicle_data->VINNo;
				
				$vehicle_data_array["Vehicle"]  = $vehicle_data->Vehicle;
				
				$vehicle_data_array["VehicleDesc"]  = $vehicle_data->VehicleDesc;
				
				$vehicle_data_array["Warranty"]  = $vehicle_data->Warranty;
				
				$vehicle_data_array["Year"]  = $vehicle_data->Year;
				
				$vehicle_data_array["YearName"]  = $vehicle_data->Year;
				
				
				$result->resultStatus = resultConstant::Success;
				$result->resultData = $vehicle_data_array;
			}
		}
		catch (Exception $e) {
			$this->log->logIt("fetch_vehicle_for_guest" . "-" . $e);
		}
		return $result;
	}
		
	function fetch_vehicle( $regno = '', $action = '' ){
		
		try{
			$this->log->logIt("fetch_vehicle-regno:".$regno.",action:".$action);
			
			$regno = strtoupper($regno);
			
			$this->refresh_customer_data(); //Important
			
			$vehicle_list_by_id = array();
			
			$result=new resultobject();
			
			if( isset($_SESSION['Front']['customer_info_obj']->CustomerVehicleList->CustomerVehicleModel) ){
						
				$vehicle_list =   $_SESSION['Front']['customer_info_obj']->CustomerVehicleList->CustomerVehicleModel;
				
				$this->log->logIt( "vehicle list:".count($vehicle_list) );
				
				$vehicles = array();
				
				if(count($vehicle_list) == 1){
					
					$vehicles[0] = $vehicle_list;
				}
				else{
					
					$vehicles  = $vehicle_list;
				}
				
				$this->log->logIt( json_encode($vehicles) );
				
				$this->log->logIt( "total vehicles:". count($vehicles) );
				
				for( $i=0; $i < count($vehicles); $i++ ){
					
					$this->log->logIt( $vehicles[$i]->RegistrationNo );
					
					$vehicle_key = "'".$vehicles[$i]->RegistrationNo."'";
					
					$vehicle_list_by_id[$vehicle_key]["DateOfFirstRegistration"]  = $vehicles[$i]->DateOfFirstRegistration;
					
					$vehicle_list_by_id[$vehicle_key]["CustomerVehicleID"]  = $vehicles[$i]->CustomerVehicleID;
					
					$vehicle_list_by_id[$vehicle_key]["EngineNo"]  = $vehicles[$i]->EngineNo;
					
					$vehicle_list_by_id[$vehicle_key]["InsuranceCustomerVehicle"]  = $vehicles[$i]->InsuranceCustomerVehicle;
					
					$vehicle_list_by_id[$vehicle_key]["MMCode"]  = $vehicles[$i]->MMCode;
					
					$vehicle_list_by_id[$vehicle_key]["Make"]  = $vehicles[$i]->Make;
					
					$vehicle_list_by_id[$vehicle_key]["MakeDesc"]  = $vehicles[$i]->MakeDesc;
					
					$vehicle_list_by_id[$vehicle_key]["Model"]  = $vehicles[$i]->Model;
					
					$vehicle_list_by_id[$vehicle_key]["ModelDesc"]  = $vehicles[$i]->ModelDesc;
					
					$vehicle_list_by_id[$vehicle_key]["PreviousOwned"]  = $vehicles[$i]->PreviousOwned;
					
					$vehicle_list_by_id[$vehicle_key]["RegistrationNo"]  = $vehicles[$i]->RegistrationNo;
					
					$vehicle_list_by_id[$vehicle_key]["Series"]  = $vehicles[$i]->Series;
					
					$vehicle_list_by_id[$vehicle_key]["SeriesDesc"]  = $vehicles[$i]->SeriesDesc;
					
					$vehicle_list_by_id[$vehicle_key]["ServiceHistory"]  = $vehicles[$i]->ServiceHistory;
					
					$vehicle_list_by_id[$vehicle_key]["VINNo"]  = $vehicles[$i]->VINNo;
					
					$vehicle_list_by_id[$vehicle_key]["Vehicle"]  = $vehicles[$i]->Vehicle;
					
					$vehicle_list_by_id[$vehicle_key]["VehicleDesc"]  = $vehicles[$i]->VehicleDesc;
					
					$vehicle_list_by_id[$vehicle_key]["Warranty"]  = $vehicles[$i]->Warranty;
					
					$vehicle_list_by_id[$vehicle_key]["Year"]  = $vehicles[$i]->Year;
					
					$vehicle_list_by_id[$vehicle_key]["YearName"]  = $vehicles[$i]->Year;
				}
				
			}
			
			$this->log->logIt( "vehicle details:".$regno);
			$this->log->logIt( json_encode($vehicle_list_by_id) );

						
			if( !empty($vehicle_list_by_id) ){
				
				if($action == ''){
					
					$this->log->logIt("array_key_exists:".array_key_exists( "'".$regno."'",$vehicle_list_by_id ));
					
					if( $regno != ""  && array_key_exists( "'".$regno."'",$vehicle_list_by_id ) ){
						
						$result->resultStatus = resultConstant::Success;
						
						$result->resultData = $vehicle_list_by_id["'".$regno."'"];
						
					}
					else{
						
						$result->resultStatus = resultConstant::Warning;
						
						$result->resultData = "No data found";
						
					}
				}
				elseif($action == 'list'){
					
					$result->resultStatus = resultConstant::Success;
						
					$result->resultData = $vehicle_list_by_id;
				}
				
			}
			else{
					
					$result->resultStatus = resultConstant::Warning;
					
					$result->resultData = "No data found";
					
			}
			
			return $result;
			 
		}
		catch ( Exception $e ){
			
			echo $e;
			
			$this->log->logIt("fetch_vehicle - ".$e);
		}
	}
	
	function fetch_vehicle_from_session( $regno = '', $action = '' ){
		
		try{
			$this->log->logIt($this->module . "-" . "fetch_vehicle_from_session:regno" .$regno.",action:".$action);
			
			$regno = strtoupper($regno);
			
			$vehicle_list_by_id = array();
			
			$result=new resultobject();
			
			if( isset($_SESSION['Front']['customer_info_obj']->CustomerVehicleList->CustomerVehicleModel) ){
						
				$vehicle_list =   $_SESSION['Front']['customer_info_obj']->CustomerVehicleList->CustomerVehicleModel;
				
				$this->log->logIt( "vehicle list:".count($vehicle_list) );
				
				$vehicles = array();
				
				if(count($vehicle_list) == 1){
					
					$vehicles[0] = $vehicle_list;
				}
				else{
					
					$vehicles  = $vehicle_list;
				}
				
				$this->log->logIt( json_encode($vehicles) );
				
				$this->log->logIt( "total vehicles:". count($vehicles) );
				
				for( $i=0; $i < count($vehicles); $i++ ){
					
					$this->log->logIt( $vehicles[$i]->RegistrationNo );
					
					$vehicle_key = "'".$vehicles[$i]->RegistrationNo."'";
					
					$vehicle_list_by_id[$vehicle_key]["DateOfFirstRegistration"]  = $vehicles[$i]->DateOfFirstRegistration;
					
					$vehicle_list_by_id[$vehicle_key]["CustomerVehicleID"]  = $vehicles[$i]->CustomerVehicleID;
					
					$vehicle_list_by_id[$vehicle_key]["EngineNo"]  = $vehicles[$i]->EngineNo;
					
					$vehicle_list_by_id[$vehicle_key]["InsuranceCustomerVehicle"]  = $vehicles[$i]->InsuranceCustomerVehicle;
					
					$vehicle_list_by_id[$vehicle_key]["MMCode"]  = $vehicles[$i]->MMCode;
					
					$vehicle_list_by_id[$vehicle_key]["Make"]  = $vehicles[$i]->Make;
					
					$vehicle_list_by_id[$vehicle_key]["MakeDesc"]  = $vehicles[$i]->MakeDesc;
					
					$vehicle_list_by_id[$vehicle_key]["Model"]  = $vehicles[$i]->Model;
					
					$vehicle_list_by_id[$vehicle_key]["ModelDesc"]  = $vehicles[$i]->ModelDesc;
					
					$vehicle_list_by_id[$vehicle_key]["PreviousOwned"]  = $vehicles[$i]->PreviousOwned;
					
					$vehicle_list_by_id[$vehicle_key]["RegistrationNo"]  = $vehicles[$i]->RegistrationNo;
					
					$vehicle_list_by_id[$vehicle_key]["Series"]  = $vehicles[$i]->Series;
					
					$vehicle_list_by_id[$vehicle_key]["SeriesDesc"]  = $vehicles[$i]->SeriesDesc;
					
					$vehicle_list_by_id[$vehicle_key]["ServiceHistory"]  = $vehicles[$i]->ServiceHistory;
					
					$vehicle_list_by_id[$vehicle_key]["VINNo"]  = $vehicles[$i]->VINNo;
					
					$vehicle_list_by_id[$vehicle_key]["Vehicle"]  = $vehicles[$i]->Vehicle;
					
					$vehicle_list_by_id[$vehicle_key]["VehicleDesc"]  = $vehicles[$i]->VehicleDesc;
					
					$vehicle_list_by_id[$vehicle_key]["Warranty"]  = $vehicles[$i]->Warranty;
					
					$vehicle_list_by_id[$vehicle_key]["Year"]  = $vehicles[$i]->Year;
					
					$vehicle_list_by_id[$vehicle_key]["YearName"]  = $vehicles[$i]->Year;
					
				}
				
			}
			
			$this->log->logIt( "vehicle details:".$regno);
			$this->log->logIt( json_encode($vehicle_list_by_id) );

						
			if( !empty($vehicle_list_by_id) ){
				
				if($action == ''){
					
					$this->log->logIt("array_key_exists:".array_key_exists( "'".$regno."'",$vehicle_list_by_id ));
					
					if( $regno != ""  && array_key_exists( "'".$regno."'",$vehicle_list_by_id ) ){
						
						$result->resultStatus = resultConstant::Success;
						
						$result->resultData = $vehicle_list_by_id["'".$regno."'"];
						
					}
					else{
						
						$result->resultStatus = resultConstant::Warning;
						
						$result->resultData = "No data found";
						
					}
				}
				elseif($action == 'list'){
					
					$result->resultStatus = resultConstant::Success;
						
					$result->resultData = $vehicle_list_by_id;
				}
				
			}
			else{
					
					$result->resultStatus = resultConstant::Warning;
					
					$result->resultData = "No data found";
					
			}
			
			return $result;
			 
		}
		catch ( Exception $e ){
			
			echo $e;
			
			$this->log->logIt("fetch_vehicle - ".$e);
		}
	}
	
	public function customer_vehicle_model(){
		try {
			 
			$response_array = array();
			$RegistrationNo = $_SESSION['Front']['vehicle_details']['registration_number'];
			$Year 			= intval($_SESSION['Front']['vehicle_details']['year_of_registration']);
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
			
			//$DateOfFirstRegistration = "2012-02-02";//$_SESSION['Front']['vehicle_details']['vehicle_license_issue_date'];
			$DateOfFirstRegistration = "";
			if( isset($_SESSION['Front']['vehicle_details']['year_of_registration']) ){
				
				//$yeardata_array =  $this->commondao->get_data_service_json('VehicleYearData');
				//
				//$year_data = json_decode($yeardata_array);
				//
				//$year_array = array();
				//
				//for($i=0; $i < count($year_data->value); $i++){
				//	
				//	$year_array[$year_data->value[$i]->ID] = $year_data->value[$i]->Year;
				//}
				//
				//$year_id = $_SESSION['Front']['vehicle_details']['year_of_registration'];
				
				$year = $_SESSION['Front']['vehicle_details']['year_of_registration'];
				
				$DateOfFirstRegistration = $year."-01-01";
				
				$DateOfFirstRegistration = date('Y-m-d',strtotime($DateOfFirstRegistration));
			}
			
			
			/*InsuranceCustomerVehicle Model data*/
			$VehicleFinanced = boolval(0);
			$this->log->logIt( "VehicleFinanced-----------------1---:".$VehicleFinanced);
			
			if( isset( $_SESSION['Front']['vehicle_details']['vehicle_finance'])
			   && !empty( $_SESSION['Front']['vehicle_details']['vehicle_finance']) ){				
				#$VehicleFinanced = $_SESSION['Front']['vehicle_details']['vehicle_finance'];
			
				$this->log->logIt( "VehicleFinanced-----------------2---:".$_SESSION['Front']['vehicle_details']['vehicle_finance']);
			
				if($_SESSION['Front']['vehicle_details']['vehicle_finance'] == "true"){
					$VehicleFinanced = 1;		
				}
				else{
					$VehicleFinanced = 0;	
				}
			}
			
			
			$this->log->logIt( "VehicleFinanced-----------------3---:".$VehicleFinanced);
			
			
			
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
			
			$MotorSarsia = "";
			if( isset( $_SESSION['Front']['storage_details']['motor_sarsia']) ){
				$MotorSarsia = $_SESSION['Front']['storage_details']['motor_sarsia'];
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
			
			$DayAccessControl = "01";
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
					$DriverDateOfBirth = date('Y-m-d',strtotime($DriverDateOfBirth));
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
			
			$DriverAccessControl = "01";
			if( isset( $_SESSION['Front']['vehicle_details']['driver_access_control']) ){
						$DriverAccessControl = $_SESSION['Front']['vehicle_details']['driver_access_control'];
			}
			
			$DriverAreaType = "";
			if( isset( $_SESSION['Front']['vehicle_details']['driver_area_type']) ){
					$DriverAreaType = $_SESSION['Front']['vehicle_details']['driver_area_type'];
			}
			
			$DriverLicenseDate = date("Y-m-d");
			
			if( isset($_SESSION['Front']['vehicle_details']['vehicle_license_issue_date']) ){
				$DriverLicenseDate = $_SESSION['Front']['vehicle_details']['vehicle_license_issue_date'];
				$DriverLicenseDate = date('Y-m-d',strtotime($DriverLicenseDate));
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
			
			$HailCover = "Y";
			if( isset( $_SESSION['Front']['storage_details']['hail_cover']) ){			
				if( $_SESSION['Front']['storage_details']['hail_cover'] == "N"){
					$HailCover = "N";
				}
			}
			
			$WindscreenCover = "Y";
			if( isset( $_SESSION['Front']['storage_details']['windscreen_cover']) ){			
				if( $_SESSION['Front']['storage_details']['windscreen_cover'] == "N"){
					$WindscreenCover = "N";
				}
			}
			
			$CarHireIncluded = "Y";
			if( isset( $_SESSION['Front']['storage_details']['car_hire_included']) ){			
				if( $_SESSION['Front']['storage_details']['car_hire_included'] == "N"){
					$CarHireIncluded = "N";
				}
			}
			
			$CarHireOption = "C";
			if( isset( $_SESSION['Front']['storage_details']['car_hire_option'])
				&& !empty( $_SESSION['Front']['storage_details']['car_hire_option']) ){
					$CarHireOption = $_SESSION['Front']['storage_details']['car_hire_option'];
			}
			
			$CanopyCoverIncluded = "Y";
			if( isset( $_SESSION['Front']['storage_details']['canopy_included']) ){			
				if( $_SESSION['Front']['storage_details']['canopy_included'] == "N"){
					$CanopyCoverIncluded = "N";
				}
			}
			
			$IncludeTheftExcessBuster = "Y";
			if( isset( $_SESSION['Front']['storage_details']['theft_access_include']) ){			
				if( $_SESSION['Front']['storage_details']['theft_access_include'] == "N"){
					$IncludeTheftExcessBuster = "N";
				}
			}
			
			$RadioCover = "Y";
			if( isset( $_SESSION['Front']['storage_details']['radio_cover']) ){			
				if( $_SESSION['Front']['storage_details']['radio_cover'] == "N"){
					$RadioCover = "N";
				}
			}
			
			$RadioCoverValue = "0";
			if( isset( $_SESSION['Front']['storage_details']['radio_cover_value']) ){			
					$RadioCoverValue = $_SESSION['Front']['storage_details']['radio_cover_value'] ;
			}
			
			$VoluntaryExcess  = "0";
			if( isset( $_SESSION['Front']['storage_details']['voluntary_excess'])
			   && !empty($_SESSION['Front']['storage_details']['voluntary_excess']) ){
					$VoluntaryExcess = $_SESSION['Front']['storage_details']['voluntary_excess'];
			}
			
			$MMCode  = "";
			if( isset( $_SESSION['Front']['storage_details']['mm_code']) && $_SESSION['Front']['storage_details']['mm_code'] != ""){
					$MMCode = $_SESSION['Front']['storage_details']['mm_code'];
			}
			
			$SaverAccidentCover = "Y";
			$SaverAccidentOption = "A";
			$SaverTotalLoss = "Y";
			$PublicLiability = "Y";
			
			$InsuranceCustomerVehicleModel 	= array (
				//"VehicleKey" 				=>  "", // String
				//"VehicleDescription" 		=>  "", // String
				"VehicleFinanced" 			=>  $VehicleFinanced,
				"NCB" 						=>  intval($no_claim_bonus), // dropdown string
				"CoverType" 				=>  $CoverType, // String
				"VehicleUse" 				=> 	$VehicleUse, // String
				"HailCover"					=>  $HailCover, //YesNoIndicator
				"RadioCover"				=>  $RadioCover, //YesNoIndicator
				"RadioCoverValue"			=>  $RadioCoverValue, //int
				"OvernightParking"			=>  $OvernightParking, //string
				"DayParking"				=>  $DayParking, //string
				"DayAddressType"			=>  $DayAddressType, //AddressType
				//"DayParkingSame"			=>  "Yes", //YesNoIndicator
				//"DaySuburbName"			=>  "", //string
				"DayAreaType"				=>  $DayAreaType, //string
				"DayAccessControl"			=>  $DayAccessControl, //string
				"TrackingDeviceInstalled" 	=>  $TrackingDeviceInstalled, //YesNoIndicator
				"TrackerDeviceType"			=>	$TrackerDeviceType, //string
				"WindscreenCover"			=>	$WindscreenCover, //YesNoIndicator
				"CarHireIncluded"			=>	$CarHireIncluded,//YesNoIndicator
				"CarHireOption"				=>  $CarHireOption, //string
				"CanopyCoverIncluded"		=>	$CanopyCoverIncluded, //YesNoIndicator
				"InsuredOption"				=>	$InsuredOption,//string
				"NightAddressType"			=>  $NightAddressType, //AddressType
				"NightParkingSame"			=>  $NightParkingSame,//YesNoIndicator
				"NightPostalCode"			=>  $NightPostalCode, //sting
				"NightSuburbName"			=>  $NightSuburbName,//string
				"NightAreaType"				=>  $NightAreaType, //string
				"NightAccessControl"		=>  $NightAccessControl, //string
				
				"VoluntaryExcess"			=>  $VoluntaryExcess, //string
				"IncludeTheftExcessBuster"=>  	$IncludeTheftExcessBuster, //YesNoIndicator
				//"SaverThirdPartyLiability"=>  "Yes", //YesNoIndicator
				"SaverAccidentCover"		=>  $SaverAccidentCover, //"Yes", //YesNoIndicator
				"SaverAccidentOption"		=>  $SaverAccidentOption, //string
				"SaverTotalLoss"			=>  $SaverTotalLoss,//"Yes", //YesNoIndicator
				//"SaverAssist"				=>  "Yes", //YesNoIndicator
				"PublicLiability"			=>  $PublicLiability,//"Yes", //YesNoIndicator
				"VehicleColour"				=>  $VehicleColour, //string
				"VehiclePaintType"			=>  $VehiclePaintType, //string
				//"DriverDateOfBirth"  		=>  $DriverDateOfBirth,
				"DriverGender"				=>  $DriverGender, //string
				"DriverMaritalStatus"		=>  $DriverMaritalStatus, //string
				"DriverEmploymentStatus"	=>  $DriverEmploymentStatus, //string
				"DriverLicenseType"			=>  $DriverLicenseType, //string
				"DriverPostalCode"			=>  $DriverPostalCode, //string
				"DriverSuburbName"			=>  $DriverSuburbName, //string
				"DriverAccessControl"		=>  $DriverAccessControl, //string
				"DriverAreaType"			=>  $DriverAreaType, //string
				"DriverLicenseDate"			=>  $DriverLicenseDate, //string
				"CurrentMileage"			=>  $CurrentMileage, //int				
			);
			if($DriverDateOfBirth != ""){
				$InsuranceCustomerVehicleModel["DriverDateOfBirth"] = $DriverDateOfBirth;
			}
			
			/*if($DriverLicenseDate != ""){
				$InsuranceCustomerVehicleModel["DriverLicenseDate"] = $DriverLicenseDate;
			}*/
		
			
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
				//"DateOfFirstRegistration"  => $DateOfFirstRegistration,
				"InsuranceCustomerVehicle" => $InsuranceCustomerVehicleModel,
				//"Vehicle"				=> 101,// int,
				//"VehicleDesc			=> '',// str
				//"Warranty"			=> "Yes",
				//"VINNo" 				=> "", //string
				//"EngineNo"			=> "", //string
				"MMCode" 				=> $MMCode, //string
				//"PreviousOwned"		=> 1, //bool
			);
			
			if($DateOfFirstRegistration != ""){
				$customerVehicleModel["DateOfFirstRegistration"] = $DateOfFirstRegistration;
			}
			
			return $customerVehicleModel;
			 
		}
		catch (Exception $e) {
			echo $e;
			$this->log->logIt($this->module . "-" . "customer_vehicle_model" . "-" . $e);
		}
	}
	
 
	
					
}    
?>
<?php
require_once(BASE_PATH."/Util/util.php");
require_once(BASE_PATH."/Util/Services/customerservices.php");
require_once(BASE_PATH."/Util/Services/data_curl.php");
require_once(BASE_PATH."/Util/Services/service_util.php");

class personal_details{
	private $module = 'personal_details';
	private $log;
	private $util;
	
	public function __construct(){
		
		$this->log = new logger();
		
		$this->util = new util();
		
		$this->customerservices = new customerservices();
		
		$this->service_util = new service_util();
		
		$this->data_curl = new data_curl();
	
		if (isset($_REQUEST['action'])) {

			if ($_REQUEST['action'] != "") {

				$this->step_name = $_REQUEST['action'];
			}
		}

	}
	
	// Jim this function is moved to personal_detail.php
	public function personal_details(){
		$result = new resultobject();
	 
		try {
			$this->log->logIt($this->module . "-" . "personal_details");
			$error_array = array();
			$driver_array = array();
			/* Personal Details */
			$id_type 			= $_POST['id_type_personal'];
			$passport_number 	= $_POST['passport_number'];
			$identity_number 	= $_POST['identity_number'];
			$person_title 		= $_POST['person_title'];
			$person_name 		= $_POST['name'];
			$person_surname 	= $_POST['surname'];
			$person_dob 		= $_POST['dob'];
			$person_email 		= $_POST['email'];
			$person_mobile 		= $_POST['mobile'];
			$person_telephone 	= $_POST['telephone'];
			$person_fax 		= $_POST['fax'];
			$person_street 		= $_POST['street_address'];
			$person_street2 	= $_POST['street_address2'];
			$person_street3	 	= $_POST['street_address3'];
			$person_suburb 		= $_POST['suburb'];
			$person_city 		= $_POST['city'];
			$person_postal_code = $_POST['postal_code'];
			$person_gender 		= $_POST['gender'];
			$person_marital_status 		= $_POST['marital_status'];
			$person_employment_status 	= $_POST['employment_status'];
			$personal_address_id = $_POST['personal_address_id'];

			/* Driver Details */
			$driver_id_type 		= $_POST['driver_id_type'];
			$driver_array['driver_id_type'] = $driver_id_type;
			
			$driver_passport_number = $_POST['driver_passport_number'];
			$driver_array['driver_passport_number'] = $driver_passport_number;
			
			$driver_identity_number = $_POST['driver_identity_number'];
			$driver_array['driver_identity_number'] = $driver_identity_number;
			
			$driver_title 			= $_POST['driver_title'];
			$driver_array['driver_title'] = $driver_title;

			$driver_name 			= $_POST['driver_name'];
			$driver_array['driver_name'] = $driver_name;
			$driver_surname 		= $_POST['driver_surname'];
			$driver_array['driver_surname'] = $driver_surname;

			$driver_dob 			= $_POST['driver_dob'];
			$driver_array['driver_dob'] = $driver_dob;
			
			$driver_email 			= $_POST['driver_email'];
			$driver_array['driver_email'] = $driver_email;
			
			$driver_mobile 			= $_POST['driver_mobile'];
			$driver_array['driver_mobile'] = $driver_mobile;
			
			$driver_telephone 		= $_POST['driver_telephone'];
			$driver_array['driver_telephone'] = $driver_telephone;

			$driver_fax 			= $_POST['driver_fax'];
			$driver_array['driver_fax'] = $driver_fax;
			
			$driver_street 			= $_POST['driver_street_address'];
			$driver_array['driver_street'] = $driver_street;
			
			$driver_street2 		= $_POST['driver_street_address2'];
			$driver_array['driver_street2'] = $driver_street2;
			
			$driver_street3 		= $_POST['driver_street_address3'];
			$driver_array['driver_street_address3'] = $driver_street3;
			
			$driver_suburb 			= $_POST['driver_suburb'];
			$driver_array['driver_suburb'] = $driver_suburb;
			
			$driver_city 			= $_POST['driver_city'];
			$driver_array['driver_city'] = $driver_city;
			
			$driver_postal_code 	= $_POST['driver_postal_code'];
			$driver_array['driver_postal_code'] = $driver_postal_code;
			
			$driver_gender 			= $_POST['driver_gender'];
			$driver_array['driver_gender'] = $driver_gender;
			
			$driver_marital_status 	= $_POST['driver_marital_status'];
			$driver_array['driver_marital_status'] = $driver_marital_status;
			
			$driver_employment_status = $_POST['driver_employment_status'];
			$driver_array['driver_employment_status'] = $driver_employment_status;
			
			$driver_address_id 		= $_POST['driver_address_id'];
			$driver_array['driver_address_id'] = $driver_address_id;
			
			$same_as_billing = $_POST['same_as_billing'];
			$driver_array['same_as_billing'] = $same_as_billing;
			
			$customer_id					= $_POST['customer_id'];
			$data_array['customer_id'] 		= $customer_id;
			$data_array['same_as_billing'] 	= $same_as_billing;
			
			if ($this->util->mandatoryField($personal_address_id)) {
				$data_array['personal_address_id'] = $personal_address_id;
			} else {
				$error_array['personal_address_id'] = "Invalid Billing Address.";
			}
			
			if ($this->util->mandatoryField($driver_address_id)) {
				$data_array['driver_address_id'] = $driver_address_id;
				$driver_array['driver_address_id'] = $driver_address_id;
			} else {
				$error_array['driver_address_id'] = "Invalid Driver Address.";
			}
			
			
			/* Populate the fields for PERSON details. If field is valid add to DATA array else add to ERROR array */
			if ($this->util->mandatoryField($id_type)) {
				$data_array['id_type'] = $id_type;
			} else {
				$error_array['id_type'] = "Billing ID type is required.";
			}

			if ($this->util->mandatoryField($person_title)) {
				$data_array['person_title'] = $person_title;
			} else {
				$error_array['person_title'] = "Billing Title is required.";
			}
			
			if ( $this->util->mandatoryField($passport_number) != true
				&& $this->util->mandatoryField($identity_number) != true) {
				
				$error_array['identity_number'] = "Billing Identity or Passport number is required.";
			}
			else{
				$data_array['identity_number'] = $identity_number;
				$data_array['passport_number'] = $passport_number;
			}

			/*if ($this->util->mandatoryField($passport_number) ) {
				$data_array['passport_number'] = $passport_number;
			} else {
				$error_array['passport_number'] = "Passport number is required.";
			}
			
			if ($this->util->mandatoryField($identity_number)) {
				$data_array['identity_number'] = $identity_number;
			} else {
				$error_array['identity_number'] = "Identity number is required.";
			}*/

			if ($this->util->mandatoryField($person_name)) {
				$data_array['person_name'] = $person_name;
			} else {
				$error_array['person_name'] = "Billing Name is required.";
			}

			if ($this->util->mandatoryField($person_surname)) {
				$data_array['person_surname'] = $person_surname;
			} else {
				$error_array['person_surname'] = "Billing Surname is required.";
			}

			if ($this->util->mandatoryField($person_dob)) {
				$data_array['person_dob'] = $person_dob;
			} else {
				$error_array['person_dob'] = "Billing Date of birth is required.";
			}

			if ($this->util->mandatoryField($person_email)) {
				$data_array['person_email'] = $person_email;
			} else {
				$error_array['person_email'] = "Billing Email is required.";
			}

			if ($this->util->mandatoryField($person_mobile)) {
				$data_array['person_mobile'] = $person_mobile;
			} else {
				$error_array['person_mobile'] = "Billing Mobile number is required.";
			}

			if ($this->util->mandatoryField($person_telephone)) {
				$data_array['person_telephone'] = $person_telephone;
			} else {
				$error_array['person_telephone'] = "Billing Telephone is required.";
			}

			$data_array['person_fax'] = $person_fax;
			
			//if ($this->util->mandatoryField($person_fax)) {
			//	$data_array['person_fax'] = $person_fax;
			//} else {
			//	$error_array['person_fax'] = "Billing Fax is required.";
			//}

			if ($this->util->mandatoryField($person_street)) {
				$data_array['person_street_address'] = $person_street;
			} else {
				$error_array['person_street_address'] = "Billing Street address is required.";
			}
			
			$data_array['person_street_address2'] = !empty($person_street2) ? $person_street2 : "";
			$data_array['person_street_address3'] = !empty($person_street3) ? $person_street3 : "";
			
			if ($this->util->mandatoryField($person_suburb)) {
				$data_array['person_suburb'] = $person_suburb;
			} else {
				$error_array['person_suburb'] = "Billing Suburb is required.";
			}
			

			if ($this->util->mandatoryField($person_city)) {
				$data_array['person_city'] = $person_city;
			} else {
				$error_array['person_city'] = "Billing City/Town is required.";
			}
			
			if ($this->util->mandatoryField($person_postal_code)) {
				$data_array['person_postal_code'] = $person_postal_code;
			}
			else {
				$error_array['person_postal_code'] = "Billing City/Town is required.";
			}

			if ($this->util->mandatoryField($person_gender)) {
				$data_array['person_gender'] = $person_gender;
			} else {
				$error_array['person_gender'] = "Billing Gender is required.";
			}

			if ($this->util->mandatoryField($person_marital_status)) {
				$data_array['person_marital_status'] = $person_marital_status;
			} else {
				$error_array['person_marital_status'] = "Billing Marital status is required.";
			}

			if ($this->util->mandatoryField($person_employment_status)) {
				$data_array['person_employment_status'] = $person_employment_status;
			} else {
				$error_array['person_employment_status'] = "Billing Employment status is required.";
			}

			/* Populate the fields for DRIVER details. If field is valid add to DATA array else add to ERROR array */
			if ($this->util->mandatoryField($driver_id_type)) {
				$data_array['driver_id_type'] = $driver_id_type;
			} else {
				$error_array['driver_id_type'] = "Driver type is required.";
			}

			if ($this->util->mandatoryField($driver_title)) {
				$data_array['driver_title'] = $driver_title;
			} else {
				$error_array['driver_title'] = "Driver Title is required.";
			}
			
			
			if ( $this->util->mandatoryField($driver_passport_number) != true
				&& $this->util->mandatoryField($driver_identity_number) != true) {
				
				$error_array['driver_identity_number'] = "Driver Identity or Passport number is required.";
			}
			else{
				$data_array['driver_identity_number'] = $driver_identity_number;
				$data_array['driver_passport_number'] = $driver_passport_number;
			}
			

			/*if ($this->util->mandatoryField($driver_passport_number)) {
				$data_array['driver_passport_number'] = $driver_passport_number;
			} else {
				$error_array['driver_passport_number'] = "Passport number is required.";
			}*/

			if ($this->util->mandatoryField($driver_name)) {
				$data_array['driver_name'] = $driver_name;
			} else {
				$error_array['driver_name'] = "Driver Name is required.";
			}

			if ($this->util->mandatoryField($driver_surname)) {
				$data_array['driver_surname'] = $driver_surname;
			} else {
				$error_array['driver_surname'] = "Driver Surname is required.";
			}

			if ($this->util->mandatoryField($driver_dob)) {
				$data_array['driver_dob'] = $driver_dob;
			} else {
				$error_array['driver_dob'] = "Driver Date of birth is required.";
			}

			if ($this->util->mandatoryField($driver_email)) {
				$data_array['driver_email'] = $driver_email;

			} else {
				$error_array['driver_email'] = "Driver Email is required.";
			}

			if ($this->util->mandatoryField($driver_mobile)) {
				$data_array['driver_mobile'] = $driver_mobile;
			} else {
				$error_array['driver_mobile'] = "Driver Mobile number is required.";
			}

			if ($this->util->mandatoryField($driver_telephone)) {
				$data_array['driver_telephone'] = $driver_telephone;
			} else {
				$error_array['driver_telephone'] = "Driver Telephone is required.";
			}
			
			$data_array['driver_fax'] = $driver_fax;
			//if ($this->util->mandatoryField($driver_fax)) {
			//	
			//} else {
			//	$error_array['driver_fax'] = "Driver Fax is required.";
			//}

			if ($this->util->mandatoryField($driver_street)) {
				$data_array['driver_street_address'] = $driver_street;
			} else {
				$error_array['driver_street_address'] = "Driver Street address is required.";
			}
			
			$data_array['driver_street_address2'] = !empty($driver_street2) ? $driver_street2 : "";
			$data_array['driver_street_address3'] = !empty($driver_street2) ? $driver_street3 : "";
			
			if ($this->util->mandatoryField($driver_suburb)) {
				$data_array['driver_suburb'] = $driver_suburb;
			} else {
				$error_array['driver_suburb'] = "Driver Suburb is required.";
			}

			if ($this->util->mandatoryField($driver_city)) {
				$data_array['driver_city'] = $driver_city;
			}
			else {
				$error_array['driver_city'] = "Driver City/Town is required.";
			}
			
			if ($this->util->mandatoryField($driver_postal_code)) {
				$data_array['driver_postal_code'] = $driver_postal_code;
			}
			else {
				$error_array['driver_postal_code'] = "Driver City/Town is required.";
			}
			

			if ($this->util->mandatoryField($driver_gender)) {
				$data_array['driver_gender'] = $driver_gender;
			} else {
				$error_array['driver_gender'] = "Driver Gender is required.";
			}

			if ($this->util->mandatoryField($driver_marital_status)) {
				$data_array['driver_marital_status'] = $driver_marital_status;
			} else {
				$error_array['driver_marital_status'] = "Driver Marital status is required.";
			}

			if ($this->util->mandatoryField($driver_employment_status)) {
				$data_array['driver_employment_status'] = $driver_employment_status;
			} else {
				$error_array['driver_employment_status'] = "Driver Employment status is required.";
			}
			/* End */

			$this->log->logIt("Validation Error".json_encode($error_array));
			
			/* Set the values to final array */
			if ( empty($error_array) ) {
				/* Check if customer is exists or not */
				$idno = "";
				
				$passportno = "";
				
				if( $data_array['id_type'] == "id" ){
					
					$idno  		= $data_array['identity_number'];
					$passportno = "";
				}
				else{
					
					$passportno = $data_array['passport_number'];
					$idno		= "";
				}
				
				$_SESSION['Front']['personal_details'] = $data_array;
				$_SESSION['Front']['driver_details'] = $driver_array;
				
				$response = "";
				
				$this->log->logIt("Check Customer Exist Id: ".$idno."Passport: ".$passportno);
				
				$response = $this->customerservices->fn_CustomerExist($idno, $passportno);
				
				$this->log->logIt("Customer Exist Res:".json_encode($response->CustomerExistResult));

				if ($response->CustomerExistResult) {
					$response_array['resultStatus'] = resultConstant::Success;
					$response_array['resultData']['isCustomerExist'] = $response->CustomerExistResult;
					$response_array['resultData']['message'] = "An account for provided ID/Passport number is already exists.";
					$response_array['resultData']['formData'] = $data_array;
					$response_array['resultData']['is_exist'] = 1;					
				}
				else {
					$response_array['resultData']['message'] = "An account for provided ID/Passport number is not exists.";
					$response_array['resultStatus'] = resultConstant::Success;
					$response_array['resultData']['formData'] = $data_array;
					$response_array['resultData']['is_exist'] = 0;
					$response_array['resultData']['redirect'] = "signup/";
				}
			} else {
				// validation fails
				$response_array['resultStatus'] = resultConstant::Warning;
				$response_array['resultData']['message'] = $error_array;
				$response_array['resultData']['formData'] = array();
			}

			print_r(json_encode($response_array));
			exit(0);

		}
		catch (Exception $e) {
			echo $e;
			$this->log->logIt($this->module . "-" . "form_add_edit" . "-" . $e);
		}
	}
	
	public function guest_user(){
		try {
			$this->log->logIt($this->module . "-" . "guest_user");
			$response_array = array();
			if( isset($_SESSION['Front']['personal_details']) ){
				
				$CellphoneNo		= $_SESSION['Front']['personal_details']['person_mobile'];
				$OtherContactNo		= $_SESSION['Front']['personal_details']['person_telephone'];
				$FaxNo				= $_SESSION['Front']['personal_details']['person_fax'];
				$EmploymentStatus 	= $_SESSION['Front']['personal_details']['person_employment_status'];
				$Gender				= $_SESSION['Front']['personal_details']['person_gender'];
				$MaritalStatus		= $_SESSION['Front']['personal_details']['person_marital_status'];
				$phy_add_line1 = $_SESSION['Front']['personal_details']['person_street_address'];
				$phy_add_line2 = $_SESSION['Front']['personal_details']['person_street_address2'];
				$phy_add_line3 = $_SESSION['Front']['personal_details']['person_street_address3'];
				$phy_post_code = $_SESSION['Front']['personal_details']['person_postal_code'];
				$pos_add_line1 = $_SESSION['Front']['personal_details']['driver_street_address'];
				$pos_add_line2 = $_SESSION['Front']['personal_details']['driver_street_address2'];
				$pos_add_line3 = $_SESSION['Front']['personal_details']['driver_street_address3'];
				$pos_post_code = $_SESSION['Front']['personal_details']['driver_postal_code'];
				$personal_address_id 	= $_SESSION['Front']['personal_details']['personal_address_id'];
				$driver_address_id 		= $_SESSION['Front']['personal_details']['driver_address_id'];
				}
				
				if( isset($_SESSION['Front']['personal_details']['person_dob']) ){
					$person_dob = date('Y-m-d',strtotime($_SESSION['Front']['personal_details']['person_dob']));
					$BirthDate = $person_dob;
				}
				
				if( isset($_SESSION['Front']['personal_details']['person_email']) ){
					$Email = $_SESSION['Front']['personal_details']['person_email'];
				}
				
				if( isset($_SESSION['Front']['personal_details']['person_mobile']) ){
					$CellphoneNo = $_SESSION['Front']['personal_details']['person_mobile'];
				}
				
				if( isset($_SESSION['Front']['personal_details']['person_telephone']) ){
					$OtherContactNo = $_SESSION['Front']['personal_details']['person_telephone'];
				}
				$IdentificationNo= "";
				if( isset($_SESSION['Front']['personal_details']['identity_number']) ){
					if( $_SESSION['Front']['personal_details']['identity_number'] != "" ){
						$IdentificationNo = $_SESSION['Front']['personal_details']['identity_number'];
					}
				}
				$PassportNo = "";
				if( isset($_SESSION['Front']['personal_details']['passport_number']) ){
					if( $_SESSION['Front']['personal_details']['passport_number'] != ""){
						$PassportNo = $_SESSION['Front']['personal_details']['passport_number'];
					}
				}
				if( isset($_SESSION['Front']['personal_details']['person_title']) ){
					if( $_SESSION['Front']['personal_details']['person_title'] != "" ){
						$Title = $_SESSION['Front']['personal_details']['person_title'];
					}
				}
				if( isset($_SESSION['Front']['personal_details']['person_name']) ){
					if( $_SESSION['Front']['personal_details']['person_name'] != "" ){
						$FirstName = $_SESSION['Front']['personal_details']['person_name'];
					}
				}
				if( isset($_SESSION['Front']['personal_details']['person_surname']) ){
					if( $_SESSION['Front']['personal_details']['person_surname'] != "" ){
						$SurName = $_SESSION['Front']['personal_details']['person_surname'];
					}
				}
				
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
				
				$InsuranceCustomer = array(
					//"AccessControl" => "",
                  //  "AreaType" => "",
                    "EmploymentStatus" => $EmploymentStatus,
                    "Gender" => $Gender,
                   // "LicenseDate" => "",
                   // "LicenseType" => "",
                    "MaritalStatus" =>  $MaritalStatus,
				);
				 
				$customerVehicleModel = $this->service_util->customer_vehicle_model();	
				
				$vehicle_object = new stdClass();
				
				$vehicle_object->CustomerVehicleModel = $customerVehicleModel;
								
				$CustomerModel = array(
					"Title"				=>	$Title,
					//"TitleDesc"			=>	$TitleDesc,
					"FirstName"			=>	$FirstName,
					"SurName"			=>	$SurName,
					"IdentificationNo"	=>	$IdentificationNo,
					"PassportNo"		=>	$PassportNo,
					"BirthDate"			=>	$BirthDate,
					"Email"				=>	$Email,
					"EmailVerified"		=>	1,
					"CellphoneNo"		=>	$CellphoneNo,
					"OtherContactNo"	=> 	$OtherContactNo,
					"FaxNo"				=>	$FaxNo,
					"PhysicalAddress"	=> 	$PhysicalAddress,
					"PostalAddress"		=> 	$PhysicalAddress,
					"InsuranceCustomer"	=>  $InsuranceCustomer,
					"AcceptTermsAndConditions" => 1,
					"CustomerVehicleList" => $vehicle_object,
				);
				
				$this->log->logIt($this->module . "-" . "guest_user:request:".json_encode($CustomerModel));
				
				$response = $this->customerservices->fn_CustomerCreate($CustomerModel);
				
				$this->log->logIt(array($response));
				
				if( array_key_exists('faultstring',$response) ){
					$response_array['resultStatus'] = resultConstant::Warning;
					$response_array['resultData']['message'] = $response->faultstring;
				}
				else if(array_key_exists('CustomerCreateResult',$response)){
					$_SESSION['Front']['isGuest'] = True;
					$_SESSION['Front']['CustomerCreateResult'] = $response->CustomerCreateResult;
					$redirect_str = "";
					if( isset( $_SESSION['Front']['personal_details']) ){
						$redirect_str = "car-insurance-quote?action=personal_details";
					}
					$response_array['resultData']['redirect'] = $redirect_str;
					$response_array['resultStatus'] = resultConstant::Success;
					$response_array['resultData']['message'] = "Guest Account is Crated";
					
					$this->service_util->refresh_customer_data();
					
				}
				
				$this->log->logIt($this->module . "-" . "guest_user:response:".json_encode($response_array));
				
				print_r(json_encode($response_array));
				
				exit(0);
				
		}
		catch (Exception $e) {
			$this->log->logIt($this->module . "-" . "create_customer" . "-" . $e);
		}
	}
	
	public function update_customer( $is_return = "" ){
		try {
			
			$this->log->logIt("update_customer");
			
			#if($_SESSION['Front']['customer_info_obj']->CustomerID != "" && $_SESSION['token'] != ""){
			if($_SESSION['Front']['customer_info_obj']->CustomerID != "" ){
				
				#$this->log->logIt(json_encode($_SESSION['Front']['personal_details']));
				
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
				
				 
				$CellphoneNo = $OtherContactNo = $FaxNo = "";
				$EmploymentStatus = $Gender = $MaritalStatus = "";
				$phy_add_line1 = $phy_add_line2=$phy_add_line3=$phy_post_code="";
				$pos_add_line1=$pos_add_line2=$pos_add_line3=$pos_post_code="";
				$personal_address_id = $driver_address_id = "";
				 
				if( isset($_SESSION['Front']['personal_details']) ){
				$CellphoneNo		= $_SESSION['Front']['personal_details']['person_mobile'];
				$OtherContactNo		= $_SESSION['Front']['personal_details']['person_telephone'];
				$FaxNo				= $_SESSION['Front']['personal_details']['person_fax'];
				
				$EmploymentStatus 	= $_SESSION['Front']['personal_details']['person_employment_status'];
				$Gender				= $_SESSION['Front']['personal_details']['person_gender'];
				$MaritalStatus		= $_SESSION['Front']['personal_details']['person_marital_status'];
				
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
				
				}
				
				if( isset($_SESSION['Front']['personal_details']['person_dob']) ){
					$person_dob = date('Y-m-d',strtotime($_SESSION['Front']['personal_details']['person_dob']));
					$BirthDate = $person_dob;
				}
				if( isset($_SESSION['Front']['personal_details']['person_email']) ){
					$Email = $_SESSION['Front']['personal_details']['person_email'];
				}
				
				if( isset($_SESSION['Front']['personal_details']['person_mobile']) ){
					$CellphoneNo = $_SESSION['Front']['personal_details']['person_mobile'];
				}
				
				if( isset($_SESSION['Front']['personal_details']['person_telephone']) ){
					$OtherContactNo = $_SESSION['Front']['personal_details']['person_telephone'];
				}
				if( isset($_SESSION['Front']['personal_details']['identity_number']) ){
					if( $_SESSION['Front']['personal_details']['identity_number'] != "" ){
						$IdentificationNo = $_SESSION['Front']['personal_details']['identity_number'];
					}
				}
				if( isset($_SESSION['Front']['personal_details']['passport_number']) ){
					if( $_SESSION['Front']['personal_details']['passport_number'] != ""){
						$PassportNo = $_SESSION['Front']['personal_details']['passport_number'];
					}
				}
				if( isset($_SESSION['Front']['personal_details']['person_title']) ){
					if( $_SESSION['Front']['personal_details']['person_title'] != "" ){
						$Title = $_SESSION['Front']['personal_details']['person_title'];
					}
				}
				if( isset($_SESSION['Front']['personal_details']['person_name']) ){
					if( $_SESSION['Front']['personal_details']['person_name'] != "" ){
						$FirstName = $_SESSION['Front']['personal_details']['person_name'];
					}
				}
				if( isset($_SESSION['Front']['personal_details']['person_surname']) ){
					if( $_SESSION['Front']['personal_details']['person_surname'] != "" ){
						$SurName = $_SESSION['Front']['personal_details']['person_surname'];
					}
				}
				
				
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
				
				$InsuranceCustomer = array(
					//"AccessControl" => "",
                  //  "AreaType" => "",
                    "EmploymentStatus" => $EmploymentStatus,
                    "Gender" => $Gender,
                   // "LicenseDate" => "",
                   // "LicenseType" => "",
                    "MaritalStatus" =>  $MaritalStatus,
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
					"PostalAddress"		=> 	$PhysicalAddress,
					"InsuranceCustomer"	=>  $InsuranceCustomer,
				);
				
				if( array_key_exists('token',$_SESSION) ){
					$this->customerservices->token = $_SESSION['token'];
				}
				else{
					$this->customerservices->token = NULL;
				}
				$response = $this->customerservices->fn_CustomerUpdate($CustomerModel);
				$this->log->logIt("update_customer:model:".json_encode($CustomerModel));
				$this->log->logIt("update_customer:response:".json_encode($response));
				
				if( $response['resultStatus'] == "Success"){
					$this->log->logIt("Successfully updated ");
					$_SESSION['Front']['customer_info_obj']  = $response['resultData']->CustomerUpdateResult;
				}
				
				$response_array = array();
				$response_array['resultStatus'] = resultConstant::Success;
				
				if($is_return == 1){
					return $response_array;
				}
				else{
					print_r( json_encode($response_array) );
					exit(0);	
				}
				
			
			}
			 
			
		}
		catch (Exception $e) {
			echo $e;
			$this->log->logIt($this->module . "-" . "get_userinfo_session" . "-" . $e);
		}
		
	}
	
	public function get_address(){
		try {
			
			if( isset($_REQUEST['q']) &&  $_REQUEST['q'] != "" && isset($_REQUEST['w']) &&  $_REQUEST['w'] != ""){
				
			$search_term  = $_REQUEST['q'];
        
			$search_style = $_REQUEST['w'];
		
			#$search_term = $_REQUEST['search'];
			$response_array = array();
			$json_str = '';
			#$container_type = $_REQUEST['container_type'];
			
			if($search_style == "suburb"){
				$url = '/pinkelephant/PostCodeDataService.svc/PostCodeData?$filter=substringof(%27Street%27,PostCodeStyle)%20and%20substringof(%27' . strtoupper($search_term) .'%27,Suburb)&$skip=0&$format=json';	
			}
			else{
				$url = '/pinkelephant/PostCodeDataService.svc/PostCodeData?$filter=substringof(%27Postal%27,PostCodeStyle)%20and%20substringof(%27' . strtoupper($search_term) .'%27,Code)&$skip=0&$format=json';
			}
			
			
			$json_data = $this->data_curl->json_request($url, '');
			
			#$json_data = exec("php /var/www/vhosts/maven.me/motorhappy.maven.me/test_call.php $url");
			
			#echo "-".$json_data;
			
			$address_data = json_decode($json_data);
			
			$final_refined_array = array();
        
			if($search_style == "suburb"){
				for($i=0; $i < count($address_data->value); $i++){
		
					if( $address_data->value[$i]->City != "-"){
						$tmp_array = array();
						$tmp_array["Name"] = $address_data->value[$i]->ID.",".$address_data->value[$i]->Name;
						$tmp_array["label"] = $address_data->value[$i]->Suburb;
						$tmp_array["Suburb"] = $address_data->value[$i]->Suburb;
						$tmp_array["ID"] = $address_data->value[$i]->ID;
						$tmp_array["City"] = $address_data->value[$i]->City;
						$tmp_array["Code"] = $address_data->value[$i]->Code;
						
						$final_refined_array[] = $tmp_array;
					}
				}
			}
			else if($search_style == "postal_code"){
				for($i=0; $i < count($address_data->value); $i++){
					if( $address_data->value[$i]->City != "-"){
						$tmp_array = array();
						$tmp_array["label"] = $address_data->value[$i]->Code;
						$tmp_array["Name"] = $address_data->value[$i]->ID.",".$address_data->value[$i]->Name;
						$tmp_array["Suburb"] = $address_data->value[$i]->Suburb;
						$tmp_array["ID"] = $address_data->value[$i]->ID;
						$tmp_array["City"] = $address_data->value[$i]->City;
						$tmp_array["Code"] = $address_data->value[$i]->Code;
						
						$final_refined_array[] = $tmp_array;
					}
				}
			}
			$response_array['resultStatus'] = "Success";
			$response_array['resultData'] 	= $final_refined_array;
			
			print_r( json_encode($response_array) );
			}
			exit(0);	
			
		}
		catch (Exception $e) {
			$this->log->logIt($this->module . "-" . "get_address" . "-" . $e);
		}
		
	}
	public function vehicle_data(){
		
		try{
			
			if( isset($_REQUEST['ty']) && isset($_REQUEST['yr'])){
		
				if( $_REQUEST['ty'] == "make" &&  $_REQUEST['ty'] != "" ){
					$year = $_REQUEST['yr'];
					$url = '/ProductCatelog/VehicleDataService.svc/GetVehicleMake?vehicleYear='.$year.'&$orderby=Name&$format=json';
				}
				elseif( $_REQUEST['ty'] == "model" && isset($_REQUEST['yr']) && isset($_REQUEST['mk'])  ){
					
					if( $_REQUEST['yr'] != "" && $_REQUEST['mk'] != ""){
						$year = $_REQUEST['yr'];
						$make = $_REQUEST['mk'];
						$url='/ProductCatelog/VehicleDataService.svc/GetVehicleModel?vehicleYear='.$year.'&vehicleMake='.$make.'&$orderby=Name&$format=json';
					}
					
					#echo "model";
				}
				elseif( $_REQUEST['ty'] == "series" && isset($_REQUEST['yr']) && isset($_REQUEST['mk']) && isset($_REQUEST['mo']) ){
					if( $_REQUEST['yr'] != "" && $_REQUEST['mk'] != "" &&  $_REQUEST['mo'] != ""){
						$year = $_REQUEST['yr'];
						$make = $_REQUEST['mk'];
						$model = $_REQUEST['mo'];
						$url = '/ProductCatelog/VehicleDataService.svc/GetVehicleSeries?vehicleYear='.$year.'&vehicleMake='.$make.'&vehicleModel='.$model.'&$orderby=Name&$format=json';
					}
				}
				elseif( $_REQUEST['ty'] == "mileage" && isset($_REQUEST['yr']) && isset($_REQUEST['sr']) ){
					if( $_REQUEST['yr'] != "" && $_REQUEST['sr'] != "" ){
						$year = $_REQUEST['yr'];
						$series = $_REQUEST['sr'];
						$url = '/ProductCatelog/ProductDataService.svc/GetProductMileage?vehicleYear='.$year.'&currentKm=0&vehicleSeries='.$series.'&planType=-1&$orderby=Mileage&$format=json';
					}
				}
				if( $url != "" ){
					
					$response_array = array();
					
					#$url = urlencode($url);
					#$result_json_data = exec("php /srv/www/htdocs/staging.motorhappy.co.za/telesure/test_call.php $url");
					
					$result_json_data = $this->data_curl->json_request($url, '');
			
					$response_json_data = '{"resultStatus":"Success","resultData":'.$result_json_data.',"url":"'.$url.'"}';
					
					echo $response_json_data;
					
					exit(0);
					
					
				}
				
					
			}
			exit(0);
		}
		catch(Exception $e){
			$this->log->logIt($this->module . "-" . "vehicle_data" . "-" . $e);
		}
	}
	
	
}
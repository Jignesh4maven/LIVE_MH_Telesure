<?php
require_once(BASE_PATH."/Util/util.php");
require_once(BASE_PATH."/Util/Services/customerservices.php");
require_once(BASE_PATH."/Util/Services/data_curl.php");
require_once(BASE_PATH."/Util/Services/service_util.php");
require_once(BASE_PATH."/Dbaccess/commondao.php");
require_once(BASE_PATH."/Dbaccess/servicedao.php");
require_once(BASE_PATH."/Util/Services/quoteservice.php");


class results{
	private $module = 'results';
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
	
	/*
	 * Notice : If you are modifying / adding any code in this function please add an entry in "change_log.txt" file
	 * 			located at "/Docs"
	 */
	public function load_data(){
		$this->log->logIt($this->module . "-" . "load_data");
		$data_array = array();
		$error_array = array();
		$result = new resultobject();
		$response_array = array();
		try{
			
			$error_array = array();
			
			$insurance_customer_vehicle_id = "";
			
			$registration_number = "";
			
			if(	isset($_SESSION['Front']['vehicle_details']['registration_number']) ){
				
				$registration_number = $_SESSION['Front']['vehicle_details']['registration_number'];
			}
			
			if(	isset($_SESSION['Front']['storage_details']['insurance_customer_vehicle_id']) ){
				
				$insurance_customer_vehicle_id = $_SESSION['Front']['storage_details']['insurance_customer_vehicle_id'];
			}
			
			$vehicle_result = $this->service_util->fetch_vehicle_from_session($registration_number);
			
			$vehicle_details = array();
			
			$this->log->logIt( json_encode($vehicle_result) );
			
			$car_description = "";
			
			$deal_message = "";
			
			$final_array = array();
			
			if( $vehicle_result->resultStatus == "Success" ){
				
				$vehicle_details = $vehicle_result->resultData;
				
				$_SESSION['Front']['requested_vehicle'] = $vehicle_details;
				
				$vehicleModelData = $vehicle_details["InsuranceCustomerVehicle"];
				
				$this->log->logIt( "vehicleModelData:".json_encode($vehicleModelData) );
				
				$insurance_customer_vehicle_id = $vehicleModelData->InsuranceCustomeVehicleID;
				
				$wind_screen_cover 	= (!empty($vehicleModelData)) ? $vehicleModelData->WindscreenCover : 'N';
				
				$hail_cover 		= (!empty($vehicleModelData)) ? $vehicleModelData->HailCover : 'N';
				
				$public_liability 	= (!empty($vehicleModelData)) ? $vehicleModelData->PublicLiability : 'N';
				
				$vehicle_financed 	= (!empty($vehicleModelData)) ? $vehicleModelData->VehicleFinanced : 'false';
				
				//Quote submission
				$insuranceQuoteRequest = array(
				'InsuranceCustomerVehicleId'	=> $insurance_customer_vehicle_id,
				'ExpressQuote'		 => 1,
				'IncludeMotorSasria' => 1,
				);
				
				$this->log->logIt($this->module . "-" . "Quote_request:".json_encode($insuranceQuoteRequest));
				
				$quote_result 	= $this->quoteservice->fn_InsuranceQuoteSubmission($insuranceQuoteRequest);
				
				$this->log->logIt($this->module . "-" . "Quote_result:".json_encode($quote_result));
								 
				if( isset($quote_result->faultstring) && $quote_result->faultstring != ""){
					
					$response_array["resultStatus"]			= resultConstant::Warning;
					$response_array["carDescription"]			= "-";
					$response_array["resultData"]["list"]	    = array();
					$response_array["resultData"]["error_message"]  = $quote_result->faultstring;
					
					echo json_encode($response_array);
					exit(0);
				}
				
				$insuranceData = $quote_result->InsuranceQuoteSubmissionResult->InsuranceQuotes->InsuranceQuoteModel;
				
				//insurance company list
				$companies_array =  $this->commondao->get_data_service_json('InsuranceCalculationCompanies');
				
				$this->log->logIt($this->module . "-" . "InsuranceCalculationCompanies-");
				
				$this->log->logIt( $companies_array );
				
				$companies_data = json_decode($companies_array);
				
				//$this->log->logIt(array($companies_data));
								
				$insurance_company_list = array();
				
				for($i=0; $i < count($companies_data->value); $i++){
	
					$tmp_array = array();
					
					$tmp_array["InsuranceCalculationCompanyId"] = $companies_data->value[$i]->InsuranceCalculationCompanyId;
					
					$tmp_array["InsuranceCompanyName"] 			= $companies_data->value[$i]->InsuranceCompanyName;
					
					$insurance_company_list[$companies_data->value[$i]->InsuranceCalculationCompanyId] = $tmp_array;
				}
				
				$this->log->logIt(array($insurance_company_list));
				
				$_SESSION['Front']['InsuranceCompanies'] = $insurance_company_list;
				$car_make 	= $vehicle_details['MakeDesc'];
				$car_model 	= $vehicle_details['ModelDesc'];
				$car_series = $vehicle_details['SeriesDesc'];
				$reg_year	= $vehicle_details['Year'];
				$car_description = $car_make." ".$car_model." ".$car_series." ".$reg_year;
				
				$error_in_quotes = array();
				$received_leads = array();
				foreach($insuranceData as $data){
					$received_leads[$data->InsuranceCalculationCompanyId]  = $data;
					$result_array['LeadId'] 				= $data->InsuranceCustomerLeadId;
					$result_array['QuoteId'] 				= $data->InsuranceQuoteId;
					$result_array['CompanyId'] 				= $data->InsuranceCalculationCompanyId;
					$result_array['InsuranceCustomerVehicleId'] = $data->InsuranceCustomerVehicleId;
					$result_array['CustomerVehicleId'] = $vehicle_details["CustomerVehicleID"];
					$result_array['Insure'] 				= $insurance_company_list[$data->InsuranceCalculationCompanyId]['InsuranceCompanyName'];
					$result_array['Premium'] 				= $data->TotalPremium;
					$result_array['Excess'] 				= $data->TotalExcess;
					$result_array['RoadsideAssistance'] 	= "N/A";    //'<i class="s4-check"></i>';
					$result_array['TowingandStorage'] 		= "N/A";//'<i class="s4-check"></i>';
					$result_array['FixedPremiums'] 			= 'N/A';//'<i class="s4-check"></i>';
					$result_array['HailCover'] 			= ($hail_cover == "Y") ? '<i class="s4-check"></i>' : "-";
					$result_array['WidescreenProtection'] 	= ($wind_screen_cover == "Y") ? '<i class="s4-check"></i>' : " - ";
					$result_array['PublicLiability'] 	= ($public_liability == "Y") ? '<i class="s4-check"></i>' : " - ";
					$result_array['VehicleFinanced'] 	= ($vehicle_financed == true) ? '<i class="s4-check"></i>' : " - ";
					
					$result_array['ButtonText'] 			= 'Select and Proceed';
					$result_array['ErrorDescriptions'] 		= $data->ErrorDescriptions;
					$result_array['ErrorStatus'] 			= $data->ErrorStatus;
					
					if( $data->ErrorStatus == "E" ){
						array_push($error_in_quotes,$data->ErrorDescriptions);
					}
					
					$final_array[] = $result_array;
				}
				
				//$this->log->logIt("res_array".json_encode($result_array));
				
				$_SESSION['Front']['received_leads'] = $received_leads;
				
				$_SESSION['Front']['car_description'] = $car_description;
				
				//$this->log->logIt("--------1------------");
				
				$almost_done_text = "";
				if( isset($_SESSION['Front']['personal_details']) ){
					$display_user_name  = $_SESSION['Front']['personal_details']['person_name']." ".$_SESSION['Front']['personal_details']['person_surname'];
					$almost_done_text = $display_user_name.", we've ".count($insuranceData)." insurance quote today.Simply select the deal for you.";
				}
				//$this->log->logIt("--------2------------");
				
				//$this->log->logIt( array($result) );
				//$this->log->logIt("--------3------------".count($error_in_quotes) );
				
				if( count($error_in_quotes) <= 0){
					$response_array["resultStatus"]			= resultConstant::Success;
					$response_array["carDescription"]		= $car_description;
					$response_array["almostDone"]				= $almost_done_text;
					$response_array["resultData"]["list"]	    = $final_array;
				}
				else{
					$response_array["resultStatus"]			= resultConstant::Warning;
					$response_array["carDescription"]			= $car_description;
					$response_array["resultData"]["list"]	    = $final_array;
					$response_array["resultData"]["error_message"]  = $error_in_quotes;
				}
				
				//$this->log->logIt( "result:2:".json_encode($response_array) );
			}
			else{
				
				$response_array["resultStatus"]			= resultConstant::Error;
				$response_array["carDescription"]			= $car_description;
				$response_array["resultData"]["list"]	    = $final_array;
			}
			
			//$this->log->logIt( "result:3:".json_encode($response_array) );
			
			$this->log->logIt("response:". json_encode($response_array) );
			
			print_r( json_encode($response_array) );
			exit(0);
		}
		catch (Exception $e) {
			echo $e;
			$this->log->logIt($this->module . "-" . "load_data" . "-" . $e);
		}
	}
	
	public function callme_back(){
		
		$this->log->logIt($this->module . "-" . "callme_back");
		
		try{
			
			$customer_vehicle_id  = $_POST['vehicle_id'];
			
			$InsuranceCallMeSubmissionRequestModel = array(
				"CustomerVehicleId" 	=> $customer_vehicle_id,
			);
			
			$callme_back_result 	= $this->quoteservice->fn_InsuranceCallMeSubmission($InsuranceCallMeSubmissionRequestModel);
			
			$result = new resultobject();
			$result->resultStatus			= resultConstant::Success;
			$result->resultData    			= $callme_back_result;
				
			echo json_encode($result);
			
			exit(0);
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module . "-" . "callme_back" . "-" . $e);
		}
	}
	
	public function callme_nold(){
		
		$this->log->logIt($this->module . "-" . "callme_nold");
		
		try{
			
 
			$result = new resultobject();
			
			$name = $surname = $email = $contact = $customer_id = $vehicle_desc = $vehicle_year = "";
			
			$error_array = array();
			
			if(isset($_POST['name']) && $_POST['name'] != ""){
				$name = $_POST['name'];
			}
			else{
				if( $_SESSION['Front'] ){
					if($_SESSION['Front']['personal_details']){
						$name = $_SESSION['Front']['personal_details']['person_name'];
					}
				}
				
			}
			
			if(isset($_POST['surname']) && $_POST['surname'] != ""){
				$surname = $_POST['surname'];
			}
			else{
				if( $_SESSION['Front'] ){
					if($_SESSION['Front']['personal_details']){
						$surname = $_SESSION['Front']['personal_details']['person_surname'];
					}
				}
				
			}
			
			if(isset($_POST['email']) && $_POST['email'] != ""){
				$email = $_POST['email'];
			}
			else{
				if( $_SESSION['Front'] ){
					if($_SESSION['Front']['personal_details']){
						$email = $_SESSION['Front']['personal_details']["person_email"];
					}
				}
				
			}
			
			if(isset($_POST['contact']) && $_POST['contact'] != ""){
				$contact = $_POST['contact'];
			}
			else{
				if( $_SESSION['Front'] ){
					if($_SESSION['Front']['personal_details']){
						$contact = $_SESSION['Front']['personal_details']['person_mobile'];
					}
				}
				
			}
			
			if(isset($_POST['customer_id'])){
				$customer_id = $_POST['customer_id'];
			}
			else{
				if( $_SESSION['Front'] ){
					if($_SESSION['Front']['personal_details']){
						$customer_id = $_SESSION['Front']['personal_details']['customer_id'];
					}
				}
			}
			
			if(isset($_POST['year'])){
				$vehicle_year = trim($_POST['year']);
			}
			else{
				if( $_SESSION['Front'] ){
					if( isset($_SESSION['Front']['vehicle_details']) ){
						$vehicle_year = $_SESSION['Front']['vehicle_details']['year_of_registration'];
					}
				}
				
			}
			
			if(isset($_POST['desc'])){
				$vehicle_desc = trim($_POST['desc']);
			}
			else{
				if( $_SESSION['Front'] ){
					if($_SESSION['Front']['vehicle_details']){
						$vehicle_desc = $_SESSION['Front']['vehicle_details']['vehicle_info'];
					}
				}
				
			}
			
	 
			//Required parameterters
			if ( !$this->util->mandatoryField($name)) {
				$error_array["FirstName"]	= "First name is required";
			}
			if ( !$this->util->mandatoryField($surname)) {
				$error_array["Surname"]	= "Surname is required";
			}
			if ( !$this->util->mandatoryField($contact)) {
				$error_array["ContactNumber"]	= "Contact number is required";
			}
			if ( !$this->util->mandatoryField($vehicle_desc)) {
				$error_array["VehicleDescriptionForInsurance"]	= "Vehicle description is required";
			}
			if ( !$this->util->mandatoryField($vehicle_year)) {
				$error_array["VehicleYearForInsurance"]	= "Year is required";
			}
			
			if ( empty($error_array) ) {
			
				$InsuranceCallMeNoIdModel = array(
					"FirstName" 						=> $name,
					"Surname" 							=> $surname,
					"ContactNumber" 					=> $contact,
					"VehicleDescriptionForInsurance" 	=> $vehicle_desc,
					"VehicleYearForInsurance" 			=> $vehicle_year,
				);
				
				//Optional parameterters
				if ( $this->util->mandatoryField($customer_id) ) {
					$InsuranceCallMeNoIdModel["CustomerId"]	= $customer_id;
				}
				
				if ( $this->util->mandatoryField($email) ) {
					$InsuranceCallMeNoIdModel["EmailAddress"]	= $email;
				}
				
				$this->log->logIt("callme_nold->fn_InsuranceCallMeNoIdSubmission");
				$this->log->logIt(array($InsuranceCallMeNoIdModel));
				
				$callme_back_result 	= $this->quoteservice->fn_InsuranceCallMeNoIdSubmission($InsuranceCallMeNoIdModel);
				$this->log->logIt(json_encode($callme_back_result));
				
				if( isset($callme_back_result->InsuranceCallMeNoIdSubmissionResult) ){
					
					if( $callme_back_result->InsuranceCallMeNoIdSubmissionResult->ErrorStatus == "E" ){
						$result->resultStatus			= resultConstant::Warning;
						$result->resultData["result"]	    = $callme_back_result->InsuranceCallMeNoIdSubmissionResult;
						$result->resultData["error_message"]  = $callme_back_result->InsuranceCallMeNoIdSubmissionResult->ErrorDescriptions;
					}
					else{
						$result->resultStatus			= resultConstant::Success;
						$result->resultData	    = $callme_back_result;
					}
				}
				else{
					$result->resultStatus			= resultConstant::Error;
					$result->resultData["error_message"]  = "Error while requesting";
				}
			}
			else{
				$result->resultStatus			= resultConstant::Warning;
				$result->resultData["result"]	    = $error_array;
				$result->resultData["error_message"]  = "Validation Error";
			}
			echo json_encode($result);
			
			exit(0);
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module . "-" . "callme_back" . "-" . $e);
		}
	}
	
	public function submit_lead(){
		
		$this->log->logIt($this->module . "-" . "callme_back");
		
		try{
			
			$insurance_lead_id   = $_POST['lead_id'];
			$insurance_quote_id  = $_POST['quote_id'];
			
			$InsuranceLeadSubmissionRequestModel = array(
				"InsuranceCustomerLeadId" 	=> $insurance_lead_id,
				"InsuranceQuoteId" 	=> $insurance_quote_id,
			);
			
			if( array_key_exists('token',$_SESSION) ){
				$this->quoteservice->token  = $_SESSION['token'];
			}
			else{
				$this->quoteservice->token = NULL;
			}
			$submit_lead_result 	= $this->quoteservice->fn_InsuranceLeadSubmission($InsuranceLeadSubmissionRequestModel);
			
			$result = new resultobject();
			$result->resultStatus			= resultConstant::Success;
			$result->resultData    			= $submit_lead_result;
				
			echo json_encode($result);
			
			exit(0);
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module . "-" . "callme_back" . "-" . $e);
		}
	}
	
	public function select_quote(){
		
		$this->log->logIt($this->module . "-" . "vehicle_storage_result");
		
		$result = new resultobject();
		
		try{
			
			if( isset($_REQUEST['company_id']) ){
				
				if( $_REQUEST['company_id'] != ""){
					
					$_SESSION['Front']['selected_quote_company'] = $_REQUEST['company_id'];
					$company_id = $_REQUEST['company_id'];
					$result->resultData	= $_SESSION['Front']['received_leads'][$company_id];
					
				}
			}
			else{
				
				if( isset($_SESSION['Front']['selected_quote_company'] ) ){
					$company_id = $_SESSION['Front']['selected_quote_company'];
					$_SESSION['Front']['received_leads'][$company_id];
					$result->resultData	= $_SESSION['Front']['received_leads'][$company_id];
				}
				
			}
			
			$result->resultStatus			= resultConstant::Success;
			
			echo json_encode($result);
			
			exit(0);
			
			
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module . "-" . "select_quote" . "-" . $e);
		}
		
	}
	
	public function get_last_step_data(){
		try{
			$response_array=array();
			
			$response_array['resultStatus'] = resultConstant::Success;
			$response_array['resultData'] = $response_array;
			
			#cover type
			$cover_type_str 	= $this->commondao->get_data_service_json('CoverTypeItems');
			$response_array['CoverTypeItems']= $cover_type_str;
			
			
			#yes no indecator
			$static = new staticarray();
			$yesno =  json_encode( $static::$YesNoIndicator ) ;
			$response_array['YsNo'] = $yesno;
			
			#insured value type
			$insured_type_str 	= $this->commondao->get_data_service_json('MotorInsuredItems');
			//$insured_type		= json_decode($insured_type_str);
			$response_array['MotorInsuredItems']=$insured_type_str;
			
			#insured value type
			$car_hire_options_str 	= $this->commondao->get_data_service_json('CarHireOptions');
			//$car_hire_options		= json_decode($car_hire_options_str);
			$response_array['CarHireOptions']=$car_hire_options_str;
			
			#insured value type
			$sound_insured_str 	= $this->commondao->get_data_service_json('SoundSystemInsuredValues');
			//$sound_insured		= json_decode($sound_insured_str);
			$response_array['SoundSystemInsuredValues']=$sound_insured_str;
			
			
			#insured value type
			$saver_accident_cover_str 	= $this->commondao->get_data_service_json('SaverAccidentCoverOptions');
			$response_array['SaverAccidentCoverOptions'] = $saver_accident_cover_str;
			
			if( isset($_SESSION['Front']['selected_quote_company'] ) ){
				$company_id = $_SESSION['Front']['selected_quote_company'];
				$_SESSION['Front']['received_leads'][$company_id];
				$response_array['selected_company']	= $_SESSION['Front']['received_leads'][$company_id];
				$response_array['selected_company_info'] = $_SESSION['Front']['InsuranceCompanies'][$company_id];
			}
			
			$response_array['requested_vehicle'] = $_SESSION['Front']['requested_vehicle'];
			
			$this->log->logIt($this->module . " Gender-----");
			
			$data_obj = $_SESSION['Front']['requested_vehicle'];
			
			$driver_employment_status =  $data_obj["InsuranceCustomerVehicle"]->DriverEmploymentStatus;
			
			$this->log->logIt( $data_obj["InsuranceCustomerVehicle"]->DriverGender );
			
			#insured value type
			if($driver_employment_status == "E"){
				$voluntary_access_items_str 	= $this->commondao->get_data_service_json('VoluntaryExcessItems-E');
			}
			elseif($driver_employment_status == "C"){
				$voluntary_access_items_str 	= $this->commondao->get_data_service_json('VoluntaryExcessItems-C');
			}
			elseif($driver_employment_status == "F"){
				$voluntary_access_items_str 	= $this->commondao->get_data_service_json('VoluntaryExcessItems-F');
			}
			elseif($driver_employment_status == "H"){
				$voluntary_access_items_str 	= $this->commondao->get_data_service_json('VoluntaryExcessItems-h');
			}
			elseif($driver_employment_status == "N"){
				$voluntary_access_items_str 	= $this->commondao->get_data_service_json('VoluntaryExcessItems-N');
			}
			elseif($driver_employment_status == "R"){
				$voluntary_access_items_str 	= $this->commondao->get_data_service_json('VoluntaryExcessItems-R');
			}
			elseif($driver_employment_status == "U"){
				$voluntary_access_items_str 	= $this->commondao->get_data_service_json('VoluntaryExcessItems-U');
			}
			$response_array['VoluntaryExcessItems'] = $voluntary_access_items_str;
			
			$response_array['car_description'] = $_SESSION['Front']['car_description'];
			
			echo json_encode($response_array);
			exit(0);
			
		}
		catch(Exception $e){
			echo $e;
		}
		 
		
	}
	
	public function refine_quote(){
		
		try{
			
			$insurance_customer_vehicle_id  = "";
					
			if(	isset($_SESSION['Front']['storage_details']['insurance_customer_vehicle_id']) ){
		
				$insurance_customer_vehicle_id = $_SESSION['Front']['storage_details']['insurance_customer_vehicle_id'];
			}
			
			$this->log->logIt("refine quote insurance_customer_vehicle_id:".$insurance_customer_vehicle_id );		
			
			if( $this->util->mandatoryField($insurance_customer_vehicle_id) ){
			 
				$covertype 	= $_POST['covertype'];
				$thirdpartyliability = $_POST['thirdpartyliability'];
				$insuredvaluetype = $_POST['insuredvaluetype'];
				$excess = $_POST['excess'];
				$hailcover = $_POST['hailcover'];
				$windscreencover = $_POST['windscreencover'];
				$assistcover = $_POST['assistcover'];
				$carhire = $_POST['carhire'];
				$carhireoption = $_POST['carhireoption'];
				$radiocover = $_POST['radiocover'];
				$radiocoveroption = $_POST['radiocoveroption'];
				$canopycover = $_POST['canopycover'];
				$voluntaryexcess = $_POST['voluntaryexcess'];
				$holderdob = $_POST['holderdob'];
				$theftexcessbuster = $_POST['theftexcessbuster'];
				$accidentcover = $_POST['accidentcover'];
				$accidentcoveroption = $_POST['accidentcoveroption'];
				$totalloss = $_POST['totalloss'];
				$publicliability = $_POST['publicliability'];
				
				
							
				if( $this->util->mandatoryField($covertype) ){
					$_SESSION['Front']['storage_details']['cover_type'] = $covertype;
				}
				
				/***/
				if( $this->util->mandatoryField($thirdpartyliability) ){
					$_SESSION['Front']['storage_details']['thirdpartyliability'] = $thirdpartyliability;
				}
				
				if( $this->util->mandatoryField($accidentcoveroption) ){
					$_SESSION['Front']['storage_details']['saver_accident_option'] = $accidentcoveroption;
				}
				
				//if( $this->util->mandatoryField($excess) ){
				//	$_SESSION['Front']['storage_details']['voluntary_excess'] = $excess;
				//}
				
				if( $this->util->mandatoryField($hailcover) ){
					$_SESSION['Front']['storage_details']['hail_cover'] = $hailcover;
				}
				
				if( $this->util->mandatoryField($windscreencover) ){
					$_SESSION['Front']['storage_details']['windscreen_cover'] = $windscreencover;
				}
				
				/***/
				if( $this->util->mandatoryField($assistcover) ){
					$_SESSION['Front']['storage_details']['assist_cover'] = $assistcover;
				}
				
				if( $this->util->mandatoryField($carhire) ){
					$_SESSION['Front']['storage_details']['car_hire_included'] = $carhire;
				}
				
				if( $this->util->mandatoryField($carhireoption) ){
					$_SESSION['Front']['storage_details']['car_hire_option'] = $carhireoption;
				}
				
				if( $this->util->mandatoryField($radiocover) ){
					$_SESSION['Front']['storage_details']['radio_cover'] = $radiocover;
				}
				if( $this->util->mandatoryField($radiocoveroption) ){
					$_SESSION['Front']['storage_details']['radio_cover_value'] = $radiocoveroption;
				}
				if( $this->util->mandatoryField($canopycover) ){
					$_SESSION['Front']['storage_details']['canopy_included'] = $canopycover;
				}
				if( $this->util->mandatoryField($voluntaryexcess) ){
					$_SESSION['Front']['storage_details']['voluntary_excess'] = $voluntaryexcess;
				}
				if( $this->util->mandatoryField($holderdob) ){
					$_SESSION['Front']['personal_details']['driver_dob'] = $holderdob;
				}
				if( $this->util->mandatoryField($theftexcessbuster) ){
					$_SESSION['Front']['storage_details']['theft_access_include'] = $theftexcessbuster;
				}
				/***/
				if( $this->util->mandatoryField($accidentcover) ){
					$_SESSION['Front']['storage_details']['accident_cover'] = $accidentcover;
				}
				/***/
				if( $this->util->mandatoryField($accidentcoveroption) ){
					$_SESSION['Front']['storage_details']['accident_cover_option'] = $accidentcoveroption;
				}
				/***/
				if( $this->util->mandatoryField($totalloss) ){
					$_SESSION['Front']['storage_details']['total_loss'] = $totalloss;
				}
				/***/
				if( $this->util->mandatoryField($publicliability) ){
					$_SESSION['Front']['storage_details']['public_liability'] = $publicliability;
				}
				
				$result = $this->service_util->update_customer_vehicle($insurance_customer_vehicle_id);
				
				$this->log->logIt("vehicle updated:".json_encode($result) );
				
				if( $result["resultStatus"] != "Success" ) {
					$result = new resultobject();
					$result->resultStatus			= resultConstant::Warning;
					$result->resultData["error_message"]  = "Error while updating Vehicle";
				}
				
				echo json_encode($result);
				exit(0);
				
			}
			else{
				
				exit(0);
			}
			
			
		}
		catch(Exception $e){
			echo $e;
		}
	}
	
	public function insurance_company_quote_submission(){
		
		try{
			$result = new resultobject();
			
			$company_id = $_SESSION['Front']['selected_quote_company'];
					
			$this->log->logIt("Insurance Company:".$company_id);
			
			$this->log->logIt(array($_SESSION['Front']['InsuranceCompanies'][$company_id]));
			
			$insuranceCalculationCompanyModel = $_SESSION['Front']['InsuranceCompanies'][$company_id];
			
			$insurance_customer_vehicle_id = "";
			
			if(	isset($_SESSION['Front']['storage_details']['insurance_customer_vehicle_id']) ){
				
				$insurance_customer_vehicle_id = $_SESSION['Front']['storage_details']['insurance_customer_vehicle_id'];
			}
					
			$insuranceQuoteRequest = array(
					'InsuranceCustomerVehicleId'	=> $insurance_customer_vehicle_id,
					'ExpressQuote'		 => 1,
					'IncludeMotorSasria' => 1,
					'CompanyDetails' => array($insuranceCalculationCompanyModel)
					);
					
			$quote_result 	= $this->quoteservice->fn_InsuranceQuoteSubmission($insuranceQuoteRequest);
			
			$this->log->logIt( array($quote_result) );
			
			if( $quote_result->InsuranceQuoteSubmissionResult->InsuranceQuotes->InsuranceQuoteModel->ErrorStatus == "E" ){
				$result->resultStatus		= resultConstant::Warning;
				$result->resultData["error_message"]  = $quote_result->InsuranceQuoteSubmissionResult->InsuranceQuotes->InsuranceQuoteModel->ErrorDescriptions;
			}
			else{
				$result->resultStatus	= resultConstant::Success;
				$result->resultData	    = $quote_result->InsuranceQuoteSubmissionResult->InsuranceQuotes->InsuranceQuoteModel;
			}
			echo json_encode($result);
			exit(0);
		}
		catch(Exception $e){
			echo $e;
		}
	}
	public function company_logo(){
		 
		try{
			if( isset($_REQUEST['id']) && $_REQUEST['id'] != ""){
				header("Content-Type: image/jpeg");
				$id = $_REQUEST['id'];
				$url = '/PinkElephant/QuoteDataService.svc/InsuranceCalculationCompanyData('.$id.')/InsuranceCompanyPicture';
				$logo = $this->data_curl->make_request($url,'logo_'.$id,'image');
				echo $logo;
			}
			exit(0);
		}
		catch(Exception $e){
			echo $e;
		}
	}
}


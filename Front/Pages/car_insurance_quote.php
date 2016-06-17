<?php
require_once(BASE_PATH."/Util/util.php");
require_once(BASE_PATH."/Util/Services/customerservices.php");
require_once(BASE_PATH."/Util/Services/data_curl.php");
require_once(BASE_PATH."/Util/Services/service_util.php");
require_once(BASE_PATH."/Dbaccess/servicedao.php");
require_once(BASE_PATH."/Dbaccess/commondao.php");
require_once(BASE_PATH."/Util/Services/quoteservice.php");

class car_insurance_quote{
	private $module = 'car_insurance_quote';
	private $log;
	private $util;
	private $securityservices;
	private $step_name = "default";
	private $data_curl;
	private $service_util;
	private $service;

	public function __construct()
	{
		$this->log = new logger();
		$this->util = new util();
		$this->customerservices = new customerservices();
		$this->data_curl = new data_curl();
		$this->service_util = new service_util();
		$this->service = new servicedao();
		$this->quoteservice = new quoteservice();

		
		$this->commondao = new commondao();

		if (isset($_REQUEST['action'])) {

			if ($_REQUEST['action'] != "") {

				$this->step_name = $_REQUEST['action'];
			}
		}

	}

	# @author: Jignesh Rana <mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: Initiate template view on first blog loading
	public function load()	{
		try {
			
			global $tpl;
			
			global $config;

			if(!array_key_exists('Front',$_SESSION) ){
				$this->service_util->refresh_customer_data();
			}
			
			$login_session_data = $this->service_util->get_userinfo_session();
			
			$title_data_str 	= $this->commondao->get_data_service_json('TitleData');
			$title_data			= json_decode($title_data_str);
			
			$marital_status_str 	=  $this->commondao->get_data_service_json('MaritalStatusItems');
			$marital_status_list 	= json_decode($marital_status_str);
			
			$employment_status_str 	=  $this->commondao->get_data_service_json('EmploymentStatusItems');
			$employment_status_list = json_decode($employment_status_str);
			
			$display_user_name = "";
			$user = "";
			if( isset($_SESSION['Front']['user']) ){
				$display_user_name  = $_SESSION['Front']['user'];
				$user =  $_SESSION['Front']['user'];
			}
			elseif(isset($_SESSION['Front']['personal_details']) ){
				$display_user_name  = $_SESSION['Front']['personal_details']['person_name']." ".$_SESSION['Front']['personal_details']['person_surname'];
			}
			
			$personal = array();
			if( isset($_SESSION['Front']['personal_details']) ){
				$personal  = $_SESSION['Front']['personal_details'];
			}
			
			$driver = array();
			if( isset($_SESSION['Front']['driver_details']) ){
				$driver  = $_SESSION['Front']['driver_details'];
			}
			
			$isGuest = 1;
			if( isset($_SESSION['token']) ){
				$isGuest	= 0;
			}
			
		 	
			$tpl->assign(array(
					"T_BODY" 			=> 'car_insurance_quote' . $config['tplEx'],
					"T_FRM_PERSONAL" 	=> 'car_insurace_frm_personal_details' . $config['tplEx'],
					"T_FRM_DETAILS" 	=> 'car_insurace_frm_vehicle_details' . $config['tplEx'],
					"T_FRM_STORAGE" 	=> 'car_insurace_frm_storage_details' . $config['tplEx'],
					"T_FRM_REUSLT" 		=> 'car_insurace_frm_results' . $config['tplEx'],
					"T_FRM_REFINE" 		=> 'car_insurace_frm_refine' . $config['tplEx'],
					"page_name" 		=> 'Car Insurance',
					"step_name" 		=> $this->step_name,
					"title_data" 		=> $title_data->value,
					"marital_status" 	=> $marital_status_list->value,
					"employment_status" => $employment_status_list->value,
					"data" 				=> $login_session_data,
					"personal"			=> $personal,
					"driver"			=> $driver,
					"display_user_name"	=> $display_user_name,
					"isGuest" 			=> $isGuest,
				    //"result"			=> $result,
					"user" =>$user,
				)
			);
			
		}
		catch (Exception $e) {
			echo $e;
			$this->log->logIt($this->module . "-" . "load" . Insurance . $e);
		}
	}	
}
?>
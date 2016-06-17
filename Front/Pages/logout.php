<?php
require_once(BASE_PATH."/Util/util.php");

class logout{

	private $module = 'logout';
	private $log;
	private $util;

	public function __construct(){
		$this->log		= new logger();
		$this->util 	= new util();
	}

	public function load(){
		try{

			$today =  gmdate("Y-m-d\ H:i:s");
			$this->log->logIt($today." ".$this->module."-"."Page Load");
			global $tpl;
			global $config;

			$tpl->assign(array(
							"T_BODY"			=>	'logout'.$config['tplEx'],
							"page_name"			=>  'Logout',
							)
						);
            
            session_unset();
            session_destroy();
            $_SESSION = array();
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."load".Insurance.$e);
		}
	}
	public function clear_session(){
		try{
			session_unset();
            session_destroy();
            $_SESSION = array();
			$response_array['resultData']['redirect'] = "";
			$response_array['resultStatus'] = resultConstant::Success;
			echo json_encode($response_array);
			exit(0);
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."load".Insurance.$e);
		}
	}


}				
?>
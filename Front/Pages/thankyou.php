<?php
require_once(BASE_PATH."/Util/util.php");
class thankyou{
	
	private $module = 'thankyou';
	private $log;
	private $util;
	
	public function __construct(){
		$this->log		= new logger();
		$this->util 	= new util();
	}	

	# @author: Jignesh Rana <mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: Initiate template view on first blog loading
	public function load(){
		try{
			$this->log->logIt($this->module."-"."Page Load");
			global $tpl;
			global $config;
			
			$type = "";
			$msg  = "";
			if (isset($_REQUEST['type'])) {

				if ($_REQUEST['type'] != "") {
	
					$type = $_REQUEST['type'];
				}
			}
			
			if (isset($_REQUEST['msg'])) {

				if ($_REQUEST['msg'] != "") {
	
					$msg = $_REQUEST['msg'];
				}
			}
			
			#destroy session for Guest
			if( $_SESSION['Front']['isGuest'] == 1){
				session_unset();
				session_destroy();
				$_SESSION = array();
			}
				
			$tpl->assign(array(	
								"T_BODY"					=>	'thankyou'.$config['tplEx'],
								"page_name"					=>	'Thank You',
								"Type"						=>	$type,
								"Msg"						=>	$msg
							
							)
						);		
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."load"."-".$e);
		}		
	}	
}				
?>
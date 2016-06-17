<?php
//define("IN_ADMIN", true);
require_once("../Dbaccess/forgotpassworddao.php");
require_once("../Util/util.php");
class forgotpassword 
{
	private $module = 'forgotpassword';
	private $log;	
	private $forgotpassword;
	private $util;
	
	public function __construct(){
		$this->log					=new logger();
		$this->forgotpassworddao 	= new forgotpassworddao();
		$this->util 				= new util();
	    
	
	}	

	public function load(){
		try{
			$this->log->logIt($this->module."-"."Page Load");		
			global $tpl;
			global $config;
			
			
			$tpl->display(COMMON_TMPL_PATH."/forgot_password.tpl");
			 
			 
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."onLoad"."-".$e);
		}		
	}
	
	public function get_data_records(){
		try{
			$this->log->logIt($this->module."-"."get_data_list");
			
			$$result_data="";
				
				if( isset($_POST['userid']) ){
					$_POST['userid'] = $this->util->strip_html_tags( $_POST['userid'] );
					$userid= $this->util->strip_unsafe_tags( $_POST['userid'] );
					
				}
				if( isset($_POST['usermailid']) ){
					$_POST['usermailid'] = $this->util->strip_html_tags( $_POST['usermailid'] );
					$usermailid= $this->util->strip_unsafe_tags( $_POST['usermailid'] );
					
				}
			
			
			$this->forgotpassworddao->userid       = $userid;
			$this->forgotpassworddao->usermailid   = $usermailid;
			
			$result_data 			       			= 	$this->forgotpassworddao->get_records();
			
			//if password in db than update otherwise show error password worng runnig else part
			if($result_data->resultStatus == "Success"){
				$result_list = $result_data->resultData['list'];
				print_r(json_encode($result_data));
				
			}
				
			exit(0);
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."get_data_list"."-".$e);
		}		
	}
}				
?>

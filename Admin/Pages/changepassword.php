<?php
require_once("../Dbaccess/changepassworddao.php");
require_once("../Util/util.php");
class changepassword 
{
	private $module = 'changepassword';
	private $log;	
	private $changepassworddao;
	private $util;
	
	public function __construct(){
		$this->log					=new logger();
		$this->changepassworddao 	= new changepassworddao();
		$this->util 				= new util();
	    
	
	}	

	public function load(){
		try{
			$this->log->logIt($this->module."-"."Page Load");		
			global $tpl;
			global $config;
			$result_data 					= "";
			$result_list 					= "";
			$total_records 					= 0;
			
			
			if($result_data->resultStatus == "Success"){
				$result_list 	= $result_data->resultData['list'];
				
			}
			
			//echo "<pre>";
			//print_r($result_data);
			//echo "</pre>";
			//exit(0);
			$result_json = json_encode ($result_data);
				
			$tpl->assign(array(	
								"T_BODY"			=>	'change_password'.$config['tplEx'],
								"page_name"			=>  'Change Password',
					           // "load_result_json" 	=>	$result_json,
								//"load_result" 		=>	$result_list
								"form_action"		=>  'get_data_records'
								 
							)
						);		
			 
			 
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."onLoad"."-".$e);
		}		
	}
	
	public function get_data_records(){
		try{
			$this->log->logIt($this->module."-"."get_data_list");
			$limit =  5;
			$offset = 0;
			$search_old_pwd = "";
			$parmas = array();
			
			//$this->log->logIt($this->module."-"."search_name"."-".$_POST['partner_search_title']);
			
			
				
				if( isset($_POST['old_password']) ){
					$_POST['old_password'] = $this->util->strip_html_tags( $_POST['old_password'] );
					$search_old_pwd= $this->util->strip_unsafe_tags( $_POST['old_password'] );
					
				}
			
			
			$parmas['offset'] 					=	$offset;
			$parmas['limit'] 					= 	$limit;
			$parmas['search_old_pwd'] 			=	$search_old_pwd;
			$this->changepassworddao->params 	=	$parmas;
			$result_data 			       		= 	$this->changepassworddao->get_records();
			
			//if password in db than update otherwise show error password worng runnig else part
			if($result_data->resultStatus == "Success"){
				$result_list = $result_data->resultData['list'];
				print_r(json_encode($result_data));
				
				
				if( isset($_POST['old_password']) ){
					$_POST['old_password'] = $this->util->strip_html_tags( $_POST['old_password'] );
					$_POST['old_password'] = $this->util->strip_unsafe_tags( $_POST['old_password'] );
				}
				
				if( isset($_POST['new_password']) ){
					$_POST['new_password'] = $this->util->strip_html_tags( $_POST['new_password'] );
					$_POST['new_password'] = $this->util->strip_unsafe_tags( $_POST['new_password'] );
				}
				
				
				$this->changepassworddao->ip				= "1.2.2.14";
				$this->changepassworddao->created_by 		= "test";
				
				$this->changepassworddao->old_password 		= $_POST['old_password'];
				$this->changepassworddao->new_password 		= $_POST['new_password'];
				$this->changepassworddao->modified_by 		= $_SESSION['AdminDetails']['str_nick_name'];
				
				$data_result = $this->changepassworddao->update_record();
			}
			else{
					print_r(json_encode($result_data));
					$data_result->resultStatus == "Warning";
					
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

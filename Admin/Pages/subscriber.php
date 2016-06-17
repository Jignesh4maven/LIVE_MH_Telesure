<?php
require_once(BASE_PATH."/Dbaccess/subscribersdao.php");
require_once(BASE_PATH."/Util/util.php");


class subscriber
{
	private $module = 'subscriber';
	private $log;	
	private $subscriberdao;
	private $util;
	
	public function __construct(){
	
		$this->log				= new logger();
		$this->subscriberdao 	= new subscribersdao();
		$this->util 			= new util();
		
	}	

	public function load(){
		try{
			$this->log->logIt($this->module."-"."Page Load");		
			global $tpl;
			global $config;
			$parmas['limit'] 				= 10;
			$parmas['offset'] 				= 0;
			$this->subscriberdao->params 	= $parmas;
			$this->subscriberdao->limit 	= 10;
			$this->subscriberdao->offset 	= 0;
			$result_data 					= $this->subscriberdao->get_records();
			$result_list 					= "";
			$total_records 					= 0;
			
			
		
			
			if($result_data->resultStatus == "Success"){
				$result_list 	= $result_data->resultData['list'];
				$total_records	= $result_data->resultData['total'];
			}
		
			$result_json = json_encode ($result_data);
			
			$tpl->assign(array(	
								"T_BODY"					=>	'subscriber'.$config['tplEx'],
								"page_name"					=>  'Subscriber',
					            "load_result_json" 			=>	$result_json,
								"load_result" 				=>	$result_list,
								"total_record"				=>  $total_records,
								"form_action"				=>  'get_data_records'
								 
							)
						);		
			 
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."onLoad"."-".$e);
		}		
	}
	
	/* calling insert_form or edit_form */
	public function form_add_edit(){
		try{
			$this->log->logIt($this->module."-"."form_add_edit");
			global $tpl;
			global $config;
			
			$tpl->assign(array(	
								"T_BODY"			=>	'subscriber_add_edit'.$config['tplEx'],
								"blog_name"			=>  'Subscriber Detail',
								
							)
						);
			if( isset($_REQUEST['subscriber_id']) &&  $_REQUEST['subscriber_id'] != ""){
				$this->subscriberdao->subscriber_id =  $_REQUEST['subscriber_id'];
				$result_data = $this->subscriberdao->get_record();
				
				
				
				if( $result_data->resultStatus == "Success" ){
					$tpl->assign(array(	
								
								"data_row"				=>	$result_data->resultData['list'],
								'form_action'			=>	'edit_data',
								
							)
						);
				}
			}
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."form_add_edit"."-".$e);
		}		
	}
	
	
//	/* for Deleteing records  */
	public function delete(){
		 $subscriber_id = $this->util->safeNumber($_REQUEST['id']);
		 if( $subscriber_id != ""){
			$this->subscriberdao->subscriber_id 		= $subscriber_id;
			$data_result = $this->subscriberdao->soft_delete_record();
			if( $data_result->resultStatus == "Success" ){
				$data_result->resultMessage = "Deleted successful.";
				$parmas['offset'] 	= 0;
				$parmas['limit'] 	= 10;
				$this->subscriberdao->params =  $parmas;
				$data_result = $this->subscriberdao->get_records();
			}
			print_r(json_encode($data_result));
		 }
		 exit(0);
	}
	
	
//	/* For edting form data and update  */
		public function edit_data(){
		try{
			$this->log->logIt($this->module."-"."edit_data");

			
			if( isset($_POST['subsciber_name']) ){
				$_POST['subsciber_name'] = $this->util->strip_html_tags( $_POST['subsciber_name'] );
				$subsciber_name = $this->util->strip_unsafe_tags( $_POST['subsciber_name'] );
			}
			
			if( isset($_POST['subsciber_email']) ){
				$_POST['subsciber_email'] = $this->util->strip_html_tags( $_POST['subsciber_email'] );
				$subsciber_email = $this->util->strip_unsafe_tags( $_POST['subsciber_email'] );
			}
			
			$status = "Inactive";
			if( isset($_POST['subsciber_status']) ){
				$_POST['subsciber_status'] = $this->util->strip_html_tags( $_POST['subsciber_status'] );
				$subsciber_status = $this->util->strip_unsafe_tags( $_POST['subsciber_status'] );
				
				if($subsciber_status == 1){
					
					$status="Active";
				}
				else{
					
					$status="Inactive";
				}
				
			}
			
			$subscriber_id = $this->util->safeNumber($_REQUEST['subscriber_id']);
			
			if( $subscriber_id != ""){
				$this->subscriberdao->subscriber_id 	   			= $subscriber_id;
				$this->subscriberdao->subscriber_name				= $subsciber_name;
				$this->subscriberdao->subscriber_email				= $subsciber_email;
				$this->subscriberdao->subscriber_status				= $status;
			
				$this->subscriberdao->modified_by 					= $_SESSION['AdminDetails']['str_nick_name'];
				
				$data_result = $this->subscriberdao->update_record();
			   if( $data_result->resultStatus == "Success" ){
				
				   $data_result->resultMessage = "Update successful.";
				   $data_result->resultAction = "Update";
			   }
			   
			   print_r(json_encode($data_result));
			}
			exit(0);
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."edit_data"."-".$e);
		}		
	}
//	
//	# @definition: get json list of records and also for sreach record form search input
	public function get_data_records(){
		try{
			$this->log->logIt($this->module."-"."get_data_list");
			$limit =  10;
			$offset = 0;
			$search_name = "";
			$search_status = "";
			$search_category = "";
			$parmas = array();
			
			//$this->log->logIt($this->module."-"."search_name"."-".$_POST['mh_buzz_search_title']);
			
			if( isset($_REQUEST['action']) && $_REQUEST['action'] == "search" ){
				
				
				if( isset($_POST['srch_subscriber_name']) ){
					$_POST['srch_subscriber_name'] = $this->util->strip_html_tags( $_POST['srch_subscriber_name'] );
					$search_name = $this->util->strip_unsafe_tags( $_POST['srch_subscriber_name'] );
					
					$srch_entries_par_page= $this->util->strip_unsafe_tags($_POST['srch_entries_par_page']);
					if( $srch_entries_par_page !=''){
						$limit =  $srch_entries_par_page;
					}
				}
				if( isset($_POST['srch_subscriber_status']) ){
					$_POST['srch_subscriber_status'] = $this->util->strip_html_tags( $_POST['srch_subscriber_status'] );
					$search_status = $this->util->strip_unsafe_tags( $_POST['srch_subscriber_status'] );
					
					$srch_entries_par_page= $this->util->strip_unsafe_tags($_POST['srch_entries_par_page']);
					if( $srch_entries_par_page !=''){
						$limit =  $srch_entries_par_page;
					}
				}
				
				
			}
			else{
				if( isset( $_REQUEST['entries_per_page'] ) &&  isset( $_REQUEST['page'] )){
					$_REQUEST['entries_per_page']   = $this->util->safeNumber($_REQUEST['entries_per_page']);
					$_REQUEST['page']  				= $this->util->safeNumber($_REQUEST['page']);
					if( $_REQUEST['entries_per_page'] != "" && $_REQUEST['page'] != ""){
						$limit = $_REQUEST['entries_per_page'];
						$offset = ($_REQUEST['page'] - 1) * $limit;
					}
					//for search when on. record change from table
					if( isset($_POST['srch_subscriber_name']) ){
						$_POST['srch_subscriber_name'] = $this->util->strip_html_tags( $_POST['srch_subscriber_name'] );
						$search_name = $this->util->strip_unsafe_tags( $_POST['srch_subscriber_name'] );
					}
					if( isset($_POST['srch_subscriber_status']) ){
						$_POST['srch_subscriber_status'] = $this->util->strip_html_tags( $_POST['srch_subscriber_status'] );
						$search_status = $this->util->strip_unsafe_tags( $_POST['srch_subscriber_status'] );
					}
					
				}
			}
			$parmas['offset'] 				= $offset;
			$parmas['limit'] 				= $limit;
			$parmas['txtname'] 				= $search_name;
			$parmas['status'] 				= $search_status;
			
			$this->subscriberdao->params 	= $parmas;
			
			
			
			$result_data 			        = $this->subscriberdao->get_records();
			
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

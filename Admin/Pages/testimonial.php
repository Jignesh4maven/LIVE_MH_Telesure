<?php
require_once(BASE_PATH."/Dbaccess/testimonialdao.php");
require_once(BASE_PATH."/Util/util.php");

class testimonial 
{
	private $module = 'testimonial';
	private $log;	
	private $testimonialdao;
	private $util;
	
	public function __construct(){
		$this->log				= new logger();
		$this->testimonialdao 	= new testimonialdao();
		$this->util 			= new util();
	
	}	
   
   /* intaily load this function */
	public function load(){
		try{
			$this->log->logIt($this->module."-"."Page Load");		
			global $tpl;
			global $config;
			$parmas['limit'] 				= 10;
			$parmas['offset'] 				= 0;
			$this->testimonialdao->params 	= $parmas;
			$this->testimonialdao->limit 	= 10;
			$this->testimonialdao->offset 	= 0;
			$result_data 					= $this->testimonialdao->get_records();
			$result_list 					= "";
			$total_records 					= 0;
		 
			if($result_data->resultStatus == "Success"){
				$result_list 	= $result_data->resultData['list'];
				$total_records	= $result_data->resultData['total'];
			}
			
			
			//print_r($result_data);
			
			$result_json = json_encode ($result_data);
				
			$tpl->assign(array(	
								"T_BODY"			=>	'testimonial'.$config['tplEx'],
								"page_name"			=>  'Testimonial',
					            "load_result_json" 	=>	$result_json,
								"load_result" 		=>	$result_list,
								"total_record"		=>  $total_records,
								"form_action"		=>  'get_data_records'
								 
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
								"T_BODY"			=>	'testimonial_add_edit'.$config['tplEx'],
								"blog_name"			=>  'Testimonial',
								'form_action'		=>	'add_data',
							)
						);
			if( isset($_REQUEST['testimonial_id']) &&  $_REQUEST['testimonial_id'] != ""){
				$this->testimonialdao->testimonial_id =  $_REQUEST['testimonial_id'];
				$result_data = $this->testimonialdao->get_record();
				
				if( $result_data->resultStatus == "Success" ){
					$tpl->assign(array(	
								"data_row"			=>	$result_data->resultData['list'],
								'form_action'		=>	'edit_data',
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
	
	/* getting data from input and insert */
	public function add_data(){
		try{
			
			$this->log->logIt($this->module."-"."add_data");
			
			if( isset($_POST['title']) ){
				$_POST['title'] = $this->util->strip_html_tags( $_POST['title'] );
				$_POST['title'] = $this->util->strip_unsafe_tags( $_POST['title'] );
			}
			$status = "Inactive";
			if( isset($_POST['status']) ){
				$_POST['status'] = $this->util->strip_html_tags( $_POST['status'] );
				$_POST['status'] = $this->util->strip_unsafe_tags( $_POST['status'] );
				
				if($_POST['status'] == 1){
					
					$status="Active";
				}
				else{
					
					$status="Inactive";
				}
				
			}
			
			
			if( isset($_POST['description']) ){
				//$_POST['description'] = $this->util->strip_html_tags( $_POST['description'] );
				$description = $this->util->strip_unsafe_tags( $_POST['description'] );
			}
			//$this->log->logIt($this->module."-"."description"."-".$description );
			
			$this->testimonialdao->testimonial_title 		= $_POST['title'];
			$this->testimonialdao->testimonial_status		= $status;
			$this->testimonialdao->testimonial_description	= $description;
			$this->testimonialdao->ip				= "1.2.2.14";
			$this->testimonialdao->created_by 		= "test";
			$data_result = $this->testimonialdao->insert_record();
			
			if($data_result->resultStatus == "Success" || $data_result->resultStatus == "Warning"){
				$data_result->resultAction = "Insert";
				print_r(json_encode($data_result));
			}
		
			exit(0);
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."add_data"."-".$e);
		}		
	}
	
	/* for Deleteing records  */
	public function delete(){
		 $testimonial_id = $this->util->safeNumber($_REQUEST['id']);
		 if( $testimonial_id != ""){
			$this->testimonialdao->testimonial_id 		= $testimonial_id;
			$data_result = $this->testimonialdao->soft_delete_record();
			if( $data_result->resultStatus == "Success" ){
				$data_result->resultMessage = "Deleted successful.";
				$parmas['offset'] 	= 0;
				$parmas['limit'] 	= 10;
				$this->testimonialdao->params =  $parmas;
				$data_result = $this->testimonialdao->get_records();
			}
			print_r(json_encode($data_result));
		 }
		 exit(0);
	}
	
	/* For edting form data and update  */
		public function edit_data(){
		try{
			$this->log->logIt($this->module."-"."edit_data");
			if( isset($_POST['title']) ){
				$_POST['title'] = $this->util->strip_html_tags( $_POST['title'] );
				$_POST['title'] = $this->util->strip_unsafe_tags( $_POST['title'] );
			}
			
			if( isset($_POST['status']) ){
				$_POST['status'] = $this->util->strip_html_tags( $_POST['status'] );
				$_POST['status'] = $this->util->strip_unsafe_tags( $_POST['status'] );
				
				if($_POST['status'] == 1){
					
					$status="Active";
				}
				else{
					
					$status="Inactive";
				}
			}
			
			if( isset($_POST['description']) ){
				//$_POST['description'] = $this->util->strip_html_tags( $_POST['description'] );
				$_POST['description'] = $this->util->strip_unsafe_tags( $_POST['description'] );
			}
			
			
			$testimonial_id = $this->util->safeNumber($_REQUEST['testimonial_id']);
			if( $testimonial_id != ""){
			   $this->testimonialdao->testimonial_id 				= $testimonial_id;
			   $this->testimonialdao->title 						= $_POST['title'];
			   $this->testimonialdao->status 						= $status;
			   $this->testimonialdao->testimonial_description 		= $_POST['description'];
			   $this->testimonialdao->modified_by 					= $_SESSION['AdminDetails']['str_nick_name'];
			   $data_result = $this->testimonialdao->update_record();
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
	
	# @definition: get json list of records and also for sreach record form search input
	public function get_data_records(){
		try{
			$this->log->logIt($this->module."-"."get_data_list");
			$limit =  10;
			$offset = 0;
			$search_name = "";
			$search_status = "";
			$parmas = array();
			
			//$this->log->logIt($this->module."-"."search_name"."-".$_POST['srch_testimonial_title']);
			
			if( isset($_REQUEST['action']) && $_REQUEST['action'] == "search" ){
				if( isset($_POST['srch_testimonial_title']) ){
					$_POST['srch_testimonial_title'] = $this->util->strip_html_tags( $_POST['srch_testimonial_title'] );
					$search_name = $this->util->strip_unsafe_tags( $_POST['srch_testimonial_title'] );
					$srch_entries_par_page= $this->util->strip_unsafe_tags($_POST['srch_entries_par_page']);
					if( $srch_entries_par_page !=''){
						$limit =  $srch_entries_par_page;
					}
				}
				
				if( isset($_POST['search_testimonial_status']) ){
					$_POST['search_testimonial_status'] = $this->util->strip_html_tags( $_POST['search_testimonial_status'] );
					$search_status = $this->util->strip_unsafe_tags( $_POST['search_testimonial_status'] );
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
					if( isset($_POST['srch_testimonial_title']) ){
						$_POST['srch_testimonial_title'] = $this->util->strip_html_tags( $_POST['srch_testimonial_title'] );
						$search_name = $this->util->strip_unsafe_tags( $_POST['srch_testimonial_title'] );
					}
					
					if( isset($_POST['search_testimonial_status']) ){
						$_POST['search_testimonial_status'] = $this->util->strip_html_tags( $_POST['search_testimonial_status'] );
						$search_status = $this->util->strip_unsafe_tags( $_POST['search_testimonial_status'] );
					}
				}
			}
			$parmas['offset'] 				= $offset;
			$parmas['limit'] 				= $limit;
			$parmas['txtname'] 				= $search_name;
			$parmas['txtstatus'] 			= $search_status;
			$this->testimonialdao->params 	=  $parmas;
			$result_data 			        = $this->testimonialdao->get_records();
			
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

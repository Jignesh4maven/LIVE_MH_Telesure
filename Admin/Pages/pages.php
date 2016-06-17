<?php
require_once(BASE_PATH."/Dbaccess/pagedao.php");
require_once(BASE_PATH."/Util/util.php");

class pages
{
	private $module = 'pages';
	private $log;	
	private $pagedao;
	private $util;
	
	public function __construct(){
		$this->log		= new logger();
		$this->pagedao	= new pagedao();
		$this->util		= new util();
	}	
   
   /* intaily load this function */
	public function load(){
		try{
			$this->log->logIt($this->module."-"."Page Load");		
			global $tpl;
			global $config;
			$parmas['limit'] 				= 10;
			$parmas['offset'] 				= 0;
			$this->pagedao->params 			= $parmas;
			$this->pagedao->limit 			= 10;
			$this->pagedao->offset 			= 0;
			$result_data 					= $this->pagedao->get_records();
			$result_list 					= "";
			$total_records 					= 0;
		 
			if($result_data->resultStatus == "Success"){
				$result_list 	= $result_data->resultData['list'];
				$total_records	= $result_data->resultData['total'];
			}
			
			
			//print_r($result_data);
			
			$result_json = json_encode ($result_data);
			
			$tpl->assign(array(	
								"T_BODY"			=>	'pages'.$config['tplEx'],
								"page_name"			=>  'Pages',
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
								"T_BODY"			=>	'page_add_edit'.$config['tplEx'],
								"blog_name"			=>  'pages',
								'form_action'		=>	'add_data',
							)
						);
			if( isset($_REQUEST['page_id']) &&  $_REQUEST['page_id'] != ""){
				$this->pagedao->page_id =  $_REQUEST['page_id'];
				$result_data = $this->pagedao->get_record();
				
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
				$title = $this->util->strip_unsafe_tags( $_POST['title'] );
			}
			if( isset($_POST['alias']) ){
				$_POST['alias'] = $this->util->strip_html_tags( $_POST['alias'] );
				$alias = $this->util->strip_unsafe_tags( $_POST['alias'] );
			}
			
			if( isset($_POST['description']) ){
				$description = $this->util->strip_unsafe_tags( $_POST['description'] );
			}
		
			$this->pagedao->pages_title 		= $title;
			$this->pagedao->pages_alias			= $alias;
			$this->pagedao->pages_description	= $description;
			$this->pagedao->ip					= "1.2.2.14";
			$this->pagedao->created_by 			= "test";
			
			$data_result = $this->pagedao->insert_record();
			
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
		 $page_id = $this->util->safeNumber($_REQUEST['id']);
		 if( $page_id != ""){
			
			$this->pagedao->page_id 		= $page_id;
			
			$data_result = $this->pagedao->soft_delete_record();
			
			if( $data_result->resultStatus == "Success" ){
				$data_result->resultMessage = "Deleted successful.";
				$parmas['offset'] 	= 0;
				$parmas['limit'] 	= 10;
				$this->pagedao->params =  $parmas;
				$data_result = $this->pagedao->get_records();
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
				$title = $this->util->strip_unsafe_tags( $_POST['title'] );
			}
			if( isset($_POST['alias']) ){
				$_POST['alias'] = $this->util->strip_html_tags( $_POST['alias'] );
				$alias = $this->util->strip_unsafe_tags( $_POST['alias'] );
			}
			
			if( isset($_POST['description']) ){
				$description = $this->util->strip_unsafe_tags( $_POST['description'] );
			}
			
			$page_id = $this->util->safeNumber($_REQUEST['page_id']);
			if( $page_id != ""){
				
				$this->pagedao->page_id 			= $page_id;
				$this->pagedao->pages_title 		= $title;
				$this->pagedao->pages_alias			= $alias;
				$this->pagedao->pages_description	= $description;
				$this->pagedao->modified_by 		= $_SESSION['AdminDetails']['str_nick_name'];
				
			   $data_result = $this->pagedao->update_record();
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
			$parmas = array();
			
			//$this->log->logIt($this->module."-"."search_name"."-".$_POST['srch_testimonial_title']);
			
			if( isset($_REQUEST['action']) && $_REQUEST['action'] == "search" ){
				if( isset($_POST['srch_page_title']) ){
					$_POST['srch_page_title'] = $this->util->strip_html_tags( $_POST['srch_page_title'] );
					$search_name = $this->util->strip_unsafe_tags( $_POST['srch_page_title'] );
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
					if( isset($_POST['srch_page_title']) ){
						$_POST['srch_page_title'] = $this->util->strip_html_tags( $_POST['srch_page_title'] );
						$search_name = $this->util->strip_unsafe_tags( $_POST['srch_page_title'] );
					}
				
				}
			}
			$parmas['offset'] 				= $offset;
			$parmas['limit'] 				= $limit;
			$parmas['txtname'] 				= $search_name;
			
			$this->pagedao->params 			=  $parmas;
			$result_data 			        = $this->pagedao->get_records();
			
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

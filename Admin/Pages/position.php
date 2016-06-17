<?php
//require_once(BASE_PATH."/Dbaccess/buzzcategorydao.php");
//require_once(BASE_PATH."/Util/util.php");


class positions 
{
	private $module = 'positions';
	private $log;	
	//private $buzzcategorydao;
	//private $util;
	
	public function __construct(){
	
		$this->log				= new logger();
	//	$this->buzzcategorydao 	= new buzzcategorydao();
	//	$this->util 			= new util();
		
	}	

	public function load(){
		try{
			$this->log->logIt($this->module."-"."Page Load");		
			global $tpl;
			global $config;
			//$parmas['limit'] 				= 10;
			//$parmas['offset'] 				= 0;
			//$this->buzzcategorydao->params 	= $parmas;
			//$this->buzzcategorydao->limit 	= 10;
			//$this->buzzcategorydao->offset 	= 0;
			//$result_data 					= $this->buzzcategorydao->get_records();
			//$result_list 					= "";
			//$total_records 					= 0;
			//
			//
			//
			//
			//if($result_data->resultStatus == "Success"){
			//	$result_list 	= $result_data->resultData['list'];
			//	$total_records	= $result_data->resultData['total'];
			//}
			//
			//$result_json = json_encode ($result_data);
			//
			$tpl->assign(array(	
								"T_BODY"					=>	'position'.$config['tplEx'],
								"page_name"					=>  'Position',
					//            "load_result_json" 			=>	$result_json,
					//			"load_result" 				=>	$result_list,
					//			"total_record"				=>  $total_records,
					//			"form_action"				=>  'get_data_records'
								 
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
								"T_BODY"				=>	'position_add_edit'.$config['tplEx'],
								"blog_name"				=>  'Position',
								'form_action'			=>	'add_data',
							)
						);
			
			//if( isset($_REQUEST['buzz_category_id']) &&  $_REQUEST['buzz_category_id'] != ""){
			//	$this->buzzcategorydao->buzz_category_id =  $_REQUEST['buzz_category_id'];
			//	$result_data = $this->buzzcategorydao->get_record();
			//	
			//	
			//	
			//	if( $result_data->resultStatus == "Success" ){
			//		$tpl->assign(array(	
			//					"data_row"				=>	$result_data->resultData['list'],
			//					'form_action'			=>	'edit_data',
			//					
			//				)
			//			);
			//	}
			//}
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."form_add_edit"."-".$e);
		}		
	}
	
	/* getting data from input and insert */
//	public function add_data(){
//		try{
//			
//			$this->log->logIt($this->module."-"."add_data");
//			
//			
//			
//			if( isset($_POST['buzz_category_title']) ){
//				$_POST['buzz_category_title'] = $this->util->strip_html_tags( $_POST['buzz_category_title'] );
//				$buzz_category_title = $this->util->strip_unsafe_tags( $_POST['buzz_category_title'] );
//			}
//			
//			if( isset($_POST['buzz_category_alias']) ){
//				$_POST['buzz_category_alias'] = $this->util->strip_html_tags( $_POST['buzz_category_alias'] );
//				$buzz_category_alias = $this->util->strip_unsafe_tags( $_POST['buzz_category_alias'] );
//			}
//			
//			$status = "Inactive";
//			if( isset($_POST['buzz_catrgory_status']) ){
//				$_POST['buzz_catrgory_status'] = $this->util->strip_html_tags( $_POST['buzz_catrgory_status'] );
//				$buzz_catrgory_status = $this->util->strip_unsafe_tags( $_POST['buzz_catrgory_status'] );
//				
//				if($buzz_catrgory_status == 1){
//					
//					$status="Active";
//				}
//				else{
//					
//					$status="Inactive";
//				}
//				
//			}
//			
//			if( isset($_POST['buzz_category_description']) ){
//				$buzz_category_description = $this->util->strip_unsafe_tags( $_POST['buzz_category_description'] );
//			}
//		
//			
//		
//			$this->buzzcategorydao->buzz_category_title					= $buzz_category_title;
//			$this->buzzcategorydao->buzz_category_alias					= $buzz_category_alias;
//			$this->buzzcategorydao->buzz_category_status				= $status;
//			$this->buzzcategorydao->buzz_category_description 			= $buzz_category_description;
//			
//			//$this->buzzcategorydao->ip								= "1.2.2.14";
//			//$this->buzzcategorydao->created_by 						= "test";
//			
//			$data_result = $this->buzzcategorydao->insert_record();
//			
//			if($data_result->resultStatus == "Success" || $data_result->resultStatus == "Warning"){
//				
//				$data_result->resultAction = "Insert";
//				print_r(json_encode($data_result));
//			}
//			exit(0);
//		}
//		catch(Exception $e){
//			echo $e;
//			$this->log->logIt($this->module."-"."add_data"."-".$e);
//		}		
//	}
////	
////	/* for Deleteing records  */
//	public function delete(){
//		 $buzz_category_id = $this->util->safeNumber($_REQUEST['id']);
//		 if( $buzz_category_id != ""){
//			$this->buzzcategorydao->buzz_category_id 		= $buzz_category_id;
//			$data_result = $this->buzzcategorydao->soft_delete_record();
//			if( $data_result->resultStatus == "Success" ){
//				$data_result->resultMessage = "Deleted successful.";
//				$parmas['offset'] 	= 0;
//				$parmas['limit'] 	= 10;
//				$this->buzzcategorydao->params =  $parmas;
//				$data_result = $this->buzzcategorydao->get_records();
//			}
//			print_r(json_encode($data_result));
//		 }
//		 exit(0);
//	}
//	
//	
////	/* For edting form data and update  */
//		public function edit_data(){
//		try{
//			$this->log->logIt($this->module."-"."edit_data");
//
//			
//			if( isset($_POST['buzz_category_title']) ){
//				$_POST['buzz_category_title'] = $this->util->strip_html_tags( $_POST['buzz_category_title'] );
//				$buzz_category_title = $this->util->strip_unsafe_tags( $_POST['buzz_category_title'] );
//			}
//			
//			if( isset($_POST['buzz_category_alias']) ){
//				$_POST['buzz_category_alias'] = $this->util->strip_html_tags( $_POST['buzz_category_alias'] );
//				$buzz_category_alias = $this->util->strip_unsafe_tags( $_POST['buzz_category_alias'] );
//			}
//			
//			$status = "Inactive";
//			if( isset($_POST['buzz_catrgory_status']) ){
//				$_POST['buzz_catrgory_status'] = $this->util->strip_html_tags( $_POST['buzz_catrgory_status'] );
//				$buzz_catrgory_status = $this->util->strip_unsafe_tags( $_POST['buzz_catrgory_status'] );
//				
//				if($buzz_catrgory_status == 1){
//					
//					$status="Active";
//				}
//				else{
//					
//					$status="Inactive";
//				}
//				
//			}
//			
//			if( isset($_POST['buzz_category_description']) ){
//				$buzz_category_description = $this->util->strip_unsafe_tags( $_POST['buzz_category_description'] );
//			}
//			
//			$buzz_category_id = $this->util->safeNumber($_REQUEST['buzz_category_id']);
//			
//			if( $buzz_category_id != ""){
//				$this->buzzcategorydao->buzz_category_id 	   				= $buzz_category_id;
//				$this->buzzcategorydao->buzz_category_title					= $buzz_category_title;
//				$this->buzzcategorydao->buzz_category_alias					= $buzz_category_alias;
//				$this->buzzcategorydao->buzz_category_status				= $status;
//				$this->buzzcategorydao->buzz_category_description 			= $buzz_category_description;
//				$this->buzzcategorydao->modified_by 						= $_SESSION['AdminDetails']['str_nick_name'];
//				
//				$data_result = $this->buzzcategorydao->update_record();
//			   if( $data_result->resultStatus == "Success" ){
//				
//				   $data_result->resultMessage = "Update successful.";
//				   $data_result->resultAction = "Update";
//			   }
//			   
//			   print_r(json_encode($data_result));
//			}
//			exit(0);
//		}
//		catch(Exception $e){
//			echo $e;
//			$this->log->logIt($this->module."-"."edit_data"."-".$e);
//		}		
//	}
////	
////	# @definition: get json list of records and also for sreach record form search input
//	public function get_data_records(){
//		try{
//			$this->log->logIt($this->module."-"."get_data_list");
//			$limit =  10;
//			$offset = 0;
//			$search_name = "";
//			$search_status = "";
//			$search_category = "";
//			$parmas = array();
//			
//			//$this->log->logIt($this->module."-"."search_name"."-".$_POST['mh_buzz_search_title']);
//			
//			if( isset($_REQUEST['action']) && $_REQUEST['action'] == "search" ){
//				
//				
//				if( isset($_POST['buzz_category_search_title']) ){
//					$_POST['buzz_category_search_title'] = $this->util->strip_html_tags( $_POST['buzz_category_search_title'] );
//					$search_name = $this->util->strip_unsafe_tags( $_POST['buzz_category_search_title'] );
//					
//					$srch_entries_par_page= $this->util->strip_unsafe_tags($_POST['srch_entries_par_page']);
//					if( $srch_entries_par_page !=''){
//						$limit =  $srch_entries_par_page;
//					}
//				}
//				if( isset($_POST['buzz_category_search_status']) ){
//					$_POST['buzz_category_search_status'] = $this->util->strip_html_tags( $_POST['buzz_category_search_status'] );
//					$search_status = $this->util->strip_unsafe_tags( $_POST['buzz_category_search_status'] );
//					
//					$srch_entries_par_page= $this->util->strip_unsafe_tags($_POST['srch_entries_par_page']);
//					if( $srch_entries_par_page !=''){
//						$limit =  $srch_entries_par_page;
//					}
//				}
//				
//				//if( isset($_POST['buzz_categroy_search']) ){
//				//	$_POST['buzz_categroy_search'] = $this->util->strip_html_tags( $_POST['buzz_categroy_search'] );
//				//	$search_category = $this->util->strip_unsafe_tags( $_POST['buzz_categroy_search'] );
//				//	
//				//	$srch_entries_par_page= $this->util->strip_unsafe_tags($_POST['srch_entries_par_page']);
//				//	if( $srch_entries_par_page !=''){
//				//		$limit =  $srch_entries_par_page;
//				//	}
//				//}
//			}
//			else{
//				if( isset( $_REQUEST['entries_per_page'] ) &&  isset( $_REQUEST['page'] )){
//					$_REQUEST['entries_per_page']   = $this->util->safeNumber($_REQUEST['entries_per_page']);
//					$_REQUEST['page']  				= $this->util->safeNumber($_REQUEST['page']);
//					if( $_REQUEST['entries_per_page'] != "" && $_REQUEST['page'] != ""){
//						$limit = $_REQUEST['entries_per_page'];
//						$offset = ($_REQUEST['page'] - 1) * $limit;
//					}
//					//for search when on. record change from table
//					if( isset($_POST['buzz_category_search_title']) ){
//						$_POST['buzz_category_search_title'] = $this->util->strip_html_tags( $_POST['buzz_category_search_title'] );
//						$search_name = $this->util->strip_unsafe_tags( $_POST['buzz_category_search_title'] );
//					}
//					if( isset($_POST['buzz_category_search_status']) ){
//						$_POST['buzz_category_search_status'] = $this->util->strip_html_tags( $_POST['buzz_category_search_status'] );
//						$search_status = $this->util->strip_unsafe_tags( $_POST['buzz_category_search_status'] );
//					}
//					//if( isset($_POST['buzz_categroy_search']) ){
//					//	$_POST['buzz_categroy_search'] = $this->util->strip_html_tags( $_POST['buzz_categroy_search'] );
//					//	$search_category = $this->util->strip_unsafe_tags( $_POST['buzz_categroy_search'] );
//					//}
//				}
//			}
//			$parmas['offset'] 				= $offset;
//			$parmas['limit'] 				= $limit;
//			$parmas['txtname'] 				= $search_name;
//			$parmas['status'] 				= $search_status;
//			//$parmas['category'] 			= $search_category;
//			$this->buzzcategorydao->params 	= $parmas;
//			
//			
//			
//			$result_data 			        = $this->buzzcategorydao->get_records();
//			
//			if($result_data->resultStatus == "Success"){
//				$result_list = $result_data->resultData['list'];
//				print_r(json_encode($result_data));
//			}
//			exit(0);
//		}
//		catch(Exception $e){
//			echo $e;
//			$this->log->logIt($this->module."-"."get_data_list"."-".$e);
//		}		
//	}


	

}				
?>

<?php
require_once("../Dbaccess/pagedao.php");
require_once("../Util/util.php");
class pages{
	
	private $module = 'addressbook';
	private $log;
	private $pagedao;
	private $util;
	
	public function __construct(){
		$this->log		= new logger();
		$this->pagedao 	= new pagedao();
		$this->util 	= new util();
	}	

	// initiate template and data on first load
	public function load(){
		try{
			
			$this->log->logIt($this->module."-"."Page Load");
			global $tpl;
			global $config;
			
			$parmas['limit'] 	= 5;
			$parmas['offset'] 	= 0;
			$this->pagedao->params =  $parmas;
			
			$this->pagedao->limit 	= 5;
			$this->pagedao->offset 	= 0;
			$page_result = $this->pagedao->get_list();
			
			$result_list 	= "";
			$total_records 	= 0;
		 
			if($page_result->resultStatus == "Success"){
				$result_list 	= $page_result->resultData['list'];
				$total_records	= $page_result->resultData['total'];
			}
			
			$page_result_json = json_encode ($page_result);
			$tpl->assign(array(	
								"T_BODY"			=>	'pages'.$config['tplEx'],
								"page_name"			=>  'Pages',
								'load_result_json' 	=>	$page_result_json,
								'load_result' 		=>	$result_list,
								'total_record'		=>  $total_records,
								'form_action'		=>  'get_list'
							)
						);		
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."onLoad"."-".$e);
		}		
	}
	
	// load json data on pagination call
	public function get_list(){
		try{
			
			$this->log->logIt($this->module."-"."Get List");
			
			$limit =  5;
			
			$offset = 0;
			
			$search_name = "";
			
			$parmas = array();
			
			
			if( isset($_REQUEST['action']) && $_REQUEST['action'] == "search" ){
				if( isset($_POST['pagename']) ){
					$_POST['pagename'] = $this->util->strip_html_tags( $_POST['pagename'] );
					$_POST['pagename'] = $this->util->strip_unsafe_tags( $_POST['pagename'] );
					$search_name = $_POST['pagename'];
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
				}
			}
			
			$parmas['offset'] = $offset;
			
			$parmas['limit'] = $limit;
			
			$parmas['txtname'] = $search_name;
						
			$this->pagedao->params =  $parmas;
			
			$page_result = $this->pagedao->get_list();
			
			if($page_result->resultStatus == "Success"){
				
				$result_list = $page_result->resultData['list'];
				
				print_r(json_encode($page_result));
			
			}
			exit(0);
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."onLoad"."-".$e);
		}		
	}
	
	public function add_edit(){
		try{
			
			$this->log->logIt($this->module."-"."Page Add Edit");
			global $tpl;
			global $config;
			
		 
			$tpl->assign(array(	
								"T_BODY"			=>	'page_add_edit'.$config['tplEx'],
								"page_name"			=>  'Pages',
								'form_action'		=>	'add_page',
							)
						);
			
			if( isset($_REQUEST['page_id']) &&  $_REQUEST['page_id'] != ""){
				
				$this->pagedao->page_id =  $_REQUEST['page_id'];
				
				$page_result = $this->pagedao->get();
				
				if( $page_result->resultStatus == "Success" ){
					
					#print_r($page_result->resultData['list']);
					
					$tpl->assign(array(	
								"data_row"			=>	$page_result->resultData['list'],
								'form_action'		=>	'edit_page',
								
							)
						);
					
				}
				
				
			}
			
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."onLoad"."-".$e);
		}		
	}
	
	public function add_page(){
		try{
			
			$this->log->logIt($this->module."-"."Add New Page");
			
			if( isset($_POST['pagename']) ){
				$_POST['pagename'] = $this->util->strip_html_tags( $_POST['pagename'] );
				$_POST['pagename'] = $this->util->strip_unsafe_tags( $_POST['pagename'] );
			}
			if( isset($_POST['pagecontent']) ){
				//$_POST['pagecontent'] = $this->util->strip_html_tags( $_POST['pagecontent'] );
				$_POST['pagecontent'] = $this->util->strip_unsafe_tags( $_POST['pagecontent'] );
				
			}
			
			$this->pagedao->page_alias 		= $_POST['pagename'];
			$this->pagedao->page_name 		= $_POST['pagename'];
			$this->pagedao->page_content	= $_POST['pagecontent'];
			$this->pagedao->status 			= "Y";
			$this->pagedao->priority		= 3;
			$this->pagedao->ip				= "1.2.2.14";
			$this->pagedao->created_by 		= "test";
			$page_result = $this->pagedao->insert();
			
			if($page_result->resultStatus == "Success" || $page_result->resultStatus == "Warning"){
				$page_result->resultAction = "Update";
				print_r(json_encode($page_result));
			
			}
			
			exit(0);
			
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."onLoad"."-".$e);
		}		
	}
	
	public function edit_page(){
		
		try{
			
			$this->log->logIt($this->module."-"."Update New Page");
			
			if( isset($_POST['pagename']) ){
				$_POST['pagename'] = $this->util->strip_html_tags( $_POST['pagename'] );
				$_POST['pagename'] = $this->util->strip_unsafe_tags( $_POST['pagename'] );
			}
			if( isset($_POST['pagecontent']) ){
				//$_POST['pagecontent'] = $this->util->strip_html_tags( $_POST['pagecontent'] );
				$_POST['pagecontent'] = $this->util->strip_unsafe_tags( $_POST['pagecontent'] );
				
			}
			
			$page_id = $this->util->safeNumber($_REQUEST['page_id']);
		 
			if( $page_id != ""){
			   
			   $this->pagedao->page_id 			= $page_id;
			   $this->pagedao->page_name 		= $_POST['pagename'];
			   $this->pagedao->page_content 	= $_POST['pagecontent'];
			   
			   $page_result = $this->pagedao->update();
			   
			   if( $page_result->resultStatus == "Success" ){
				   
				   $page_result->resultMessage = "Update successful.";
				   
				   $page_result->resultAction = "Update";
				   
			   }
			   
			   print_r(json_encode($page_result));
			   
			}
			
			exit(0);
			
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."onLoad"."-".$e);
		}		
	}
	
	public function delete(){
		
		 $page_id = $this->util->safeNumber($_REQUEST['page_id']);
		 
		 if( $page_id != ""){
			
			$this->pagedao->page_id 		= $page_id;
			
			$page_result = $this->pagedao->soft_delete();
			
			if( $page_result->resultStatus == "Success" ){
				
				$page_result->resultMessage = "Deleted successful.";
				
			}
			
			print_r(json_encode($page_result));
			
		 }
		 exit(0);
		 
	}
	
	
	
	
	
	
	
	
	
	
	
}				
?>

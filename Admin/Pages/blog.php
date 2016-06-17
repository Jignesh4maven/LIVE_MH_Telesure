<?php
require_once("../Dbaccess/blogdao.php");
require_once("../Util/util.php");
class blog{
	
	private $module = 'blog';
	private $log;
	private $blogdao;
	private $util;
	
	public function __construct(){
		$this->log		= new logger();
		$this->blogdao 	= new blogdao();
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
			$parmas['limit'] 		= 5;
			$parmas['offset'] 		= 0;
			$this->blogdao->params 	= $parmas;
			$this->blogdao->limit 	= 5;
			$this->blogdao->offset 	= 0;
			$result_data 			= $this->blogdao->get_records();
			$result_list 			= "";
			$total_records 			= 0;
		 
			if($result_data->resultStatus == "Success"){
				$result_list 	= $result_data->resultData['list'];
				$total_records	= $result_data->resultData['total'];
			}
			
			
			//print_r($result_data);
			
			$result_json = json_encode ($result_data);
			
			$tpl->assign(array(	
								"T_BODY"			=>	'blog'.$config['tplEx'],
								"blog_name"			=>  'blog',
								'load_result_json' 	=>	$result_json,
								'load_result' 		=>	$result_list,
								'total_record'		=>  $total_records,
								'form_action'		=>  'get_data_records'
							)
						);		
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."load"."-".$e);
		}		
	}
	
	# @author: Jignesh Rana <mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: get json list of records
	public function get_data_records(){
		try{
			$this->log->logIt($this->module."-"."get_data_list");
			$limit =  5;
			$offset = 0;
			$search_name = "";
			$parmas = array();
			
			if( isset($_REQUEST['action']) && $_REQUEST['action'] == "search" ){
				if( isset($_POST['blogname']) ){
					$_POST['blogname'] = $this->util->strip_html_tags( $_POST['blogname'] );
					$_POST['blogname'] = $this->util->strip_unsafe_tags( $_POST['blogname'] );
					$search_name = $_POST['blogname'];
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
			$parmas['offset'] 	= $offset;
			$parmas['limit'] 	= $limit;
			$parmas['txtname'] 	= $search_name;
			$this->blogdao->params 	=  $parmas;
			$result_data 			= $this->blogdao->get_records();
			
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
	
	# @author: Jignesh Rana <mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: Add / Edit Template View
	public function form_add_edit(){
		try{
			$this->log->logIt($this->module."-"."form_add_edit");
			global $tpl;
			global $config;
			$tpl->assign(array(	
								"T_BODY"			=>	'blog_add_edit'.$config['tplEx'],
								"blog_name"			=>  'Pages',
								'form_action'		=>	'add_data',
							)
						);
			if( isset($_REQUEST['blog_id']) &&  $_REQUEST['blog_id'] != ""){
				$this->blogdao->blog_id =  $_REQUEST['blog_id'];
				$result_data = $this->blogdao->get_record();
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
	
	# @author: Jignesh Rana <mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: Validate form data and send to insert method.
	public function add_data(){
		try{
			$this->log->logIt($this->module."-"."add_data");
			if( isset($_POST['blogname']) ){
				$_POST['blogname'] = $this->util->strip_html_tags( $_POST['blogname'] );
				$_POST['blogname'] = $this->util->strip_unsafe_tags( $_POST['blogname'] );
			}
			if( isset($_POST['blogcontent']) ){
				//$_POST['blogcontent'] = $this->util->strip_html_tags( $_POST['blogcontent'] );
				$_POST['blogcontent'] = $this->util->strip_unsafe_tags( $_POST['blogcontent'] );
			}
			
			$this->blogdao->blog_alias 		= $_POST['blogname'];
			$this->blogdao->blog_name 		= $_POST['blogname'];
			$this->blogdao->blog_content	= $_POST['blogcontent'];
			$this->blogdao->status 			= "Y";
			$this->blogdao->priority		= 3;
			$this->blogdao->ip				= "1.2.2.14";
			$this->blogdao->created_by 		= "test";
			$data_result = $this->blogdao->insert_record();
			if($data_result->resultStatus == "Success" || $data_result->resultStatus == "Warning"){
				$data_result->resultAction = "Update";
				print_r(json_encode($data_result));
			}
			exit(0);
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."add_data"."-".$e);
		}		
	}
	
	# @author: Jignesh Rana <mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: Validate form data and send to update method.
	public function edit_data(){
		try{
			$this->log->logIt($this->module."-"."edit_data");
			if( isset($_POST['blogname']) ){
				$_POST['blogname'] = $this->util->strip_html_tags( $_POST['blogname'] );
				$_POST['blogname'] = $this->util->strip_unsafe_tags( $_POST['blogname'] );
			}
			if( isset($_POST['blogcontent']) ){
				$_POST['blogcontent'] = $this->util->strip_unsafe_tags( $_POST['blogcontent'] );
			}
			
			$blog_id = $this->util->safeNumber($_REQUEST['blog_id']);
			if( $blog_id != ""){
			   $this->blogdao->blog_id 			= $blog_id;
			   $this->blogdao->blog_name 		= $_POST['blogname'];
			   $this->blogdao->blog_content 	= $_POST['blogcontent'];
			   $data_result = $this->blogdao->update_record();
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
	
	# @author: Jignesh Rana <mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: Delete record from given id
	public function delete(){
		 $blog_id = $this->util->safeNumber($_REQUEST['id']);
		 if( $blog_id != ""){
			$this->blogdao->blog_id 		= $blog_id;
			$data_result = $this->blogdao->soft_delete_record();
			if( $data_result->resultStatus == "Success" ){
				$data_result->resultMessage = "Deleted successful.";
				$parmas['offset'] 	= 0;
				$parmas['limit'] 	= 5;
				$this->blogdao->params =  $parmas;
				$data_result = $this->blogdao->get_records();
			}
			print_r(json_encode($data_result));
		 }
		 exit(0);
	}	
}				
?>
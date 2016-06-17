<?php
require_once(BASE_PATH."/Dbaccess/mhbuzzdao.php");
require_once(BASE_PATH."/Dbaccess/commondao.php");
require_once(BASE_PATH."/Util/util.php");
require_once(BASE_PATH."/Conf/common.php");
require_once(BASE_PATH."/Dbaccess/buzzcategorydao.php");
class mhbuzz 
{
	private $module = 'mhbuzz';
	private $log;	
	private $testimonialdao;
	private $util;
	private $buzz_category;
	private $buzzcategorydao;
	public function __construct(){
	
		$this->log				=new logger();
		$this->mhbuzzdao 		= new mhbuzzdao();
		$this->commondao= new commondao();
		$this->util 			= new util();
		$this->buzzcategorydao 	= new buzzcategorydao();
	}	

	public function load(){
		try{
			$this->log->logIt($this->module."-"."Page Load");		
			global $tpl;
			global $config;
			$parmas['limit'] 				= 10;
			$parmas['offset'] 				= 0;
			$this->mhbuzzdao->params 		= $parmas;
			$this->mhbuzzdao->limit 		= 10;
			$this->mhbuzzdao->offset 		= 0;
			$result_data 					= $this->mhbuzzdao->get_records();
			$result_list 					= "";
			$total_records 					= 0;
			
		
			
			//getting buzz-category category from DB
			$buzz_category_list = array();
			$result_category_list	= $this->buzzcategorydao->get_records();
			
		
			if($result_category_list->resultStatus == "Success"){
				
				$buzz_category_list 	= $result_category_list->resultData['list'];
			}
			
			if($result_data->resultStatus == "Success"){
				$result_list 	= $result_data->resultData['list'];
				$total_records	= $result_data->resultData['total'];
			}
			
			$result_json = json_encode ($result_data);
			
			$tpl->assign(array(	
								"T_BODY"					=>	'mh_buzz'.$config['tplEx'],
								"page_name"					=>  'MH-Buzz',
					            "load_result_json" 			=>	$result_json,
								"buzz_category_list"		=> 	$buzz_category_list,
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
			
			//$buzz_category 			= new staticarray();
			//$buzz_category_list = $buzz_category::$BuzzCategory  ;
			
			//getting buzz-category category from DB
			$buzz_category_list = array();
			$result_category_list	= $this->buzzcategorydao->get_records();
			
			if($result_category_list->resultStatus == "Success"){
				
				$buzz_category_list 	= $result_category_list->resultData['list'];
			}
			
			$tpl->assign(array(	
								"T_BODY"				=>	'mhbuzz_add_edit'.$config['tplEx'],
								"blog_name"				=>  'MH-Buzz',
								"buzz_category_list"	=> 	$buzz_category_list,
								'form_action'			=>	'add_data',
							)
						);
			
			if( isset($_REQUEST['buzz_id']) &&  $_REQUEST['buzz_id'] != ""){
				$this->mhbuzzdao->buzz_id =  $_REQUEST['buzz_id'];
				$result_data = $this->mhbuzzdao->get_record();
				
				$img_result_data = $this->commondao->get_image_records('buzz',$this->mhbuzzdao->buzz_id);
				if(!empty($img_result_data))
				{
					foreach($img_result_data->resultData['image_list'] as $imgs){
						foreach($imgs as $image_data){
							$raw_data = $this->util->getImageRawData($image_data);
							$img_result['imageid'] = $raw_data['filename'];
							$img_result['image']   = $image_data;
							$final_array[] = $img_result;
						}
					}
					
				}
				
				if( $result_data->resultStatus == "Success" ){
					$tpl->assign(array(	
								"data_row"				=>	$result_data->resultData['list'],
								"gallery_images"		=>	$final_array,
								'form_action'			=>	'edit_data',
								"IMAGE_PATH"			=>  HTTP_PATH.'/Uploads/',
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
			
			if( isset($_POST['mh_buzz_title']) ){
				$_POST['mh_buzz_title'] = $this->util->strip_html_tags( $_POST['mh_buzz_title'] );
				$_POST['mh_buzz_title'] = $this->util->strip_unsafe_tags( $_POST['mh_buzz_title'] );
			}
			
			if( isset($_POST['mh_buzz_categroy']) ){
				$_POST['mh_buzz_categroy'] = $this->util->strip_html_tags( $_POST['mh_buzz_categroy'] );
				$_POST['mh_buzz_categroy'] = $this->util->strip_unsafe_tags( $_POST['mh_buzz_categroy'] );
			}
			
			if( isset($_POST['mh_buzz_alias']) ){
				$_POST['mh_buzz_alias'] = $this->util->strip_html_tags( $_POST['mh_buzz_alias'] );
				$_POST['mh_buzz_alias'] = $this->util->strip_unsafe_tags( $_POST['mh_buzz_alias'] );
			}
			
			//if( isset($_POST['mh_buzz_date']) ){
			//	$_POST['mh_buzz_date'] = $this->util->strip_html_tags( $_POST['mh_buzz_date'] );
			//	$_POST['mh_buzz_date'] = $this->util->strip_unsafe_tags( $_POST['mh_buzz_date'] );
			//	$formatdate = date("Y-m-d H:i:s ",strtotime($_POST['mh_buzz_date']));
			//}
			
			$status = "Inactive";
			if( isset($_POST['mhbuzz_status']) ){
				$_POST['mhbuzz_status'] = $this->util->strip_html_tags( $_POST['mhbuzz_status'] );
				$_POST['mhbuzz_status'] = $this->util->strip_unsafe_tags( $_POST['mhbuzz_status'] );
				
				if($_POST['mhbuzz_status'] == 1){
					
					$status="Active";
				}
				else{
					
					$status="Inactive";
				}
				
			}
			
			if( isset($_POST['mhbuzz_short_description']) ){
				//$_POST['mhbuzz_short_description'] = $this->util->strip_html_tags( $_POST['mhbuzz_short_description'] );
				$_POST['mhbuzz_short_description'] = $this->util->strip_unsafe_tags( $_POST['mhbuzz_short_description'] );
			}
			
			if( isset($_POST['mhbuzz_full_description']) ){
				//$_POST['mhbuzz_full_description'] = $this->util->strip_html_tags( $_POST['mhbuzz_full_description'] );
				$_POST['mhbuzz_full_description'] = $this->util->strip_unsafe_tags( $_POST['mhbuzz_full_description'] );
			}
			
			
			
			
			$this->mhbuzzdao->buzz_title 				= $_POST['mh_buzz_title'];
			$this->mhbuzzdao->buzz_categroy				= $_POST['mh_buzz_categroy'];
			$this->mhbuzzdao->buzz_alias				= $_POST['mh_buzz_alias'];
			$this->mhbuzzdao->buzz_status				= $status;
			$this->mhbuzzdao->buzz_short_description 	= $_POST['mhbuzz_short_description'];
			$this->mhbuzzdao->buzz_full_description 	= $_POST['mhbuzz_full_description'];
			$this->mhbuzzdao->ip						= "1.2.2.14";
			$this->mhbuzzdao->created_by 				= "test";
			
			$data_result = $this->mhbuzzdao->insert_record();
			
			if($data_result->resultStatus == "Success" || $data_result->resultStatus == "Warning"){
				
				if( isset($_SESSION['session_images']) && !empty($_SESSION['session_images']) ){
					$img_res_array = array();
					foreach($_SESSION['session_images'] as $img){
						
						$img_raw_data = $this->util->getImageRawData($img);						
						$fileName = $img_raw_data['filename']. '.' .$img_raw_data['extension'];
						
						$thumbName = "thumb_".$fileName;
										
						$target_file = IMAGE_PATH.$fileName;
						
						
						if(rename($img,$target_file)){
							
							$this->util->create_thumb_image($target_file,$thumbName);
							
							// Add code for insert in image table
							$this->commondao->module				= "buzz";
							$this->commondao->module_reference_id   = $data_result->lastInsertId;
							$this->commondao->image_url             = IMAGE_URL;
							$this->commondao->image_path            = IMAGE_PATH;
							$this->commondao->image_name            = $fileName;
							
							$result = $this->commondao->insert_image_record();
						}
						else{
							error_log("File Not Uploaded");
							$img_res_array[] = $img; 
						}
					}
				}
				
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
		 $buzz_id = $this->util->safeNumber($_REQUEST['id']);
		 if( $buzz_id != ""){
			$this->mhbuzzdao->buzz_id 		= $buzz_id;
			$data_result = $this->mhbuzzdao->soft_delete_record();
			if( $data_result->resultStatus == "Success" ){
				$data_result->resultMessage = "Deleted successful.";
				$parmas['offset'] 	= 0;
				$parmas['limit'] 	= 10;
				$this->mhbuzzdao->params =  $parmas;
				$data_result = $this->mhbuzzdao->get_records();
			}
			print_r(json_encode($data_result));
		 }
		 exit(0);
	}
	
	
	/* For edting form data and update  */
		public function edit_data(){
		try{
			$this->log->logIt($this->module."-"."edit_data");
			if( isset($_POST['mh_buzz_title']) ){
				$_POST['mh_buzz_title'] = $this->util->strip_html_tags( $_POST['mh_buzz_title'] );
				$_POST['mh_buzz_title'] = $this->util->strip_unsafe_tags( $_POST['mh_buzz_title'] );
			}
			
			if( isset($_POST['mh_buzz_categroy']) ){
				$_POST['mh_buzz_categroy'] = $this->util->strip_html_tags( $_POST['mh_buzz_categroy'] );
				$_POST['mh_buzz_categroy'] = $this->util->strip_unsafe_tags( $_POST['mh_buzz_categroy'] );
			}
			
			if( isset($_POST['mh_buzz_alias']) ){
				$_POST['mh_buzz_alias'] = $this->util->strip_html_tags( $_POST['mh_buzz_alias'] );
				$_POST['mh_buzz_alias'] = $this->util->strip_unsafe_tags( $_POST['mh_buzz_alias'] );
			}
			
			//if( isset($_POST['mh_buzz_date']) ){
			//	$_POST['mh_buzz_date'] = $this->util->strip_html_tags( $_POST['mh_buzz_date'] );
			//	$_POST['mh_buzz_date'] = $this->util->strip_unsafe_tags( $_POST['mh_buzz_date'] );
			//	$formatdate = date("Y-m-d H:i:s ",strtotime($_POST['mh_buzz_date']));
			//}
			//
			$status = "Inactive";
			if( isset($_POST['mhbuzz_status']) ){
				$_POST['mhbuzz_status'] = $this->util->strip_html_tags( $_POST['mhbuzz_status'] );
				$_POST['mhbuzz_status'] = $this->util->strip_unsafe_tags( $_POST['mhbuzz_status'] );
				
				if($_POST['mhbuzz_status'] == 1){
					
					$status="Active";
				}
				else{
					
					$status="Inactive";
				}
				
			}
			
			if( isset($_POST['mhbuzz_short_description']) ){
				//$_POST['mhbuzz_short_description'] = $this->util->strip_html_tags( $_POST['mhbuzz_short_description'] );
				$_POST['mhbuzz_short_description'] = $this->util->strip_unsafe_tags( $_POST['mhbuzz_short_description'] );
			}
			
			if( isset($_POST['mhbuzz_full_description']) ){
				//$_POST['mhbuzz_full_description'] = $this->util->strip_html_tags( $_POST['mhbuzz_full_description'] );
				$_POST['mhbuzz_full_description'] = $this->util->strip_unsafe_tags( $_POST['mhbuzz_full_description'] );
			}
			
		
			
			
			$buzz_id = $this->util->safeNumber($_REQUEST['buzz_id']);
			if( $buzz_id != ""){
				$this->mhbuzzdao->buzz_id 	   				= $buzz_id;
				$this->mhbuzzdao->buzz_title 				= $_POST['mh_buzz_title'];
				$this->mhbuzzdao->buzz_categroy				= $_POST['mh_buzz_categroy'];
				$this->mhbuzzdao->buzz_alias				= $_POST['mh_buzz_alias'];
				$this->mhbuzzdao->buzz_status				= $status;
				$this->mhbuzzdao->buzz_short_description 	= $_POST['mhbuzz_short_description'];
				$this->mhbuzzdao->buzz_full_description 	= $_POST['mhbuzz_full_description'];
				$this->mhbuzzdao->modified_by 				= $_SESSION['AdminDetails']['str_nick_name'];
				
				$data_result = $this->mhbuzzdao->update_record();
			   if( $data_result->resultStatus == "Success" ){
				
				if( isset($_SESSION['session_images']) && !empty($_SESSION['session_images']) ){
						$img_res_array = array();
						foreach($_SESSION['session_images'] as $img){
							
							$img_raw_data = $this->util->getImageRawData($img);						
							$fileName = $img_raw_data['filename']. '.' .$img_raw_data['extension'];
							
							$thumbName = "thumb_".$fileName;
											
							$target_file = IMAGE_PATH.$fileName;
							
							
							if(rename($img,$target_file)){
								
								$this->util->create_thumb_image($target_file,$thumbName);
								
								// Add code for insert in image table
								$this->commondao->module				= "buzz";
								$this->commondao->module_reference_id   = $buzz_id;
								$this->commondao->image_url             = IMAGE_URL;
								$this->commondao->image_path            = IMAGE_PATH;
								$this->commondao->image_name            = $fileName;
								
								$result = $this->commondao->insert_image_record();
							}
							else{
								error_log("File Not Uploaded");
								$img_res_array[] = $img; 
							}
						}
					}
					
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
			$search_category = "";
			$parmas = array();
			
			//$this->log->logIt($this->module."-"."search_name"."-".$_POST['mh_buzz_search_title']);
			
			if( isset($_REQUEST['action']) && $_REQUEST['action'] == "search" ){
				
				
				if( isset($_POST['mh_buzz_search_title']) ){
					$_POST['mh_buzz_search_title'] = $this->util->strip_html_tags( $_POST['mh_buzz_search_title'] );
					$search_name = $this->util->strip_unsafe_tags( $_POST['mh_buzz_search_title'] );
					
					$srch_entries_par_page= $this->util->strip_unsafe_tags($_POST['srch_entries_par_page']);
					if( $srch_entries_par_page !=''){
						$limit =  $srch_entries_par_page;
					}
				}
				if( isset($_POST['mh_buzz_search_status']) ){
					$_POST['mh_buzz_search_status'] = $this->util->strip_html_tags( $_POST['mh_buzz_search_status'] );
					$search_status = $this->util->strip_unsafe_tags( $_POST['mh_buzz_search_status'] );
					
					$srch_entries_par_page= $this->util->strip_unsafe_tags($_POST['srch_entries_par_page']);
					if( $srch_entries_par_page !=''){
						$limit =  $srch_entries_par_page;
					}
				}
				
				if( isset($_POST['mh_buzz_categroy']) ){
					$_POST['mh_buzz_categroy'] = $this->util->strip_html_tags( $_POST['mh_buzz_categroy'] );
					$search_category = $this->util->strip_unsafe_tags( $_POST['mh_buzz_categroy'] );
					
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
					if( isset($_POST['mh_buzz_search_title']) ){
						$_POST['mh_buzz_search_title'] = $this->util->strip_html_tags( $_POST['mh_buzz_search_title'] );
						$search_name = $this->util->strip_unsafe_tags( $_POST['mh_buzz_search_title'] );
					}
					if( isset($_POST['mh_buzz_search_status']) ){
						$_POST['mh_buzz_search_status'] = $this->util->strip_html_tags( $_POST['mh_buzz_search_status'] );
						$search_status = $this->util->strip_unsafe_tags( $_POST['mh_buzz_search_status'] );
					}
					if( isset($_POST['mh_buzz_categroy']) ){
						$_POST['mh_buzz_categroy'] = $this->util->strip_html_tags( $_POST['mh_buzz_categroy'] );
						$search_category = $this->util->strip_unsafe_tags( $_POST['mh_buzz_categroy'] );
					}
				}
			}
			$parmas['offset'] 				= $offset;
			$parmas['limit'] 				= $limit;
			$parmas['txtname'] 				= $search_name;
			$parmas['status'] 				= $search_status;
			$parmas['category'] 			= $search_category;
			$this->mhbuzzdao->params 		= $parmas;
			
			
			
			$result_data 			        = $this->mhbuzzdao->get_records();
			
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
	
	
	# @author: Vihang Joshi<mavenagency.co.za>
    # @version: 1.0.0
    # @date: 2016-05-12
    # @definition: Uploads images in bulk or single amount in Cache folder first and final it will be uploaded in Uploads folder
	public function images_upload(){
		
		try{
			$this->log->logIt($this->module."-"."images_upload");
			if($_POST['image_form_submit'] == 1)
			{
				$images_arr = $sessionImgArr =  $tmp_array = array();
				foreach($_FILES['images']['name'] as $key=>$val){
					$image_name = $_FILES['images']['name'][$key];
					$tmp_name 	= $_FILES['images']['tmp_name'][$key];
					$size 		= $_FILES['images']['size'][$key];
					$type 		= $_FILES['images']['type'][$key];
					$error 		= $_FILES['images']['error'][$key];
					
					############ Remove comments if you want to upload and stored images into the "uploads/" folder #############
					
					$img_raw_data = $this->util->getImageRawData($_FILES['images']['name'][$key]);
					$fileName = time().uniqid() . '.' . $img_raw_data['extension'];
			
					$target_dir = BASE_PATH."/Cache/";
					$target_file = $target_dir.$fileName;
					
					if(move_uploaded_file($_FILES['images']['tmp_name'][$key],$target_file)){
						//$images_arr['image_name'] = $target_file;
						array_push($sessionImgArr,$target_file);
					}
					$extra_info = getimagesize($target_file);
					$tmp_images_arr['image_name'] = "data:" . $extra_info["mime"] . ";base64," . base64_encode(file_get_contents($target_file));
					//$tmp_array = array('image_name' => $fileName);
					//array_push($sessionImgArr,$images_arr);
				}
				
				$_SESSION['session_images'] = $sessionImgArr;
				
				foreach($_SESSION['session_images'] as $img){
					
					$img_raw_data = $this->util->getImageRawData($img);
					$extra_info = getimagesize($img);
					$display_images_arr['httpPath'] = BASE_PATH;
					
					$display_images_arr['imageData'] = "data:" . $extra_info["mime"] . ";base64," . base64_encode(file_get_contents($img));
					$display_images_arr['image'] = $img_raw_data['basename'];
					$display_images_arr['imageid'] = $img_raw_data['filename'];
					
					$imageArray[] = $display_images_arr;
				}
				
				$response_array['resultData'] = $imageArray;
				
				echo json_encode($response_array);
				exit(0);
			}
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."images_upload"."-".$e);
		}	
		
	}
	
	# @author: Vihang Joshi<mavenagency.co.za>
    # @version: 1.0.0
    # @date: 2016-05-12
    # @definition: Deletes images from table as well as from the physical location.
	public function delete_image(){
		
		try{
			$this->log->logIt($this->module."-"."delete_image");
			$images = array();
			if(isset($_POST['image']))
			{
				$image = $_POST['image'];
				$modal_action = isset($_POST['modal_action']) ? $_POST['modal_action'] : '';
				
				if(strtolower($modal_action) == "add_data"){

					$target_image = BASE_PATH."/Cache/".$image;
				}
				else if(strtolower($modal_action) == "edit_data"){
					$target_image = BASE_PATH."/Uploads/".$image;
					$module_ref_id = isset($_POST['buzz_id']) ? $_POST['buzz_id'] : '';
					$this->commondao->delete_image_record('buzz', $module_ref_id,$image);
				}
				
				if(($key = array_search($image, $_SESSION['session_images'])) !== false) {
					unset($_SESSION['session_images'][$key]);
				}
				
				if(!empty($image)){		
						
					if(unlink($target_image)){
						$response['resultStatus'] = "success";
						$response['resultMessage'] = "Image successfully deleted.";	
					}
					else{
						$response['resultStatus'] = "warning";
						$response['resultImages'] = $images;
						$response['resultMessage'] = "No image found on location!";	
					}
				}else{
					$response['resultStatus'] = "warning";
					$response['resultImages'] = $images;
					$response['resultMessage'] = "No image found on location!";	
				}
				$responseArray['resultData'] = $response;
				
			}
			else{
				$responseArray['resultData'] = array();
			}
			echo json_encode($responseArray);
			exit(0);
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."delete_image"."-".$e);
		}
		
	}
	

	

}				
?>

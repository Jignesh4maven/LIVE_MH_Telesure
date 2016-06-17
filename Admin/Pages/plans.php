<?php
require_once(BASE_PATH."/Dbaccess/plansdao.php");
require_once(BASE_PATH."/Util/util.php");
require_once(BASE_PATH."/Dbaccess/commondao.php");
class plans 
{
	private $module = 'plans';
	private $log;	
    private $plansdao;
	private $util;
	private $need;
	private $covered;
	private $faq;
	private $commondao;
	public function __construct(){
	
		$this->log			=	new logger();
		$this->plansdao		=	new plansdao();
		$this->util			=	new util();
		$this->commondao   	=   new commondao();
		
		//for plan detail  label
		$this->need	 	= "need";
		$this->covered	= "covered";
		$this->faq		= "faq";
	}	

	public function load(){
		try{
			$this->log->logIt($this->module."-"."Page Load");		
			global $tpl;
			global $config;
			$parmas['limit'] 				= 10;
			$parmas['offset'] 				= 0;
			$this->plansdao->params 		= $parmas;
			$this->plansdao->limit 			= 10;
			$this->plansdao->offset 		= 0;
			$result_data 					= $this->plansdao->get_records();
			$result_list 					= "";
			$total_records 					= 0;
			
			
			
			if($result_data->resultStatus == "Success"){
				$result_list 	= $result_data->resultData['list'];
				$total_records	= $result_data->resultData['total'];
			}
			
			
			//print_r($result_data);
			
			$result_json = json_encode ($result_data);
			
			
			$tpl->assign(array(	
								"T_BODY"			=>	'plans'.$config['tplEx'],
								"page_name"			=>  'Plans',
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
			
			//getting plan type
			$plan_type_names=array();
			$result_plan_type = $this->plansdao->get_plan_types();
			
			if($result_plan_type->resultStatus == "Success"){
				
				$plan_type_names = $result_plan_type->resultData['list'];
			}
			
			$tpl->assign(array(	
								"T_BODY"			=>	'plans_add_edit'.$config['tplEx'],
								"blog_name"			=>  'Plans',
								"plan_type_names"	=>	$plan_type_names,
								"form_action"		=>	'add_data',
							)
						);
			if( isset($_REQUEST['plan_id']) &&  $_REQUEST['plan_id'] != ""){
				$this->plansdao->plans_id =  $_REQUEST['plan_id'];
				$result_data = $this->plansdao->get_record();
				$result_data1 = $this->plansdao->get_detail();
				
				//for image
				$img_result_data = $this->commondao->get_image_records('plans',$this->plansdao->plans_id);
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
				
				
				if( $result_data1->resultStatus == "Success" ){
					$tpl->assign(array(	
								"data_need"		=>	$result_data1->resultData['list'][0],
								"data_covered"	=>	$result_data1->resultData['list'][1],
								"data_faq"		=>	$result_data1->resultData['list'][2],
								'form_action'	=>	'edit_data',
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
			
			//for General tab
			if( isset($_POST['plans_title']) ){
				$plans_title = $this->util->strip_html_tags( $_POST['plans_title'] );
				$plans_title = $this->util->strip_unsafe_tags( $_POST['plans_title'] );
			}
			
			if( isset($_POST['plans_alias']) ){
				$plans_alias = $this->util->strip_html_tags( $_POST['plans_alias'] );
				$plans_alias = $this->util->strip_unsafe_tags( $_POST['plans_alias'] );
			}
			
			$status = "Inactive";
			if( isset($_POST['plans_status']) ){
				$plans_status = $this->util->strip_html_tags( $_POST['plans_status'] );
				$plans_status = $this->util->strip_unsafe_tags( $_POST['plans_status'] );
				
				if($plans_status == 1){
					
					$status="Active";
				}
				else{
					
					$status="Inactive";
				}
				
			}
			
			if( isset($_POST['plans_image']) ){
				$plans_image = $this->util->strip_html_tags( $_POST['plans_image'] );
				$plans_image = $this->util->strip_unsafe_tags( $_POST['plans_image'] );
			}
			
			if( isset($_POST['plans_short_description']) ){
				//$plans_short_description = $this->util->strip_html_tags( $_POST['plans_short_description'] );
				$plans_short_description = $this->util->strip_unsafe_tags( $_POST['plans_short_description'] );
			}
			
			if( isset($_POST['plans_full_description']) ){
				//$plans_full_description = $this->util->strip_html_tags( $_POST['plans_full_description'] );
				$plans_full_description = $this->util->strip_unsafe_tags( $_POST['plans_full_description'] );
			}
			
			if( isset($_POST['plan_type']) ){
				$_POST['plan_type'] = $this->util->strip_html_tags( $_POST['plan_type'] );
				$plan_type = $this->util->strip_unsafe_tags( $_POST['plan_type'] );
			}
			
			$this->plansdao->plans_title 							= $plans_title;
			$this->plansdao->plans_alias 							= $plans_alias;
			$this->plansdao->plans_status 							= $status;
			$this->plansdao->plans_image 							= $plans_image;
			$this->plansdao->plans_short_description 				= $plans_short_description;
			$this->plansdao->plans_full_description 				= $plans_full_description;
			$this->plansdao->plan_type								= $plan_type;
			$this->plansdao->ip										= "1.2.2.14";
			$this->plansdao->created_by 							= "test";
			
			if($plans_title !="" || $plans_alias !="" || $plans_short_description !="" || $plans_full_description !=""){
					$data_result = $this->plansdao->insert_record();
			}
			
			
			if( $data_result->resultStatus == "Success" ){
				
				$plan_id 	= $data_result->resultData['inserted_id'];

				//for image insert in tbl_images table
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
							$this->commondao->module				= "plans";
							$this->commondao->module_reference_id   = $plan_id;
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
				//end image code
					
				
					if( isset($_POST['plans_need_description']) ){
						//$plans_need_description = $this->util->strip_html_tags( $_POST['plans_need_description'] );
						$plans_need_description = $this->util->strip_unsafe_tags( $_POST['plans_need_description'] );
					}
					
					if( isset($_POST['plans_covered_description']) ){
						//$plans_covered_description = $this->util->strip_html_tags( $_POST['plans_covered_description'] );
						$plans_covered_description = $this->util->strip_unsafe_tags( $_POST['plans_covered_description'] );
					}
				
					if( isset($_POST['plans_faq']) ){
						//$plans_faq = $this->util->strip_html_tags( $_POST['plans_faq'] );
						$plans_faq = $this->util->strip_unsafe_tags( $_POST['plans_faq'] );
					}
					
				
					$this->plansdao->detail_labels 							= $this->need;
					$this->plansdao->details_values 						= $plans_need_description;
					$this->plansdao->plan_id								= $plan_id;
					
					if($plans_need_description !="" ){
						$data_result = $this->plansdao->insert_detail();
					}
			
					
					
					$this->plansdao->detail_labels 							= $this->covered;
					$this->plansdao->details_values 						= $plans_covered_description;
					$this->plansdao->plan_id								= $plan_id;
					
					if($plans_covered_description !="" ){
						$data_result = $this->plansdao->insert_detail();
					}
					
					$this->plansdao->detail_labels 							= $this->faq;
					$this->plansdao->details_values 						= $plans_faq;
					$this->plansdao->plan_id								= $plan_id;
					
					if($plans_faq !="" ){
						$data_result = $this->plansdao->insert_detail();
					}
					
			}
			
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
		 $plan_id = $this->util->safeNumber($_REQUEST['id']);
		 if( $plan_id != ""){
			$this->plansdao->plan_id 		= $plan_id;
			$data_result = $this->plansdao->soft_delete_record();
			if( $data_result->resultStatus == "Success" ){
				$data_result->resultMessage = "Deleted successful.";
				$parmas['offset'] 	= 0;
				$parmas['limit'] 	= 10;
				$this->plansdao->params =  $parmas;
				$data_result = $this->plansdao->get_records();
			}
			print_r(json_encode($data_result));
		 }
		 exit(0);
	}
	
	/* For edting form data and update  */
		public function edit_data(){
		try{
			$this->log->logIt($this->module."-"."edit_data");
			//for General tab
			if( isset($_POST['plans_title']) ){
				$plans_title = $this->util->strip_html_tags( $_POST['plans_title'] );
				$plans_title = $this->util->strip_unsafe_tags( $_POST['plans_title'] );
			}
			
			if( isset($_POST['plans_alias']) ){
				$plans_alias = $this->util->strip_html_tags( $_POST['plans_alias'] );
				$plans_alias = $this->util->strip_unsafe_tags( $_POST['plans_alias'] );
			}
			
			$status = "Inactive";
			if( isset($_POST['plans_status']) ){
				$plans_status = $this->util->strip_html_tags( $_POST['plans_status'] );
				$plans_status = $this->util->strip_unsafe_tags( $_POST['plans_status'] );
				
				if($plans_status == 1){
					
					$status="Active";
				}
				else{
					
					$status="Inactive";
				}
				
			}
			
			if( isset($_POST['plans_image']) ){
				$plans_image = $this->util->strip_html_tags( $_POST['plans_image'] );
				$plans_image = $this->util->strip_unsafe_tags( $_POST['plans_image'] );
			}
			
			if( isset($_POST['plans_short_description']) ){
				$plans_short_description = $this->util->strip_html_tags( $_POST['plans_short_description'] );
				$plans_short_description = $this->util->strip_unsafe_tags( $_POST['plans_short_description'] );
			}
			
			if( isset($_POST['plans_full_description']) ){
				$plans_full_description = $this->util->strip_html_tags( $_POST['plans_full_description'] );
				$plans_full_description = $this->util->strip_unsafe_tags( $_POST['plans_full_description'] );
			}
			
			if( isset($_POST['plan_type']) ){
				$_POST['plan_type'] = $this->util->strip_html_tags( $_POST['plan_type'] );
				$plan_type = $this->util->strip_unsafe_tags( $_POST['plan_type'] );
			}
			
			$plans_id = $this->util->safeNumber($_REQUEST['plan_id']);
			if( $plans_id != ""){
				
				$this->plansdao->plan_id 						= $plans_id;
				$this->plansdao->plans_title 					= $plans_title;
				$this->plansdao->plans_alias 					= $plans_alias;
				$this->plansdao->plans_status 					= $status;
				$this->plansdao->plans_image 					= $plans_image;
				$this->plansdao->plans_short_description 		= $plans_short_description;
				$this->plansdao->plans_full_description 		= $plans_full_description;
				$this->plansdao->plan_type						= $plan_type;
				$this->plansdao->modified_by 					= $_SESSION['AdminDetails']['str_nick_name'];
			  
				$data_result = $this->plansdao->update_record();
				
				/* for detail tab*/
				
				//for details tab
				
				if( isset($_POST['plans_need_description']) ){
					//$plans_need_description = $this->util->strip_html_tags( $_POST['plans_need_description'] );
					$plans_need_description = $this->util->strip_unsafe_tags( $_POST['plans_need_description'] );
				}
				
				if( isset($_POST['plans_covered_description']) ){
					//$plans_covered_description = $this->util->strip_html_tags( $_POST['plans_covered_description'] );
					$plans_covered_description = $this->util->strip_unsafe_tags( $_POST['plans_covered_description'] );
				}
			
				if( isset($_POST['plans_faq']) ){
					//$plans_faq = $this->util->strip_html_tags( $_POST['plans_faq'] );
					$plans_faq = $this->util->strip_unsafe_tags( $_POST['plans_faq'] );
				}
				
				$this->plansdao->detail_labels 							= $this->need;
				$this->plansdao->details_values 						= $plans_need_description;
				
				$data_result = $this->plansdao->update_detail();
			
				$this->plansdao->detail_labels 							= $this->covered;
				$this->plansdao->details_values 						= $plans_covered_description;
				
				$data_result = $this->plansdao->update_detail();
				
				$this->plansdao->detail_labels 							= $this->faq;
				$this->plansdao->details_values 						= $plans_faq;
			
				$data_result = $this->plansdao->update_detail();
		   
				if( $data_result->resultStatus == "Success" ){
					
					//for image
					// for image
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
								$this->commondao->module				= "plans";
								$this->commondao->module_reference_id   = $plans_id;
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
			$parmas = array();
			
			
			if( isset($_REQUEST['action']) && $_REQUEST['action'] == "search" ){
				
				
				if( isset($_POST['plan_search_title']) ){
					$_POST['plan_search_title'] = $this->util->strip_html_tags( $_POST['plan_search_title'] );
					$search_name = $this->util->strip_unsafe_tags( $_POST['plan_search_title'] );
					
					$srch_entries_par_page= $this->util->strip_unsafe_tags($_POST['srch_entries_par_page']);
					if( $srch_entries_par_page !=''){
						$limit =  $srch_entries_par_page;
					}
				}
				if( isset($_POST['plan_search_status']) ){
					$_POST['plan_search_status'] = $this->util->strip_html_tags( $_POST['plan_search_status'] );
					$search_status = $this->util->strip_unsafe_tags( $_POST['plan_search_status'] );
					
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
					if( isset($_POST['plan_search_title']) ){
						$_POST['plan_search_title'] = $this->util->strip_html_tags( $_POST['plan_search_title'] );
						$search_name = $this->util->strip_unsafe_tags( $_POST['plan_search_title'] );
					}
					if( isset($_POST['plan_search_status']) ){
						$_POST['plan_search_status'] = $this->util->strip_html_tags( $_POST['plan_search_status'] );
						$search_status = $this->util->strip_unsafe_tags( $_POST['plan_search_status'] );
					}
				}
			}
			$parmas['offset'] 				= $offset;
			$parmas['limit'] 				= $limit;
			$parmas['txtname'] 				= $search_name;
			$parmas['status'] 				= $search_status;
			$this->plansdao->params 		= $parmas;
			$result_data 			        = $this->plansdao->get_records();
			
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
	
	 // for image preview
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
	/* for delete upload image on preview*/
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
					$module_ref_id = isset($_POST['plan_id']) ? $_POST['plan_id'] : '';
					$this->commondao->delete_image_record('plans', $module_ref_id,$image);
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

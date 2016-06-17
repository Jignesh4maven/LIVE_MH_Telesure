<?php
require_once(BASE_PATH."/Dbaccess/bannerdao.php");
require_once(BASE_PATH."/Dbaccess/commondao.php");
require_once(BASE_PATH."/Conf/common.php");
require_once(BASE_PATH."/Util/util.php");

class banner 
{
	private $module = 'banner';
	private $log;	
	private $bannerdao;
	private $util;
	public function __construct(){
		$this->log=new logger();
		$this->bannerdao= new bannerdao();
		$this->commondao= new commondao();
		$this->util=new util();
		/*if($_SESSION['session_images']){
			unset($_SESSION['session_images']);
		}*/
	}	

	public function load(){
		try{
			$this->log->logIt($this->module."-"."Page Load");		
			global $tpl;
			global $config;
			$parmas['limit'] 				= 10;
			$parmas['offset'] 				= 0;
			$this->bannerdao->params 		= $parmas;
			$this->bannerdao->limit 		= 10;
			$this->bannerdao->offset 		= 0;
			$result_data 					= $this->bannerdao->get_records();
			$result_list 					= "";
			$total_records 					= 0;
		 
			if($result_data->resultStatus == "Success"){
				$result_list 	= $result_data->resultData['list'];
				$total_records	= $result_data->resultData['total'];
			}
			
			
			//print_r($result_data);
			
			$result_json = json_encode ($result_data);
			$tpl->assign(array(	
								"T_BODY"			=>	'banner'.$config['tplEx'],
								"page_name"			=>  'Banner',
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
								"T_BODY"			=>	'banner_add_edit'.$config['tplEx'],
								"blog_name"			=>  'Banner/Gallery',
								'form_action'		=>	'add_data',
							)
						);
			if( isset($_REQUEST['banner_id']) &&  $_REQUEST['banner_id'] != ""){
				$this->bannerdao->banner_id =  $_REQUEST['banner_id'];
				$result_data = $this->bannerdao->get_record();
				
				$img_result_data = $this->commondao->get_image_records('banner',$this->bannerdao->banner_id );
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
								"data_row"			=>	$result_data->resultData['list'],
								"gallery_images"	=>	$final_array,
								'form_action'		=>	'edit_data',
								"IMAGE_PATH"		=>  HTTP_PATH.'/Uploads/',
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
	# Modified By 		: Vihang Joshi <mavenagency.co.za>
	# Modified Content  : Added thumb image creation code.
	#					  - Updated code for moving image from Cache folder to Uploads folder.
	# Modified Date		: 2016-05-16
	public function add_data(){
		try{
			
			$this->log->logIt($this->module."-"."add_data");
			
			if( isset($_POST['banner_title']) ){
				$_POST['banner_title'] = $this->util->strip_html_tags( $_POST['banner_title'] );
				$_POST['banner_title'] = $this->util->strip_unsafe_tags( $_POST['banner_title'] );
			}
			
			if( isset($_POST['banner_short_description']) ){
				//$_POST['banner_short_description'] = $this->util->strip_html_tags( $_POST['banner_short_description'] );
				$_POST['banner_short_description'] = $this->util->strip_unsafe_tags( $_POST['banner_short_description'] );
			}
			
			//if( isset($_POST['banner_display_order']) ){
			//	$_POST['banner_display_order'] = $this->util->strip_html_tags( $_POST['banner_display_order'] );
			//	$_POST['banner_display_order'] = $this->util->strip_unsafe_tags( $_POST['banner_display_order'] );
			//}
			
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
			
			$this->bannerdao->banner_title 				= $_POST['banner_title'];
			$this->bannerdao->banner_short_description	= $_POST['banner_short_description'];
			//$this->bannerdao->banner_display_order		= $_POST['banner_display_order'];
			$this->bannerdao->banner_status				= $status;
			$this->bannerdao->banner_image				= $_POST['banner_image'];
			$this->bannerdao->ip						= "1.2.2.14";
			$this->bannerdao->created_by 				= "test";
			$data_result = $this->bannerdao->insert_record();
			
			if($data_result->resultStatus == "Success"){
				$data_result->resultAction = "Insert";
				
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
							$this->commondao->module				= "banner";
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
		 $banner_id = $this->util->safeNumber($_REQUEST['id']);
		 if( $banner_id != ""){
			$this->bannerdao->banner_id 		= $banner_id;
			$data_result = $this->bannerdao->soft_delete_record();
			if( $data_result->resultStatus == "Success" ){
				$data_result->resultMessage = "Deleted successful.";
				$parmas['offset'] 	= 0;
				$parmas['limit'] 	= 10;
				$this->bannerdao->params =  $parmas;
				$data_result = $this->bannerdao->get_records();
			}
			print_r(json_encode($data_result));
		 }
		 exit(0);
	}
	
	/* For edting form data and update  */
	# Modified By 		: Vihang Joshi <mavenagency.co.za>
	# Modified Content  : Added upload image code.
	#					  - Updated code for moving image from Cache folder to Uploads folder.
	# Modified Date		: 2016-05-16
	public function edit_data(){
		try{
			$this->log->logIt($this->module."-"."edit_data");
			if( isset($_POST['banner_title']) ){
				$_POST['banner_title'] = $this->util->strip_html_tags( $_POST['banner_title'] );
				$_POST['banner_title'] = $this->util->strip_unsafe_tags( $_POST['banner_title'] );
			}
			
			if( isset($_POST['banner_short_description']) ){
				//$_POST['banner_short_description'] = $this->util->strip_html_tags( $_POST['banner_short_description'] );
				$_POST['banner_short_description'] = $this->util->strip_unsafe_tags( $_POST['banner_short_description'] );
			}
			
			//if( isset($_POST['banner_display_order']) ){
			//	$_POST['banner_display_order'] = $this->util->strip_html_tags( $_POST['banner_display_order'] );
			//	$_POST['banner_display_order'] = $this->util->strip_unsafe_tags( $_POST['banner_display_order'] );
			//}
			
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
			
			
			if( isset($_POST['banner_image']) ){
				$_POST['banner_image'] = $this->util->strip_html_tags( $_POST['banner_image'] );
				$_POST['banner_image'] = $this->util->strip_unsafe_tags( $_POST['banner_image'] );
			}
			
			$banner_id = $this->util->safeNumber($_REQUEST['banner_id']);
			if( $banner_id != ""){
				
				$this->bannerdao->banner_id 					= $banner_id;
			 	$this->bannerdao->banner_title 					= $_POST['banner_title'];
				$this->bannerdao->banner_short_description		= $_POST['banner_short_description'];
				//$this->bannerdao->banner_display_order		= $_POST['banner_display_order'];
				$this->bannerdao->banner_status					= $status;
				$this->bannerdao->banner_image					= $_POST['banner_image'];
				$this->bannerdao->modified_by 					= $_SESSION['AdminDetails']['str_nick_name'];
				
			   $data_result = $this->bannerdao->update_record();
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
								$this->commondao->module				= "banner";
								$this->commondao->module_reference_id   = $banner_id;
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
			$parmas = array();
			
			//$this->log->logIt($this->module."-"."search_name"."-".$_POST['srch_testimonial_title']);
			
			if( isset($_REQUEST['action']) && $_REQUEST['action'] == "search" ){
				if( isset($_POST['srch_banner_title']) ){
					$_POST['srch_banner_title'] = $this->util->strip_html_tags( $_POST['srch_banner_title'] );
					$search_name = $this->util->strip_unsafe_tags( $_POST['srch_banner_title'] );
					$srch_entries_par_page= $this->util->strip_unsafe_tags($_POST['srch_entries_par_page']);
					if( $srch_entries_par_page !=''){
						$limit =  $srch_entries_par_page;
					}
				}
				
				if( isset($_POST['search_banner_status']) ){
					$_POST['search_banner_status'] = $this->util->strip_html_tags( $_POST['search_banner_status'] );
					$search_status = $this->util->strip_unsafe_tags( $_POST['search_banner_status'] );
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
					if( isset($_POST['srch_banner_title']) ){
						$_POST['srch_banner_title'] = $this->util->strip_html_tags( $_POST['srch_banner_title'] );
						$search_name = $this->util->strip_unsafe_tags( $_POST['srch_banner_title'] );
					}
					
					if( isset($_POST['search_banner_status']) ){
						$_POST['search_banner_status'] = $this->util->strip_html_tags( $_POST['search_banner_status'] );
						$search_status = $this->util->strip_unsafe_tags( $_POST['search_banner_status'] );
					}
				}
			}
			$parmas['offset'] 				= $offset;
			$parmas['limit'] 				= $limit;
			$parmas['txtname'] 				= $search_name;
			$parmas['txtstatus'] 			= $search_status;
			$this->bannerdao->params 		=  $parmas;
			$result_data 			        = $this->bannerdao->get_records();
			
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
					//$img = "data:" . $extra_info["mime"] . ";base64," . base64_encode(file_get_contents($img));
					//$display_images_arr['imageData'] = "<img src=".$img."/>";
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
					$thumb_image = BASE_PATH."/Uploads/"."thumb_".$image;
					$module_ref_id = isset($_POST['banner_id']) ? $_POST['banner_id'] : '';
					$this->commondao->delete_image_record('banner', $module_ref_id,$image);
				}
				
				if(($key = array_search($image, $_SESSION['session_images'])) !== false) {
					unset($_SESSION['session_images'][$key]);
				}
				
				if(!empty($image)){		
						
					if(unlink($target_image)){
						unlink($thumb_image);
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

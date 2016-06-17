<?php
require_once(BASE_PATH."/Dbaccess/socialdao.php");
require_once(BASE_PATH."/Util/util.php");
class social 
{
	private $module = 'social';
	private $log;	
	private $socialdao;
	private $util;
	private $twitter,$facebook,$linkedin,$linkedin1,$linkedin2,$linkedin3;
	public function __construct(){
		$this->log=new logger();
		$this->socialdao 	= new socialdao();
		$this->util 		= new util();
	    
		//for social_network label
		$this->twitter		= "twitter_link";
		$this->facebook		= "facebook_link";
		$this->linkedin		= "linkedin_link";
		$this->linkedin1	= "linkedin1_link";
		$this->linkedin2	= "linkedin2_link";
		$this->linkedin3	= "linkedin3_link";
	}	

	public function load(){
		try{
			$this->log->logIt($this->module."-"."Page Load");		
			global $tpl;
			global $config;
			$result_data 					= $this->socialdao->get_records();
			$result_list 					= "";
			$total_records 					= 0;
		 
		 
			if($result_data->resultStatus == "Success"){
				$result_list 	= $result_data->resultData['list'];
				
			}
			
			
			$result_json = json_encode ($result_data);
				
			$tpl->assign(array(	
								"T_BODY"			=>	'social'.$config['tplEx'],
								"page_name"			=>  'Social',
					            "load_result_json" 	=>	$result_json,
								"load_result" 		=>	$result_list
								//"form_action"		=>  'get_data_records'
								 
							)
						);		
			 
			 
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."onLoad"."-".$e);
		}		
	}
	
	/* calling insert_form or edit_form */
	//public function form_add_edit(){
	//	try{
	//		$this->log->logIt($this->module."-"."form_add_edit");
	//		global $tpl;
	//		global $config;
	//		$tpl->assign(array(	
	//							"T_BODY"			=>	'social'.$config['tplEx'],
	//							"blog_name"			=>  'Social',
	//							'form_action'		=>	'add_data',
	//						)
	//					);
	//		/*if( isset($_REQUEST['social_id']) &&  $_REQUEST['social_id'] != ""){
	//			$this->socialdao->social_id =  $_REQUEST['social_id'];
	//			$result_data = $this->socialdao->get_record();
	//			*/
	//			//if( $result_data->resultStatus == "Success" ){
	//				$tpl->assign(array(	
	//							"T_BODY"			=>	'social'.$config['tplEx'],
	//							//"data_row"			=>	$result_data->resultData['list'],
	//							'form_action'		=>	'edit_data',
	//						)
	//					);
	//			//}
	//		//}
	//	}
	//	catch(Exception $e){
	//		echo $e;
	//		$this->log->logIt($this->module."-"."form_add_edit"."-".$e);
	//	}		
	//}
	/* getting data from input and insert */
	//public function add_data(){
	//	try{
	//		
	//		$this->log->logIt($this->module."-"."add_data");
	//		
	//		if( isset($_POST['twitterlink']) ){
	//			$_POST['twitterlink'] = $this->util->strip_html_tags( $_POST['twitterlink'] );
	//			$_POST['twitterlink'] = $this->util->strip_unsafe_tags( $_POST['twitterlink'] );
	//		}
	//		
	//		if( isset($_POST['facebooklink']) ){
	//			$_POST['facebooklink'] = $this->util->strip_html_tags( $_POST['facebooklink'] );
	//			$_POST['facebooklink'] = $this->util->strip_unsafe_tags( $_POST['facebooklink'] );
	//		}
	//		
	//		if( isset($_POST['linkdinlink']) ){
	//			$_POST['linkdinlink'] = $this->util->strip_html_tags( $_POST['linkdinlink'] );
	//			$_POST['linkdinlink'] = $this->util->strip_unsafe_tags( $_POST['linkdinlink'] );
	//		}
	//		
	//		if( isset($_POST['linkdinlink1']) ){
	//			$_POST['linkdinlink1'] = $this->util->strip_html_tags( $_POST['linkdinlink1'] );
	//			$_POST['linkdinlink1'] = $this->util->strip_unsafe_tags( $_POST['linkdinlink1'] );
	//		}
	//		
	//		if( isset($_POST['linkdinlink2']) ){
	//			$_POST['linkdinlink2'] = $this->util->strip_html_tags( $_POST['linkdinlink2'] );
	//			$_POST['linkdinlink2'] = $this->util->strip_unsafe_tags( $_POST['linkdinlink2'] );
	//		}
	//		
	//		if( isset($_POST['linkdinlink3']) ){
	//			$_POST['linkdinlink3'] = $this->util->strip_html_tags( $_POST['linkdinlink3'] );
	//			$_POST['linkdinlink3'] = $this->util->strip_unsafe_tags( $_POST['linkdinlink3'] );
	//		}
	//		
	//		$this->socialdao->ip				= "1.2.2.14";
	//		$this->socialdao->created_by 		= "test";
	//		
	//		$this->socialdao->social_network 	= $this->twitter;
	//		$this->socialdao->social_url 		= $_POST['twitterlink'];
	//		$data_result = $this->socialdao->insert_record();
	//		
	//		$this->socialdao->social_network 	= $this->facebook;
	//		$this->socialdao->social_url 		= $_POST['facebooklink'];
	//		$data_result = $this->socialdao->insert_record();
	//		
	//		$this->socialdao->social_network 	= $this->linkedin;
	//		$this->socialdao->social_url 		= $_POST['linkdinlink'];
	//		$data_result = $this->socialdao->insert_record();
	//		
	//		$this->socialdao->social_network 	= $this->linkedin1;
	//		$this->socialdao->social_url 		= $_POST['linkdinlink1'];
	//		$data_result = $this->socialdao->insert_record();
	//		
	//		$this->socialdao->social_network 	= $this->linkedin2;
	//		$this->socialdao->social_url 		= $_POST['linkdinlink2'];
	//		$data_result = $this->socialdao->insert_record();
	//		
	//		$this->socialdao->social_network 	= $this->linkedin3;
	//		$this->socialdao->social_url 		= $_POST['linkdinlink3'];
	//		$data_result = $this->socialdao->insert_record();
	//		
	//	
	//		
	//		
	//		if($data_result->resultStatus == "Success" || $data_result->resultStatus == "Warning"){
	//			$data_result->resultAction = "Insert";
	//			print_r(json_encode($data_result));
	//		}
	//		exit(0);
	//	}
	//	catch(Exception $e){
	//		echo $e;
	//		$this->log->logIt($this->module."-"."add_data"."-".$e);
	//	}		
	//}
	
	/* getting data from input and insert */
	public function edit_data(){
		try{
			
			$this->log->logIt($this->module."-"."edit_data");
			
			if( isset($_POST['twitter_link']) ){
				$_POST['twitter_link'] = $this->util->strip_html_tags( $_POST['twitter_link'] );
				$_POST['twitter_link'] = $this->util->strip_unsafe_tags( $_POST['twitter_link'] );
			}
			
			if( isset($_POST['facebook_link']) ){
				$_POST['facebook_link'] = $this->util->strip_html_tags( $_POST['facebook_link'] );
				$_POST['facebook_link'] = $this->util->strip_unsafe_tags( $_POST['facebook_link'] );
			}
			
			if( isset($_POST['linkedin_link']) ){
				$_POST['linkedin_link'] = $this->util->strip_html_tags( $_POST['linkedin_link'] );
				$_POST['linkedin_link'] = $this->util->strip_unsafe_tags( $_POST['linkedin_link'] );
			}
			
			if( isset($_POST['linkedin1_link']) ){
				$_POST['linkedin1_link'] = $this->util->strip_html_tags( $_POST['linkedin1_link'] );
				$_POST['linkedin1_link'] = $this->util->strip_unsafe_tags( $_POST['linkedin1_link'] );
			}
			
			if( isset($_POST['linkedin2_link']) ){
				$_POST['linkedin2_link'] = $this->util->strip_html_tags( $_POST['linkedin2_link'] );
				$_POST['linkedin2_link'] = $this->util->strip_unsafe_tags( $_POST['linkedin2_link'] );
			}
			
			if( isset($_POST['linkedin3_link']) ){
				$_POST['linkedin3_link'] = $this->util->strip_html_tags( $_POST['linkedin3_link'] );
				$_POST['linkedin3_link'] = $this->util->strip_unsafe_tags( $_POST['linkedin3_link'] );
			}
			
			$this->socialdao->ip				= "1.2.2.14";
			$this->socialdao->created_by 		= "test";
			
			$this->socialdao->social_network 	= $this->twitter;
			$this->socialdao->social_url 		= $_POST['twitter_link'];
			$data_result = $this->socialdao->update_record();
			
			$this->socialdao->social_network 	= $this->facebook;
			$this->socialdao->social_url 		= $_POST['facebook_link'];
			$data_result = $this->socialdao->update_record();
			
			$this->socialdao->social_network 	= $this->linkedin;
			$this->socialdao->social_url 		= $_POST['linkedin_link'];
			$data_result = $this->socialdao->update_record();
			
			$this->socialdao->social_network 	= $this->linkedin1;
			$this->socialdao->social_url 		= $_POST['linkedin1_link'];
			$data_result = $this->socialdao->update_record();
			
			$this->socialdao->social_network 	= $this->linkedin2;
			$this->socialdao->social_url 		= $_POST['linkedin2_link'];
			$data_result = $this->socialdao->update_record();
			
			$this->socialdao->social_network 	= $this->linkedin3;
			$this->socialdao->social_url 		= $_POST['linkedin3_link'];
			$data_result = $this->socialdao->update_record();
			
		
			
			
			if($data_result->resultStatus == "Success" || $data_result->resultStatus == "Warning"){
				$data_result->resultAction = "Insert";
				print_r(json_encode($data_result));
			}
			exit(0);
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."edit_data"."-".$e);
		}		
	}
}				
?>

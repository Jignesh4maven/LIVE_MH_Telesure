<?php
require_once("../Dbaccess/customerdao.php");
require_once("../Util/util.php");

class customers
{
    private $module = 'blog';
    private $log;
    private $customerdao;
    private $util;

    public function __construct(){
        $this->log		= new logger();
        $this->customerdao 	= new customerdao();
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
            $parmas['limit'] 		    = 5;
            $parmas['offset'] 		    = 0;
            $this->customerdao->params 	= $parmas;
            $this->customerdao->limit 	= 5;
            $this->customerdao->offset 	= 0;
            $result_data 			    = $this->customerdao->get_records();
            $result_list 			    = "";
            $total_records 			    = 0;

            if($result_data->resultStatus == "Success"){
                $result_list 	= $result_data->resultData['list'];
                $total_records	= $result_data->resultData['total'];
            }

            $result_json = json_encode ($result_data);

            $tpl->assign(array(
                    "T_BODY"			=>	'customers'.$config['tplEx'],
                    "page_name"			=>  'Customers',
                    'load_result_json' 	=>	$result_json,
                    'load_result' 		=>	$result_list,
                    'total_record'		=>  $total_records,
                    'form_action'		=>  'get_list'
                )
            );
        }
        catch(Exception $e){
            echo $e;
            $this->log->logIt($this->module."-"."load"."-".$e);
        }
    }

    # @author: Vihang Joshi <mavenagency.co.za>
    # @version: 1.0.0
    # @date: 2016-03-02
    # @definition: Add / Edit Template View
    public function form_add_edit(){
        try{
            $this->log->logIt($this->module."-"."form_add_edit");
            global $tpl;
            global $config;
            $tpl->assign(array(
                    "T_BODY"			=>	'customer_add_edit'.$config['tplEx'],
                    "page_name"			=>  'Customers',
                    'form_action'		=>	'add_data',
                )
            );
            if( isset($_REQUEST['customer_id']) &&  $_REQUEST['customer_id'] != ""){
                $this->customerdao->customer_id =  $_REQUEST['customer_id'];
                $result_data = $this->customerdao->get_record();
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

    public function add_data(){
        try{
            $this->log->logIt($this->module."-"."add_data");
            if( isset($_POST['customername']) ){
                $_POST['customername'] = $this->util->strip_html_tags( $_POST['customername'] );
                $_POST['customername'] = $this->util->strip_unsafe_tags( $_POST['customername'] );
            }
            if( isset($_POST['customeraddress']) ){
                $_POST['customeraddress'] = $this->util->strip_html_tags( $_POST['customeraddress'] );
                $_POST['customeraddress'] = $this->util->strip_unsafe_tags( $_POST['customeraddress'] );
            }

            $this->customerdao->full_name 		= $_POST['customername'];
            $this->customerdao->address 		= $_POST['customeraddress'];
            $this->customerdao->gender	        = $_POST['customergender'];
            $this->customerdao->created_by 		= "test";
            $data_result = $this->customerdao->insert_record();
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

    # @author: Vihang Joshi <mavenagency.co.za>
    # @version: 1.0.0
    # @date: 2016-03-02
    # @definition: Validate form data and send to update method.
    public function edit_data(){
        try{
            $this->log->logIt($this->module."-"."edit_data");
            if( isset($_POST['customername']) ){
                $_POST['customername'] = $this->util->strip_html_tags( $_POST['customername'] );
                $_POST['customername'] = $this->util->strip_unsafe_tags( $_POST['customername'] );
            }
            if( isset($_POST['customeraddress']) ){
                $_POST['customeraddress'] = $this->util->strip_html_tags( $_POST['customeraddress'] );
                $_POST['customeraddress'] = $this->util->strip_unsafe_tags( $_POST['customeraddress'] );
            }

            $customer_id = $this->util->safeNumber($_REQUEST['customer_id']);
            if( $blog_id != ""){
                $this->customerdao->full_name 		= $_POST['customername'];
                $this->customerdao->address 		= $_POST['customeraddress'];
                $this->customerdao->gender	        = $_POST['customergender'];
                $data_result = $this->customerdao->update_record();
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

    # @author: Vihang Joshi <mavenagency.co.za>
    # @version: 1.0.0
    # @date: 2016-03-02
    # @definition: get json list of records
    public function get_data_records(){
        try{
            $this->log->logIt($this->module."-"."get_data_list");
            $limit =  5;
            $offset = 0;
            $search_name = "";
            $parmas = array();

            if( isset($_REQUEST['action']) && $_REQUEST['action'] == "search" ){
                if( isset($_POST['customername']) ){
                    $_POST['customername'] = $this->util->strip_html_tags( $_POST['customername'] );
                    $_POST['customername'] = $this->util->strip_unsafe_tags( $_POST['customername'] );
                    $search_name = $_POST['customername'];
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
            $this->customerdao->params 	=  $parmas;
            $result_data 			= $this->customerdao->get_records();

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

    # @author: Vihang Joshi <mavenagency.co.za>
    # @version: 1.0.0
    # @date: 2016-03-02
    # @definition: Delete record from given id
    public function delete(){
        $customer_id = $this->util->safeNumber($_REQUEST['id']);
        if( $customer_id != ""){
            $this->customerdao->customer_id 		= $customer_id;
            $data_result = $this->customerdao->soft_delete_record();
            if( $data_result->resultStatus == "Success" ){
                $data_result->resultMessage = "Deleted successful.";
                $parmas['offset'] 	= 0;
                $parmas['limit'] 	= 5;
                $this->customerdao->params =  $parmas;
                $data_result = $this->customerdao->get_records();
            }
            print_r(json_encode($data_result));
        }
        exit(0);
    }
}
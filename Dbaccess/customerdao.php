<?php
# @author: Vihang Joshi <mavenagency.co.za>
# @version: 1.0.0
# @date: 2016-03-02
# @definition: used to create /customer modified cms pages.
require_once("../Dbaccess/commondao.php");

class customerdao
{
    #Object Variables - Start
    private $log;
    public  $params;
    public 	$common;
    #Object Variables - End

    #Object Variables - Getter/Setter - Start
    function __construct(){
        try{
            $this->log=new logger();
            $this->params = array();
            $this->common = new commondao();
        }
        catch(Exception $e){
            throw $e;
        }
    }

    public function get_records($txtname='',$request='',$sortkey='',$sortorder='',$offset='',$limit=''){
        $result=new resultobject();
        try{
            $limit 	= 5;
            $offset = 0;
            $txtname = $request = $sortkey = $sortorder = '';
            $strsql_where = $strsql_order = $strsql_limit = '';

            if ( array_key_exists('limit', $this->params) ) {
                $limit = $this->params['limit'];
            }
            if ( array_key_exists('offset', $this->params) ) {
                $offset = $this->params['offset'];
            }
            if ( array_key_exists('txtname', $this->params) ) {
                $txtname = $this->params['txtname'];
            }
            if ( array_key_exists('request', $this->params) ) {
                $request = $this->params['request'];
            }
            if ( array_key_exists('sortkey', $this->params) ) {
                $sortkey = $this->params['sortkey'];
            }
            if ( array_key_exists('sortorder', $this->params) ) {
                $sortorder = $this->params['sortorder'];
            }
            $dao = new dao();

            $strsql_total_select = " SELECT CUSTOMER.int_customer_id AS id from ".dbtable::TblCustomer." as CUSTOMER WHERE flg_deleted = 'N' " ;

            $strsql_select = "select CUSTOMER.int_customer_id as id,CUSTOMER.str_full_name as `name`,CUSTOMER.str_address as `address`
			,CUSTOMER.flg_gender as `gender`,CUSTOMER.dat_created_on as date
						from ".dbtable::TblCustomer." as CUSTOMER WHERE `flg_deleted`='N' ";

            /*if( $txtname !='' ){
                $strsql_where .= " AND (str_blog_name LIKE :name)";
            }*/
            if( $sortkey != "" ){
                $strsql_order = " ORDER BY ".$sortkey." ".$sortorder;
            }

            $strsql_limit .= " LIMIT ".$offset.",".$limit;
            $str_sql = $strsql_select.$strsql_where.$strsql_order.$strsql_limit;
            $this->log->logIt(get_class($this)."-"."get_list >> ".$str_sql);
            $dao->initCommand($str_sql);

            /*if($txtname != ''){
                $dao->addParameter(":name",'%'.trim($txtname).'%');
            }*/

            $result->resultStatus			= resultConstant::Success;
            $result->resultData["list"] 	= $dao->executeQuery();
            $str_sql_total = $strsql_total_select.$strsql_where;

            $dao2 = new dao();
            $dao2->initCommand($str_sql_total);
            /*if($txtname != ''){
                $dao2->addParameter(":name",'%'.trim($txtname).'%');
            }*/
            $result->resultData["total"] 	= count($dao2->executeQuery());

        }
        catch(Exception $e){
            $this->log->logIt(get_class($this)."-"."ListUser"."-".$e);
            $result->resultStatus=resultConstant::Error;
            $result->exception=$e;
        }
        return $result;
    }

    # @author: Vihang Joshi
    # @version: 1.0.0
    # @date: 2016-03-02
    # @definition: Insert to record to database table.
    public function insert_record(){
        $result=new resultobject();
        try{
            $dao=new dao();
            $result = $this->is_exists();
            if( $result->resultData['total'] < 1){
                $this->common->table_name 	= dbtable::TblCustomer;
                $this->common->colum_name	= "full_name";
                $max_num = 1+$this->common->get_max_number();
                $user_id = $_SESSION['AdminDetails']['int_user_id'];

                $str_sql = " INSERT INTO ".dbtable::TblCustomer."(str_full_name,str_address,flg_gender,int_created_by) ".
                    " VALUES(:customer_name,:customer_address,:customer_gender,:created_by) ";

                $dao->initCommand($str_sql);
                $dao->addParameter(":customer_name",$this->full_name);
                $dao->addParameter(":customer_address",$this->address);
                $dao->addParameter(":customer_gender",$this->gender);
                $dao->addParameter(":created_by",$user_id);
                $dao->executeNonQuery();
                $result->resultStatus=resultConstant::Success;
            }
            else{
                $result->resultStatus=resultConstant::Warning;
                $result->resultMessage="Record already exist.";

            }
        }
        catch(Exception $e)
        {
            $this->log->logIt(get_class($this)."-"."insert"."-".$e);
            $result->resultStatus=resultConstant::Error;
            $result->exception=$e->getMessage();
        }
        return $result;
    }

    # @author: Vihang Joshi
    # @version: 1.0.0
    # @date: 2016-03-02
    # @definition: Update to record to database table.
    public function update_record(){
        $result=new resultobject();
        try{
            $dao=new dao();
            $this->log->logIt(get_class($this)."-"."update");
            $str_sql 	= 	" update ".dbtable::TblCustomer." set ";
            $str_sql 	.= 	" str_blog_name=:blog_name,str_blog_content=:blog_content";
            $str_sql 	.= 	" where int_blog_id=:blog_id ";

            $dao->initCommand($str_sql);
            $dao->addParameter(":customer_name",$this->full_name);
            $dao->addParameter(":customer_address",$this->address);
            $dao->addParameter(":customer_gender",$this->gender);
            $dao->addParameter(":blog_id",$this->blog_id);

            $dao->executeNonQuery();
            $result->resultStatus=resultConstant::Success;
        }
        catch(Exception $e){
            $this->log->logIt(get_class($this)."-"."update"."-".$e);
            $result->resultStatus=resultConstant::Error;
            $result->exception=$e;
        }
        return $result;
    }

    # @author: Vihang Joshi
    # @version: 1.0.0
    # @date: 2016-03-02
    # @definition: Check if record is already available in the system.
    public function is_exists(){
        $result=new resultobject();
        try{
            $dao=new dao();
            $this->log->logIt(get_class($this)."-"."is_exists");
            $str_sql = "select CUSTOMER.*
					   from ".dbtable::TblCustomer." as CUSTOMER
					   where CUSTOMER.str_full_name = :customer_name ";

            $dao->initCommand($str_sql);
            $dao->addParameter(":customer_name",trim($this->full_name));
            $this->log->logIt($str_sql);
            $result->resultData["list"] = $dao->executeRow();
            $result->resultData["total"] = count($dao->executeQuery());
            return $result;
        }
        catch(Exception $e){
            $this->log->logIt(get_class($this)."-"."is_exists"."-".$e);
            $result->resultStatus=resultConstant::Error;
            $result->exception=$e;
        }
        return $result;
    }

    # @author: Vihang Joshi
    # @version: 1.0.0
    # @date: 2016-03-02
    # @definition: Update records status to deleted.
    public function soft_delete_record(){
        $result=new resultobject();
        try{
            $dao=new dao();
            $this->log->logIt(get_class($this)."-"."soft_delete_record");
            $str_sql = "UPDATE ".dbtable::TblCustomer." set flg_deleted=:delete where int_customer_id=:customer_id";
            $dao->initCommand($str_sql);
            $dao->addParameter(":delete",'Y');
            $dao->addParameter(":customer_id",$this->customer_id);
            $dao->executeNonQuery();
            $result->resultStatus=resultConstant::Success;
        }
        catch(Exception $e){
            $this->log->logIt(get_class($this)."-"."soft_delete_record"."-".$e);
            $result->resultStatus=resultConstant::Error;
            $result->exception=$e;
        }
        return $result;
    }

    # @author: Vihang Joshi
    # @version: 1.0.0
    # @date: 2016-03-02
    # @definition: Get single record from given id.
    public function get_record(){
        $result=new resultobject();
        try{
            $dao=new dao();
            $this->log->logIt(get_class($this)."-"."get record");
            $str_sql = "select CUSTOMER.int_customer_id as id,CUSTOMER.str_full_name as `name`,CUSTOMER.str_address as `address`
			,CUSTOMER.flg_gender as `gender`,CUSTOMER.dat_created_on as date
						from ".dbtable::TblCustomer." as CUSTOMER
						WHERE  CUSTOMER.int_customer_id = :customer_id AND `flg_deleted`='N' ";

            $dao->initCommand($str_sql);
            $dao->addParameter(":customer_id",trim($this->customer_id));
            $this->log->logIt($str_sql);
            $result->resultStatus=resultConstant::Success;
            $result->resultData["list"] = $dao->executeRow();
            return $result;
        }
        catch(Exception $e){
            $this->log->logIt(get_class($this)."-"."is_exists"."-".$e);
            $result->resultStatus=resultConstant::Error;
            $result->exception=$e;
        }
        return $result;
    }
}
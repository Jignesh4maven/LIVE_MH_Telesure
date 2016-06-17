<?php
 # @author: Jignesh Rana <mavenagency.co.za>
 # @version: 1.0.0
 # @date: 2016-02-17
 # @definition: used to create / modified cms pages.
require_once(BASE_PATH."/Dbaccess/commondao.php");
class plantypesdao {
	
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
	
	public function __set( $name, $value ){
		$name	= strtolower( $name );
		if( is_string( $value ) || trim( $value )=='' ){
			$value	= addslashes( $value );
			$value	= trim( $value );
			//$value	= strip_tags( $value );
			$str	='$this->'."$name="."'".$value."'";
		}
		else{
			$str	='$this->'."$name=".$value."";
		}
		eval("$str;");	
    }
	
	public function __get($name){
		$name	= strtolower($name);
		$str	= '$this->'."$name";
		eval("\$str = \"$str\";");
		return $str;
	}

	# @author: Vihang Joshi 
	# @version: 1.0.0
	# @date: 2016-05-17
	# @definition: Get records from table.
	public function get_records($txtname='',$request='',$sortkey='',$sortorder='',$offset='',$limit=''){
		
		$result=new resultobject();
		try{
			$limit 	= 10;
			$offset = 0;
			$txtname = $txtstatus = $request = $sortkey = $sortorder = $txtallow_on_home = '';
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
			if ( array_key_exists('status', $this->params) ) {
				$txtstatus = $this->params['status'];
			}
			if ( array_key_exists('allow_on_home', $this->params) ) {
				$txtallow_on_home = $this->params['allow_on_home'];
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
	
			$strsql_total_select = " SELECT PLANS.int_plan_type_id AS id from ".dbtable::Tbplanmaster." as PLANS WHERE flg_deleted = 'N' " ;
			 
			/*$strsql_select = " select PLANS.int_plan_type_id as id,PLANS.str_plan_type_name as `title`,PLANS.str_alias as `status`,PLANS.str_alias as `alias`,";
			$strsql_select.= " PLANS.str_description as `description`,PLANS.str_image as `image`,";
			$strsql_select.= " PLANS.flg_status as `status`,PLANS.int_display_order as `display_order`,";
			$strsql_select.= " PLANS.dat_created_on as date";
			$strsql_select.= " from ".dbtable::Tbplanmaster." as PLANS WHERE `flg_deleted`='N' ";*/
			$strsql_select = " select PLANS.int_plan_type_id as id,PLANS.str_plan_type_name as `title`,PLANS.str_alias as `status`,PLANS.str_alias as `alias`,";
			$strsql_select.= " PLANS.str_description as `description`,PLANS.str_image as `image`,";
			$strsql_select.= " PLANS.flg_status as `status`,PLANS.int_display_order as `display_order`,";
			$strsql_select.= " PLANS.dat_created_on as date,";
			$strsql_select.= " PLANIMG.str_image_url AS `img_url`,PLANIMG.str_image_path AS `path`,";
			$strsql_select.= " PLANIMG.str_image_name AS `img_name` ";
			$strsql_select.= " from ".dbtable::Tbplanmaster." as PLANS LEFT JOIN ".dbtable::Tbimages." AS PLANIMG ON ";
			$strsql_select.=" PLANS.int_plan_type_id=PLANIMG.int_module_ref_id AND str_module = 'plantype' WHERE `flg_deleted`='N' ";
			/**/
			
			
			
			if( $txtname !='' ){
				$strsql_where .= " AND (str_plan_type_name LIKE :title)";
			}
			if( $txtstatus !='' ){
				$strsql_where .= " AND (flg_status = :status)";
			}
			if( $txtallow_on_home !='' ){
				$strsql_where .= " AND (flg_allow_at_homepage = :allow_on_home)";
			}
			if( $sortkey != "" ){
				$strsql_order = " ORDER BY ".$sortkey." ".$sortorder;
			}
			else{
				$strsql_order .= " ORDER BY int_plan_type_id ASC";
			}
			$strsql_limit .= " LIMIT ".$offset.",".$limit;
			$str_sql = $strsql_select.$strsql_where.$strsql_order.$strsql_limit;
			
			$this->log->logIt(get_class($this)."-"."get_status >> ".$txtstatus);
			$this->log->logIt(get_class($this)."-"."get_list >> ".$str_sql);
			
			$dao->initCommand($str_sql);
	
			if($txtname != ''){
				$dao->addParameter(":title",'%'.trim($txtname).'%');
			}
			
			if($txtstatus != ''){
				$dao->addParameter(":status",trim($txtstatus));
			}
			
			$result->resultStatus			= resultConstant::Success;
			$result->resultData["list"] 	= $dao->executeQuery();
			$str_sql_total = $strsql_total_select.$strsql_where;
			
			$dao2 = new dao();
			$dao2->initCommand($str_sql_total);
			if($txtname != ''){
				$dao2->addParameter(":title",'%'.trim($txtname).'%');
			}
			if($txtstatus != ''){
				$dao2->addParameter(":status",trim($txtstatus));
			}
			$result->resultData["total"] 	= count($dao2->executeQuery());
			 
		}
		catch(Exception $e){
			$this->log->logIt(get_class($this)."-"."ListUser"."-".$e);
			$result->resultStatus=resultConstant::Error;
			$result->exception=$e;
		}	
		return $result;	
	}
	
	# @definition: Insert to record to database table.
	public function insert_record(){
		$result=new resultobject();
		try{
			
			$dao=new dao();
			$result = $this->is_exists();
			if( $result->resultData['total'] < 1){
				$this->common->table_name 	= dbtable::Tbplanmaster;
				$this->common->colum_name	= "int_display_order";
				$max_num = 1+$this->common->get_max_number();
				$user_id = $_SESSION['AdminDetails']['int_user_id'];
					
				$str_sql = " INSERT INTO ".dbtable::Tbplanmaster;
				$str_sql.="	(str_plan_type_name,str_alias,str_description,flg_status,flg_allow_at_homepage,str_image,int_display_order) ";
		        $str_sql.=" VALUES(:plan_type_name,:plan_type_alias,:plan_type_description,:plans_status,:plan_allow_at_home,:plan_type_image,:display_order) ";
			
				
				$dao->initCommand($str_sql);
				$dao->addParameter(":plan_type_name",$this->plan_type_name);
				$dao->addParameter(":plan_type_alias",$this->plan_type_alias);
				$dao->addParameter(":plans_status",$this->plans_status);
				$dao->addParameter(":plan_allow_at_home",$this->plan_allow_at_home);
				$dao->addParameter(":plan_type_image",$this->plan_type_image);
				$dao->addParameter(":plan_type_description",$this->plan_type_description);
				$dao->addParameter(":display_order",$max_num);
			//	$dao->addParameter(":created_by",$user_id);
				$dao->executeNonQuery();	
				$result->resultStatus=resultConstant::Success;
				
				//for image insert this  id is needed
				$result->lastInsertId=$dao->getLastInsertedId();
				//$result->resultData["inserted_id"] = $dao->getLastInsertedId();
				
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
	/* check record exists or not*/
	public function is_exists(){
		$result=new resultobject();
		try{
			$dao=new dao();
			$this->log->logIt(get_class($this)."-"."is_exists");			
			$str_sql = "select PLANS.*
					   from ".dbtable::Tbplanmaster." as PLANS 
					   where PLANS.str_plan_type_name = :plan_type_name ";
					   
			$dao->initCommand($str_sql);						
			$dao->addParameter(":plan_type_name",trim($this->plan_type_name));						
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
	
	/*  performing updation of record */
	public function update_record(){
		$result=new resultobject();
		try{
			$dao=new dao();		
			$this->log->logIt(get_class($this)."-"."update");
			$str_sql 	= 	" update ".dbtable::Tbplanmaster." set ";
			$str_sql 	.= 	" str_plan_type_name=:plan_type_name,str_alias=:plan_type_alias,str_description=:plan_type_description,flg_status=:plans_status,";
			$str_sql 	.=  " flg_allow_at_homepage=:plan_allow_at_home,str_image=:plan_type_image,str_modified_by=:modified_by";
			$str_sql 	.= 	" where int_plan_type_id=:plantype_id ";
			$dao->initCommand($str_sql);
			$dao->addParameter(":plantype_id",$this->plantype_id);
			$dao->addParameter(":plan_type_name",$this->plan_type_name);
			$dao->addParameter(":plan_type_alias",$this->plan_type_alias);
			$dao->addParameter(":plans_status",$this->plans_status);
			$dao->addParameter(":plan_allow_at_home",$this->plan_allow_at_home);
			$dao->addParameter(":plan_type_image",$this->plan_type_image);
			$dao->addParameter(":plan_type_description",$this->plan_type_description);
			$dao->addParameter(":modified_by",$this->modified_by);
	       
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
	
	/* for signle record data  for update record*/
		public function get_record(){
		$result=new resultobject();
		try{
			$dao=new dao();
			$this->log->logIt(get_class($this)."-"."get record");
			
			/*$str_sql = " select PLANS.int_plan_type_id as id,PLANS.str_plan_type_name as `title`,PLANS.str_alias as `status`,PLANS.str_alias as `alias`,";
			$str_sql.= " PLANS.str_description as `description`,PLANS.str_image as `image`,";
			$str_sql.= " PLANS.flg_status as `status`,PLANS.flg_allow_at_homepage as `allow` ,PLANS.int_display_order as `display_order`,";
			$str_sql.= " PLANS.dat_created_on as date";
			$str_sql.= " from ".dbtable::Tbplanmaster." as PLANS WHERE PLANS.int_plan_type_id = :plantype_id AND flg_deleted = 'N'";*/
		
			$str_sql =" SELECT  PLANS.int_plan_type_id AS id,PLANS.str_plan_type_name AS `title`,PLANS.str_alias AS `status`,";
			$str_sql .=" PLANS.str_alias AS `alias`,PLANS.str_description as `description`,";
			$str_sql .=" PLANIMG.str_image_url AS `img_url`,PLANIMG.str_image_path AS `path`,";
			$str_sql .=" PLANIMG.str_image_name AS `img_name`";
			$str_sql .=" FROM ".dbtable::Tbplanmaster." AS  PLANS LEFT JOIN ".dbtable::Tbimages." AS PLANIMG ON ";
			$str_sql .=" PLANS.int_plan_type_id=PLANIMG.int_module_ref_id AND str_module = 'plantype' WHERE PLANS.int_plan_type_id = :plantype_id AND PLANS.flg_deleted = 'N'";
			
			$dao->initCommand($str_sql);
			$dao->addParameter(":plantype_id",trim($this->plantype_id));
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
	
	/*   performing delete query for deletion of record */
	public function soft_delete_record(){
		$result=new resultobject();
		try{
			//for plan
			$dao=new dao();		
			$this->log->logIt(get_class($this)."-"."soft_delete_record");
			$str_sql = "update ".dbtable::Tbplanmaster." set flg_deleted=:delete where int_plan_type_id=:plantype_id";
			$dao->initCommand($str_sql);
			$dao->addParameter(":delete",'Y');
			$dao->addParameter(":plantype_id",$this->plantype_id);
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
}
?>
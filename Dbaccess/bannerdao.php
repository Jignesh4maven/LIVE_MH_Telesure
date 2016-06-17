<?php
 # @author: Jignesh Rana <mavenagency.co.za>
 # @version: 1.0.0
 # @date: 2016-02-17
 # @definition: used to create / modified cms pages.
require_once(BASE_PATH."/Dbaccess/commondao.php");
class bannerdao {
	
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

	# @author: Jignesh Rana 
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: Insert to record to database table.
	public function insert_record(){
		$result=new resultobject();
		try{
			$dao=new dao();
			$result = $this->is_exists();
			if( $result->resultData['total'] < 1){
				$this->common->table_name 	= dbtable::Tbbanner;
				$this->common->colum_name	= "int_display_order";
				$max_num = 1+$this->common->get_max_number();
				$user_id = $_SESSION['AdminDetails']['int_user_id'];
					
				$str_sql = " INSERT INTO ".dbtable::Tbbanner."(str_title,str_short_description,int_display_order,flg_status,str_image,int_created_by) ".
						 " VALUES(:banner_title,:banner_short_description,:display_order,:banner_status,:banner_image,:created_by) ";
				
				
				$dao->initCommand($str_sql);
				$dao->addParameter(":banner_title",$this->banner_title);
				$dao->addParameter(":banner_short_description",$this->banner_short_description);
				$dao->addParameter(":banner_status",$this->banner_status);
				$dao->addParameter(":banner_image",$this->banner_image);
			    $dao->addParameter(":display_order",$max_num);
				$dao->addParameter(":created_by",$user_id);
				$dao->executeNonQuery();
				
				$result->resultStatus=resultConstant::Success;
				$result->lastInsertId=$dao->getLastInsertedId();
				
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
			$str_sql = "select BANNER.*
					   from ".dbtable::Tbbanner." as BANNER 
					   where BANNER.str_title = :banner_title ";
					   
			$dao->initCommand($str_sql);						
			$dao->addParameter(":banner_title",trim($this->banner_title));						
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
	
	/*  gettinng all records */
	public function get_records($txtname='',$txtstatus='',$request='',$sortkey='',$sortorder='',$offset='',$limit=''){
		$result=new resultobject();
		try{
			$limit 	= 10;
			$offset = 0;
			$txtname = $txtstatus = $request = $sortkey = $sortorder = '';
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
			if ( array_key_exists('txtstatus', $this->params) ) {
				$txtstatus = $this->params['txtstatus'];
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

			$strsql_total_select = " SELECT BANNER.int_banner_id AS id from ".dbtable::Tbbanner." as BANNER WHERE flg_deleted = 'N' " ;
			 
			$strsql_select = "select BANNER.int_banner_id as id,BANNER.str_title as `title`,BANNER.str_short_description as `short_description`,BANNER.int_display_order as `display_order`,";
			$strsql_select .= "BANNER.flg_status as `status`,BANNER.str_image as `image`,BANNER.int_created_by as createdby,BANNER.dat_created_on as date,BANNER.str_modified_by as `modifiedby`";
			$strsql_select .= "from ".dbtable::Tbbanner." as BANNER WHERE `flg_deleted`='N' ";
			
			
			if( $txtname !='' ){
				$strsql_where .= " AND (str_title LIKE :title)";
			}
			if( $txtstatus !='' ){
				$strsql_where .= " AND (flg_status LIKE :status)";
			}
			if( $sortkey != "" ){
				$strsql_order = " ORDER BY ".$sortkey." ".$sortorder;
			}
			else{
				$strsql_order .= " ORDER BY int_banner_id ASC";
			}
			$strsql_limit .= " LIMIT ".$offset.",".$limit;
			$str_sql = $strsql_select.$strsql_where.$strsql_order.$strsql_limit;
			
			//$this->log->logIt(get_class($this)."-"."get_title >> ".$txtname);
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
	
	/* for signle record data  for update record*/
		public function get_record(){
		$result=new resultobject();
		try{
			$dao=new dao();
			$this->log->logIt(get_class($this)."-"."get record");
			$str_sql = "select BANNER.int_banner_id as id,BANNER.str_title as `title`,BANNER.str_short_description as `short_description`,BANNER.int_display_order as `display_order`,";
			$str_sql .= "BANNER.flg_status as `status`,BANNER.str_image as `image`,BANNER.int_created_by as createdby,BANNER.dat_created_on as date,BANNER.str_modified_by as `modifiedby`";
			$str_sql .= "from ".dbtable::Tbbanner." as BANNER WHERE  BANNER.int_banner_id = :banner_id AND `flg_deleted`='N' ";
					  
			$dao->initCommand($str_sql);
			$dao->addParameter(":banner_id",trim($this->banner_id));
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
	
	/*  performing updation of record */
	public function update_record(){
		$result=new resultobject();
		try{
			$dao=new dao();		
			$this->log->logIt(get_class($this)."-"."update");
			$str_sql 	= 	" update ".dbtable::Tbbanner." set ";
			$str_sql 	.= 	" str_title=:banner_title,str_short_description=:banner_short_description,flg_status=:banner_status,str_image=:banner_image,str_modified_by=:modified_by";
			$str_sql 	.= 	" where int_banner_id=:banner_id ";
			
			$dao->initCommand($str_sql);
			$dao->addParameter(":banner_title",$this->banner_title);
			$dao->addParameter(":banner_short_description",$this->banner_short_description);
			$dao->addParameter(":banner_status",$this->banner_status);
			$dao->addParameter(":banner_image",$this->banner_image);
			$dao->addParameter(":banner_id",$this->banner_id);
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
	
	/*   performing delete query for deletion of record */
	public function soft_delete_record(){
		$result=new resultobject();
		try{
			$dao=new dao();		
			$this->log->logIt(get_class($this)."-"."soft_delete_record");
			$str_sql = "update ".dbtable::Tbbanner." set flg_deleted=:delete where int_banner_id=:banner_id";
			$dao->initCommand($str_sql);
			$dao->addParameter(":delete",'Y');
			$dao->addParameter(":banner_id",$this->banner_id);
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
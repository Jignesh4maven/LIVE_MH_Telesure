<?php
 # @author: Jignesh Rana <mavenagency.co.za>
 # @version: 1.0.0
 # @date: 2016-02-17
 # @definition: used to create / modified cms pages.
require_once("../Dbaccess/commondao.php");
class blogdao {
	
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
			$value	= strip_tags( $value );
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
				echo "inside";
				$this->common->table_name 	= dbtable::TblBlog;
				$this->common->colum_name	= "priority";
				$max_num = 1+$this->common->get_max_number();
				$user_id = $_SESSION['AdminDetails']['int_user_id'];
					
				$str_sql = " INSERT INTO ".dbtable::TblBlog."(str_blog_alias,str_blog_name,str_blog_content,flg_status,int_display_order,int_created_by) ".
						 " VALUES(:blog_alias,:blog_name,:blog_content,:status,:display_order,:created_by) ";
					
				$dao->initCommand($str_sql);
				$dao->addParameter(":blog_alias",$this->blog_alias);
				$dao->addParameter(":blog_name",$this->blog_name);
				$dao->addParameter(":blog_content",$this->blog_content);
				$dao->addParameter(":status",$this->status);
				$dao->addParameter(":display_order",$max_num);
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

	# @author: Jignesh Rana 
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: Update to record to database table.
	public function update_record(){
		$result=new resultobject();
		try{
			$dao=new dao();		
			$this->log->logIt(get_class($this)."-"."update");
			$str_sql 	= 	" update ".dbtable::TblBlog." set ";
			$str_sql 	.= 	" str_blog_name=:blog_name,str_blog_content=:blog_content";
			$str_sql 	.= 	" where int_blog_id=:blog_id ";
			
			$dao->initCommand($str_sql);
			$dao->addParameter(":blog_name",$this->blog_name);
			$dao->addParameter(":blog_content",$this->blog_content);
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
	
	# @author: Jignesh Rana 
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: Check if record is already available in the system.
	public function is_exists(){
		$result=new resultobject();
		try{
			$dao=new dao();
			$this->log->logIt(get_class($this)."-"."is_exists");			
			$str_sql = "select BLOG.*
					   from ".dbtable::TblBlog." as BLOG 
					   where BLOG.str_blog_name = :blog_name ";
					   
			$dao->initCommand($str_sql);						
			$dao->addParameter(":blog_name",trim($this->blog_name));						
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
	
	# @author: Jignesh Rana 
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: Update records status to deleted.
	public function soft_delete_record(){
		$result=new resultobject();
		try{
			$dao=new dao();		
			$this->log->logIt(get_class($this)."-"."soft_delete_record");
			$str_sql = "update ".dbtable::TblBlog." set flg_deleted=:delete where int_blog_id=:blog_id";
			$dao->initCommand($str_sql);
			$dao->addParameter(":delete",'Y');
			$dao->addParameter(":blog_id",$this->blog_id);
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

	# @author: Jignesh Rana 
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: Get single record from given id.
	public function get_record(){
		$result=new resultobject();
		try{
			$dao=new dao();
			$this->log->logIt(get_class($this)."-"."get record");
			$str_sql = "select int_blog_id as blog_id,BLOG.str_blog_name as blog_name,str_blog_content as blog_content
					   from ".dbtable::TblBlog." as BLOG 
					   where BLOG.int_blog_id = :blog_id AND flg_deleted = 'N'";
			$dao->initCommand($str_sql);
			$dao->addParameter(":blog_id",trim($this->blog_id));
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

	# @author: Jignesh Rana 
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: get list of all records as per page page size and number
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

			$strsql_total_select = " SELECT BLOG.int_blog_id AS id from ".dbtable::TblBlog." as BLOG WHERE flg_deleted = 'N' " ;
			 
			$strsql_select = "select BLOG.int_blog_id as id,BLOG.str_blog_alias as alias,BLOG.str_blog_name as `name`
			,BLOG.flg_status as `status`,BLOG.int_display_order as `display_order`,BLOG.dat_created_on as date
						from ".dbtable::TblBlog." as BLOG WHERE `flg_deleted`='N' ";
			
			if( $txtname !='' ){
				$strsql_where .= " AND (str_blog_name LIKE :name)";
			}
			if( $sortkey != "" ){
				$strsql_order = " ORDER BY ".$sortkey." ".$sortorder;
			}
			else{
				$strsql_order .= " ORDER BY int_display_order ASC";
			}
			$strsql_limit .= " LIMIT ".$offset.",".$limit;
			$str_sql = $strsql_select.$strsql_where.$strsql_order.$strsql_limit;
			$this->log->logIt(get_class($this)."-"."get_list >> ".$str_sql);
			$dao->initCommand($str_sql);

			if($txtname != ''){
				$dao->addParameter(":name",'%'.trim($txtname).'%');
			}
			
			$result->resultStatus			= resultConstant::Success;
			$result->resultData["list"] 	= $dao->executeQuery();
			$str_sql_total = $strsql_total_select.$strsql_where;
			
			$dao2 = new dao();
			$dao2->initCommand($str_sql_total);
			if($txtname != ''){
				$dao2->addParameter(":name",'%'.trim($txtname).'%');
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

	# @author: Jignesh Rana 
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: Active / Inactive status.
	public function toggle_records(){
		  
	}	
}
?>
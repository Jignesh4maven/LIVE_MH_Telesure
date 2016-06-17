<?php
 # @author: Jignesh Rana <mavenagency.co.za>
 # @version: 1.0.0
 # @date: 2016-02-17
 # @definition: used to create / modified cms pages.
require_once("../Dbaccess/commondao.php");
class changepassworddao {
	
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

	/*  gettinng all records */
	public function get_records($search_old_pwd='',$request='',$sortkey='',$sortorder='',$offset='',$limit=''){
		$result=new resultobject();
		try{
			$limit 	= 10;
			$offset = 0;
			$search_old_pwd	= $request = $sortkey = $sortorder = '';
			$strsql_where = $strsql_order = $strsql_limit = '';
			
			if ( array_key_exists('limit', $this->params) ) {
				$limit = $this->params['limit'];
			}
			if ( array_key_exists('offset', $this->params) ) {
				$offset = $this->params['offset'];
			}
			if ( array_key_exists('search_old_pwd', $this->params) ) {
				$search_old_pwd = $this->params['search_old_pwd'];
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

			//$strsql_total_select = " SELECT SOCIAL.int_social_links_id AS id from ".dbtable::Tbsocial." as SOCIAL WHERE flg_deleted = 'N' " ;
			 
			$strsql_select = "select USERS.int_user_id as id,USERS.str_login_password as old_password from ".dbtable::TblAuthUsers." as USERS";
			$strsql_select .= " WHERE  `flg_deleted`='N' ";
			
			
			if( $search_old_pwd !='' ){
				$strsql_where .= " AND (str_login_password LIKE :old_password)";
			}
			if( $sortkey != "" ){
				$strsql_order = " ORDER BY ".$sortkey." ".$sortorder;
			}
			else{
				$strsql_order .= " ORDER BY int_user_id ASC";
			}
			$strsql_limit .= " LIMIT ".$offset.",".$limit;
			$str_sql = $strsql_select.$strsql_where.$strsql_order.$strsql_limit;
			
			$this->log->logIt(get_class($this)."-"."get_old p assowrd >> ".$search_old_pwd);
			$this->log->logIt(get_class($this)."-"."get_list >> ".$str_sql);
			$dao->initCommand($str_sql);

			if($search_old_pwd != ''){
				$dao->addParameter(":old_password",trim($search_old_pwd));
			}
			
			$result->resultData["total"] 	= count($dao->executeQuery());
			
			if(($result->resultData["total"]) > 0 ){
				$result->resultStatus			= resultConstant::Success;
				$result->resultData["list"] 	= $dao->executeQuery();
			}
			else{
				$result->resultStatus			= resultConstant::Warning;
				$result->resultData["list"] 	= $dao->executeQuery();
			}
			
			
			
		}
		catch(Exception $e){
			$this->log->logIt(get_class($this)."-"."ListUser"."-".$e);
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
			$str_sql 	= 	" update ".dbtable::TblAuthUsers." set ";
			$str_sql 	.= 	" str_login_password=:new_password,str_modified_by=:modified_by";
			$str_sql 	.= 	" where str_login_password=:old_password ";
			
			$dao->initCommand($str_sql);
			$dao->addParameter(":old_password",$this->old_password);
			$dao->addParameter(":new_password",$this->new_password);
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
	
	
}
?>
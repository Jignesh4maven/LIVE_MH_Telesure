<?php
require_once("../Dbaccess/commondao.php");
class forgotpassworddao
{
	private $log;
	public  $typeArray;
	
	function __construct(){
		try{
			$this->log=new logger();
		}
		catch(Exception $e){
			throw $e;
		}
    }
	
	public function __set($name, $value){		
		$name=strtolower($name);
		if(is_string($value) || trim($value)==''){
			$value=addslashes($value);
			$value=trim($value);
			$value=strip_tags($value);
			$str='$this->'."$name="."'".$value."'";
		}
		else{
			$str='$this->'."$name=".$value."";
		}
		eval("$str;");	
    }
	
	public function __get($name){
		$name=strtolower($name);
		$str='$this->'."$name";
		eval("\$str = \"$str\";");
		return $str;
    }		
/*  gettinng all records */
	public function get_records(){
		$result=new resultobject();
		try{
			
			$dao = new dao();

			
			 
			$strsql_select = "select USERS.int_user_id as id,USERS.str_login_password as user_password from ".dbtable::TblAuthUsers." as USERS";
			$strsql_select .= " WHERE  str_login_id=:userid and `flg_deleted`='N' ";
			
			
		
			
			$this->log->logIt(get_class($this)."-"."get_usernma >> ".$search_old_pwd);
			$this->log->logIt(get_class($this)."-"."get_list >> ".$strsql_select);
			$dao->initCommand($strsql_select);

			
			$dao->addParameter(":userid",$this->userid);
			
			
			$result->resultStatus			= resultConstant::Success;
			$result->resultData["list"] 	= $dao->executeQuery();
		
			
			
		}
		catch(Exception $e){
			$this->log->logIt(get_class($this)."-"."ListUser"."-".$e);
			$result->resultStatus=resultConstant::Error;
			$result->exception=$e;
		}	
		return $result;	
	}
}
?>
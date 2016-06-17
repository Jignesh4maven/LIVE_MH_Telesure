<?php
class logindao
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

	# @author: Jignesh Rana <mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: Validate user 
	public function validateUser(){
		$result=new resultobject();
		try{
			$dao=new dao();		
			$this->log->logIt(get_class($this)."-"."validateUser");
									
			$strSql="SELECT *  
			FROM ".dbtable::TblAuthUsers." as user   WHERE ".
			"user.str_login_id=:username AND ".
			"user.str_login_password=:password  ";
			
			$dao->initCommand($strSql);
			$dao->addParameter(":username",$this->username);
			//$dao->addParameter(":password",md5($this->password));
			$dao->addParameter(":password",$this->password);
			$cnt=count($dao->executeQuery());
			if($cnt>0){
				$result->resultStatus=resultConstant::Success;
				$result->resultData['record']=$dao->executeRow();
				$result->resultData['message']="Please Wait...";
				return $result;
			}
			else
			{
				$result->resultStatus=resultConstant::Warning;
				$result->resultData['message']="Login Failed. Please recheck your login information.";
				return $result;
			}			
		}
		catch(Exception $e)
		{
			$this->log->logIt(get_class($this)."-"."validateUser"."-".$e);
			$result->resultStatus=resultConstant::Error;
			$result->exception=$e;
			$result->viewName="errorpage";
		}		
		return $result;				
	}
	
	# @author: Jignesh Rana <mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: Store session logs
	public function auditLoginAttempt($software,$success)
	{
		$result=new resultobject();
		try{
			$dao=new dao();		
			$this->log->logIt(get_class($this)."-"."auditLoginAttempt");
			$strSql="	INSERT INTO ".dbtable::TblSessionLogs."  ";
			$strSql.="	(user_id,success,ip,proxyip,country,city,browser) ";
			$strSql.="	VALUES ";
			$strSql.="	(:user_id,:success,:ip,:proxyip,:country,:city,:browser)";
			$dao->initCommand($strSql);
			
			$ip 		= util::VisitorIP();
			$proxyip 	= util::VisitorProxyIP();
			$location 	= util::getLocationFromIP($ip);
			$browser	= $_SERVER['HTTP_USER_AGENT'];
			$country	= 'NA';
			$city		= 'NA';
			if(count($location)){
				$country	= $location['country'];
				$city		= $location['city'];
			}
			
			$dao->addParameter(":user_id",$this->user_id);
			$dao->addParameter(":success",$success);
			$dao->addParameter(":ip",$ip);
			$dao->addParameter(":proxyip",$proxyip);
			$dao->addParameter(":country",$country);
			$dao->addParameter(":city",$city);
			$dao->addParameter(":browser",$browser);				
			$dao->executeNonQuery();
		}
		catch(Exception $e){
			$this->log->logIt(get_class($this)."-"."validateUser"."-".$e);
			$result->resultStatus=resultConstant::Error;
			$result->exception=$e;
			$result->viewName="errorpage";
		}		
		return $result;	
	}
}#class	
?>
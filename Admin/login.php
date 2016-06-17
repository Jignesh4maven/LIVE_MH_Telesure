<?php
define("IN_ADMIN", true);

require_once("../Conf/common.php");	
require_once("../Dbaccess/logindao.php");	
require_once("../Conf/ip2location_finder.php");
require_once("../Util/util.php");	

$_SESSION['prefix']='Admin_';
$_SESSION[$_SESSION['prefix']]["dsn"]="mysql:host=".$mysqlhost.";dbname=".$db_name;
$_SESSION[$_SESSION['prefix']]["dbusername"]=$mysqluser;
$_SESSION[$_SESSION['prefix']]["dbpassword"]=$mysqlpwd;
$_SESSION[$_SESSION['prefix']]['pagesize']="10";

global $connection;
	
$connection=new PDO($_SESSION[$_SESSION['prefix']]["dsn"],$_SESSION[$_SESSION['prefix']]["dbusername"],$_SESSION[$_SESSION['prefix']]["dbpassword"]);
@$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$connection->setAttribute(PDO::ATTR_TIMEOUT,30);
$connection->exec("SET NAMES utf8");

/*if(isset($_SESSION['AdminDetails']))
{	
	
	header("location:index.php/localstorage");
}*/



if(count($_REQUEST)>0)
{
	$util=new util();
	
	$_POST['username'] = $util->hackerDefense( $_POST['username'] );
	$_POST['username'] = $util->strip_html_tags( $_POST['username'] );
	$userid			   = $util->strip_unsafe_tags( $_POST['username'] );
	
	$_POST['usermailid'] = $util->hackerDefense( $_POST['usermailid'] );
	$_POST['usermailid'] = $util->strip_html_tags( $_POST['usermailid'] );
	$usermailid			 = $util->strip_unsafe_tags( $_POST['usermailid'] );
	
	if($_POST['onform'] != "forgotform"){
	
		//print_r($_REQUEST);	
		$obj=new logindao();
		
		$obj->username=$_POST['userid'];
		$obj->password=$_POST['passwd'];
		$result=$obj->validateUser();
		
		
		if($result->resultStatus==resultConstant::Success)
		{
			$row=$result->resultData['record'];
			$AuthLoginDetails=array();
			$_SESSION['AdminDetails']=$row;
			
			if(isset($_REQUEST['txtrememberme']))
			{
				 setcookie('login_id',$_REQUEST['userid'],time()+3600);			
				 setcookie('login_password',$_REQUEST['passwd'],time()+3600);			
								 
			}
		}
		else
		{
			#$obj->auditLoginAttempt('rwConfig',0);
		}
		
		$result->resultData['record'] = "";
		echo json_encode($result);
		exit(0);
	}
	else{
		 //for forgot password
		$response_data = array();
		$forgot_pwd_obj 	= new logindao();
		
		$forgot_pwd_obj->userid     = $userid;
		$forgot_pwd_obj->usermailid = $usermailid;
		$result 					= $forgot_pwd_obj->get_records();
		
		if( $result->resultStatus == resultConstant::Success ){
			
			//send email
			
			$response_data['resultStatus'] = resultConstant::Success;
			$response_data['resultData'] = "Email has been sent.";
			
		}
		else{
			
			$response_data['resultStatus'] = resultConstant::Error;
			$response_data['resultData'] = "Please fill correct details.";
			
		}
		
		echo json_encode($response_data);
		exit(0);
		
	    
	}
	
	
}
else
{
	$tpl->display(COMMON_TMPL_PATH."/login.tpl");
	
}
?>
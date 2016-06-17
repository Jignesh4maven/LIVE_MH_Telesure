<?php
	define("IN_ADMIN",true);
	require_once($_SERVER['DOCUMENT_ROOT']."telesure/Conf/common.php");
	global $connection;
	$log=new logger();
	$log->logIt("index");
 	
	$dns = $_SESSION[$_SESSION['prefix']]["dsn"];
	$username = $_SESSION[$_SESSION['prefix']]["dbusername"];		
	$password = $_SESSION[$_SESSION['prefix']]["dbpassword"];	
 
	$connection=new PDO($dns,$username,$password);
 
	@$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connection->setAttribute(PDO::ATTR_TIMEOUT,30);
	$connection->exec("SET NAMES utf8");
 
	if(isset($_REQUEST['opcode'])){
       $opcode=$_REQUEST['opcode'];
       $opcode = $util->safeString($opcode);
    }
	else	
		$opcode="load";
		
	$_GET['m'] = isset($_GET['m']) ? $_GET['m'] : 'dashboard';
    $_GET['m'] = $_GET['m'] == "" ? 'dashboard' : $_GET['m'];
    
	$_GET['m'] = $util->safeString($_GET['m']);
	
	$_GET['m'] =  preg_replace('/-/', '_', $_GET['m']);
	
	if( file_exists(BASE_PATH."/Admin/Pages/".$_GET['m'].".php")){
		
		require_once(BASE_PATH."/Admin/Pages/".$_GET['m'].".php");
	}
	else{
	
		$_GET['m'] = "notfound";
	
		require_once(BASE_PATH."/Admin/Pages/notfound.php");
	
	}
	 
	$request='';

	$obj = new $_GET['m']();

	$result=$obj->$opcode($request);
	
	if(isset($_GET['popup']))		
		$tpl->display(COMMON_TMPL_PATH."/default_popup_layout.tpl");			
	else
		$tpl->display(COMMON_TMPL_PATH."/default_layout.tpl");
		
?>
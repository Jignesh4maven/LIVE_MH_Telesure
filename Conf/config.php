<?php
defined("VERSION") or define("VERSION","1.0.0.1");

$server	= ($_SERVER['HTTP_HOST']=='mavenindia' || $_SERVER['HTTP_HOST']=='maven-2'  || $_SERVER['HTTP_HOST']=='desktop5'  || $_SERVER['HTTP_HOST']=='localhost')?'local':'livelocal';

global $G_PARAMS;

 
/*if( $_SERVER['HTTP_HOST'] == "motorhappy.co.za" || $_SERVER['HTTP_HOST'] == "www.motorhappy.co.za" ){
	$server = "www.motorhappy.co.za";
}*/

 
if( $server =='local' )
{
	defined("BASE_PATH") or define("BASE_PATH",$_SERVER['DOCUMENT_ROOT'].'/motorhappy.co.za');
	defined("HTTP_PATH") or define("HTTP_PATH",(isset($_SERVER["HTTPS"])?(strtolower($_SERVER["HTTPS"])=="on"?"https://":"http://"):"http://").$_SERVER['HTTP_HOST']."/motorhappy.co.za");
}
else if( $server == "livelocal"){
	defined("BASE_PATH") or define("BASE_PATH",$_SERVER['DOCUMENT_ROOT'].'/telesure');
	defined("HTTP_PATH") or define("HTTP_PATH",(isset($_SERVER["HTTPS"])?(strtolower($_SERVER["HTTPS"])=="on"?"https://":"http://"):"http://").$_SERVER['HTTP_HOST']."/telesure");
}
else
{
	defined("BASE_PATH") or define("BASE_PATH",$_SERVER['DOCUMENT_ROOT']);	
	$primary_address = 'motorhappy.maven.me';
	$primary_addressroot = 'motorhappy.maven.me';
	defined("HTTP_PATH") or define("HTTP_PATH",(isset($_SERVER["HTTPS"])?(strtolower($_SERVER["HTTPS"])=="on"?"https://":"http://"):"http://").$primary_address);
	defined("HTTPROOT_PATH") or define("HTTPROOT_PATH",(isset($_SERVER["HTTPS"])?(strtolower($_SERVER["HTTPS"])=="on"?"https://":"http://"):"http://").$primary_addressroot);
}	

defined("LIBRARY_PATH") or define("LIBRARY_PATH",BASE_PATH.'/Libs');
defined("COMPILE_TMPL_PATH") or define("COMPILE_TMPL_PATH",BASE_PATH.'/Cache');
defined("MH_COMPILE_TMPL_PATH") or define("MH_COMPILE_TMPL_PATH",BASE_PATH.'/Cache');

defined("IMAGE_URL") or define("IMAGE_URL",HTTP_PATH.'/Uploads/');
defined("IMAGE_PATH") or define("IMAGE_PATH",BASE_PATH.'/Uploads/');

if( defined("IN_ADMIN") )
{
error_reporting(0);
	defined("COMMON_TMPL_PATH") or define("COMMON_TMPL_PATH",BASE_PATH.'/Admin/Templates');
	defined("HTTP_TMPL_PATH") or define("HTTP_TMPL_PATH",HTTP_PATH.'/Admin/Templates');

	defined("CONFIG_THEME_PATH") or define("CONFIG_THEME_PATH",HTTP_PATH.'/Themes/Admin/AdminBlue');
	defined("LOGIN_THEME_PATH") or define("LOGIN_THEME_PATH",HTTP_PATH.'/Themes/Admin/AdminBlue');
	
}
else if( defined("FRONT") )
{
	defined("COMMON_TMPL_PATH") or define("COMMON_TMPL_PATH",BASE_PATH.'/Front/Templates');
	defined("HTTP_TMPL_PATH") or define("HTTP_TMPL_PATH",HTTP_PATH.'/Front/Templates');
	
	defined("FRONT_THEME_PATH") or define("FRONT_THEME_PATH",HTTP_PATH.'/Themes/Front/default');
	defined("LOGIN_THEME_PATH") or define("LOGIN_THEME_PATH",HTTP_PATH.'/Themes/Front/default');
	
	
	defined("MH_COMMON_TMPL_PATH") or define("MH_COMMON_TMPL_PATH",BASE_PATH.'/Front/MHNew');
	defined("MH_HTTP_TMPL_PATH") or define("MH_HTTP_TMPL_PATH",HTTP_PATH.'/Front/MHNew');
	
	defined("MH_FRONT_THEME_PATH") or define("MH_FRONT_THEME_PATH",HTTP_PATH.'/Themes/Front/MHNew');
	defined("MH_LOGIN_THEME_PATH") or define("MH_LOGIN_THEME_PATH",HTTP_PATH.'/Themes/Front/MHNew');
}

defined("LANG_PATH") or define("LANG_PATH",BASE_PATH.'/Language');

global $logsPath;
$db_name = "telesure_db_prod";
if( $server=='local' )
{
	$db_name = "motorhappy";
	$serverurl = (isset($_SERVER["HTTPS"])?(strtolower($_SERVER["HTTPS"])=="on"?"https://":"http://"):"http://").$_SERVER['HTTP_HOST']."/motorhappy.co.za/";
	$mysqlhost = "localhost";
	$mysqluser = "root";
	$mysqlpwd = "";
	$logsPath = $_SERVER['DOCUMENT_ROOT'].'/motorhappy.co.za/Logs/';
}
else if( $server == "livelocal"){
	$db_name = "telesure_db_prod";
	$serverurl = (isset($_SERVER["HTTPS"])?(strtolower($_SERVER["HTTPS"])=="on"?"https://":"http://"):"http://").$_SERVER['HTTP_HOST']."/telesure/";
	$mysqlhost = "localhost";
	$mysqluser = "telesure_user_Pr";
	$mysqlpwd = "9jHLvrP8Pqru4unJ";
	$logsPath = $_SERVER['DOCUMENT_ROOT'].'telesure/Logs/';
}


$connection = "";
$transaction = "";
$inittran = false;

?>
<?php
	session_start();
	require_once("config.php");
	require_once(BASE_PATH."/Util/logger.php");
	require_once(BASE_PATH."/Util/util.php");
	require_once(BASE_PATH."/Conf/staticarray.php");
	require_once(BASE_PATH."/Conf/resultobject.php");
	require_once(BASE_PATH."/Dbaccess/dao.php");	
	require_once(BASE_PATH."/Dbaccess/dbtable.php");	
	require_once(LIBRARY_PATH."/Smarty.class.php");
	require_once(BASE_PATH."/Util/htmlMimeMail5.php");
	
	$tpl = new Smarty;
	$tpl->cache_lifetime = 1; // one ms
	$tpl->caching = 0;
	$tpl->compile_check = true;
	$tpl->debugging = false;
	$tpl->force_compile = true;
	$tpl->template_dir = COMMON_TMPL_PATH;
	$tpl->compile_dir = COMPILE_TMPL_PATH;
	$tpl->error_reporting = E_ALL & ~E_NOTICE;
	
	global $log,$language,$config,$mail;
	$log = new logger();
	$mail = new htmlMimeMail5();
    $util = new util();

	/* variable initialization */
	$path_parts = pathinfo($_SERVER['PHP_SELF']);
	$config['tplEx'] = '.tpl';
	$serverurl_new = $serverurl;

	if(!defined("FRONT"))	
	{
		if(defined("IN_ADMIN"))
		{
			if(!isset($_SESSION['AdminDetails']) && $path_parts["basename"] != 'login.php')
			{	
				header("location:".HTTP_PATH."/Admin/login.php");
			}
		}
	}
	/*else{
		header("location:".HTTP_PATH."/Front/index.php");
	}*/

	if(preg_match('/Admin/',$_SERVER['REQUEST_URI']))
	{
		if(substr($serverurl, -1) == '/')
			$serverurl = $serverurl.'Admin/';
		else
			$serverurl = $serverurl.'/Admin/';	
	}
	 
	$tpl->assign(array("version"	=>	"1.6"));
	//$tpl->assign(array( "site_header"		=>  'pink',
	//				    "menu_header"		=>  'turq', 
	//				    "table_header"		=>	'turq',
	//				 ));	
	//
	//if(isset($_SESSION['prefix']))
	//{
	//	if(isset($_SESSION[$_SESSION['prefix']]))
	//	{
	//		$tpl->assign(array(
	//							"site_header"		=>  isset($_SESSION[$_SESSION['prefix']]['site_header'])?$_SESSION[$_SESSION['prefix']]['site_header']:"pink",
	//							"menu_header"		=>  isset($_SESSION[$_SESSION['prefix']]['menu_header'])?$_SESSION[$_SESSION['prefix']]['menu_header']:"turq", 
	//							"table_header"		=>	isset($_SESSION[$_SESSION['prefix']]['table_header'])?$_SESSION[$_SESSION['prefix']]['table_header']:"turq",
	//						 ));	
	//	}
	//}
	
	$tpl->assign(array("T_HEADER"				=>	 'default_header'. $config['tplEx'],//$tpl->fetch('default_header'. $config['tplEx']),
						"T_FOOTER"				=>	 'default_footer'. $config['tplEx'],
						"T_TOP"					=>	 'default_top'. $config['tplEx'],
						"T_LEFT"				=>	 'default_left'.$config['tplEx'],
						//"T_MENU"				=>	'default_menu'. $config['tplEx'],//$tpl->fetch('default_menu'. $config['tplEx']),
						"T_PAGER"				=>	'pager'. $config['tplEx'],
						"T_LOGIN_THEME"			=>	 LOGIN_THEME_PATH,
						"T_VERSION"				=>	 VERSION,
						"CSS_PAGE_NAME"			=>   'th'.(isset($_REQUEST['m'])?$_REQUEST['m']:''), 
						"SERVER_URL"			=>	$serverurl,
						"HTTP_PATH"				=> 	HTTP_PATH,
						/*"HTTP_PATH"				=> 	HTTP_PATH,
						"TEMPLATE_CSS"			=> 	CONFIG_THEME_PATH."/css/",
						"TEMPLATE_JS"			=> 	CONFIG_THEME_PATH."/js/",
						"TEMPLATE_IMAGES"		=> 	CONFIG_THEME_PATH."/images/",
						"TEMPLATE_FONTS"		=> 	CONFIG_THEME_PATH."/fonts/",
						"TEMPLATE_ICONS"		=> 	CONFIG_THEME_PATH."/icons/",
						"TEMPLATE_PLUGINS"		=> 	CONFIG_THEME_PATH."/plugins/",
						"COMMON_SCRIPTS"		=> 	HTTP_PATH."/Scripts/",*/
						
						"COMPANY_TITLE"			=>	"Motor Happy",
						"SITE_TITLE"			=>	"Motor Happy",
						"META_TITLE"			=>	"Motor Happy",
						"META_KEYWORD"			=>	"Motor Happy",
						"META_DESCRIPTION"		=>	"Motor Happy",
						"COPYRIGHT_TEXT"		=>	"Motor Happy",
						));

	if(defined("FRONT"))
	{	
		$tpl->assign(array(					
						"HTTP_PATH"				=> 	HTTP_PATH,
						"TEMPLATE_CSS"			=> 	FRONT_THEME_PATH."/css/",
						"TEMPLATE_JS"			=> 	FRONT_THEME_PATH."/js/",
						"TEMPLATE_IMAGES"		=> 	FRONT_THEME_PATH."/images/",
						"TEMPLATE_FONTS"		=> 	FRONT_THEME_PATH."/fonts/",
						"TEMPLATE_ICONS"		=> 	FRONT_THEME_PATH."/icons/",
						"TEMPLATE_PLUGINS"		=> 	FRONT_THEME_PATH."/plugins/",
						"COMMON_SCRIPTS"		=> 	HTTP_PATH."/Scripts/",
					));

		if( isset( $_SESSION['Front']['user'] ) ){

			$tpl->assign("user", $_SESSION['Front']['user']);
		}
		else{
			$tpl->assign("user", "Guest");
		}
	}
		
	if(defined("IN_ADMIN"))
	{	
		$tpl->assign(array(					
						"HTTP_PATH"				=> 	HTTP_PATH,
						"ADMIN_PATH"			=>	HTTP_PATH."/Admin/",
						"TEMPLATE_CSS"			=> 	CONFIG_THEME_PATH."/css/",
						"TEMPLATE_JS"			=> 	CONFIG_THEME_PATH."/js/",
						"TEMPLATE_IMAGES"		=> 	CONFIG_THEME_PATH."/images/",
						"TEMPLATE_FONTS"		=> 	CONFIG_THEME_PATH."/fonts/",
						"TEMPLATE_ICONS"		=> 	CONFIG_THEME_PATH."/icons/",
						"TEMPLATE_PLUGINS"		=> 	CONFIG_THEME_PATH."/plugins/",
						"COMMON_SCRIPTS"		=> 	HTTP_PATH."/Scripts/",
						"ADMIN_ALIAS"			=>  "Admin",
						"CACHE_IMG_PATH"		=>  BASE_PATH.'/Cache/',
						"UPLOADS_PATH"			=>  BASE_PATH.'/Uploads/',
					));
					
		if(isset($_SESSION['AdminDetails']))				
		{
		 
			$tpl->assign("user_id",$_SESSION['AdminDetails']['str_nick_name']);
		}	
	}
	

?>
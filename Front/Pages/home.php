<?php
require_once(BASE_PATH."/Util/util.php");
class home{
	
	private $module = 'home';
	private $log;
	private $util;
	
	public function __construct(){
		$this->log		= new logger();
		$this->util 	= new util();
	}	

	# @author: Jignesh Rana <mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: Initiate template view on first blog loading
	public function load(){
		try{
			$this->log->logIt($this->module."-"."Page Load");
			global $tpl;
			global $config;
			
			$tpl->assign(array(	
								"T_BODY"			=>	'home'.$config['tplEx'],
								"page_name"			=>  'home',
							)
						);		
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."load"."-".$e);
		}		
	}	
}				
?>
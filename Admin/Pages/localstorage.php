<?php
class localstorage 
{
	private $module = 'localstorage';
	private $log;	
	
	public function __construct()
	{
		$this->log=new logger();	
	}	

	public function load()
    {
		try
		{
			$this->log->logIt($this->module."-"."Page Load");		
			global $tpl;
			global $config;
						
			$tpl->assign(array(
								"T_BODY"			=>	'localstorage'.$config['tplEx'],
								"page_name"			=>  'Local Storage',
							)
						);		
		}
		catch(Exception $e)
		{
			echo $e;
			$this->log->logIt($this->module."-"."onLoad"."-".$e);
		}		
	}
}				
?>

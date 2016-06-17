<?php
class settings 
{
	private $module = 'settings';
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
								"T_Body"			=>	'settings'.$config['tplEx'],
								"page_name"			=>  'Settings',
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

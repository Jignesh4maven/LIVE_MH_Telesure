<?php
class listings 
{
	private $module = 'listings';
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
								"T_Body"			=>	'listings'.$config['tplEx'],
								"page_name"			=>  'Dashbord',
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

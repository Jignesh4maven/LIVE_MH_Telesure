<?php
class users 
{
	private $module = 'users';
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
								"T_Body"			=>	'users'.$config['tplEx'],
								"page_name"			=>  'Users',
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

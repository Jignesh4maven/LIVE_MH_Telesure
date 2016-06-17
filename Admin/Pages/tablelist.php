<?php
class tablelist 
{
	private $module = 'tablelist';
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
								"T_BODY"			=>	'tablelist'.$config['tplEx'],
								"page_name"			=>  'tablelist',
					 
								 
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

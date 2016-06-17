<?php
class images 
{
	private $module = 'images';
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
								"T_Body"			=>	'images'.$config['tplEx'],
								"page_name"			=>  'Images',
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

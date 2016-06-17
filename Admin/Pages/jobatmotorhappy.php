<?php
class jobatmotorhappy
{
	private $module = 'jobatmotorhappy';
	private $log;	
	
	public function __construct(){
		$this->log=new logger();
	
	}	

	public function load(){
		try{
			$this->log->logIt($this->module."-"."Page Load");		
			global $tpl;
			global $config;
			
				
			$tpl->assign(array(	
								"T_BODY"			=>	'job_at_motorhappy'.$config['tplEx'],
								"page_name"			=>  'Job at Motorhappy',
					 
								 
							)
						);		
			 
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."onLoad"."-".$e);
		}		
	}
}				
?>

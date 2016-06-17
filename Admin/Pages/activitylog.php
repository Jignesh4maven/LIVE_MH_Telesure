<?php
class activitylog
{
	private $module = 'leadinquires';
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
								"T_BODY"			=>	'activitylog'.$config['tplEx'],
								"page_name"			=>  'Activity Log',
					 
								 
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

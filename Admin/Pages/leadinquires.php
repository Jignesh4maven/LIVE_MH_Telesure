<?php
class leadinquires
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
								"T_BODY"			=>	'lead_inquires'.$config['tplEx'],
								"page_name"			=>  'Lead or Inquires',
					 
								 
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

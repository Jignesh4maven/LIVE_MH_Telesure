<?php
class feedback 
{
	private $module = 'feedback';
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
								"T_BODY"			=>	'feedback'.$config['tplEx'],
								"page_name"			=>  'Customers Feedback',
					 
								 
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

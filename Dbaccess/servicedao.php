<?php
class servicedao
{
	private $log;
	public  $typeArray;
	
	function __construct(){
		try{
			$this->log=new logger();
		}
		catch(Exception $e){
			throw $e;
		}
    }
	
	# @author: Vihang Joshi <mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-04-02
	# @definition: Get Services according action
	public function getDataServiceJson($action = null){
		
		$result=new resultobject();
		try{
			$dao=new dao();		
			$this->log->logIt(get_class($this)."-"."Data service json");
									
			$strSql="SELECT *  
			FROM ".dbtable::TblDataService." as service   WHERE ".
			"service.str_action=:action";
			
			
			$dao->initCommand($strSql);
			$dao->addParameter(":action",$action);
			$cnt=count($dao->executeQuery());
			if($cnt>0){
				$result->resultStatus=resultConstant::Success;
				$data = $dao->executeRow();
				
				$this->log->logIt($data);
				$result->resultData = $data['str_data'];
				return $result;
			}
			else
			{
				$result->resultStatus=resultConstant::Warning;
				$result->resultData['message']="Service Response Failed. Please recheck action.";
				return $result;
			}			
		}
		catch(Exception $e)
		{
			$this->log->logIt(get_class($this)."-"."Data service json"."-".$e);
			$result->resultStatus=resultConstant::Error;
			$result->exception=$e;
			$result->viewName="errorpage";
		}		
		return $result;				
	}
	
}#class	
?>
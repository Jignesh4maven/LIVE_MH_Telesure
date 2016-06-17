<?php
require_once(BASE_PATH."/Dbaccess/servicedao.php");
class commondao {
	
	private $log;
	private $servicedao;
	
	function __construct(){
		try{
			$this->log=new logger();
			$this->servicedao=new servicedao();
		}
		catch(Exception $e){
			throw $e;
		}
    }
	
	public function __set( $name, $value ){
		$name=strtolower($name);
		if( is_string($value) || trim($value)=='' ){
			$value=addslashes($value);
			$value=trim($value);
			$value=strip_tags($value);
			$str='$this->'."$name="."'".$value."'";
		}
		else{
			$str='$this->'."$name=".$value."";
		}
		eval("$str;");	
    }
	
	public function __get( $name ){
		$name=strtolower($name);
		$str='$this->'."$name";
		eval("\$str = \"$str\";");
		return $str;
	}

	
	public function get_max_number(){
		
		$result = 0;
        $table_name     =   $this->table_name;
        $column_name    =   $this->colum_name;

		try{
		
			$dao=new dao();
				
			$str_sql = " select max(".$column_name.") as maxnum from ".$table_name;
            
			$dao->initCommand($str_sql);

		    $res = $dao->executeQuery();
            
			$result =  $res[0]['maxnum'];
			 
			
		}
		catch(Exception $e)
		{
			$this->log->logIt(get_class($this)."-"."get_max_number"."-".$e);
		
		}
		return $result;
			
	}
	
	# @author: Vihang Joshi <mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-04-02
	# @definition: Get services based on action from table.
	
    public function get_data_service_json($action = null)
    {
        if($action != ""){
            try{
;
                $this->log->logIt("get_data_service_json:".$action);
				
                $json_str = '';
                
                $result = $this->servicedao->getDataServiceJson($action);
				
                if($result->resultStatus == "Success"){
					
					$json_str = $result->resultData;
					
				}
				
                if( $json_str == ''){
					
                    return '{}';
				
                }
                else{
					
                    return $json_str;
                }
            }
            catch (Exception $e) {
                    echo $e;
                    $this->log->logIt("Common->service:" . $e);
            }
        }
        else{
            return '{}';
        }
        
    }
	
	# @author: Vihang Joshi
	# @version: 1.0.0
	# @date: 2016-05-12
	# @definition: Insert image to database table.
	public function insert_image_record(){
		$result=new resultobject();
		try{
			$dao=new dao();
			//$result = $this->is_exists();
			if( $result->resultData['total'] < 1){
				$this->common->table_name 	= dbtable::Tbimages;
				//$max_num = 1+$this->common->get_max_number();
				//$user_id = $_SESSION['AdminDetails']['int_user_id'];
					
				$str_sql = " INSERT INTO ".dbtable::Tbimages."(str_module,int_module_ref_id,str_image_url,str_image_path,str_image_name,str_image_type) ".
						 " VALUES(:module,:module_reference_id,:image_url,:image_path,:image_name,:image_type) ";
				
				
				$dao->initCommand($str_sql);
				$dao->addParameter(":module",$this->module);
				$dao->addParameter(":module_reference_id",$this->module_reference_id);
				$dao->addParameter(":image_url",$this->image_url);
				$dao->addParameter(":image_path",$this->image_path);
			    $dao->addParameter(":image_name",$this->image_name);
				$dao->addParameter(":image_type",$this->image_type);
				$dao->executeNonQuery();	
				$result->resultStatus=resultConstant::Success;
				
			}
			else{
				$result->resultStatus=resultConstant::Warning;
				$result->resultMessage="Record already exist.";
				
			}		
		}
		catch(Exception $e)
		{
			$this->log->logIt(get_class($this)."-"."insert"."-".$e);
			$result->resultStatus=resultConstant::Error;
			$result->exception=$e->getMessage();
		}
		return $result;
	}
	
	public function page_id_from_alias(){
		$result=new resultobject();
		$page_id = 0;
		try{
			$dao=new dao();
			
			if( $this->pagetype == "plan"){
				
				$str_sql = "SELECT PLANS.int_plan_type_id as id";
				$str_sql .= " FROM ".dbtable::Tbplanmaster." as PLANS WHERE PLANS.str_alias=:alias";
				$str_sql .= " AND `flg_deleted` != 'Y' AND flg_status = 'Active' ";
			}
			else if( $this->pagetype == "motorhappybuzz"){
				
				$str_sql = "SELECT int_buzz_category_id as id";
				$str_sql .= " FROM ".dbtable::TbBuzzCategroy." WHERE str_alias=:alias";
				$str_sql .= " AND `flg_deleted` != 'Y' AND flg_status = 'Active' ";
			}
			else if( $this->pagetype == "motorhappybuzzdetail"){
				
				$str_sql = "SELECT int_buzz_id as id";
				$str_sql .= " FROM ".dbtable::TbBuzz." WHERE str_alias=:alias";
				$str_sql .= " AND `flg_deleted` != 'Y' AND flg_status = 'Active' ";
			}
			else{
				$str_sql = "SELECT PAGES.int_page_id as id";
				$str_sql .= " FROM ".dbtable::TblPages." as PAGES WHERE PAGES.str_page_alias=:alias";
				$str_sql .= " AND `flg_deleted` != 'Y' AND flg_status = 'Y' ";
			}
			
			$dao->initCommand($str_sql);
			$dao->addParameter(":alias",trim($this->alias));
			
			$result = $dao->executeRow();
		 
			$page_id = 0;
			if( count($result) > 0 ){
				$page_id = $result['id'];
			}
			
			
		}
		catch(Exception $e)
		{
            $this->log->logIt("Common->page_id_from_alias:" . $e);
		}
		return $page_id;
	} 

	# @author: Vihang Joshi
	# @version: 1.0.0
	# @date: 2016-05-16
	# @definition: Get Images Records.
	public function get_image_records($module = null, $module_ref_id = null){
		$result=new resultobject();
		try{
			$dao=new dao();
			if( $result->resultData['total'] < 1){
				//$this->common->table_name 	= dbtable::Tbimages;
				
				$this->log->logIt(get_class($this)."-"."get record");
				
				$str_sql = "SELECT str_image_name AS image,str_image_type AS `image_type` FROM ".dbtable::Tbimages." WHERE str_module = :module AND int_module_ref_id = :module_ref_id ";
						  
				$dao->initCommand($str_sql);
				$dao->addParameter(":module",trim($module));
				$dao->addParameter(":module_ref_id",trim($module_ref_id));
				//$this->log->logIt($str_sql);
				$result->resultStatus=resultConstant::Success;		
				$result->resultData["image_list"] = $dao->executeQuery();
				return $result;	

				
			}
			else{
				$result->resultStatus=resultConstant::Warning;
				$result->resultMessage="Record already exist.";
				
			}		
		}
		catch(Exception $e)
		{
			$this->log->logIt(get_class($this)."-"."insert"."-".$e);
			$result->resultStatus=resultConstant::Error;
			$result->exception=$e->getMessage();
		}
		return $result;
	}
	
	
	# @author: Vihang Joshi
	# @version: 1.0.0
	# @date: 2016-05-16
	# @definition: Delete images from database table.
	public function delete_image_record($module = null, $module_ref_id = null,$image_name = null){
		$result=new resultobject();
		try{
			$dao=new dao();
			$this->log->logIt(get_class($this)."-"."delete_record");
			$str_sql = "DELETE FROM ".dbtable::Tbimages." WHERE str_module = :module AND int_module_ref_id =:module_ref_id AND str_image_name =:image_name  ";
			
			$dao->initCommand($str_sql);
			$dao->addParameter(":module",trim($module));
			$dao->addParameter(":module_ref_id",trim($module_ref_id));
			$dao->addParameter(":image_name",trim($image_name));
			$dao->executeNonQuery();
			
			$result->resultStatus=resultConstant::Success;	
		}
		catch(Exception $e)
		{
			$this->log->logIt(get_class($this)."-"."delete_record"."-".$e);
			$result->resultStatus=resultConstant::Error;
			$result->exception=$e->getMessage();
		}
		return $result;
	}
	
	
	
}
?>
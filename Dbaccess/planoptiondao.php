<?php
 # @author: Jignesh Rana <mavenagency.co.za>
 # @version: 1.0.0
 # @date: 2016-02-17
 # @definition: used to create / modified cms pages.
require_once(BASE_PATH."/Dbaccess/commondao.php");
class planoptiondao {
	
	#Object Variables - Start
	private $log;
	public  $params;
	public 	$common;
	#Object Variables - End
	
	#Object Variables - Getter/Setter - Start
	function __construct(){
		try{
			$this->log=new logger();
			$this->params = array();
			$this->common = new commondao();
		}
		catch(Exception $e){
			throw $e;
		}
    }
	
	public function __set( $name, $value ){
		$name	= strtolower( $name );
		if( is_string( $value ) || trim( $value )=='' ){
			$value	= addslashes( $value );
			$value	= trim( $value );
			//$value	= strip_tags( $value );
			$str	='$this->'."$name="."'".$value."'";
		}
		else{
			$str	='$this->'."$name=".$value."";
		}
		eval("$str;");	
    }
	
	public function __get($name){
		$name	= strtolower($name);
		$str	= '$this->'."$name";
		eval("\$str = \"$str\";");
		return $str;
	}

	
	//# @definition: Get records from table.
	public function get_records($txtname='',$request='',$sortkey='',$sortorder='',$offset='',$limit=''){
		
		$result=new resultobject();
		try{
			$limit 	= 10;
			$offset = 0;
			$txtname = $request = $sortkey = $sortorder = '';
			$strsql_where = $strsql_order = $strsql_limit = '';
			
			if ( array_key_exists('limit', $this->params) ) {
				$limit = $this->params['limit'];
			}
			if ( array_key_exists('offset', $this->params) ) {
				$offset = $this->params['offset'];
			}
			if ( array_key_exists('txtname', $this->params) ) {
				$txtname = $this->params['txtname'];
			}
		
			if ( array_key_exists('request', $this->params) ) {
				$request = $this->params['request'];
			}
			if ( array_key_exists('sortkey', $this->params) ) {
				$sortkey = $this->params['sortkey'];
			}
			if ( array_key_exists('sortorder', $this->params) ) {
				$sortorder = $this->params['sortorder'];
			}
			$dao = new dao();
	
			$strsql_total_select = " SELECT PLANOPTION.int_plan_option_id AS id from ".dbtable::Tbplanoption." as PLANOPTION WHERE flg_deleted = 'N' " ;
			 
			$strsql_select = " select PLANOPTION.int_plan_option_id as id,PLANOPTION.int_plan_ref_id as plan_ref_id,";
			$strsql_select.= " PLANOPTION.str_plan_option_title as `title`,PLANOPTION.str_plan_option_description as `description`,";
			$strsql_select.= " PLANOPTION.dat_created_on as date,PLANMASTER.str_plan_type_name as `plan_type`";
			$strsql_select.= " from ".dbtable::Tbplanoption." as PLANOPTION ";
			$strsql_select .= " INNER JOIN ".dbtable::Tbplanmaster." as PLANMASTER ON PLANOPTION.int_plan_ref_id = PLANMASTER.int_plan_type_id ";
			$strsql_select .= " WHERE PLANOPTION.flg_deleted='N' ";
			
			
			if( $txtname !='' ){
				$strsql_where .= " AND (str_plan_option_title LIKE :title)";
			}
			if( $sortkey != "" ){
				$strsql_order = " ORDER BY ".$sortkey." ".$sortorder;
			}
			else{
				$strsql_order .= " ORDER BY int_plan_option_id ASC";
			}
			$strsql_limit .= " LIMIT ".$offset.",".$limit;
			$str_sql = $strsql_select.$strsql_where.$strsql_order.$strsql_limit;
			
		
			$this->log->logIt(get_class($this)."-"."get_list >> ".$str_sql);
			
			$dao->initCommand($str_sql);
	
			if($txtname != ''){
				$dao->addParameter(":title",'%'.trim($txtname).'%');
			}
			
			
			
			$result->resultStatus			= resultConstant::Success;
			$result->resultData["list"] 	= $dao->executeQuery();
			$str_sql_total = $strsql_total_select.$strsql_where;
			
			$dao2 = new dao();
			$dao2->initCommand($str_sql_total);
			if($txtname != ''){
				$dao2->addParameter(":title",'%'.trim($txtname).'%');
			}
			
			$result->resultData["total"] 	= count($dao2->executeQuery());
			 
		}
		catch(Exception $e){
			$this->log->logIt(get_class($this)."-"."ListUser"."-".$e);
			$result->resultStatus=resultConstant::Error;
			$result->exception=$e;
		}	
		return $result;	
	}
	
	# @definition: Insert to record to database table.
	public function insert_record(){
		$result=new resultobject();
		try{
			
			$dao=new dao();
			$result = $this->is_exists();
			if( $result->resultData['total'] < 1){
				$this->common->table_name 	= dbtable::Tbplanoption;
				//$this->common->colum_name	= "int_display_order";
				//$max_num = 1+$this->common->get_max_number();
				//$user_id = $_SESSION['AdminDetails']['int_user_id'];
					
				$str_sql = " INSERT INTO ".dbtable::Tbplanoption;
				$str_sql.="	(int_plan_ref_id,str_plan_option_title,str_plan_option_description) ";
		        $str_sql.=" VALUES(:plan_option_type_id,:plan_option_title,:plan_option_description) ";
			
				
				$dao->initCommand($str_sql);
				$dao->addParameter(":plan_option_type_id",$this->plan_option_type_id);
				$dao->addParameter(":plan_option_title",$this->plan_option_title);
				$dao->addParameter(":plan_option_description",$this->plan_option_description);
				
				//$dao->addParameter(":display_order",$max_num);
			//	$dao->addParameter(":created_by",$user_id);
				$dao->executeNonQuery();	
				$result->resultStatus=resultConstant::Success;
				
				//for image insert this  id is needed
				$result->lastInsertId=$dao->getLastInsertedId();
				//$result->resultData["inserted_id"] = $dao->getLastInsertedId();
				
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
	/* check record exists or not*/
	public function is_exists(){
		$result=new resultobject();
		try{
			$dao=new dao();
			$this->log->logIt(get_class($this)."-"."is_exists");			
			$str_sql = "select PLANOPTION.*
					   from ".dbtable::Tbplanoption." as PLANOPTION 
					   where PLANOPTION.str_plan_option_title = :plan_option_title ";
					   
			$dao->initCommand($str_sql);						
			$dao->addParameter(":plan_option_title",trim($this->plan_option_title));						
			$this->log->logIt($str_sql);					
			$result->resultData["list"] = $dao->executeRow();
			$result->resultData["total"] = count($dao->executeQuery());
			
			return $result;									   
		}
		catch(Exception $e){
			$this->log->logIt(get_class($this)."-"."is_exists"."-".$e);
			$result->resultStatus=resultConstant::Error;
			$result->exception=$e;
		}			
		return $result;		
	}
	
	/*  performing updation of record */
	public function update_record(){
		$result=new resultobject();
		try{
			$dao=new dao();		
			$this->log->logIt(get_class($this)."-"."update");
			$str_sql 	= 	" update ".dbtable::Tbplanoption." set ";
			$str_sql 	.= 	" int_plan_ref_id=:plan_option_type_id,str_plan_option_title=:plan_option_title,str_plan_option_description=:plan_option_description,";
			$str_sql 	.=  " str_modified_by=:modified_by";
			$str_sql 	.= 	" where int_plan_option_id=:planoption_id ";
			$dao->initCommand($str_sql);
			$dao->addParameter(":planoption_id",$this->planoption_id);
			$dao->addParameter(":plan_option_type_id",$this->plan_option_type_id);
			$dao->addParameter(":plan_option_title",$this->plan_option_title);
			$dao->addParameter(":plan_option_description",$this->plan_option_description);
			$dao->addParameter(":modified_by",$this->modified_by);
	       
			$dao->executeNonQuery();	
			$result->resultStatus=resultConstant::Success;
			
		}
		catch(Exception $e){
			$this->log->logIt(get_class($this)."-"."update"."-".$e);
			$result->resultStatus=resultConstant::Error;
			$result->exception=$e;
		}	
		return $result;	
	}
	
	///* for signle record data  for update record*/
	public function get_record(){
		$result=new resultobject();
		try{
			$dao=new dao();
			$this->log->logIt(get_class($this)."-"."get record");
			
			$str_sql = " select PLANOPTION.int_plan_option_id as id,PLANOPTION.int_plan_ref_id as plan_ref_id,";
			$str_sql.= " PLANOPTION.str_plan_option_title as `title`,PLANOPTION.str_plan_option_description as `description`,";
			$str_sql.= " PLANOPTION.dat_created_on as date";
			$str_sql.= " from ".dbtable::Tbplanoption." as PLANOPTION WHERE PLANOPTION.int_plan_option_id = :planoption_id AND flg_deleted = 'N'";
			
			$dao->initCommand($str_sql);
			$dao->addParameter(":planoption_id",trim($this->planoption_id));
			$this->log->logIt($str_sql);
			$result->resultStatus=resultConstant::Success;		
			$result->resultData["list"] = $dao->executeRow();
			return $result;									   
		}
		catch(Exception $e){
			$this->log->logIt(get_class($this)."-"."is_exists"."-".$e);
			$result->resultStatus=resultConstant::Error;
			$result->exception=$e;
		}	
		return $result;
	}
	
	///*   performing delete query for deletion of record */
	public function soft_delete_record(){
		$result=new resultobject();
		try{
			//for plan
			$dao=new dao();		
			$this->log->logIt(get_class($this)."-"."soft_delete_record");
			$str_sql = "update ".dbtable::Tbplanoption." set flg_deleted=:delete where int_plan_option_id=:planoption_id";
			$dao->initCommand($str_sql);
			$dao->addParameter(":delete",'Y');
			$dao->addParameter(":planoption_id",$this->planoption_id);
			$dao->executeNonQuery();
			
		
			
			$result->resultStatus=resultConstant::Success;
		}
		catch(Exception $e){
			$this->log->logIt(get_class($this)."-"."soft_delete_record"."-".$e);
			$result->resultStatus=resultConstant::Error;
			$result->exception=$e;
		}	
		return $result;
	}
	
	public function get_option_record_by_plan_id(){
		$result=new resultobject();
		try{
			
			$dao=new dao();
			$this->log->logIt(get_class($this)."-"."get record");
			
			$str_sql = " select PLANOPTION.int_plan_option_id as id,PLANOPTION.int_plan_ref_id as plan_ref_id,";
			$str_sql.= " PLANOPTION.str_plan_option_title as `title`,PLANOPTION.str_plan_option_description as `description`,";
			$str_sql.= " PLANOPTION.dat_created_on as date,";
			$str_sql.= " PLANIMG.str_image_url AS `img_url`,PLANIMG.str_image_path AS `path`,";
			$str_sql.= " PLANIMG.str_image_name AS `img_name` ";
			$str_sql.= " from ".dbtable::Tbplanoption." as PLANOPTION LEFT JOIN ".dbtable::Tbimages." AS PLANIMG ON ";
			$str_sql.= " PLANOPTION.int_plan_option_id=PLANIMG.int_module_ref_id AND str_module = 'planoption' WHERE PLANOPTION.int_plan_ref_id = :plan_id AND flg_deleted = 'N'";
			
			$dao->initCommand($str_sql);
			$dao->addParameter(":plan_id",trim($this->plans_id));
			$this->log->logIt($str_sql);
			$result->resultStatus=resultConstant::Success;		
			$result->resultData["list"] = $dao->executeQuery();
			return $result;									   
		}
		catch(Exception $e){
			$this->log->logIt(get_class($this)."-"."is_exists"."-".$e);
			$result->resultStatus=resultConstant::Error;
			$result->exception=$e;
		}	
		return $result;
	}
}
?>
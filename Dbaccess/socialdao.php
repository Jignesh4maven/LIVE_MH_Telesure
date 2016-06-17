<?php
 # @author: Jignesh Rana <mavenagency.co.za>
 # @version: 1.0.0
 # @date: 2016-02-17
 # @definition: used to create / modified cms pages.
require_once(BASE_PATH."/Dbaccess/commondao.php");
class socialdao {
	
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

	# @author: Jignesh Rana 
	# @version: 1.0.0
	# @date: 2016-02-17
	# @definition: Insert to record to database table.
	public function insert_record(){
		$result=new resultobject();
		try{
			$dao=new dao();
			//$result = $this->is_exists();
			if( $result->resultData['total'] < 1){
				$this->common->table_name 	= dbtable::Tbsocial;
				//$this->common->colum_name	= "int_display_order";
				//$max_num = 1+$this->common->get_max_number();
				$user_id = $_SESSION['AdminDetails']['int_user_id'];
					
				$str_sql = " INSERT INTO ".dbtable::Tbsocial."(str_social_network,str_social_url,int_created_by) ".
						 " VALUES(:social_network,:social_url,:created_by) ";
				
				
				$dao->initCommand($str_sql);
				$dao->addParameter(":social_network",$this->social_network);
				$dao->addParameter(":social_url",$this->social_url);
			    //$dao->addParameter(":display_order",$max_num);
				$dao->addParameter(":created_by",$user_id);
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

	/*  performing updation of record */
	public function update_record(){
		$result=new resultobject();
		try{
			$dao=new dao();		
			$this->log->logIt(get_class($this)."-"."update");
			$str_sql 	= 	" update ".dbtable::Tbsocial." set ";
			$str_sql 	.= 	" str_social_url=:social_url,str_modified_by=:modified_by";
			$str_sql 	.= 	" where str_social_network=:social_network ";
			$dao->initCommand($str_sql);
			$dao->addParameter(":social_url",$this->social_url);
			$dao->addParameter(":social_network",$this->social_network);
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
	/*  gettinng all records */
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

			$strsql_total_select = " SELECT SOCIAL.int_social_links_id AS id from ".dbtable::Tbsocial." as SOCIAL WHERE flg_deleted = 'N' " ;
			 
			$strsql_select = "select SOCIAL.int_social_links_id as id,SOCIAL.str_social_network as `social_network`,SOCIAL.str_social_url as `social_url`,";
			$strsql_select .= "SOCIAL.int_created_by as createdby,SOCIAL.dat_created_on as date,SOCIAL.str_modified_by as `modifiedby`";
			$strsql_select .= "from ".dbtable::Tbsocial." as SOCIAL WHERE `flg_deleted`='N' ";
			
			
			if( $txtname !='' ){
				$strsql_where .= " AND (str_title LIKE :title)";
			}
			if( $sortkey != "" ){
				$strsql_order = " ORDER BY ".$sortkey." ".$sortorder;
			}
			else{
				$strsql_order .= " ORDER BY int_social_links_id ASC";
			}
			$strsql_limit .= " LIMIT ".$offset.",".$limit;
			$str_sql = $strsql_select.$strsql_where.$strsql_order.$strsql_limit;
			
			$this->log->logIt(get_class($this)."-"."get_title >> ".$txtname);
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
	
}
?>
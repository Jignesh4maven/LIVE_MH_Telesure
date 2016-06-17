<?php
 # @author: Jignesh Rana <mavenagency.co.za>
 # @version: 1.0.0
 # @date: 2016-02-17
 # @definition: used to create / modified cms pages.
require_once(BASE_PATH."/Dbaccess/commondao.php");
class imagesdao {
	
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

	
}
?>
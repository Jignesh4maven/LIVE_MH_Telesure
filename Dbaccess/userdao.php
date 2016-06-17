<?php
class userdao {
	
	#Object Fields - Start
	private $log;
	public  $typeArray;
	#Object Fields - End
	
	#Object Fields - Getter/Setter - Start
	function __construct(){
		try{
			$this->log=new logger();
		}
		catch(Exception $e){
			throw $e;
		}
    }
	
	public function __set($name, $value){
		$name=strtolower($name);
		if(is_string($value) || trim($value)==''){
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
	
	public function __get($name){
		$name=strtolower($name);
		$str='$this->'."$name";
		eval("\$str = \"$str\";");
		return $str;
	}

	/*Add Record*/
	public function add(){
			
	} 

	/*Update Record*/
	public function update(){
		 
	}
	
	/*Check if id exists*/
	public function is_exists(){
		
	}

	/*delete record*/
	public function delete(){
					
	}

	/*get single recored*/
	public function get($id=''){
		 			
	}

	/*get records*/
	public function get_list($txtname='',$request='',$sortkey='',$sortorder='',$offset='',$limit=''){
		 			
	}

	/*update toggle for status*/
	public function update_toggle(){
		 
	}			
}
?>
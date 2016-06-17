<?php
class util
{
	public function setParam( $options = array() ){
		
		$array = $_REQUEST;
		
		#print_r($options);
		
		$accept_html_tags = false;
		
		$accept_unsafe_tags = false;
		
		if( array_key_exists("accept_html_tags",$options) ){
			$accept_html_tags = true;
		}
		if(  array_key_exists("accept_unsafe_tags",$options) ){
			$accept_unsafe_tags = true;
		}
		
		#print $accept_html_tags."---".$accept_unsafe_tags."<br/>";
		
		foreach($array as $key => $value){
			
			if( trim($key) != "" ){
					
					$new_value = $this->hackerDefense($value);
					
					if( $accept_html_tags != true){
						
						$new_value = $this->strip_html_tags($new_value);
						
					}
					
					if( $accept_unsafe_tags != true){
						
						$new_value = $this->strip_unsafe_tags($new_value);
					}
					
					$G_PARAMS[$key] = $new_value;
			}
		}
		
		return $G_PARAMS;
	}
	
	public function makeDate($intDay, $intMonth, $intYear)
	{
		return date ("Y-m-d", mktime (0,0,0,$intMonth, $intDay, $intYear));
	}

	public function hackerDefense($secvalue)
	{
		if ((preg_match("/&lt;[^&gt;]*script.*\"?[^&gt;]*&gt;/i", $secvalue)) ||
		(preg_match("/&lt;[^&gt;]*object.*\"?[^&gt;]*&gt;/i", $secvalue)) ||
		(preg_match("/&lt;[^&gt;]*iframe.*\"?[^&gt;]*&gt;/i", $secvalue)) ||
		(preg_match("/&lt;[^&gt;]*applet.*\"?[^&gt;]*&gt;/i", $secvalue)) ||
		(preg_match("/&lt;[^&gt;]*window.*\"?[^&gt;]*&gt;/i", $secvalue)) ||
		(preg_match("/&lt;[^&gt;]*document.*\"?[^&gt;]*&gt;/i", $secvalue)) ||
		(preg_match("/&lt;[^&gt;]*cookie.*\"?[^&gt;]*&gt;/i", $secvalue)) ||
		(preg_match("/&lt;[^&gt;]*meta.*\"?[^&gt;]*&gt;/i", $secvalue)) ||
		(preg_match("/&lt;[^&gt;]*style.*\"?[^&gt;]*&gt;/i", $secvalue)) ||
		(preg_match("/&lt;[^&gt;]*alert.*\"?[^&gt;]*&gt;/i", $secvalue)) ||
		(preg_match("/&lt;[^&gt;]*form.*\"?[^&gt;]*&gt;/i", $secvalue)) ||
		(preg_match("/&lt;[^&gt;]*php.*\"?[^&gt;]*&gt;/i", $secvalue)) ||
		(preg_match("/&lt;[^&gt;]*]*&gt;/i", $secvalue))) 
		{
			$secvalue='';
		}
		return $secvalue;
	}
	
	public function strip_html_tags( $text )
	{
		// PHP's strip_tags() function will remove tags, but it
		// doesn't remove scripts, styles, and other unwanted
		// invisible text between tags.  Also, as a prelude to
		// tokenizing the text, we need to insure that when
		// block-level tags (such as <p> or <div>) are removed,
		// neighboring words aren't joined.
		$text = preg_replace(
			array(
				// Remove invisible content
				'@<head[^>]*?>.*?</head>@siu',
				'@<style[^>]*?>.*?</style>@siu',
				'@<script[^>]*?.*?</script>@siu',
				'@<object[^>]*?.*?</object>@siu',
				'@<embed[^>]*?.*?</embed>@siu',
				'@<applet[^>]*?.*?</applet>@siu',
				'@<noframes[^>]*?.*?</noframes>@siu',
				'@<noscript[^>]*?.*?</noscript>@siu',
				'@<noembed[^>]*?.*?</noembed>@siu',
	
				// Add line breaks before & after blocks
				'@<((br)|(hr))@iu',
				'@</?((address)|(blockquote)|(center)|(del))@iu',
				'@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
				'@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
				'@</?((table)|(th)|(td)|(caption))@iu',
				'@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
				'@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
				'@</?((frameset)|(frame)|(iframe))@iu',
			),
			array(
				' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
				"\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
				"\n\$0", "\n\$0",
			),$text );
	
		// Remove all remaining tags and comments and return.
		return strip_tags($text);
	}
	
	public function strip_unsafe_tags( $text )
	{
		$text = preg_replace(
			array(
				// Remove invisible content
				'@<head[^>]*?>.*?</head>@siu',
				'@<style[^>]*?>.*?</style>@siu',
				'@<script[^>]*?.*?</script>@siu',
				'@<object[^>]*?.*?</object>@siu',
				'@<embed[^>]*?.*?</embed>@siu',
				'@<applet[^>]*?.*?</applet>@siu',
				'@<noframes[^>]*?.*?</noframes>@siu',
				'@<noscript[^>]*?.*?</noscript>@siu',
				'@<noembed[^>]*?.*?</noembed>@siu',
	
				// Add line breaks before & after blocks
				'@<((br)|(hr))@iu',
				'@</?((address)|(blockquote)|(center)|(del))@iu',
				'@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
				'@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
				'@</?((table)|(th)|(td)|(caption))@iu',
				'@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
				'@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
				'@</?((frameset)|(frame)|(iframe))@iu',
			),
			array(
				' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
				"\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
				"\n\$0", "\n\$0",
			),$text );
	
		return ($text);
	}
	
	public function onlyString($value)
	{
		//$value=preg_replace("/[^A-Za-z '\"]/","", $value);
		$value=preg_replace("/[,|]/"," ", $value);
		//$value=addslashes($value);
		$value=trim($value);
		$value=strip_tags($value);
		return $value;
	}
	
	public function safeString($value)
	{
		//$value=preg_replace("/[^A-Za-z '\"]/","", $value);
		$value=preg_replace("/[,|]/"," ", $value);
		//$value=addslashes($value);
		$value=trim($value);
		$value=strip_tags($value);
		return $value;
	}
	
	public function safeNumber($value)
	{
		$value=preg_replace("/[^0-9.]/","", $value);
		//$value=addslashes($value);
		$value=trim($value);
		$value=strip_tags($value);
		return trim($value,".");
	}
	
	public function safeStringNumber($value)
	{
		$value=preg_replace("/[^A-Za-z0-9 '\/\)\(\"]&/","", $value);
		//$value=addslashes($value);
		$value=trim($value);
		$value=strip_tags($value);
		return $value;
	}
	
	static public function VisitorIP()
	{ 
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$TheIp=$_SERVER['HTTP_X_FORWARDED_FOR'];
		else 
			$TheIp=$_SERVER['REMOTE_ADDR'];

		$iparr = explode(',',$TheIp);
		
		if(count($iparr)>0)
		{
			$TheIp=trim($iparr[0]);
		}
		
		return trim($TheIp);
	}
	
	static public function VisitorProxyIP()
	{ 
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$TheIp=$_SERVER['HTTP_X_FORWARDED_FOR'];
		else 
			$TheIp=$_SERVER['REMOTE_ADDR'];

		return trim($TheIp);
	}
	
	static public function getLocationFromIP($ip)
	{
		try
		{
			$result = array();
			$ip2location_data = ip2location_finder($ip);
			if(is_array($ip2location_data) && !empty($ip2location_data))
			{
				if($ip2location_data['RESPONSE'] == 'TIMEOUT')
				{
					return array();
				}
				else
				{
					$result['country'] = $ip2location_data['countryname'];
					$result['city'] = $ip2location_data['city'];
				}
			}
			else
			{
				return array();
			}
		}
		catch(Exception $e)
		{
			return array();
		}
		return $result;
	}

	public function writeUTF8File($filename,$content)
	{
        $f=fopen($filename,"w");
        # Now UTF-8 - Add BOM ( Byte Order Mark )
        fwrite($f, pack("CCC",0xef,0xbb,0xbf));
        fwrite($f,$content);
        fclose($f);
	}

	public function utf8_urldecode($str) {
    	$str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
    	return html_entity_decode($str,null,'UTF-8');;
 	 } 
	
	public function getLanguage($what="USR") # USR/CAL
	{
		$log = new logger();
		try
		{
			$user=new userdao();
			$user->userunkid=$_SESSION[$_SESSION['prefix']]['loginuserunkid'];
			//$log->logIt("getLanguage >> ".$user->userunkid);
			$result=$user->getRecord();
			$row=$result->resultValue['record'];
			if($what=="USR")
			{
				return $row["language"];
			}
			else if($what=="CAL")
			{
				return $row["calendarlanguage"];
			}
		}
		catch(Exception $e)
		{
			$log->logIt("getLanguage >> ".$user->userunkid."-".$_SESSION[$_SESSION['prefix']]['loginuserunkid']."-".$e);
		}
 	} 
	
		 
	public function generatePassword($length=9, $strength=0) {
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}
	 
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}
	 
	public function isRequestFromMobile()
	{
		$iPod=$iPhone=$iPad=$Android=$AndroidTablet=$webOS=$BlackBerry=$RimTablet=false;
		$iPod = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
		$iPhone = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
		$iPad = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
		if(stripos($_SERVER['HTTP_USER_AGENT'],"Android") && stripos($_SERVER['HTTP_USER_AGENT'],"mobile")){
				$Android = true;
		}else if(stripos($_SERVER['HTTP_USER_AGENT'],"Android")){
				$Android = false;
				$AndroidTablet = true;
		}else{
				$Android = false;
				$AndroidTablet = false;
		}
		$webOS = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
		$BlackBerry = stripos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
		$RimTablet= stripos($_SERVER['HTTP_USER_AGENT'],"RIM Tablet");
		
		return $iPod||$iPhone||$iPad||$Android||$AndroidTablet||$webOS||$BlackBerry||$RimTablet;
	}
	 
	 
	public function ParseJsonData($json_data)
	{		
		$log = new logger();
		
		$arrayformat=array();
		foreach(staticarray::$languagearray as $lang_key=>$lang_value)
		{
			$decodedata=json_decode($json_data['lang_'.$lang_key], true);
			if(isset($decodedata))
			{
				foreach($decodedata as $key=>$value)
				{
					foreach($value as $k=>$v)
						$arrayformat[$lang_key][$k]	= $v;
				}
			}	
		}	
		return $arrayformat;		
	}
	
	public function mandatoryField($value)
	{
		if(isset($value) && $value != "")
		{
			return true;
		}else{
			return false;
		}

	}
	
	public function yesnoJson(){
		
		$static = new staticarray();
		
		return $static::$YesNoIndicator;

	}
	
	public function validateDate($date, $format = 'Y-m-d H:i:s'){
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	
	public function getImageRawData($image = null){

		if(!empty($image)){
			$fileData = '';
			$fileData = pathinfo(basename($image));
			return $fileData;
		}
		else{
			return array();
		}
		
	}
	
	# @author: Vihang Joshi<mavenagency.co.za>
    # @version: 1.0.0
    # @date: 2016-05-16
    # @definition: Creates thumb Image for display purpose.
	public function create_thumb_image($filename = null,$thumbName=null,$thumbwidth,$thumbheight){
		
		try{
			
			
			$fileData = '';
			$fileData = pathinfo(basename($filename));
			$ext = $fileData['extension'];			
			//the resize will be a percent of the original size
			$percent = 0.5;
			
			// Content type
			header('Content-Type: image/jpeg');
			
			// Get new sizes
			list($width, $height) = getimagesize($filename);
			$newwidth = $width * $percent;
			$newheight = $height * $percent;
			
			// Load
			$thumb = imagecreatetruecolor($thumbwidth,$thumbheight);
			if ($ext == "jpg" || $ext == "jpeg") {
				$source=imagecreatefromjpeg($filename);
			} elseif ($ext == "png") {
				$source=imagecreatefrompng($filename);
			} elseif ($ext == "gif") {
				$source=imagecreatefromgif($filename);
			}
						
			$destination = IMAGE_PATH.'Thumb/'.$thumbName;
			// Resize
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $thumbwidth, $thumbheight, $width, $height);
			
			// Output and free memory
			//the resized image will be 100x100
			imagejpeg($thumb,$destination,75);
			imagedestroy($thumb);
			
		}
		catch(Exception $e){
			error_log($e);
			
		}
		
	}
	
	

	
}#Class
?>
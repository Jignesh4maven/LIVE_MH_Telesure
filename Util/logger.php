<?php
class logger
{
	/**
	 * The full path to the folder where the log files reside.
	 * @var string $defaultLogFolder
	 */
	private $enable=true;
	/**
	 * The full path to the folder where the log files reside.
	 * @var string $defaultLogFolder
	 */
	private $defaultLogFolder;
	
	/**
	 * Name of the default log file.
	 * @var string $defaultLogFile
	 */
	private $defaultLogFile;
	
	/**
	 * The default log type.
	 * @var string $defaultLogType
	 */
	private $defaultLogType;

	/**
	 * The default log method. 
	 * Possible values: INFO, ERROR, SQL
	 * @var string $defaultLogMethod
	 */
	private $defaultLogMethod;

	/**
	 * The default log email ID.
	 * Possible values: FILE, EMAIL
	 * @var string $defaultLogMailId
	 */
	private $defaultLogMailId;
	
	/**
	 * The default log email subject.
	 * @var string $defaultEmailSubject
	 */
	private $defaultEmailSubject;
	
	/**
	 * Constructor sets up
	 * {@link $defaultLogFolder} 
	 * {@link $defaultLogFile} 
	 * {@link $defaultLogType} 
	 * {@link $defaultLogMethod} 
	 * {@link $defaultLogMailId} 
	 * {@link $} 
	 * {@link $defaultEmailSubject}
	 */
	 
	public function __construct($logfilename='')
	{
		global $logsPath;
		$this->defaultLogFolder 	= $logsPath;#$_SERVER['DOCUMENT_ROOT'].'/logs/';
		
		if( defined("FRONT") ){
			$this->defaultLogFile 		= 'front_'.date('Ymd').'.log';
		}
		elseif($logfilename == ''){
			$this->defaultLogFile 		= 'config_'.date('Ymd').'.log';
		}
		else
			$this->defaultLogFile 		= $logfilename."_".date('Ymd').'.log';
		
		
		if(file_exists($this->defaultLogFolder.$this->defaultLogFile))
		{
			if(filesize($this->defaultLogFolder.$this->defaultLogFile)>20000000)
			{
				rename($this->defaultLogFolder.$this->defaultLogFile,$this->defaultLogFolder.date('Ymd_His').$this->defaultLogFile);
			}
		}
					
		$this->defaultLogType 		= 'INFO';
		$this->defaultLogMethod 	= 'FILE';
		$this->defaultLogMailId 	= 'jignesh@mavenagnecy.co.za';
		$this->defaultEmailSubject	= 'Notification';
	}
	
	/**
	 * Log the given data
	 */
	public function logIt($logData, $logType = '', $logMethod = '', $logFile = '', $logMailId = '')
	{
		if(is_array($logData) || is_object($logData)) 
			$finalLogData = print_r($logData, TRUE);
		else
			$finalLogData = $logData;
	
		if(trim($logType) == '')
			$logType = $this->defaultLogType;
		else
			$logType = strtoupper(strtolower($logType));			
		
		if(trim($logMethod) == '')
			$logMethod = $this->defaultLogMethod;
		
		if(trim($logFile) == '')
			$logFile = $this->defaultLogFolder.$this->defaultLogFile;

		if(trim($logMailId) == '')
			$logMailId = $this->defaultLogMailId;		
		
		#Form the log data string
		if(isset($_SESSION['prefix'])) 
		{
			if(isset($_SESSION[$_SESSION['prefix']]))
			{
				if(isset($_SESSION[$_SESSION['prefix']]['prop_code']))
				{
				$finalLogData = "hotel_".$_SESSION[$_SESSION['prefix']]['prop_code']." - ".$_SERVER['SERVER_NAME']." - ".util::VisitorIP()." - ".date("Y-m-d H:i:s")." => [".$logType."] ".$finalLogData."\n";
			
				}
			}
		}
		else{
			$server = "mavenindia";
			$ip = "Cron";
			
			if( array_key_exists('SERVER_NAME',$_SERVER ) ){
				$server = $_SERVER['SERVER_NAME'];
				$ip = util::VisitorIP();
			}
			$finalLogData = $server ." - ".$ip." - ".date("Y-m-d H:i:s")." => [".$logType."] ".$finalLogData."\n";
			
		}
		
		
		switch($logMethod)
		{
			case 'EMAIL':
				if($this->enable)
				{
				}			
			break;

			case 'FILE':
			default:
				if($this->enable)
				{
					#Write to a file
					$fp = fopen($logFile, 'a');
					
					global $server;
					if($server!="local")
					{
						$findword  = 'exception';		
						if(preg_match('/'.$findword.'/',$finalLogData))
						{
							$finalLogData="Error Found : ".$finalLogData;						
							if($server!='local')
							{
								if(isset($_SESSION['prefix'])) 
								{
									if(isset($_SESSION[$_SESSION['prefix']])) 
									{
										if(isset($_SESSION[$_SESSION['prefix']]['prop_code'])) 
										{			
											if($_SESSION[$_SESSION['prefix']]['prop_code']!=1  && $_SERVER['SERVER_NAME']!='ubuntu')
											{
												#Send the notification email
												$headers  = 'MIME-Version: 1.0' . "\r\n";
												$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
												$headers .= 'From: saas <jignesh@mavenagnecy.co.za>'."\r\n";
												mail('jignesh@mavenagnecy.co.za', 'Error Found in ratespider', $finalLogData, $headers);				
											}	
										}//isset prifix	hotel code
									}//isset prifix		
								}//isset prifix	
								
							}
						}
					}	
					
					fwrite($fp, $finalLogData."\n");
					fclose($fp);
				}
			
			break;
		}
	}
}
?>
<?php
class logout 
{
	private $module = 'logout';
	private $log;	
	
	public function __construct()
	{
		$this->log=new logger();
		try
		{
			$this->log->logIt("Logout Page Load");	
	
			unset($_SESSION['AdminDetails']);
			unset($_SESSION[$_SESSION['prefix']]);
			unset($_SESSION['AdminAccess']); 
	
			 setcookie('login_id',"",time()-3600);			
			 setcookie('login_password',"",time()-3600);			
			 
			 header("location:login.php");
		}	 
		catch(Exception $e)
		{
			$this->log->logIt($module."-"."onLoad"."-".$e);		
		}
	}	
	
	public function load()
	{
		try
		{
			$this->log->logIt("LOgout Page Load");	
	
			unset($_SESSION['AdminDetails']);
			unset($_SESSION[$_SESSION['prefix']]);
			unset($_SESSION['AdminAccess']); 
	
			 setcookie('login_id',"",time()-3600);			
			 setcookie('login_password',"",time()-3600);			
								 
			 
			 header("location:login.php");
		}	 
		catch(Exception $e)
		{
			$this->log->logIt($module."-"."onLoad"."-".$e);		
		}
	}
}	
?>



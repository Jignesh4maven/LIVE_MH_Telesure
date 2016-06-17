<?php
class resultConstant
{
	const Success	='Success';
	const Error		='Error';
	const Warning	='Warning';
}

class resultobject
{
	public $resultStatus;
	public $resultData;
	
	function __construct()
	{
		$resultStatus = resultConstant::Success;
		$resultData = array();
		
    }
}
?>
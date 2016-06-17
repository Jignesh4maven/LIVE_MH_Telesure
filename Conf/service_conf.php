<?php
/* web service configuration start */
    $dev =	false;
	#$SERVICE_URl = ($dev == true) ? "https://41.160.117.196" : "https://lc-peapp01-dev.amhfs.co.za";
    $SERVICE_URl = ($dev == true) ? "https://41.160.117.197" : "https://lc-peapp01-prod.amhfs.co.za";
	
	$CREDITCARD_PAYURL	= "https://virtual.mygateglobal.com/PaymentPage.cfm"; # LIVE
	$MERCHANT_ID 		= "ffe433f2-f81d-4b52-897f-84585f651d8c"; # LIVE
	$APPLICAION_ID 		= "4079f45d-dfff-462b-a1ad-96f347d5dc3b"; # LIVE
	$MODE 				= "1"; //0 = Test Mode. 1 = Live Mode
	
	$MERCHANTREFERENCE	= "motorhappy1234"; //Merchant Reference - afphanumeris of 4-16 characters
	$CURRENCY 			= "ZAR";
	
	//Web Service Authentication Parameter
	$WEBSERVICE_USERNAME 	= 'MotorHappy';
	$WEBSERVICE_PASSWORD  	= 'MotorHappy';
	
	//ChannelId and DealerId
	$CHANNEL_ID = 14;
	$DEALER_ID = 1;
    
	/*Telesure datatype array model*/
	$AddressType=array(		"Residential"	=> 0,
							"Postal" 		=> 1,
							"Night"	 		=> 2,
							"Day" 			=> 3
							);	
	$YesNoIndicator=array(
						"true"	=>	"yes",
						"false"	=>	"no"
						);
	
	
	
/* web service configuration end*/

$db_name 	= "maven_mh";
$mysqlhost 	= "188.40.98.198";
$mysqluser 	= "mh_db";
$mysqlpwd 	= "Fbdt37!1";
?>
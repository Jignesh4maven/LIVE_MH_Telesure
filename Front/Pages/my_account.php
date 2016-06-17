<?php
require_once(BASE_PATH."/Util/util.php");
require_once(BASE_PATH."/Util/Services/securityservices.php");
require_once(BASE_PATH."/Util/Services/customerservices.php");
require_once(BASE_PATH."/Util/Services/service_util.php");
require_once(BASE_PATH."/Front/Pages/personal_details.php");

class my_account{

	private $module = 'my_account';
	private $log;
	private $util;

	public function __construct(){
		$this->log		= new logger();
		$this->util 	= new util();
		$this->securityservices = new securityservices();
		$this->customerservices = new customerservices();
		$this->service_util = new service_util();

	}

	# @author: Vihang Joshi <vihang@mavenagency.co.za>
	# @version: 1.0.0
	# @date: 2016-03-08
	# @definition: Initiate template view
	public function load(){
		try{

			$today =  gmdate("Y-m-d\ H:i:s");
			$this->log->logIt($today." ".$this->module."-"."Page Load");
			global $tpl;
			global $config;
			
			$data = array();
			/*if( isset($_SESSION['Front']['user']) && !empty($_SESSION['Front']['user']) ){
				$data = $this->service_util->get_userinfo_session();				
			}
			else{
				
				//$data['IdentificationNo'] = "";
				if( array_key_exists('Front',$_SESSION) ){
					if( array_key_exists('personal_details',$_SESSION['Front']) ){
						$posted_session_data 	= $_SESSION['Front']['personal_details'];
						$data['PassportNo'] 	= $_SESSION['Front']['personal_details']['passport_number'];
						$data['OtherContactNo'] = $_SESSION['Front']['personal_details']['passport_number'];
						$data['Title'] 			= $_SESSION['Front']['personal_details']['person_title'];
						$data['BirthDate'] 		= $_SESSION['Front']['personal_details']['person_dob'];
					}
				}
				
			}*/
			
			$customerVehicleRes = array("CustomerGetResult" => array("AcceptTermsAndConditions" => 1,"BankAccountDetails" => array("BankAccountHolder" => "Dawie Harmse","BankAccountNumber" => "","BankAccountType" => 0,"BankAccountTypeDesc" => "","BankDetails" => 0,"BankDetailsDesc" =>"" ,"DebitOrderDay" => 1,"EFTDetailed" => "Account type: Corporate Cheque AccountAccount name: Motorhappy (Pty), LtdAccount no.: 62523137033Branch name and no.: RMB Corporate Banking Johannesburg 255005","PaymentMethod" => "None"),"BirthDate" => "1983-01-04T00:00:00","CellphoneNo" => "0825672884","ChannelDescription" => "14,MotorHappy","ChannelId" => 14,"CustomerID" => 11,"CustomerVehicleList" => array("CustomerVehicleModel" => array("0" => array("CustomerOfferList" => array("CustomerOfferModel" => array("AmountOfMonthsToCover" => 24,"AmountOfYearsToCover" => 2,"BankAccountDetails" => array("BankAccountHolder" => "","BankAccountNumber" => "","BankAccountType" => 0,"BankAccountTypeDesc" => "", "BankDetails" => 0,"BankDetailsDesc" => "", "DebitOrderDay" => 0,"EFTDetailed" => "Account type: Corporate Cheque AccountAccount name: Motorhappy (Pty), LtdAccount no.: 62523137033Branch name and no.: RMB Corporate Banking Johannesburg 255005","PaymentMethod" => "EFT"),"Brand" => "LIQUIDCAPITAL (NON AMH)","CurrentKm" => 99887,"CustomerDocumentationList" => array("CustomerDocumentationModel" => array("0" => array("Description" => "LiquidCapital Pre-Owned Service and Maintenance Plan Booklet","DocumentationID" => 21),"1" => array("Description" => "Service and Maintenance Welcome Letter","DocumentationID" => 22))),"CustomerOfferId" => 1001,"CustomerProductList" => array("CustomerProductModel" => array("0" => array("CustomerProductID" => 22,"Description" => "LIQUIDCAPITAL Roadside Assistance","ProductID" => 170),"1" => array("CustomerProductID" => 21,"Description" => "LIQUIDCAPITAL Pre-Owned Service Plan","ProductID" => 5))),"CustomerVehicleId" => 21,"DeliveryAddress" => array("AddressLine1" => "4 Welgemoed Golf Estate","AddressLine2" => "Nederburgh Street","AddressLine3" => "","PostCode" => 43891,"PostCodeDesc" => "7530,Street,WELGEMOED,BELLVILLE"),"DocumentDelivery" => "None","DocumentDeliveryEmail" => "dawie@mavenagency.co.za","DocumentDeliveryEmailVerified" => "","KmToCover" => 30000,"MonthlyTotalCost" => 211.44920476,"MonthlyTotalCostVAT" => 241.05209342,"OfferDescription" => "LiquidCapital Pre-owned Service Plan","OfferId" => 3,"PaymentTerm" => 24,"PlanValue" => 5238.05024228,"PolicyNumber" => "MOTO00001001","Status" => "Pending","SumOfMonthlyPremium" => 5785.25024200,"TotalCost" => 4594.78091428,"TotalCostVAT" => 5238.05024228)),"CustomerVehicleID" => 21,"DateOfFirstRegistration" => "2013-01-01T00:00:00","EngineNo" =>"" ,"MMCode" => 60015081,"Make" => 137,"MakeDesc" => "TOYOTA","Model" => 3607,"ModelDesc" => "AURIS","PermissionToSearch" =>"" ,"PreviousOwned" => 1,"RegistrationNo" => "123GP","Series" => 14867,"SeriesDesc" => "1.3 X","ServiceHistory" => 1,"VINNo" => "","Vehicle" => 2593,"VehicleDesc" => "TOYOTA AURIS 1.3 X","Warranty" => "Yes","Year" => 2013),"1" => array("CustomerOfferList" => array("CustomerOfferModel" => array("0" => array("AmountOfMonthsToCover" => 24,"AmountOfYearsToCover" => 2,"BankAccountDetails" => array("BankAccountHolder" => "DP Harmse","BankAccountNumber" => 9087108383,"BankAccountType" => 2,"BankAccountTypeDesc" => "Savings","BankDetails" => 491,"BankDetailsDesc" => "632005,ABSA,ABSA ELECTRONIC SETTLEMENT CNT","DebitOrderDay" => 27,"EFTDetailed" => "Account type: Corporate Cheque AccountAccount name: Motorhappy (Pty), LtdAccount no.: 62523137033Branch name and no.: RMB Corporate Banking Johannesburg 255005","PaymentMethod" => "DebitOrder"),"Brand" => "LIQUIDCAPITAL","CurrentKm" => 88776,"CustomerDocumentationList" => array("CustomerDocumentationModel" => array("0" => array("Description" => "Platinum Motor Vehicle Warranty Booklet","DocumentationID" => 13),"1" => array("Description" => "Warranty Welcome Letter","DocumentationID" => 14),"2" => array("Description" => "LIQUIDCAPITAL Roadside Assistance Plan","DocumentationID" => 910))),"CustomerOfferId" => 12,"CustomerProductList" => array("CustomerProductModel" => array("0" => array("CustomerProductID" => 15,"Description" => "LIQUIDCAPITAL Roadside Assistance","ProductID" => 235),"1" => array("CustomerProductID" => 14,"Description" => "LIQUIDCAPITAL Extended Warranty (Plan B)","ProductID" => 229))),"CustomerVehicleId" => 11,"DeliveryAddress" => array("AddressLine1" => "4 Welgemoed Golf Estate","AddressLine2" => "Nederburgh Street","AddressLine3" => "","PostCode" => 43891,"PostCodeDesc" => "7530,Street,WELGEMOED,BELLVILLE"),"DocumentDelivery" => "None","DocumentDeliveryEmail" => "dawie@mavenagency.co.za","DocumentDeliveryEmailVerified" => "","KmToCover" => 200000,"MonthlyTotalCost" => 182.74857142,"MonthlyTotalCostVAT" => 208.33337142,"OfferDescription" => "LIQUIDCAPITAL Extended Warranty (Plan B)","OfferId" => 113,"PaymentTerm" => 24,"PlanValue" => 5000.00091400,"PolicyNumber" => "MOTO00000012","Status" => "Pending","SumOfMonthlyPremium" => 5000.00091400,"TotalCost" => 4385.96571428,"TotalCostVAT" => 5000.00091428),"1" => array("AmountOfMonthsToCover" => 24,"AmountOfYearsToCover" => 2,"BankAccountDetails" => array("BankAccountHolder" => "DP Harmse","BankAccountNumber" => "9087108383","BankAccountType" => 2,"BankAccountTypeDesc" => "Savings","BankDetails" => 491,"BankDetailsDesc" => "632005,ABSA,ABSA ELECTRONIC SETTLEMENT CNT","DebitOrderDay" => 27,"EFTDetailed" => "Account type: Corporate Cheque AccountAccount name: Motorhappy (Pty), LtdAccount no.: 62523137033Branch name and no.: RMB Corporate Banking Johannesburg 255005","PaymentMethod" => "DebitOrder"),"Brand" => "360PLUS (NON AMH)","CurrentKm" => 88776,"CustomerDocumentationList" => array("CustomerDocumentationModel" => array("0" => array("Description" => "Service and Maintenance Welcome Letter","DocumentationID" => 11),"1" => array("Description" => "360PLUS Service and Maintenance Plan Booklet","DocumentationID" => 12))),"CustomerOfferId" => 11,"CustomerProductList" => array("CustomerProductModel" => array("0" => array("CustomerProductID" => 13,"Description" => "360PLUS Service Plan Booster","ProductID" => 128),"1" => array("CustomerProductID" => 12,"Description" => "360PLUS Roadside Assistance","ProductID" => 160),"2" => array("CustomerProductID" => 11,"Description" => "360PLUS Service Plan","ProductID" => 127))),"CustomerVehicleId" => 11,"DeliveryAddress" => array("AddressLine1" => "4 Welgemoed Golf Estate","AddressLine2" => "Nederburgh Street","AddressLine3" => "","PostCode" => 43891,"PostCodeDesc" => "7530,Street,WELGEMOED,BELLVILLE"),"DocumentDelivery" => "None","DocumentDeliveryEmail" => "dawie@mavenagency.co.za","DocumentDeliveryEmailVerified" => "","KmToCover" => 30000,"MonthlyTotalCost" => 213.39257142,"MonthlyTotalCostVAT" => 243.26753142,"OfferDescription" => "360PLUS Service Plan Booster","OfferId" => 8,"PaymentTerm" => 24,"PlanValue" => 5838.42075400,"PolicyNumber" => "MOTO00000011","Status" => "Pending","SumOfMonthlyPremium" => 5838.42075400,"TotalCost" => 5121.42171428,"TotalCostVAT" => 5838.42075428),"2" => array("AmountOfMonthsToCover" => 24,"AmountOfYearsToCover" => 2,"BankAccountDetails" => array("BankAccountHolder" => "Mr Dawie Harmse","BankAccountNumber" => 4066507082,"BankAccountType" => 1,"BankAccountTypeDesc" => "Current","BankDetails" => 491,"BankDetailsDesc" => "632005,ABSA,ABSA ELECTRONIC SETTLEMENT CNT","DebitOrderDay" => 1,"EFTDetailed" => "Account type: Corporate Cheque AccountAccount name: Motorhappy (Pty), LtdAccount no.: 62523137033Branch name and no.: RMB Corporate Banking Johannesburg 255005","PaymentMethod" => "DebitOrder"),"Brand" => "360PLUS (NON AMH)","CurrentKm" => 77867,"CustomerDocumentationList" => array("CustomerDocumentationModel" => array("0" => array("Description" => "Service and Maintenance Welcome Letter","DocumentationID" => 27),"1" => array("Description" => "360PLUS Service and Maintenance Plan Booklet","DocumentationID" => 28))),"CustomerOfferId" => 1004,"CustomerProductList" => array("CustomerProductModel" => array("0" => array("CustomerProductID" => 31,"Description" => "360PLUS Roadside Assistance","ProductID" => 160),"1" => array("CustomerProductID" => 30,"Description" => "360PLUS Service Plan","ProductID" => 127),"2" => array("CustomerProductID" => 29,"Description" => "360PLUS Unlimited Maintenance Plan","ProductID" => 130))),"CustomerVehicleId" => 11,"DeliveryAddress" => array("AddressLine1" => "4 Welgemoed Golf Estate","AddressLine2" => "Nederburgh Street","AddressLine3" => "","PostCode" => 43891,"PostCodeDesc" => "7530,Street,WELGEMOED,BELLVILLE"),"DocumentDelivery" => "None","DocumentDeliveryEmail" => "dawie@mavenagency.co.za","DocumentDeliveryEmailVerified" => "","KmToCover" => 30000,"MonthlyTotalCost" => 296.66994047,"MonthlyTotalCostVAT" => 338.20373214,"OfferDescription" => "360PLUS Unlimited Maintenance Plan","OfferId" => 10,"PaymentTerm" => 24,"PlanValue" => 8116.88957100,"PolicyNumber" => "MOTO00001004","Status" => "Pending","SumOfMonthlyPremium" => 8116.88957100,"TotalCost" => 7120.07857142,"TotalCostVAT" => 8116.88957142))),"CustomerVehicleID" => 11,"DateOfFirstRegistration" => "2014-01-01T00:00:00","EngineNo" => "","MMCode" => "64027655","Make" => 140,"MakeDesc" => "VOLKSWAGEN","Model" => 3686,"ModelDesc" => "POLO","PermissionToSearch" => "","PreviousOwned" => 1,"RegistrationNo" => "CA123","Series" => 15880,"SeriesDesc" => "1.2 TDI BLUEMOTION","ServiceHistory" => 1,"VINNo" => "","Vehicle" => 12384,"VehicleDesc" => "VOLKSWAGEN POLO 1.2 TDI BLUEMOTION","Warranty" => "Yes","Year" => 2014))),"DealerDescription" => "MotorHappy","DealerId" => 1,"DocumentDelivery" => "None","DocumentDeliveryEmail" => "dawie@mavenagency.co.za","DocumentDeliveryEmailVerified" => "","Email" => "dawie@mavenagency.co.za","EmailVerified" => 1,"FaxNo" => "","FirstName" => "Dawie","IdentificationNo" => 8301045067083,"Marekting" => array("CellphoneNo" => 0825672884,"ContactNo" => "","EmailAddress" => "dawie@mavenagency.co.za","EmailVerified" => 1,"FaxNo" => "","FirstName" => "Dawie","MarketingMethod" => 1,"MarketingMethodDesc" => "By Email","PermissionToMarket" => 1,"PostalAddress" => array("AddressLine1" => "","AddressLine2" => "","AddressLine3" => "","PostCode" => 0,"PostCodeDesc" =>""),"Surname" => "Harmse","Title" => 0,"TitleDesc" => ""),"NotificationVia" => "None","NotificationViaContactNo" => 0825672884,"NotificationViaEmail" => "dawie@mavenagency.co.za","NotificationViaEmailVerified" => 1,"OtherContactNo" => "","PassportNo" => "","PhysicalAddress" => array("AddressLine1" => "4 Welgemoed Golf Estate","AddressLine2" => "Nederburgh Street","AddressLine3" => "","PostCode" => 43891,"PostCodeDesc" => "7530,Street,WELGEMOED,BELLVILLE"),"PostalAddress" => array("AddressLine1" => "", "AddressLine2" => "", "AddressLine3" => "", "PostCode" => 0,"PostCodeDesc" => ""),"SurName" => "Harmse","Title" => 0,"TitleDesc" =>"" ));
			//$json = json_encode($arr);
			//$customerVehicleRes 		= json_decode(json_encode($response), true);
			$CustomerVehicleListRes 	= $customerVehicleRes['CustomerGetResult']['CustomerVehicleList'];
			
			//echo "<pre/>";print_r($CustomerVehicleListRes);exit;
			
			$i = 0;
			if (isset($CustomerVehicleListRes) && !empty($CustomerVehicleListRes)) 
			{
				$CustomerVehicleModelRes = $CustomerVehicleListRes['CustomerVehicleModel'];
				if (!isset($CustomerVehicleModelRes[0]))
				{
					$CustomerVehicleModelRes = array($CustomerVehicleListRes['CustomerVehicleModel']);
				}
	
				//echo "<pre>";print_r($CustomerVehicleModelRes);echo "</pre>";exit;
	
				foreach ($CustomerVehicleModelRes as $key => $val)
				{
	
					if (isset($val['CustomerOfferList']) && !empty($val['CustomerOfferList']))
					{
						$CustomerOfferLists = $val['CustomerOfferList']['CustomerOfferModel'];
						if (!isset($CustomerOfferLists[0]))
						{
							$CustomerOfferLists = array($val['CustomerOfferList']['CustomerOfferModel']);
						}
	
						$j = 0;
						foreach ($CustomerOfferLists as $CustomerOfferList)
						{
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['CustomerOfferId'] = $CustomerOfferList['CustomerOfferId'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['OfferDescription'] = $CustomerOfferList['OfferDescription'];
							//plan details
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['AmountOfMonthsToCover'] = $CustomerOfferList['AmountOfMonthsToCover'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['AmountOfYearsToCover'] = $CustomerOfferList['AmountOfYearsToCover'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['MonthlyTotalCostVAT'] = $CustomerOfferList['MonthlyTotalCostVAT'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['TotalCostVAT'] = $CustomerOfferList['TotalCostVAT'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['KmToCover'] = $CustomerOfferList['KmToCover'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['Status'] = $CustomerOfferList['Status'];
							//payment details
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['BankAccountDetails']['BankAccountHolder'] = $CustomerOfferList['BankAccountDetails']['BankAccountHolder'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['BankAccountDetails']['BankAccountNumber'] = $CustomerOfferList['BankAccountDetails']['BankAccountNumber'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['BankAccountDetails']['BankAccountType'] = $CustomerOfferList['BankAccountDetails']['BankAccountType'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['BankAccountDetails']['BankAccountTypeDesc'] = $CustomerOfferList['BankAccountDetails']['BankAccountTypeDesc'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['BankAccountDetails']['BankDetails'] = $CustomerOfferList['BankAccountDetails']['BankDetails'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['BankAccountDetails']['BankDetailsDesc'] = $CustomerOfferList['BankAccountDetails']['BankDetailsDesc'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['BankAccountDetails']['DebitOrderDay'] = $CustomerOfferList['BankAccountDetails']['DebitOrderDay'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['BankAccountDetails']['EFTDetailed'] = $CustomerOfferList['BankAccountDetails']['EFTDetailed'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['BankAccountDetails']['PaymentMethod'] = $CustomerOfferList['BankAccountDetails']['PaymentMethod'];
							//Delivery details
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['DeliveryAddress']['AddressLine1'] = $CustomerOfferList['DeliveryAddress']['AddressLine1'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['DeliveryAddress']['AddressLine2'] = $CustomerOfferList['DeliveryAddress']['AddressLine2'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['DeliveryAddress']['AddressLine3'] = $CustomerOfferList['DeliveryAddress']['AddressLine3'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['DeliveryAddress']['PostCode'] = $CustomerOfferList['DeliveryAddress']['PostCode'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['DeliveryAddress']['DocumentDelivery'] = $CustomerOfferList['DocumentDelivery'];
							$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['DeliveryAddress']['DocumentDeliveryEmail'] = $CustomerOfferList['DocumentDeliveryEmail'];
							//Products details
							if (isset($CustomerOfferList['CustomerProductList']) && !empty($CustomerOfferList['CustomerProductList']))
							{
								$CustomerProductLists = $CustomerOfferList['CustomerProductList']['CustomerProductModel'];
								if (!isset($CustomerProductLists[0]))
								{
									$CustomerProductLists = array($CustomerOfferList['CustomerProductList']['CustomerProductModel']);
								}
	
								$p = 0;
								foreach ($CustomerProductLists as $CustomerProductList)
								{
									$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['CustomerProductLists'][$p]['CustomerProductID'] = $CustomerProductList['CustomerProductID'];
									$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['CustomerProductLists'][$p]['Description'] = $CustomerProductList['Description'];
									$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['CustomerProductLists'][$p]['ProductID'] = $CustomerProductList['ProductID'];
									$p++;
								}
							}
							//Documents details
							if (isset($CustomerOfferList['CustomerDocumentationList']) && !empty($CustomerOfferList['CustomerDocumentationList']))
							{
								$CustomerDocumentationLists = $CustomerOfferList['CustomerDocumentationList']['CustomerDocumentationModel'];
								if (!isset($CustomerDocumentationLists[0]))
								{
									$CustomerDocumentationLists = array($CustomerOfferList['CustomerDocumentationList']['CustomerDocumentationModel']);
								}
	
								$d = 0;
								foreach ($CustomerDocumentationLists as $CustomerDocumentationList)
								{
									$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['CustomerDocumentationLists'][$d]['Description'] = $CustomerDocumentationList['Description'];
									$CustomerVehicleArr[$i]['CustomerOfferLists']['CustomerOffers'][$j]['CustomerDocumentationLists'][$d]['DocumentationID'] = $CustomerDocumentationList['DocumentationID'];
									$d++;
								}
							}
							$j++;
						}
	
					}
	
					$CustomerVehicleArr[$i]['CustomerOfferLists']['RegistrationNo'] = $val['RegistrationNo'];
					$CustomerVehicleArr[$i]['CustomerOfferLists']['Year'] = $val['Year'];
					$CustomerVehicleArr[$i]['CustomerOfferLists']['Make'] = $val['Make'];
					$CustomerVehicleArr[$i]['CustomerOfferLists']['MakeDesc'] = $val['MakeDesc'];
					$CustomerVehicleArr[$i]['CustomerOfferLists']['Model'] = $val['Model'];
					$CustomerVehicleArr[$i]['CustomerOfferLists']['ModelDesc'] = $val['ModelDesc'];
					$CustomerVehicleArr[$i]['CustomerOfferLists']['Series'] = $val['Series'];
					$CustomerVehicleArr[$i]['CustomerOfferLists']['SeriesDesc'] = $val['SeriesDesc'];
	
					$i ++;
				}
			}
			//echo "<pre/>";print_r($CustomerVehicleArr);exit;
			$tpl->assign(array(
							"T_BODY"			=>	'my_account'.$config['tplEx'],
							"page_name"			=>  'My Account',
							'data'				=>   $CustomerVehicleArr,
							)
						);
		}
		catch(Exception $e){
			echo $e;
			$this->log->logIt($this->module."-"."load".Insurance.$e);
		}
	}


}				
?>
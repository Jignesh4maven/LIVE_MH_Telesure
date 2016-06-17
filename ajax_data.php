<?php
if( isset($_REQUEST['opcode']) &&  $_REQUEST['opcode'] == "get_address"){
    
    if( isset($_REQUEST['q']) &&  $_REQUEST['q'] != "" && isset($_REQUEST['w']) &&  $_REQUEST['w'] != ""){
        
        $search_term  = $_REQUEST['q'];
        
        $search_style = $_REQUEST['w'];
        
        if($search_style == "suburb"){
             $url = '/pinkelephant/PostCodeDataService.svc/PostCodeData?$filter=substringof(%27Street%27,PostCodeStyle)%20and%20substringof(%27' . strtoupper($search_term) .'%27,Suburb)&$skip=0&$format=json';	
        }
        else{
             $url = '/pinkelephant/PostCodeDataService.svc/PostCodeData?$filter=substringof(%27Postal%27,PostCodeStyle)%20and%20substringof(%27' . strtoupper($search_term) .'%27,Code)&$skip=0&$format=json';
        }
        
        $url = urlencode($url);
        
		try{
        $cont = exec("php /srv/www/htdocs/staging.motorhappy.co.za/telesure/test_call.php $url");
		}
		catch(Exeption $e){
			echo $e;
			
		}
     
        $address_data = json_decode($cont);
			
        $final_refined_array = array();
        
        if($search_style == "suburb"){
            for($i=0; $i < count($address_data->value); $i++){

				if( $address_data->value[$i]->City != "-"){
					$tmp_array = array();
					$tmp_array["Name"] = $address_data->value[$i]->ID.",".$address_data->value[$i]->Name;
					$tmp_array["label"] = $address_data->value[$i]->Suburb;
					$tmp_array["Suburb"] = $address_data->value[$i]->Suburb;
					$tmp_array["ID"] = $address_data->value[$i]->ID;
					$tmp_array["City"] = $address_data->value[$i]->City;
					$tmp_array["Code"] = $address_data->value[$i]->Code;
					
					$final_refined_array[] = $tmp_array;
				}
            }
        }
        else if($search_style == "postal_code"){
            for($i=0; $i < count($address_data->value); $i++){
				if( $address_data->value[$i]->City != "-"){
					$tmp_array = array();
					$tmp_array["label"] = $address_data->value[$i]->Code;
					$tmp_array["Name"] = $address_data->value[$i]->ID.",".$address_data->value[$i]->Name;
					$tmp_array["Suburb"] = $address_data->value[$i]->Suburb;
					$tmp_array["ID"] = $address_data->value[$i]->ID;
					$tmp_array["City"] = $address_data->value[$i]->City;
					$tmp_array["Code"] = $address_data->value[$i]->Code;
					
					$final_refined_array[] = $tmp_array;
				}
            }
        }
        $response_array['resultStatus'] = "Success";
        $response_array['resultData'] 	= $final_refined_array;
        
        print_r( json_encode($response_array) );
			
		exit(0);
    }
    
}
elseif(isset($_REQUEST['opcode']) &&  $_REQUEST['opcode'] == "vehicle_data"){
	if( isset($_REQUEST['ty']) && isset($_REQUEST['yr'])){
		
		if( $_REQUEST['ty'] == "make" &&  $_REQUEST['ty'] != "" ){
			$year = $_REQUEST['yr'];
			$url = '/ProductCatelog/VehicleDataService.svc/GetVehicleMake?vehicleYear='.$year.'&$orderby=Name&$format=json';
		}
		elseif( $_REQUEST['ty'] == "model" && isset($_REQUEST['yr']) && isset($_REQUEST['mk'])  ){
			
			if( $_REQUEST['yr'] != "" && $_REQUEST['mk'] != ""){
				$year = $_REQUEST['yr'];
				$make = $_REQUEST['mk'];
				$url='/ProductCatelog/VehicleDataService.svc/GetVehicleModel?vehicleYear='.$year.'&vehicleMake='.$make.'&$orderby=Name&$format=json';
			}
			
			#echo "model";
		}
		elseif( $_REQUEST['ty'] == "series" && isset($_REQUEST['yr']) && isset($_REQUEST['mk']) && isset($_REQUEST['mo']) ){
			if( $_REQUEST['yr'] != "" && $_REQUEST['mk'] != "" &&  $_REQUEST['mo'] != ""){
				$year = $_REQUEST['yr'];
				$make = $_REQUEST['mk'];
				$model = $_REQUEST['mo'];
				$url = '/ProductCatelog/VehicleDataService.svc/GetVehicleSeries?vehicleYear='.$year.'&vehicleMake='.$make.'&vehicleModel='.$model.'&$orderby=Name&$format=json';
			}
		}
		elseif( $_REQUEST['ty'] == "mileage" && isset($_REQUEST['yr']) && isset($_REQUEST['sr']) ){
			if( $_REQUEST['yr'] != "" && $_REQUEST['sr'] != "" ){
				$year = $_REQUEST['yr'];
				$series = $_REQUEST['sr'];
				$url = '/ProductCatelog/ProductDataService.svc/GetProductMileage?vehicleYear='.$year.'&currentKm=0&vehicleSeries='.$series.'&planType=-1&$orderby=Mileage&$format=json';
			}
		}
		if( $url != "" ){
			
			$response_array = array();
			
			$url = urlencode($url);
			
			$result_json_data = exec("php /srv/www/htdocs/staging.motorhappy.co.za/telesure/test_call.php $url");
	
			$response_json_data = '{"resultStatus":"Success","resultData":'.$result_json_data.',"url":"'.$url.'"}';
			
			echo $response_json_data;
			
			exit(0);
			#$address_data = json_decode($json_data);
	
			#$res_json_str = $this->data_curl->json_request($url,'');
			#$response_array['resultStatus'] 	= resultConstant::Success;
			#echo $res_json_str;
			
		}
		
			
	}
}
#exit(0); 
 //$search_term = "CAP";
//$url = '/pinkelephant/PostCodeDataService.svc/PostCodeData?$filter=substringof(%27Street%27,PostCodeStyle)%20and%20substringof(%27' . strtoupper($search_term) .'%27,Suburb)&$skip=0&$format=json';
//$url = urlencode($url);
//$cont = system("php /var/www/vhosts/maven.me/motorhappy.maven.me/test_call.php $url");
//echo $cont;

?>

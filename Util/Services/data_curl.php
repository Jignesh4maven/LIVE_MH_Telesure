<?php
require_once(BASE_PATH."/Conf/service_conf.php");
require_once(BASE_PATH."/Util/logger.php");
require_once(BASE_PATH."/Dbaccess/servicedao.php");

class data_curl{

    function data_curl(){
        global $WEBSERVICE_USERNAME, $WEBSERVICE_PASSWORD;
        $this->log = new logger();
        $this->servicedao=new servicedao();

    }

    function json_request($url, $data){

        $url = str_replace( "&amp;", "&", trim($url) );
        $cookie = tempnam ("/tmp", "CURLCOOKIE");
        $timeout = 100;
        global $SERVICE_URl,$WEBSERVICE_USERNAME, $WEBSERVICE_PASSWORD;

        $full_url = $SERVICE_URl.$url;

        $this->log->logIt("json_request:".$data.":".$full_url.":".$WEBSERVICE_USERNAME.":".$WEBSERVICE_PASSWORD);
         
        $ch = curl_init();
        curl_setopt_array( $ch, array(
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
            CURLOPT_VERBOSE => FALSE,               // Verbose mode for diagnostics
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" ,
            CURLOPT_URL => $full_url ,
            //CURLOPT_COOKIEJAR => $cookie ,
            CURLOPT_FOLLOWLOCATION => TRUE ,
            CURLOPT_ENCODING => "" ,
            CURLOPT_RETURNTRANSFER => TRUE ,
            CURLOPT_AUTOREFERER => TRUE ,
            CURLOPT_SSL_VERIFYPEER => FALSE ,    # required for https urls
            CURLOPT_CONNECTTIMEOUT => 0 ,
            CURLOPT_TIMEOUT => 10000 ,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_HTTPAUTH => CURLAUTH_ANY,
            CURLOPT_USERPWD => $WEBSERVICE_USERNAME . ':' . $WEBSERVICE_PASSWORD,
            CURLOPT_SSL_VERIFYHOST => FALSE
        ));

        $results = curl_exec( $ch );
        
        $this->log->logIt("Result:".$results);

        curl_close ( $ch );
        return $results;

    }
    
    function image_request($url, $data){

        $url = str_replace( "&amp;", "&", trim($url) );
        $cookie = tempnam ("/tmp", "CURLCOOKIE");
        $timeout = 100;
        global $SERVICE_URl,$WEBSERVICE_USERNAME, $WEBSERVICE_PASSWORD;

        $full_url = $SERVICE_URl.$url;

        $this->log->logIt("json_request:".$data.":".$full_url.":".$WEBSERVICE_USERNAME.":".$WEBSERVICE_PASSWORD);
         
        $ch = curl_init();
        curl_setopt_array( $ch, array(
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
            CURLOPT_VERBOSE => FALSE,               // Verbose mode for diagnostics
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" ,
            CURLOPT_URL => $full_url ,
            //CURLOPT_COOKIEJAR => $cookie ,
            CURLOPT_FOLLOWLOCATION => TRUE ,
            CURLOPT_HEADER=> 0,
            //CURLOPT_ENCODING => "" ,
            CURLOPT_RETURNTRANSFER => TRUE ,
            CURLOPT_BINARYTRANSFER => 1,
            CURLOPT_AUTOREFERER => TRUE ,
            CURLOPT_SSL_VERIFYPEER => FALSE ,    # required for https urls
            CURLOPT_CONNECTTIMEOUT => 0 ,
            CURLOPT_TIMEOUT => 10000 ,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_HTTPAUTH => CURLAUTH_ANY,
            CURLOPT_USERPWD => $WEBSERVICE_USERNAME . ':' . $WEBSERVICE_PASSWORD,
            CURLOPT_SSL_VERIFYHOST => FALSE
        ));

        $results = curl_exec( $ch );
 

        curl_close ( $ch );
        return $results;

    }

    #$url = api data url
    #$action = unique action to get/set resonse from session.
    #$type = json data type return.
    function make_request($url,$action,$type='json'){
        
        $result = "";
        
        $this->log->logIt("make_request:".$action.":".$url);
        
        if( isset($_SESSION[$action]) ){

            if($type == "image"){
                 $result =  $_SESSION[$action];
            }
            else{
                if( json_decode ($_SESSION[$action]) ){
    
                    //$this->log->logIt("make_request[SESSION]:".$action.":".$url);
                    
                    $result =  $_SESSION[$action];
                }
            }    
        }
        else{
            
            if($type == "image"){
                $result = $this->image_request($url,$action);
                 $_SESSION[$action] = $result;
            }
            else{

                $result = $this->json_request($url,$action);
                
                //$this->log->logIt("make_request[ISCRIPT]:".$action.":".$url);
                
                $_SESSION[$action] = $result;
            }    
        }

        return $result;

    }
   
   
    public function get_data_service_json($action){
        try{
            
            $this->log->logIt("get_data_service_json:".$action);

            $json_str = '';
            
            if( $action == "TelesureAreaTypeItems" ){
                
                $url = '/PinkElephant/QuoteDataService.svc/GetTelesureAreaTypeItems?$format=json';
                
                $json_str = $this->make_request($url,'TelesureAreaTypeItems');
            }
            elseif( $action == "VehicleYearData" ){
                
                $url = '/productcatelog/VehicleDataService.svc/VehicleYearData?$format=json';
                
                $json_str = $this->make_request($url,'VehicleYearData');
            }
            elseif( $action == "VehicleMakeData" ){
                
                $url = '/productcatelog/VehicleDataService.svc/VehicleMakeData?$format=json';
                
                $json_str = $this->make_request($url,'VehicleMakeData');
            }
            elseif( $action == "VehicleUseItems" ){
                
                $url = '/PinkElephant/QuoteDataService.svc/GetTelesureVehicleUseItems?$format=json';
                
                $json_str = $this->make_request($url,'VehicleUseItems');
            }
            elseif( $action == "VehiclePaintTypes" ){
                
                $url = '/PinkElephant/QuoteDataService.svc/GetTelesureVehiclePaintTypes?$format=json';
                
                $json_str = $this->make_request($url,'VehiclePaintTypes');
            }
            elseif( $action == "VehicleModelData" ){
                
                $url = '/productcatelog/VehicleDataService.svc/VehicleModelData?$format=json';
                
                $json_str = $this->make_request($url,'VehicleModelData');
            }
            elseif( $action == "VehicleSeriesData" ){
                
                $url = '/productcatelog/VehicleDataService.svc/VehicleSeriesData?$format=json';
                
                $json_str = $this->make_request($url,'VehicleSeriesData');
            }
            elseif( $action == "MaritalStatusItems" ){
                
                $url = '/PinkElephant/QuoteDataService.svc/GetTelesureMaritalStatusItems?$format=json';
                
                $json_str = $this->make_request($url,'MaritalStatusItems');
            }
            elseif( $action == "EmploymentStatusItems" ){
                
                $url = '/PinkElephant/QuoteDataService.svc/GetTelesureEmploymentStatusItems?$format=json';
                
                $json_str = $this->make_request($url,'EmploymentStatusItems');
            }
            elseif( $action == "DriverLicenceType" ){
                $url = '/PinkElephant/QuoteDataService.svc/GetTelesureDriverLicenceType?$format=json';
                
                $json_str = $this->make_request($url,'DriverLicenceType');
            }
            elseif( $action == "VehicleColours" ){
                
                $url = '/PinkElephant/QuoteDataService.svc/GetTelesureVehicleColours?$format=json';
                
                $json_str = $this->make_request($url,'VehicleColours');
            }
            elseif( $action == "AccessControlTypeItems" ){
                
                $url = '/PinkElephant/QuoteDataService.svc/GetTelesureAccessControlTypeItems?$format=json';
                
                $json_str = $this->make_request($url,'AccessControlTypeItems');
            }
            elseif( $action == "AddressType" ){
                
                $url = '/PinkElephant/PostCodeDataService.svc/AddressTypeData?$format=json';
                
                $json_str = $this->make_request($url,'AddressType');
            }
            elseif( $action == "MotorInsuredItems" ){
                
                $url = '/PinkElephant/QuoteDataService.svc/GetTelesureMotorInsuredItems?$format=json';
                
                $json_str = $this->make_request($url,'MotorInsuredItems');
            }
            elseif( $action == "MotorTrackerOptions" ){
                
                $url = '/PinkElephant/QuoteDataService.svc/GetTelesureMotorTrackerOptions?$format=json';
                
                $json_str = $this->make_request($url,'MotorTrackerOptions');
            }
            elseif( $action == "OvernightParkingFacility" ){
                
                $url = '/PinkElephant/QuoteDataService.svc/GetTelesureOvernightParkingFacility?$format=json';
                
                $json_str = $this->make_request($url,'OvernightParkingFacility');
            }
            elseif( $action == "MotorNCBItems" ){
                
                $url = '/PinkElephant/QuoteDataService.svc/GetTelesureMotorNCBItems?$format=json';
                
                $json_str = $this->make_request($url,'MotorNCBItems');
            }
            elseif( $action == "TitleData" ){
                
                $url = '/PinkElephant/CommonDataService.svc/TitleData?$format=json';
                
                $json_str = $this->make_request($url,'TitleData');
            }
            
            if( $json_str == ''){
                return '{}';
            }
            else{
                return $json_str;
            }
        }
        catch (Exception $e) {
                echo $e;
                $this->log->logIt("Services->data_curl:" . $e);
        }
        
    }
    
}  
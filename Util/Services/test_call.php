<?php
$search_term = "CAP";
$url = '/pinkelephant/PostCodeDataService.svc/PostCodeData?$filter=substringof(%27Street%27,PostCodeStyle)%20and%20substringof(%27' . strtoupper($search_term) .'%27,Suburb)&$skip=0&$format=json';	
$url = str_replace( "&amp;", "&", trim($url) );


  $cookie = tempnam ("/tmp", "CURLCOOKIE");
  $timeout = 100;
  $SERVICE_URl = 'https://41.160.117.197';
  $WEBSERVICE_USERNAME= "MotorHappy";
  $WEBSERVICE_PASSWORD = "MotorHappy";

  $full_url = $SERVICE_URl.$url;


echo  $full_url."\n";


$ch = curl_init();
        curl_setopt_array( $ch, array(
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
            CURLOPT_VERBOSE => FALSE,               // Verbose mode for diagnostics
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" ,
            CURLOPT_URL => $full_url ,
           // CURLOPT_COOKIEJAR => $cookie ,
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

print_r($results);

?>

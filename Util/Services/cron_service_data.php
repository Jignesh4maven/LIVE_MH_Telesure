<?php
echo "\ncron_service_data\n";
$base_path = "/var/www/vhosts/maven.me/motorhappy.maven.me";
require_once($base_path."/Conf/service_conf.php");
require_once($base_path."/Dbaccess/dao.php");
require_once($base_path."/Dbaccess/dbtable.php");
require_once($base_path."/Util/logger.php");

$dns = "mysql:host=".$mysqlhost.";dbname=".$db_name;
$connection=new PDO($dns,$mysqluser,$mysqlpwd);
 
@$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$connection->setAttribute(PDO::ATTR_TIMEOUT,30);
$connection->exec("SET NAMES utf8");

$dao=new dao();

$str_sql = "SELECT * From ".dbtable::TblDataService;
$dao->initCommand($str_sql);
$result = $dao->executeQuery();

for( $i = 0 ; $i<count($result); $i++){

    $dao=new dao();    
    $url = $SERVICE_URl.$result[$i]['str_url'];
    $response = json_request($url, array());
	echo "response-".$result[$i]['str_action']."\n";
	
	if($result[$i]['str_action'] == "VehicleSeriesData"){
		
		echo $response;
	}
	
    $update_sql = "UPDATE ".dbtable::TblDataService." set `str_data` =:response WHERE `str_action` =:action ";
			
    $dao->initCommand($update_sql);
    $dao->addParameter(":response",$response);
    $dao->addParameter(":action",$result[$i]['str_action']);

    $dao->executeNonQuery();
}


function json_request($url, $data){

        $url = str_replace( "&amp;", "&", trim($url) );

        $cookie = tempnam ("/tmp", "CURLCOOKIE");
        $timeout = 10;
        global $SERVICE_URl,$WEBSERVICE_USERNAME, $WEBSERVICE_PASSWORD;

        //$full_url = $SERVICE_URl.$url;

        $ch = curl_init();
        curl_setopt_array( $ch, array(
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
            CURLOPT_VERBOSE => FALSE,               // Verbose mode for diagnostics
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" ,
            CURLOPT_URL => $url ,
            CURLOPT_COOKIEJAR => $cookie ,
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
            CURLOPT_SSL_VERIFYHOST => 0
        ));

        $results = curl_exec( $ch ) or die(curl_error($ch));

        curl_close ( $ch );
        return $results;

    }
?>
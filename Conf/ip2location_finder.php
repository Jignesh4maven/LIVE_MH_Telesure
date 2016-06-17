<?php
function ip2location_finder($ip)
{
	$ip = ($ip != '')?$ip:$_SERVER['REMOTE_ADDR']; 

	$ip2location_url='http://api.ipinfodb.com/v3/ip-city/?key=9ef7677fafc67fe34da6161b79e09a8f2b94b64b405b89fbe7a80fef7997d352&ip='.$_SERVER['REMOTE_ADDR'];
	
	// Configuration of the CURL library usage
	$ip2location_ch = curl_init($ip2location_url);
	
	curl_setopt($ip2location_ch, CURLOPT_RETURNTRANSFER, true); // Return the response into a variable
	curl_setopt($ip2location_ch, CURLOPT_TIMEOUT, 5); // Timeout in seconds
	
	$ip2location_response = curl_exec($ip2location_ch);
	$ip2location_curlinfo = curl_getinfo($ip2location_ch);
	
	$ip2location_data = array();
	
	// When there's a timeout
	
		if($ip2location_curlinfo['http_code'] != '200')
		{
			 $ip2location_data['RESPONSE'] = 'TIMEOUT';
			// echo 'TIMEOUT';
		}
		else
		{
			if($ip2location_response != '')
			{
				$ip2location_response_chunks = explode(';', $ip2location_response);
				$name=array('RESPONSE','None','IP','CountryCode','countryname','State','city','x','Latitude','Longitude','TimeZone');
		
				if(is_array($ip2location_response_chunks) && !empty($ip2location_response_chunks))
				{
					$cnt=count($ip2location_response_chunks);
					for($i=0;$i<$cnt;$i++)
					{
						if (($i != '1') && ( $i != '7'))
						{
							$ip2location_data["$name[$i]"]=$ip2location_response_chunks[$i]; 
							
						}
					}	
				}
			}
		}

	return $ip2location_data;	
	curl_close($ip2location_ch);
}
?>
 <?
 
 function umlautepas($string){
  $upas = Array("ä" => "ae", "ü" => "ue", "ö" => "oe", "Ä" => "Ae", "Ü" => "Ue", "Ö" => "Oe"); 
  return strtr($string, $upas);
  }
  
  
$datei = file("blacklist.data");

foreach($datei AS $ausgabe)
   {
   $zerlegen = explode("|", $ausgabe);
	
	if($zerlegen[1] == strtolower(umlautepas($_POST[subname])))
	{
	
	
	header('Location: index.php?p=error');
	exit;
	}
}
 
		?>


		
		
		
<?php
error_reporting(0);

include("config.php");

// Create a A-record for DNS

$ch = curl_init("https://www.cloudflare.com/api_json.html");
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);

// handling of -d curl parameter is here.
$param = array(
    'a' => 'rec_new',
    'tkn' => ''.$apikey.'',
    'email' => ''.$email.'',
    'z' => ''.$domain.'',
	'type' => 'A',
	'name' => ''.strtolower(umlautepas($_POST[subname])).'',
	'content' => ''.$_POST[ip].'',
	'ttl' => '120'
);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));

$result = curl_exec($ch);
curl_close($ch);



// Create a SRV for Teamspeak 3

$ch2 = curl_init("https://www.cloudflare.com/api_json.html");
curl_setopt($ch2, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER,false);

// handling of -d curl parameter is here.
$param2 = array(
    'a' => 'rec_new',
    'tkn' => ''.$apikey.'',
    'email' => ''.$email.'',
    'z' => ''.$domain.'',
	'type' => 'SRV',
	'name' => ''.$domain.'',
	'ttl' => '120',
	'prio' => '0',
	'service' => '_ts3',
	'srvname' => ''.strtolower(umlautepas($_POST[subname])).'',
	'protocol' => '_udp',
	'weight' => '5',
	'port' => ''.$_POST[port].'',
	'target' => ''.strtolower(umlautepas($_POST[subname])).'.'.$domain.''
);
curl_setopt($ch2, CURLOPT_POST, 1);
curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query($param2));

$result2 = curl_exec($ch2);
curl_close($ch2);


// rec_id 


load_recs();

function load_recs() {

	global $apikey;
	global $email;
	global $domain;
	
    $url = "https://www.cloudflare.com/api_json.html";
    $data = array(
    "a" => "rec_load_all",
    "tkn" => "".$apikey."",
    "email" => "".$email."",
    "z" => "".$domain.""
    );
    $ch3 = curl_init();
    curl_setopt($ch3, CURLOPT_VERBOSE, 1);
    curl_setopt($ch3, CURLOPT_FORBID_REUSE, true); 
    curl_setopt($ch3, CURLOPT_URL, $url);
    curl_setopt($ch3, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch3, CURLOPT_POST, 1);
    curl_setopt($ch3, CURLOPT_POSTFIELDS, $data ); 
    curl_setopt($ch3, CURLOPT_TIMEOUT, 10);
    $test = curl_getinfo($ch3);
    $http_result = curl_exec($ch3);
    $error = curl_error($ch3);
    $http_code = curl_getinfo($ch3 ,CURLINFO_HTTP_CODE);	
    curl_close($ch3);
    $cloud_arr = json_decode($http_result,true); 
	
	
	
    if ($http_code != 200) {
        print "Error: $error\n";
    } else {
	foreach($cloud_arr[ "response" ][ "recs" ][ "objs" ] as $item) {
	
	if($item[ "type" ] == 'A' && $item[ "display_name" ] == strtolower(umlautepas($_POST[subname])))
	{
				if ( $entry[ "content" ] != $_POST[ip] )
                    {
                       // service_mode=1

					$ch4 = curl_init("https://www.cloudflare.com/api_json.html");
					curl_setopt($ch4, CURLOPT_RETURNTRANSFER,1);
					curl_setopt($ch4, CURLOPT_FOLLOWLOCATION, 1);
					curl_setopt($ch4, CURLOPT_SSL_VERIFYPEER,false);

					// handling of -d curl parameter is here.
					$param4 = array(
						'a' => 'rec_edit',
						'tkn' => ''.$apikey.'',
						'id' => ''.$item[ "rec_id" ].'',
						'email' => ''.$email.'',
						'z' => ''.$domain.'',
						'type' => 'A',
						'name' => ''.strtolower(umlautepas($_POST[subname])).'',
						'content' => ''.$_POST[ip].'',
						'service_mode' => '1',
						'ttl' => '1'
					);
					curl_setopt($ch4, CURLOPT_POST, 1);
					curl_setopt($ch4, CURLOPT_POSTFIELDS, http_build_query($param4));

					$result4 = curl_exec($ch4);
					curl_close($ch4);
                    }
	}
	
        

 
		}
    }
}



		
				$daten = "|".strtolower(umlautepas($_POST[subname]))."|".$domain."|".$_POST[port]."";

				$datenbank = "blacklist.data";

				$datei = fopen($datenbank,"a");

				fwrite($datei, $daten."\r\n");
						

		




 ?>
 		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/css/bootstrap.css" />
 		<div class="jumbotron" style="border-radius: 0px; position:relative; top:-14px; border: 0px;">
			
	
			<center><div class="alert alert-success" role="alert">Your Teamspeak 3 DNS is <? echo strtolower(umlautepas($_POST[subname])).'.'.$domain.''; ?> </div></center>
				
				
		</div>
		
		
		<script type="application/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="application/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script type="application/javascript" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.js"></script>
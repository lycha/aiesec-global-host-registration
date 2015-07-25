<?php

$imie_i_nazwisko = $_POST["first_name"]." ".$_POST["last_name"];
$adres_email = $_POST["email"];
$telefon_kontaktowy = $_POST["phone_number"];
$mieszkam = $_POST["mieszkam"];
$wybor_miasta = $_POST["localcommittee"];

 //echo " ".$imie_i_nazwisko." ".$adres_email." ".$telefon_kontaktowy." ".$mieszkam;
require_once 'podio-php-master/PodioAPI.php';
require_once 'podio_keys.php';

$keys  = new PodioKeys();
$miasto = (object)$keys->getLCKeys($wybor_miasta);		

$url = 'https://podio.com/oauth/token';
$data = array('grant_type' => 'app', 'app_id' => $miasto->my_app_id, 'app_token' => $miasto->my_app_token, 
'client_id' => $miasto->client_id, 'redirect_uri' => 'http://aiesec.pl', 'client_secret' => $miasto->client_secret);

// use key 'http' even if you send the request to https://...
$options = array(
	'http' => array(
		'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		'method'  => 'POST',
		'content' => http_build_query($data),
		),
	);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

//var_dump($result);

Podio::setup($miasto->client_id, $miasto->client_secret);

try {
  
  $output = Podio::authenticate('app', array('app_id' => $miasto->my_app_id, 'app_token' => $miasto->my_app_token));
  PodioItem::create($miasto->my_app_id, array('fields' => array(
	  "imie-i-nazwisko" => $imie_i_nazwisko,
	  "adres-email" => $adres_email,
	  "telefon-kontaktowy" => $telefon_kontaktowy,
	  "mieszkam" => $mieszkam,
	  
	)));
/****************/

}
catch (PodioError $e) {
  $e->body['error_description'];
  // Something went wrong. Examine $e->body['error_description'] for a description of the error.
}

$website_url = $_POST['website_url'];
    /*if(strpos($website_url, '?')!=null){
        header("Location: ".$website_url."&thank_you=true");
    } else {
        header("Location: ".$website_url."?thank_you=true");
    }*/
?>

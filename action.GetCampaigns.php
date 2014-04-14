<?php

ini_set ('display_errors', 1);
error_reporting (E_ALL);

require_once('libraries/3rd/CMBase.php');

//-----------------------------INPUT PARAMS---------------------------------------

$apikey = '3369c81347b5907a0ac29a454ab38911';
$client_id = '20c11f6038b390e4bf3f2d7f679bab38';

//-------------------------------------------------------------------------------	

$cm = new CampaignMonitor( $apikey );

//Optional statement to include debugging information in the result
$cm->debug_level = 1;

//This is the actual call to the method
$result = $cm->clientGetCampaigns($client_id);



echo '<br><br>';
echo print_r($result);


?>
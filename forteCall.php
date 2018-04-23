<?php
$rawData = file_get_contents("php://input");
$params = explode("~", $rawData);


$testMode	  = $params[1];
$forteRequest = $params[0];	
$forteOrgid	  = $params[2];
$forteLocid	  = $params[3];
$forteAuthHeader = $params[4];

if($testMode=='t') {
	$url="https://sandbox.forte.net/api/v3/organizations/org_".$forteOrgid."/locations/loc_".$forteLocid."/transactions";
}else {
	$url="https://api.forte.net/v3/organizations/org_".$forteOrgid."/locations/loc_".$forteLocid."/transactions";	
}		
		
$header = array("Content-type: application/json","X-Forte-Auth-Organization-Id:org_".$forteOrgid,"Authorization:Basic ".$forteAuthHeader);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$forteRequest);
curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);
echo $server_output;
curl_close ($ch);

?>
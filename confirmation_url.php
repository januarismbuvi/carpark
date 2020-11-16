<?php 
header("Content-Type:application/json");
$response='{
	"ResultCode":0
	"ResultDesc":"cornfimation Received successfuly"
}';
//DATA
$mpesaResponse=file_get_contents('php://input');//text file
$logFile="M_PESAResponse.txt";
$jsonMpesaResponse=json_decode($mpesaResponse,true);
//write to file
$log=fopen($logFile, "a");
fwrite($log, $jsonMpesaResponse);//write mpesa response not decoded string
fclose($log);

?>
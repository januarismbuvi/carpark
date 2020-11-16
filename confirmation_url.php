<?php 
require 'config1.php';

header("Content-Type:application/json");
$response='{
	"ResultCode":0
	"ResultDesc":"cornfimation Received successfuly"
}';
//DATA
$mpesaResponse=file_get_contents('php://input');//text file
$logFile="M_PESAconfimationResponse.txt";
$jsonMpesaResponse=json_decode($mpesaResponse,true);

$transaction=array(
':TransactionType'   =>$jsonMpesaResponse['TransactionType'],
':TransID'           =>$jsonMpesaResponse['TransID'],
':TransTime'         =>$jsonMpesaResponse['TransTime'],
':TransAmount'       =>$jsonMpesaResponse['TransAmount'],
':BussinesShortCode' =>$jsonMpesaResponse['BussinesShortCode'],
':BillRefNumber'     =>$jsonMpesaResponse['BillRefNumber'],
':InvoiceNumber'     =>$jsonMpesaResponse['InvoiceNumber'],
':OrgAcountBalance'  =>$jsonMpesaResponse['OrgAcountBalance'],
':ThirdPartyTransID' =>$jsonMpesaResponse['ThirdPartyTransID'],
':MSISDN'            =>$jsonMpesaResponse['MSISDN'],
':FirstName'         =>$jsonMpesaResponse['FirstName'],
':MiddleName'        =>$jsonMpesaResponse['MiddleName'],
':LastName'          =>$jsonMpesaResponse['LastName'],

);

$log=fopen($logFile, "a");
fwrite($log, $mpesaResponse);
fclose($log);

insert_response($transaction);
?>
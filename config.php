<?php 
require_once '../includes/config.php';

function insert_response($jsonMpesaResponse){
try{
	$insert=$con->prepare("INSERT INTO `payments`(`TransactionType`, `TransID`, `TransTime`, `TransAmount`, `BussinesShortCode`, `BillRefNumber`, `InvoiceNumber`, `OrgAccountBalance`, `ThirdPartyTransID`, `MSISDN`, `FirstName`, `MiddleName`, `LastName`)
	 VALUES (TransactionType,TransID,TransTime,TransAmount,BussinesShortCode,BillRefNum ber,InvoiceNumber,OrgAccountBalance,ThirdPartyTransID,MSISDN,FirstName,MiddleName,LastName)");
	$insert->execute((array)($jsonMpesaResponse));

$transaction=fopen('transaction.txt', 'a');
fwrite($transaction, json_encode($jsonMpesaResponse));
fclose($transaction);  




}catch(PDOExeption $e){
	$errorLog=fopen('error.txt', 'a');
	fwrite($errorLog, $e->getMessage());
	fclose($errorLog);

	$logFailedTransaction= fopen('failedTransaction.txt', 'a');
	fwrite($logFailedTransaction, json_encode($jsonMpesaResponse));
	fclose($logFailedTransaction);
}

}

?>
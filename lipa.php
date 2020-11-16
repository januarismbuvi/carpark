<?php 
//access token
$consumer_key='';
$consumer_secret='';
$headers=['ContentType:application/json;charset=utf8'];
$access_token_url='https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$curl=curl_init($access_token_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl,CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_USERPWD, $consumer_key.'#'.$consumer_secret);
$result=curl_exec($curl);
$status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
$result=json_decode($result);
$access_token=$result->access_token;
curl_close($curl);


//initiate transaction

$initiate_url='https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

  $businessShortCode = " ";
    $passKey = " ";
    $timestamp = date('YmdGis');
    $password = base64_encode($businessShortCode.$passKey.$timestamp);
    $Amount = '1';
    $partyA = "0701237958";//paying phone number
    $callBackUrl = "https://cptmsproject.epizy.com/carrental/mpesa/callbacl_url.php";
    $accReff = "Park001";
    $transDesc = "Paymnet for CPTMS ";

$stkHeader=['Content-Type:application/json','Authorization:Bearer '.$access_token];

 $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $initiate_url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $stkHeader);

 $curl_post_data = array(
    //Fill in the request parameters with valid values
    'BusinessShortCode' => $businessShortCode,
    'Password' => $password,
    'Timestamp' => $timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $Amount,
    'PartyA' => $partyA,
    'PartyB' => $businessShortCode,
    'PhoneNumber' => $partyA,
    'CallBackURL' => $callBackUrl,
    'AccountReference' => $accReff,
    'TransactionDesc' => $transDesc
  );


?>
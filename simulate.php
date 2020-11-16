<?php 

$consumer_key='';
$consumer_secret='';
$headers=['ContentType:application/json;charset=utf8'];
$url='https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$curl=curl_init($url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl,CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_USERPWD, $consumer_key.'#'.$consumer_secret);
$result=curl_exec($curl);
$status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
$result=json_decode($result);
$access_token=$result->access_token;

//echo $access_token;
curl_close($curl);



  $url='https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate'; 
$curl=curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:appliaction/json','Authorization:Bearer '.$access_token));


$cur_post_data=array(
'ShortCode'=>'',
'CommandID'=>'',//CustomerPayBillOnline
'Amount'=>'',//web url for '
'MSISDN'=>'',//paying number
'BillRefNumber'=>''//for validation.php
);

$data_string=json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl,CURLOPT_POSTFIELDS ,$data_string);
$curl_response=curl_exec($curl);
print_r($curl_response);
echo $curl_response;


?>
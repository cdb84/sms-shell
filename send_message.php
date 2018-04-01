<?php
include "smsGateway.php";
$smsGateway = new SmsGateway($argv[1], $argv[2]);

$deviceID = intval($argv[3]);
$number = $argv[4];
$message = $argv[5];

$options = [
'expires_at' => strtotime('+1 hour') // Cancel the message in 1 hour if the message is not yet sent
];

//Please note options is not required and can be left out
$result = $smsGateway->sendMessageToNumber($number, $message, $deviceID, $options);
if ( $argv[6] == 'tidy' ){
  echo $result['response']['result']['success']['0']['status']."\n";
}
else if ( $result['status'] == 200 ){
  print_r($result['response']['result']);
}
else {
  echo "ERR";
}
?>
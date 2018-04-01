<?php
include "smsGateway.php";
$smsGateway = new SmsGateway($argv[1], $argv[2]);

$deviceID = intval($argv[3]);
$contact_name = $argv[4];

$result = $smsGateway->getContacts();
$contact_matches = array();
foreach ( $result['response']['result']['data'] as $contact_data ){
  if ( preg_match('/'.$contact_name.'/',$contact_data['name']) ){
    array_push($contact_matches, $contact_data);
  }
}
if ( !(count($contact_matches) > 0) ){
  echo "ERR";
  exit;
}
//print_r($contact_matches);
$contact = $contact_matches[0]['id'];
$message = $argv[5];

$options = [
'expires_at' => strtotime('+1 hour') // Cancel the message in 1 hour if the message is not yet sent
];

$result = $smsGateway->sendMessageToContact($contact, $message, $deviceID, $options);

if ( $argv[6] == 'tidy' ){
  echo $result['response']['result']['success']['0']['status']."\n";
  echo $result['response']['result']['success']['0']['contact']['name']." ".$result['response']['result']['success']['0']['contact']['number'];
}
else if ( $result['status'] == 200 ){
  print_r($result['response']['result']);
}
else {
  echo "ERR";
}
?>
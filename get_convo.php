<?php
include "smsGateway.php";
$smsGateway = new SmsGateway($argv[1], $argv[2]);

$contact_name = $argv[3];

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
$contact = $contact_matches[0];

$result = $smsGateway->getMessages();

foreach ( array_reverse($result['response']['result']) as $message ){
  if ( $message['contact']['name'] == $contact['name'] ){
    echo "*****************************************\n";
    echo "Status: ".$message['status']."\n";
    echo "Received: ".strftime("%D %r %Z ", ($message['created_at']-18000))."\n";//echo gmdate("Y-m-d\TH:i:s\Z", $timestamp);
    echo "Contact: ".$message['contact']['name']." ".$message['contact']['number']."\n";
    echo $message['message']."\n";
  }
}

?>

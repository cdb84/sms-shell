<?php
include "smsGateway.php";
$smsGateway = new SmsGateway($argv[1], $argv[2]);

$page = intval($argv[3]);

$result = $smsGateway->getMessages($page);

if ( $argv[4] == 'tidy' ){
  foreach ( array_reverse($result['response']['result']) as $message ){
    echo "*****************************************\n";
    echo "Status: ".$message['status']."\n";
    echo "Received: ".strftime("%D %r %Z ", ($message['created_at']-18000))."\n";//echo gmdate("Y-m-d\TH:i:s\Z", $timestamp);
    echo "Contact: ".$message['contact']['name']." ".$message['contact']['number']."\n";
    echo $message['message']."\n";
  }
}
else if ( $result['status'] == 200 ){
  print_r($result['response']['result']);
}
else {
  echo "ERR";
}
?>

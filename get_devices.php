<?php
include "smsGateway.php";
$smsGateway = new SmsGateway($argv[1], $argv[2]);

$page = 1;

$result = $smsGateway->getDevices($page);
if ( $argv[3] == "id_only" ){
  echo $result['response']['result']['data'][0]['id'];
}
else if ( $argv[3] == "tidy" ){
  print_r($result['response']['result']['data'][0]);
}
else if ( $result['status'] == 200 ){
  print_r($result['response']['result']['data']);
}
else {
  echo "ERR";
}
?>
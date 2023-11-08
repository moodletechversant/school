<?php


require(__DIR__.'/../../config.php');


require_login();    
global $DB,$USER;

// $context = context_system::instance();
$userid= $USER->id;
$currentTimestamp = time();

  $id = $_POST['id'];

  $reason = $_POST['reason'];

$status="denied";



  // $DB->execute("UPDATE mdl_leave SET l_status='$status' WHERE  id='$id'");


  $DB->execute("UPDATE mdl_leave SET l_status='$status', l_denied='$reason',modified_by='$userid',modified_date='$currentTimestamp' WHERE id='$id'");







  //echo $id;






?>





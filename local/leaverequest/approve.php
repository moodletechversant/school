<?php


require(__DIR__.'/../../config.php');

// require_once($CFG->dirroot.'/local/clsteacherassign/assignclsteacher_form.php');
require_login();    
global $DB,$USER;
$userid= $USER->id;
$currentTimestamp = time();


  $id = $_POST['id'];
$status="approved";
$DB->execute("UPDATE mdl_leave SET l_status='$status', modified_by='$userid' , modified_date='$currentTimestamp' WHERE  id='$id'");



?>





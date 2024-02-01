<?php
require(__DIR__.'/../../config.php');
global $DB,$CFG;
require_login();
if (isset($_POST['message_id']) && isset($_POST['replymessage'])) {

$crnt_dat=time();
$record = new stdClass();
$record->msgid =$_POST['message_id'];
$record->date=$crnt_dat;
$record->replymsg =$_POST['replymessage'];
// echo $record->msgid;exit();
// print_r( $record->status );
// exit();
$DB->insert_record('teacherchat', $record, false);


$urlto = $CFG->wwwroot.'/local/parentschat/view_teacherchat_1.php?id='.$message_id;
redirect($urlto, 'Data Saved Successfully '); 
}

?>
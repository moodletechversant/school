<?php


// to display as moodle page
require_once dirname(__FILE__)."/../../config.php";
global $DB,$CFG;
$id = required_param('id', PARAM_INT);
// confirm_sesskey();
$delete=new moodle_url('/local/leaverequest/std_viewrequest.php');
// require_login();
$context = context_course::instance($COURSE->id);

$table = 'leave';

	$DB->delete_records($table, array('id'=>$id));

header("Location:".$delete);



?>

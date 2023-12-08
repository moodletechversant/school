<?php


// to display as moodle page
require_once dirname(__FILE__)."/../../config.php";
global $DB,$CFG;
$id = required_param('id', PARAM_INT);
// confirm_sesskey();
$delete = $CFG->wwwroot.'/local/holiday/view_holiday.php';

$context = context_course::instance($COURSE->id);
require_capability('moodle/site:manageblocks', $context);
//print_r($id);exit();
// the name of the table in the database
$table = 'addholiday';
// delete the record
	$DB->delete_records($table, array('id'=>$id));
	//$DB->delete_records('user', array('id'=>$id2));

	
header("Location:".$delete);

?>





<?php


// to display as moodle page
require_once dirname(__FILE__)."/../../config.php";
global $DB,$CFG;
$id = required_param('id', PARAM_INT);
// confirm_sesskey();

// require_login();
$context = context_course::instance($COURSE->id);
$delete = new moodle_url('/local/class/classview.php');

require_capability('moodle/site:manageblocks', $context);

// the name of the table in the database
$table = 'class';
// delete the record
	$DB->delete_records($table, array('id'=>$id));

header("Location:".$delete);



?>

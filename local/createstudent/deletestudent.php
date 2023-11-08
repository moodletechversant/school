<?php


// to display as moodle page
require_once dirname(__FILE__)."/../../config.php";
global $DB,$CFG;
$id = required_param('id', PARAM_INT);
$id1= $DB->get_record_sql("SELECT user_id FROM mdl_student WHERE id= '$id'");
$id2=$id1->user_id;
// confirm_sesskey();

// require_login();
$context = context_course::instance($COURSE->id);
require_capability('moodle/site:manageblocks', $context);

// the name of the table in the database
$table = 'student';
// delete the record
	$DB->delete_records($table, array('id'=>$id));
	$DB->delete_records('user', array('id'=>$id2));


header("Location:/school/local/createstudent/view_student.php");



?>
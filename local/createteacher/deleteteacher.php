<?php


// to display as moodle page
require_once dirname(__FILE__)."/../../config.php";
global $DB,$CFG;
$id = required_param('id', PARAM_INT);
$id1= $DB->get_record_sql("SELECT user_id FROM mdl_teacher WHERE id= '$id'");
$id2=$id1->user_id;
$context = context_course::instance($COURSE->id);
$delete=new moodle_url('local/createteacher/view_teacher.php');
require_capability('moodle/site:manageblocks', $context);

// the name of the table in the database
$table = 'teacher';
// delete the record
	$DB->delete_records($table, array('id'=>$id));
	$DB->delete_records('user', array('id'=>$id2));

header("Location:".$delete);



?>
<?php


// to display as moodle page
require_once dirname(__FILE__)."/../../config.php";
global $DB,$CFG;
$id = required_param('id', PARAM_INT);

$context = context_course::instance($COURSE->id);
$delete=new moodle_url('/local/schoolreg/viewschools.php');
require_capability('moodle/site:manageblocks', $context);

// the name of the table in the database
$table = 'school_reg';
// delete the record
	$DB->delete_records($table, array('id'=>$id));
	

header("Location:".$delete);



?> 

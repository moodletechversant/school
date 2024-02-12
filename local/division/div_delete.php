<?php

// to display as moodle page
require_once dirname(__FILE__)."/../../config.php";
global $DB,$CFG;
$id = required_param('id', PARAM_INT);
// confirm_sesskey();
$delete = $CFG->wwwroot.'/local/division/div_view.php';
// require_login();
$context = context_course::instance($COURSE->id);
require_capability('moodle/site:manageblocks', $context);

// the name of the table in the database
$table = 'division';
// delete the record
$DB->delete_records($table, array('id'=>$id));

header("Location:".$delete);



?>
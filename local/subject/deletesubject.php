<?php

 // to display as moodle page
    require_once dirname(__FILE__)."/../../config.php";
    global $DB,$CFG;
    $id = required_param('id', PARAM_INT);
    $id1= $DB->get_record_sql("SELECT course_id FROM mdl_subject WHERE id= '$id'");
    $id2=$id1->course_id;
 // confirm_sesskey();

 // require_login();
    $context = context_course::instance($COURSE->id);
    require_capability('moodle/site:manageblocks', $context);

 // the name of the table in the database
    $table = 'subject';
 // delete the record
	$DB->delete_records($table, array('course_id'=>$id));
   $DB->delete_records('course', array('id'=>$id));


    header("Location:/school/local/subject/viewsubject.php");



?>
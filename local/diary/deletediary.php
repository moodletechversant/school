<?php
 // to display as moodle page
    require_once dirname(__FILE__)."/../../config.php";
    global $DB,$CFG;
    $id = required_param('id', PARAM_INT);
      // the name of the table in the database

      $delete = $CFG->wwwroot.'/local/diary/view_diary.php';
      $table = 'diary';
      // delete the record
         $DB->delete_records($table, array('id'=>$id));
         //$DB->delete_records('course', array('id'=>$id2));
    header("Location:".$delete);

?>
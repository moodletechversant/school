<?php

 // to display as moodle page
    require_once dirname(__FILE__)."/../../config.php";
    global $DB,$CFG;
    $id = required_param('id', PARAM_INT);
    // print_r($id);exit();
      // the name of the table in the database
      $table = 'customsurvey';
      // delete the record
         $DB->delete_records($table, array('id'=>$id));
         $DB->delete_records('customsurvey_question', array('survey_id'=>$id));
    header("Location:/school/local/survey/survey_adminview.php");

?>
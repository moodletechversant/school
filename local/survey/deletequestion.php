<?php

 // to display as moodle page
    require_once dirname(__FILE__)."/../../config.php";
    global $DB,$CFG;
    $id = required_param('id', PARAM_INT);
    // print_r($id);exit();
      // the name of the table in the database
    //   $table = 'customsurvey_question';
      // delete the record
      $editdata = $DB->get_record_sql("SELECT * FROM {customsurvey_question} WHERE id='$id'");
      $id1=$editdata->survey_id;
    $DB->delete_records('customsurvey_question', array('id'=>$id));
    header("Location:/school/local/survey/editsurvey.php?id= $id1");

?>
<?php

 // to display as moodle page
    require_once dirname(__FILE__)."/../../config.php";
    global $DB,$CFG;
   //  $id = required_param('id', PARAM_INT);
   //  $periodid = required_param('period_id', PARAM_INT);
    $id = $_GET['id'];
    $period_id = $_GET['period_id'];
   //print_r($period_id);exit();
      // the name of the table in the database
      $table = 'new_timetable';
      // delete the record
         $DB->delete_records($table, array('id'=>$id));
         //$DB->delete_records('course', array('id'=>$id2));
         $current_count = $DB->get_field('new_timetable_periods', 't_periods', array('id' => $period_id));
//print_r($current_count);exit();
// Increment the count by 1
$new_count = $current_count-1;
//print_r($new_count);exit();

// Update the database with the new count value
$update_data = new stdClass();
$update_data->id = $period_id;
$update_data->t_periods = $new_count;
// print_r($update_data);exit();
$DB->update_record('new_timetable_periods', $update_data);

    header("Location:/school/local/new_timetable/view_timetable.php");

?>
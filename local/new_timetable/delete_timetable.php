<?php

 // to display as moodle page
    require_once dirname(__FILE__)."/../../config.php";
    global $DB,$CFG;
   $view_timetable = new moodle_url('/local/new_timetable/view_timetable.php');

    $id = $_GET['id'];
    $period_id = $_GET['period_id'];
      // the name of the table in the database
      $table = 'new_timetable';
      // delete the record
         $DB->delete_records($table, array('id'=>$id));
         $current_count = $DB->get_field('new_timetable_periods', 't_periods', array('id' => $period_id));
         $new_count = $current_count-1;
         // Update the database with the new count value
         $update_data = new stdClass();
         $update_data->id = $period_id;
         $update_data->t_periods = $new_count;
         // print_r($update_data);exit();
         $DB->update_record('new_timetable_periods', $update_data);

    header("Location:".$view_timetable);

?>
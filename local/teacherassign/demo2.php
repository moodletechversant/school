<?php
require(__DIR__.'/../../config.php');
//$context = context_system::instance();
require_login();
global $DB;



    $assignedTeachers = $DB->get_records_sql("SELECT * FROM {teacher_assign} WHERE t_subject= 94");

    // $select_data .= '<option value="">----Select Teacher----</option>';
    $excludedTeacherIDs = []; // Declare the array outside the loop

    foreach ($assignedTeachers as $assignedTeacher) {
        $excludedTeacherIDs[] = $assignedTeacher->user_id;
        
    }
    
    $teacher = $DB->get_records('teacher');
    foreach ($teacher as $teachers) {
        if (!in_array($teachers->user_id, $excludedTeacherIDs)) {
            $select_data .= '<option value =' . $teachers->user_id . '>' . $teachers->t_fname . '</option>';
        }
    }
    // print_r($select_data);exit();
    echo $select_data;

?>

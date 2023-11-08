<?php
    // to display as moodle page
    require_once dirname(__FILE__)."/../../config.php";
    global $DB,$CFG;
    require_login();

    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
        // $action = $_POST['action'];
          //unenrol the user in every course he's in
          $enrols = enrol_get_plugins(true);
          $role_id = 5;
          $enrolledusercourses = enrol_get_users_courses($user_id);
      
          foreach ($enrolledusercourses as $course) {
                  //unenrol the user
                  $courseid = $course->id;
              
                  $enrolinstances = enrol_get_instances($courseid, true);
                  $unenrolled = false;
              
                  foreach ($enrolinstances as $instance) {
                      if (!$unenrolled and $enrols[$instance->enrol]->allow_unenrol($instance)) {
                          $unenrolinstance = $instance;
                          $unenrolled = true;
                      }
                  }
              
                  $enrols[$unenrolinstance->enrol]->unenrol_user($unenrolinstance, $user_id, $role_id);
          } 

        $DB->delete_records('student_assign', array('user_id'=>$user_id));

        echo 'success';
    }
    

?>

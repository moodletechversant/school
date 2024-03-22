<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  
  
  <script type="text/javascript">
    $(document).ready(function() {
        $("#assign").DataTable( {
            
        } );
    } );
  </script>

<?php

require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/dashboard/templates/upcoming_assign.mustache');
$template2 = file_get_contents($CFG->dirroot . '/local/dashboard/templates/upcoming_parentview.mustache');

global $DB, $USER, $OUTPUT, $PAGE;


$context = context_system::instance();
require_login();

//$linktext = "Upcoming Assignment";
$user1= optional_param('id', 0, PARAM_INT);

$linkurl = new moodle_url('/local/dashboard/upcoming_assignment.php');
$csspath = new moodle_url('/local/css/style.css');
$dashboard = new moodle_url('/local/dashboard/upcoming.php', array('child_id' => $user1));


// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);                                                                  
$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
$PAGE->set_heading($linktext);
//$PAGE->navbar->add('Upcoming Assignmnet', new moodle_url($CFG->wwwroot.'/local/dashboard/upcoming_assignment.php'));

echo $OUTPUT->header();
$userid = $USER->id;
// print_r($user1);exit();
$current_date = time();
$enrolled_courses = enrol_get_users_courses($userid);
$context = context_user::instance($USER->id, MUST_EXIST);
//$pid = $DB->get_record_sql("SELECT user_id FROM {parent} WHERE child_id = ?", array($user1));
// print_r($pid);exit();
$sid = $DB->get_record_sql("SELECT * FROM {student} WHERE user_id = ?", array($userid));
$tid= $DB->get_record_sql("SELECT * FROM {teacher} WHERE user_id= ?", array($userid));

//print_r($sid);exit();
if ($user1) {
    $penrolled_courses = enrol_get_users_courses($user1);
    $enrolled_course_ids = array();
foreach ($penrolled_courses as $enrolled_course) {
    $enrolled_course_ids[] = $enrolled_course->id;
}
$in_clause = implode(',', array_fill(0, count($enrolled_course_ids), '?'));
    $params = array_merge($enrolled_course_ids, array($current_date));
    //print_r($penrolled_courses);exit();
    $data = $DB->get_records_sql("SELECT * FROM {assign} WHERE course IN ($in_clause) AND duedate >= ? ORDER BY allowsubmissionsfromdate", $params);
    $mustache = new Mustache_Engine();
    $tableRows = [];
    if (!empty($data)) {

    foreach ($data as $value) {
       // Get the course module ID from the current row of data (assuming $value is an object)
       $cmid = $value->id;

       // Load the course module record from the database
       $cm = get_coursemodule_from_instance('assign', $cmid, 0, false, MUST_EXIST);
       
       // Construct the URL for the assignment view page using the course module ID
       //$view = $CFG->wwwroot.'/mod/assign/view.php?id='.$cm->id;

        $dates1=date('d-m-Y',$value->allowsubmissionsfromdate);
        $dates=date('d-m-Y',$value->duedate);
        $assign_name=$value->name;
        
         $tableRows[] = [
            'id'=> $id,
            'Submission_date' => $dates1,
            'Due_date' => $dates,
            'Assignment_name' => $assign_name,
           // 'View'=>$view_icon,
        ];
        

        
    }
    } 
    else{
        
       $error= "There are no upcoming assignment";
       $tableRows[] = [
        
        'Submission_date' => $error,
       
    ];
    
}
$output = $mustache->render($template2, ['tableRows' => $tableRows,'csspath'=>$csspath,'dashboard'=>$dashboard]);
echo $output;

} elseif ($sid) {
    $enrolled_courses = enrol_get_users_courses($sid->user_id);
    //print_r($enrolled_courses);exit();
    $enrolled_course_ids = array();
foreach ($enrolled_courses as $enrolled_course) {
    $enrolled_course_ids[] = $enrolled_course->id;
}

if (empty($enrolled_course_ids)) {
    echo "You are not enrolled in any courses.";
} else {
    $in_clause = implode(',', array_fill(0, count($enrolled_course_ids), '?'));
    $params = array_merge($enrolled_course_ids, array($current_date));

    $data = $DB->get_records_sql("SELECT * FROM {assign} WHERE course IN ($in_clause) AND duedate >= ? ORDER BY allowsubmissionsfromdate", $params);
    $mustache = new Mustache_Engine();
    $tableRows = [];
    if (!empty($data)) {

    foreach ($data as $value) {
       // Get the course module ID from the current row of data (assuming $value is an object)
       $cmid = $value->id;

       // Load the course module record from the database
       $cm = get_coursemodule_from_instance('assign', $cmid, 0, false, MUST_EXIST);
       
       // Construct the URL for the assignment view page using the course module ID
       $view = $CFG->wwwroot.'/mod/assign/view.php?id='.$cm->id;

        $dates1=date('d-m-Y',$value->allowsubmissionsfromdate);
        $dates=date('d-m-Y',$value->duedate);
        $assign_name=$value->name;
        $subject_name= $DB->get_field('course', 'fullname', ['id' =>$value->course], MUST_EXIST);
            // print_r($subject_name);

        $view_icon=html_writer::link(
            $view,
            '<span class="custom-icon" aria-label="' . get_string('view') . '">👁️</span>'
        );

        $status = '';
    if ($current_date < $value->allowsubmissionsfromdate) {
        $status = 'Not Started';
    } elseif ($current_date >= $value->allowsubmissionsfromdate && $current_date <= $value->duedate) {
        $status = 'In Progress';
    } elseif ($current_date > $value->duedate) {
        $status = 'Late';
    }
         $tableRows[] = [
            'id'=> $id,
            'Submission_date' => $dates1,
            'Due_date' => $dates,
            'Subject' => $subject_name,
            'Assignment_name' => $assign_name,
            'View'=>$view_icon,
            'Status' => $status // Adding the status to the table row
        ];
        

        
    }
    } 
    else{
        
       $error= "There are no upcoming assignment for your enrolled courses.";
       $tableRows[] = [
        
        'Submission_date' => $error,
       
    ];
    
   // echo $view_icon;
    // echo html_writer::table($table);
    // $backurl = new moodle_url('/local/dashboard/dashboard.php');
    // $backbutton = html_writer::link($backurl, '< Back');
    // echo $backbutton;
}
$output = $mustache->render($template, ['tableRows' => $tableRows,'csspath'=>$csspath,'dashboard'=>$dashboard]);
echo $output;
}

} elseif ($tid) {
    $enrolled_courses = enrol_get_users_courses($tid->user_id);
    //print_r($enrolled_courses);exit();
    $enrolled_course_ids = array();
foreach ($enrolled_courses as $enrolled_course) {
    $enrolled_course_ids[] = $enrolled_course->id;
}

if (empty($enrolled_course_ids)) {
    echo "You are not enrolled in any courses.";
} else {
    $in_clause = implode(',', array_fill(0, count($enrolled_course_ids), '?'));
    $params = array_merge($enrolled_course_ids, array($current_date));

    $data = $DB->get_records_sql("SELECT * FROM {assign} WHERE course IN ($in_clause) AND duedate >= ? ORDER BY allowsubmissionsfromdate", $params);
    $mustache = new Mustache_Engine();
    $tableRows = [];
    if (!empty($data)) {

    foreach ($data as $value) {
       // Get the course module ID from the current row of data (assuming $value is an object)
       $cmid = $value->id;

       // Load the course module record from the database
       $cm = get_coursemodule_from_instance('assign', $cmid, 0, false, MUST_EXIST);
       
       // Construct the URL for the assignment view page using the course module ID
       $view = $CFG->wwwroot.'/mod/assign/view.php?id='.$cm->id;

        $dates1=date('d-m-Y',$value->allowsubmissionsfromdate);
        $dates=date('d-m-Y',$value->duedate);
        $assign_name=$value->name;
        $view_icon=html_writer::link(
            $view,
            '<span class="custom-icon" aria-label="' . get_string('view') . '">👁️</span>'
        );

        $status = '';
        if ($current_date < $value->allowsubmissionsfromdate) {
            $status = 'Not Started';
        } elseif ($current_date >= $value->allowsubmissionsfromdate && $current_date <= $value->duedate) {
            $status = 'In Progress';
        } elseif ($current_date > $value->duedate) {
            $status = 'Late';
        }


         $tableRows[] = [
            'id'=> $id,
            'Submission_date' => $dates1,
            'Due_date' => $dates,
            'Assignment_name' => $assign_name,
            'View'=>$view_icon,
            'Status' => $status // Adding the status to the table row

        ];
        

        
    }
    } 
    else{
        
       $error= "There are no upcoming assignment for your enrolled courses.";
       $tableRows[] = [
        
        'Submission_date' => $error,
       
    ];
    
   // echo $view_icon;
    // echo html_writer::table($table);
    // $backurl = new moodle_url('/local/dashboard/dashboard.php');
    // $backbutton = html_writer::link($backurl, '< Back');
    // echo $backbutton;
}
$output = $mustache->render($template, ['tableRows' => $tableRows,'csspath'=>$csspath,'dashboard'=>$dashboard]);
echo $output;
}

} else {
    echo "No valid parent or student record found.";
}

echo $OUTPUT->footer();
?>

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  
  
  <script type="text/javascript">
    $(document).ready(function() {
        $("#exam").DataTable( {
            
        } );
    } );
  </script>
<?php

require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/dashboard/templates/upcoming_exam.mustache');
$template2 = file_get_contents($CFG->dirroot . '/local/dashboard/templates/parentviewupcoming_exam.mustache');

global $DB, $USER,$OUTPUT, $PAGE;

$context = context_system::instance();
require_login();
$user1= optional_param('id', 0, PARAM_INT);

$linkurl = new moodle_url('/local/dashboard/upcomingexams.php');
$csspath = new moodle_url('/local/css/style.css');
$dashboard = new moodle_url('/local/dashboard/upcoming.php', array('child_id' => $user1));

$PAGE->set_context($context);
$PAGE->set_url($linkurl);                                                                  
$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);

$PAGE->set_heading($linktext);
//$PAGE->navbar->add('Upcoming Exams', new moodle_url($CFG->wwwroot.'/local/dashboard/upcomingexams.php'));

echo $OUTPUT->header();
$userid = $USER->id;
$current_date = time();
$enrolled_courses = enrol_get_users_courses($userid);
//$pid = $DB->get_record_sql("SELECT * FROM {parent} WHERE user_id = ?", array($userid));
$sid = $DB->get_record_sql("SELECT * FROM {student} WHERE user_id = ?", array($userid));
$tid= $DB->get_record_sql("SELECT * FROM {teacher} WHERE user_id= ?", array($userid));
// print_r($tid);exit();

if ($user1) {
    $penrolled_courses = enrol_get_users_courses($user1);
    $enrolled_course_ids = array();
foreach ($penrolled_courses as $enrolled_course) {
    $enrolled_course_ids[] = $enrolled_course->id;
}
$in_clause = implode(',', array_fill(0, count($enrolled_course_ids), '?'));
$params = array_merge($enrolled_course_ids, array($current_date));

$data = $DB->get_records_sql("SELECT * FROM {quiz} WHERE course IN ($in_clause) AND timeclose >= ?", $params);
//print_r($data);exit();
$mustache = new Mustache_Engine();
$tableRows = [];
if (!empty($data)) {

foreach ($data as $value) {
    $cmid = $value->id;
    $cm = get_coursemodule_from_instance('quiz', $cmid, 0, false, MUST_EXIST);
    //$view = $CFG->wwwroot.'/mod/quiz/view.php?id='.$cm->id;

    $dates1=date('d-m-Y',$value->timeopen);
    $dates=date('d-m-Y',$value->timeclose);
    $exam_name=$value->name;
    
    $tableRows[] = [
        'id'=> $id,
        'Start_date' => $dates1,
        'End_date' => $dates,
        'Exam_name' => $exam_name,
        // 'View'=>$view_icon,
    ];
}
}
else{
    
$error= "There are no upcoming exams.";
$tableRows[] = [
 
 'Start_date' => $error,

];
}

$output = $mustache->render($template2, ['tableRows' => $tableRows,'csspath'=>$csspath,'dashboard'=>$dashboard]);
echo $output;

} elseif ($sid) {
    $enrolled_courses = enrol_get_users_courses($sid->user_id);
    $enrolled_course_ids = array();
    foreach ($enrolled_courses as $enrolled_course) {
        $enrolled_course_ids[] = $enrolled_course->id;
    }
    
    if (!empty($enrolled_course_ids)) {
        $in_clause = implode(',', array_fill(0, count($enrolled_course_ids), '?'));
        $params = array_merge($enrolled_course_ids, array($current_date));
    
        $data = $DB->get_records_sql("SELECT * FROM {quiz} WHERE course IN ($in_clause) AND timeclose >= ?", $params);
        //print_r($data);exit();
        $mustache = new Mustache_Engine();
        $tableRows = [];
        if (!empty($data)) {
    
        foreach ($data as $value) {
            $cmid = $value->id;
            $cm = get_coursemodule_from_instance('quiz', $cmid, 0, false, MUST_EXIST);
            $view = $CFG->wwwroot.'/mod/quiz/view.php?id='.$cm->id;
    
            $dates1=date('d-m-Y',$value->timeopen);
            $dates=date('d-m-Y',$value->timeclose);
            $exam_name=$value->name;
            //$subject_id=$value->course;
            $subject_name= $DB->get_field('course', 'fullname', ['id' =>$value->course], MUST_EXIST);
            //print_r($subject_name);exit();
            $view_icon=html_writer::link(
                $view,
                '<span class="custom-icon" aria-label="' . get_string('view') . '">👁️</span>'
            );


            // Set the status of the exam
    $status = '';
    if ($current_date < $value->timeopen) {
        $status = 'Not Started';
    } elseif ($current_date >= $value->timeopen && $current_date <= $value->timeclose) {
        $status = 'In Progress';
    } elseif ($current_date > $value->timeclose) {
        $status = 'Late';
    }

            $tableRows[] = [
                'id'=> $id,
                'Submission_date' => $dates1,
                'End_date' => $dates,
                'Exam_name' => $exam_name,
                'Subject' => $subject_name,
                'View'=>$view_icon,
                'Status' => $status // Adding the status to the table row
            ];
        }
    }
    else{
            
        $error= "There are no upcoming exams for your enrolled courses.";
        $tableRows[] = [
         
         'Submission_date' => $error,
        
     ];
    }
    } else {
        echo "You are not enrolled in any courses.";
       
    }
    $output = $mustache->render($template, ['tableRows' => $tableRows,'csspath' => $csspath,'dashboard'=>$dashboard]);
    echo $output;

}

 elseif ($tid) {
    $enrolled_courses = enrol_get_users_courses($tid->user_id);
            // print_r($enrolled_courses);

    $enrolled_course_ids = array();
    foreach ($enrolled_courses as $enrolled_course) {
        $enrolled_course_ids[] = $enrolled_course->id;
    }
    
    if (!empty($enrolled_course_ids)) {
        $in_clause = implode(',', array_fill(0, count($enrolled_course_ids), '?'));
        $params = array_merge($enrolled_course_ids, array($current_date));
    
        $data = $DB->get_records_sql("SELECT * FROM {quiz} WHERE course IN ($in_clause) AND timeclose >= ?", $params);
        // print_r($data);exit();
        $mustache = new Mustache_Engine();
        $tableRows = [];
        if (!empty($data)) {
    
        foreach ($data as $value) {
            $cmid = $value->id;
            $cm = get_coursemodule_from_instance('quiz', $cmid, 0, false, MUST_EXIST);
            $view = $CFG->wwwroot.'/mod/quiz/view.php?id='.$cm->id;
    
            $dates1=date('d-m-Y',$value->timeopen);
            $dates=date('d-m-Y',$value->timeclose);
            $exam_name=$value->name;
            $subject_name= $DB->get_field('course', 'fullname', ['id' =>$value->course], MUST_EXIST);

            $view_icon=html_writer::link(
                $view,
                '<span class="custom-icon" aria-label="' . get_string('view') . '">👁️</span>'
            );

        // Set the status of the exam
        $status = '';
        if ($current_date < $value->timeopen) {
            $status = 'Not Started';
        } elseif ($current_date >= $value->timeopen && $current_date <= $value->timeclose) {
            $status = 'In Progress';
        } elseif ($current_date > $value->timeclose) {
            $status = 'Late';
        }


            $tableRows[] = [
                'id'=> $id,
                'Submission_date' => $dates1,
                'End_date' => $dates,
                'Exam_name' => $exam_name,
                'Subject' => $subject_name,
                'View'=>$view_icon,
                'Status' => $status // Adding the status to the table row

            ];
        }
    }
    else{
            
        $error= "There are no upcoming exams for your enrolled courses.";
        $tableRows[] = [
         
         'Submission_date' => $error,
        
     ];
    }
    } else {
        echo "You are not enrolled in any courses.";
       
    }
    $output = $mustache->render($template, ['tableRows' => $tableRows,'csspath' => $csspath,'dashboard'=>$dashboard]);
    echo $output;

}else {
    echo "No valid parent or student record found.";
}

echo $OUTPUT->footer();
?>


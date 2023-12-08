<?php

require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/dashboard/templates/upcoming_exam.mustache');

global $DB, $USER,$OUTPUT, $PAGE;

$context = context_system::instance();
require_login();

$linkurl = new moodle_url('/local/dashboard/upcomingexams.php');
$csspath = new moodle_url('/local/css/style.css');
$dashboard = new moodle_url('/local/dashboard/upcoming.php');

$PAGE->set_context($context);
$PAGE->set_url($linkurl);                                                                  
$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);

$PAGE->set_heading($linktext);
$PAGE->navbar->add('Upcoming Exams', new moodle_url($CFG->wwwroot.'/local/dashboard/upcomingexams.php'));

echo $OUTPUT->header();
$userid = $USER->id;
$current_date = time();
$enrolled_courses = enrol_get_users_courses($userid);
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
        $view_icon=html_writer::link(
            $view,
            '<span class="custom-icon" aria-label="' . get_string('view') . '">👁️</span>'
        );
        $tableRows[] = [
            'id'=> $id,
            'Start_date' => $dates1,
            'End_date' => $dates,
            'Exam_name' => $exam_name,
            'View'=>$view_icon,
        ];
    }
}
else{
        
    $error= "There are no upcoming exams for your enrolled courses.";
    $tableRows[] = [
     
     'Submission_date' => $error,
    
 ];
}
}
$output = $mustache->render($template, ['tableRows' => $tableRows,'csspath' => $csspath,'dashboard'=>$dashboard]);
echo $output;

echo $OUTPUT->footer();
?>


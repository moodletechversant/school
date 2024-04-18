<?php
// include('demo.html');
require_once(__DIR__ . '/../../config.php');
// require_once(__DIR__ . '/../../lib/mustache/src/Mustache/Autoloader.php');

require_once($CFG->dirroot . '/calendar/lib.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();


$templateAdmin = file_get_contents($CFG->dirroot . '/local/dashboard/templates/upcoming.mustache');
$templateUser= file_get_contents($CFG->dirroot . '/local/dashboard/templates/upcomings.mustache');
$templateTeacher= file_get_contents($CFG->dirroot . '/local/dashboard/templates/teacherdashbordview.mustache');


// require_once($CFG->dirroot.'/local/createstudent/demo.html');
global $class,$CFG,$USER;
$context = context_system::instance();
require_login();
// $classid = $class->id;
$child_id  = optional_param('child_id', 0, PARAM_INT);

//  print_r($child_id);exit();
$userid = $USER->id;
//  print_r($userid);exit();
$tid= $DB->get_record_sql("SELECT * FROM {teacher} WHERE user_id= ?", array($userid));

$linkurl = new moodle_url('/local/dashboard/upcoming.php');
$csspath = new moodle_url('/local/css/style.css');
$calendar = new moodle_url('/calendar/view.php');
$courses = new moodle_url('/local/dashboard/view_upcoming_exams.php');
$assignment = new moodle_url('/local/dashboard/view_upcomming_assignment.php');
$img1 = new moodle_url('/local/img/ic-20.svg');
$img2 = new moodle_url('/local/img/ic-21.svg');
$img3 = new moodle_url('/local/img/ic-22.svg');

$upcoming_events = new moodle_url('/local/dashboard/upcoming_events.php');
$upcomingexams = new moodle_url('/local/dashboard/upcomingexams.php');
$upcoming_assignment = new moodle_url('/local/dashboard/upcoming_assignment.php');
$upcomingteacherview = new moodle_url('/local/dashboard/upcomingteacherview.php');
$upcomingassignteacher= new moodle_url('/local/dashboard/upcoming_assign_view.php');
 
$PAGE->set_context($context);

$strnewclass= 'Dashboard';

$PAGE->set_url('/local/dashboard/upcoming.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);

echo $OUTPUT->header();

if (has_capability('moodle/site:config', $context)) {
    // User is a site admin, display admin template
    $mustache = new Mustache_Engine();
    echo $mustache->render($templateAdmin, ['csspath'=>$csspath,'calendar'=>$calendar,'courses'=>$courses,'assignment'=>$assignment,'img1'=>$img1,'img2'=>$img2,'img3'=>$img3]);
} 


elseif ($tid && !empty($tid)) {
    $mustache = new Mustache_Engine();
    echo $mustache->render($templateTeacher, ['csspath'=>$csspath,'upcomingteacherview'=>$upcomingteacherview,'upcomingassignteacher'=>$upcomingassignteacher,'upcomingexams'=>$upcomingexams,'calendar'=>$calendar,'assignment'=>$assignment,'img1'=>$img1,'img2'=>$img2,'img3'=>$img3,'child_id'=>$userid]);

}

else {
    // User is a regular user, display user template
    $mustache = new Mustache_Engine();
    echo $mustache->render($templateUser,['csspath'=>$csspath,'upcoming_events'=>$upcoming_events,'upcoming_assignment'=>$upcoming_assignment,'upcomingexams'=>$upcomingexams,'img1'=>$img1,'img2'=>$img2,'img3'=>$img3,'child_id'=>$child_id]);
}

echo $OUTPUT->footer();
?>

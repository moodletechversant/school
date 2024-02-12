<?php
// include('demo.html');
require_once(__DIR__ . '/../../config.php');
// require_once(__DIR__ . '/../../lib/mustache/src/Mustache/Autoloader.php');

require_once($CFG->dirroot . '/calendar/lib.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();


$template4 = file_get_contents($CFG->dirroot . '/local/dashboard/templates/course_dashboard.mustache');


// require_once($CFG->dirroot.'/local/createstudent/demo.html');
global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;

$linkurl = new moodle_url('/local/dashboard/course_dashboard.php');
$css_link = new moodle_url('/local/css/style.css');
$view_subject= new moodle_url('/local/subject/viewsubject.php');
$courseview_admin= new moodle_url('/local/subject/admin_courseview.php');

$PAGE->set_context($context);
$strnewclass= 'Student Dashboard';

$PAGE->set_url('/local/dashboard/course_dashboard.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);

echo $OUTPUT->header();
$mustache = new Mustache_Engine();

echo $mustache->render($template4, $data,['css_link'=>$css_link,'view_subject'=>$view_subject,'courseview_admin'=>$courseview_admin]);


echo $OUTPUT->footer();


?>

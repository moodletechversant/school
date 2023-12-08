<?php
// include('demo.html');
require_once(__DIR__ . '/../../config.php');
// require_once(__DIR__ . '/../../lib/mustache/src/Mustache/Autoloader.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();
if(is_siteadmin()){

$template4 = file_get_contents($CFG->dirroot . '/local/dashboard/templates/admin.mustache');

// require_once($CFG->dirroot.'/local/createstudent/demo.html');
global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;
$linktext = "View students";

$linkurl = new moodle_url('/local/dashboard/dashboardadmin.php');
$csspath = new moodle_url('/local/css/style.css');
$academicyr_view = new moodle_url('/local/academicyear/viewacademicyear.php');
$csspath = new moodle_url('/local/css/style.css');
$csspath = new moodle_url('/local/css/style.css');
$csspath = new moodle_url('/local/css/style.css');
$csspath = new moodle_url('/local/css/style.css');
$csspath = new moodle_url('/local/css/style.css');
$csspath = new moodle_url('/local/css/style.css');
$csspath = new moodle_url('/local/css/style.css');


$PAGE->set_context($context);
$strnewclass= 'Admin Dasboard';
$PAGE->set_url('/local/dashboard/dashboardadmin.php');
$PAGE->set_title($strnewclass);
echo $OUTPUT->header();
$mustache = new Mustache_Engine();
echo $mustache->render($template4,['csspath' => $csspath,'academicyr_view'=>$academicyr_view]);
echo $OUTPUT->footer();
}
else{
  echo "you have no permission to access the page";
}

?>

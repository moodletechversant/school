<?php
// include('demo.html');
require_once(__DIR__ . '/../../config.php');
// require_once(__DIR__ . '/../../lib/mustache/src/Mustache/Autoloader.php');

require_once($CFG->dirroot . '/calendar/lib.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();


$template4 = file_get_contents($CFG->dirroot . '/local/dashboard/templates/upcoming.mustache');


// require_once($CFG->dirroot.'/local/createstudent/demo.html');
global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;

$linkurl = new moodle_url('/local/dashboard/upcoming.php');

$PAGE->set_context($context);
$strnewclass= 'Student Dashboard';

$PAGE->set_url('/local/dashboard/upcoming.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);

echo $OUTPUT->header();
$mustache = new Mustache_Engine();

echo $mustache->render($template4, $data);


echo $OUTPUT->footer();


?>

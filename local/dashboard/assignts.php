<?php
// include('demo.html');
require_once(__DIR__ . '/../../config.php');
// require_once(__DIR__ . '/../../lib/mustache/src/Mustache/Autoloader.php');


require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/dashboard/templates/adminassign.mustache');

// require_once($CFG->dirroot.'/local/createstudent/demo.html');
global $class,$CFG,$SESSION;
$context = context_system::instance();
// $classid = $class->id;
//$school_id=optional_param('id', 0, PARAM_INT);   
$school_id  =$SESSION->schoolid;

$linktext = "View students";

$linkurl = new moodle_url('/local/dashboard/assignts.php');
$css_link = new moodle_url('/local/css/style.css');
$view_tassign= new moodle_url('/local/teacherassign/view_tassign.php');
$clsteacher_assign= new moodle_url('/local/clsteacherassign/view_clsteacherassign.php');
$student_assign= new moodle_url('/local/studentassign/view_sassign.php');

$view_tassign_img= new moodle_url('/local/img/academic.svg');
$clsteacher_assign_img= new moodle_url('/local/img/ic-3.svg');
$student_assign_img= new moodle_url('/local/img/ic-4.svg');

$PAGE->set_context($context);
$strnewclass= 'Admin Dasboard';

$PAGE->set_url('/local/dashboard/assignts.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);

echo $OUTPUT->header();
//$current_time = time(); 
  
    $mustache = new Mustache_Engine();
    echo $mustache->render($template,['css_link'=>$css_link,'view_tassign'=>$view_tassign,'clsteacher_assign'=>$clsteacher_assign,'student_assign'=>$student_assign,'view_tassign_img'=>$view_tassign_img,'clsteacher_assign_img'=>$clsteacher_assign_img,'student_assign_img'=>$student_assign_img]);
 
echo $OUTPUT->footer();


?>


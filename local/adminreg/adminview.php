<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/adminreg/template/adminview.mustache');
global $class,$CFG,$SESSION;

$context = context_system::instance();
$linkurl = new moodle_url('/local/adminreg/adminview.php');
$css_link = new moodle_url('/local/css/style.css');
$class_creation = new moodle_url('/local/adminreg/admin_registration.php');
$admin_edit = new moodle_url("/local/adminreg/admin_edit.php?id");

$PAGE->set_context($context);
$strnewclass= "admincreation";
$PAGE->set_url('/local/adminreg/adminview.php');
$schoolid  = $SESSION->schoolid;
$PAGE->set_title($strnewclass);
echo $OUTPUT->header();
$mustache = new Mustache_Engine(); 
$admin_details = $DB->get_record_sql("SELECT * FROM {admin_registration}  WHERE school = $schoolid");
$id =$admin_details->id ;
$name =$admin_details->name ;
$username=$admin_details->username;
$email=$admin_details->email;
$mob_number=$admin_details->number;
$output = $mustache->render($template,['css_link'=>$css_link,'id'=>$id,'name'=>$name,'username'=>$username,'email'=>$email,'mob_number'=>$mob_number,'admin_edit'=>$admin_edit]);
echo $output;
echo $OUTPUT->footer();


?>

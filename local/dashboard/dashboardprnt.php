<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();
$userid=$USER->id;
$pid= $DB->get_record_sql("SELECT user_id FROM mdl_parent WHERE user_id= '$userid'");  
if(!empty($pid) && $pid->user_id==$userid){
$template = file_get_contents($CFG->dirroot . '/local/dashboard/templates/dashboardprnt.mustache');
global $class, $CFG;
$context = context_system::instance();
$linktext = "Dashboard Parent";
$linkurl = new moodle_url('/local/dashboard/dashboardprnt.php');
$css_link= new moodle_url('/local/css/style.css');
$img_12=new moodle_url('/local/img/ic-12.svg');
$img_5=new moodle_url('/local/img/ic-5.svg');
$img_2=new moodle_url('/local/img/ic-2.svg');
$img_6=new moodle_url('/local/img/ic-6.svg');
$img_28=new moodle_url('/local/img/ic-28.svg');
$img_7=new moodle_url('/local/img/ic-7.svg');
$img_13=new moodle_url('/local/img/ic-13.svg');
$img_17=new moodle_url('/local/img/ic-17.svg');
$img_14=new moodle_url('/local/img/ic-14.svg');
$img_18=new moodle_url('/local/img/ic-18.svg');

$PAGE->set_context($context);
$PAGE->set_title($strnewclass);
echo $OUTPUT->header();
$mustache = new Mustache_Engine();
echo $mustache->render($template,['css_link'=>$css_link,'img_12'=>$img_12,'img_5'=>$img_5,'img_2'=>$img_2,'img_6'=>$img_6,'img_28'=>$img_28,'img_7'=>$img_7,'img_13'=>$img_13,'img_17'=>$img_17,'img_14'=>$img_14,'img_18'=>$img_18]);
echo $OUTPUT->footer();
}
else{
  echo "you have no permission to access the page";
}
?>

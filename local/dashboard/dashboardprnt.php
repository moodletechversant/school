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
$PAGE->set_context($context);
$PAGE->set_title($strnewclass);
echo $OUTPUT->header();
$mustache = new Mustache_Engine();
echo $mustache->render($template);
echo $OUTPUT->footer();
}
else{
  echo "you have no permission to access the page";
}
?>

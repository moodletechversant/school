<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/subject/template/subjectview.mustache');

global $class,$CFG;
$context = context_system::instance();
$linktext = "Courses";
$linkurl = new moodle_url('/local/subject/sub_teacherview.php');

$PAGE->set_context($context);
$PAGE->set_url('/local/subject/sub_teacherview.php');
$PAGE->set_heading($linktext);
$PAGE->set_title($linktext);

echo $OUTPUT->header(); 
$current_user_id = $USER->id;
$data = array();
$rec1=$DB->get_records_sql("SELECT {course}.*
FROM {enrol} JOIN {user_enrolments} ON
{user_enrolments}.enrolid = {enrol}.id JOIN {course}
  ON {course}.id = {enrol}.courseid where {user_enrolments}.userid=$current_user_id");
$mustache = new Mustache_Engine();
foreach($rec1 as $record1){
  $id = $record1->id;
  $fullname = $record1->fullname;
  $startdate = $record1->startdate;
  $enddate = $record1->enddate;
  $summary = $record1->summary;
    $data[] = array('id' => $id,'fullname' => $fullname, 'startdate' => $startdate, 'enddate' => $enddate, 'summary' => $summary);
}
//Multi-dimentional array
$subjects = array('sub' => $data);
echo $mustache->render($template,$subjects);
echo $OUTPUT->footer();

  ?>

  
    


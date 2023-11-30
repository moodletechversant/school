<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/subject/template/stud_learning.mustache');

global $class,$CFG;
$context = context_system::instance();
require_login();
// $classid = $class->id;
$linktext = "Subjects";
$linkurl = new moodle_url('/local/subject/student_learningpath.php');

$PAGE->set_context($context);
//$strnewclass= get_string('studentview');

$PAGE->set_url('/local/subject/student_learningpath.php');
$PAGE->set_heading($linktext);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);

echo $OUTPUT->header();
$current_user_id = $USER->id;
// print_r($current_user_id);exit();
// $recs=$DB->get_record_sql("SELECT * FROM {student} WHERE user_id=$current_user_id");
// print_r($recs);exit();

$data = array();
// $rec1=$DB->get_records_sql("SELECT *
// FROM mdl_subject
// JOIN mdl_student_assign ON mdl_subject.sub_class COLLATE utf8mb4_unicode_ci = mdl_student_assign.s_class COLLATE utf8mb4_unicode_ci AND mdl_subject.sub_division COLLATE utf8mb4_unicode_ci = mdl_student_assign.s_division COLLATE utf8mb4_unicode_ci");
$rec1=$DB->get_records_sql("SELECT {course}.*
FROM {enrol} JOIN {user_enrolments} ON
{user_enrolments}.enrolid = {enrol}.id JOIN {course}
  ON {course}.id = {enrol}.courseid where {user_enrolments}.userid=$current_user_id");
//  print_r($rec1);exit();
$mustache = new Mustache_Engine();
foreach($rec1 as $record1){
    $id = $record1->id;
    $fullname = $record1->fullname;
    $startdate = $record1->startdate ;
    $enddate = $record1->enddate;
    $summary = $record1->summary;
    // print_r($courseid);exit();
    // $description = $record1->sub_description;
    $data[] = array('id' => $id,'fullname' => $fullname, 'startdate' => $startdate, 'enddate' => $enddate, 'summary' => $summary);
}
// print_r($data);exit();

//Multi-dimentional array
$subjects = array('sub' => $data);
// print_r($subjects);exit();
echo $mustache->render($template,$subjects);
  ?>
<?php
    echo $OUTPUT->footer();
?>


 
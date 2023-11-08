 
<?php 
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/teacherassign/template/view_learningpath.mustache');


global $class,$CFG, $DB;
$context = context_system::instance();
$linktext = "attendance";
$linkurl = new moodle_url('/local/teacherassign/view_learningpath.php');
$PAGE->set_context($context);
$strnewclass= get_string('studentview');
$PAGE->set_url('/local/teacherassign/view_learningpath.php');
$PAGE->set_title($strnewclass);
$id  = optional_param('id', 0, PARAM_INT);
$sassign = $DB->get_record_sql("SELECT * FROM {student_assign} WHERE user_id=$id");
$div=$sassign->s_division	;
$teacher_id = $USER->id;
echo $OUTPUT->header();
$mustache = new Mustache_Engine();



$subjects = $DB->get_records_sql("SELECT mdl_teacher_assign.* FROM mdl_teacher_assign JOIN mdl_student_assign ON mdl_student_assign.s_division=mdl_teacher_assign.t_division WHERE mdl_teacher_assign.user_id=$teacher_id AND mdl_teacher_assign.t_division=$div");

foreach($subjects as $subject){
  $subjectt=$subject->t_subject;
  
  $subjectss = $DB->get_record_sql("SELECT * FROM {subject} WHERE course_id=$subjectt");

  $options1[] = array('value' => $subjectss->course_id, 'label' => $subjectss->sub_name);

  // print_r($subjectss);exit();
}
$templateData = array(
  'subject_taken' => $options1,
);

$output = $mustache->render($template, ['templateData'=>$templateData,'userid'=>$id]);

echo $output;
echo $OUTPUT->footer();
?>
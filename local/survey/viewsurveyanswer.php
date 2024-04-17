<?php 
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/survey/templates/viewanswer.mustache');

global $class,$CFG, $DB,$SESSION;
$context = context_system::instance();
$linktext = "Survey Answers ";
$linkurl = new moodle_url('/local/survey/templates/viewanswer.mustache');
$css_link=new moodle_url('/local/css/style.css');

$PAGE->set_context($context);
$strnewclass= get_string('studentview');
$PAGE->set_url('/local/survey/viewsurveyanswer.php');
$PAGE->set_heading($linktext);
$PAGE->set_title($strnewclass);

$teacher_id = $USER->id;
echo $OUTPUT->header(); 
$mustache = new Mustache_Engine();
// $school_id  = optional_param('id', 0, PARAM_INT);
$school_id  =$SESSION->schoolid;

$academic = $DB->get_records_sql("SELECT * FROM {academic_year} WHERE school=$school_id");


$options1 = array();
$options1[] = array('value' => '', 'label' => '-- Select Academic Year --');
foreach ($academic as $academic1) {
    $timestart = $academic1->start_year;
    $timestart1 = date("d-m-Y", $timestart);
    $timeend = $academic1->end_year;
    $timeend1 = date("d-m-Y", $timeend);
    $options1[] = array('value' => $academic1->id, 'label' => $timestart1.'--'.$timeend1);
}

$templateData = array(
    'startYearOptions' => $options1,
);

$output = $mustache->render($template, ['templateData'=>$templateData,'css_link'=>$css_link]);

echo $output;

echo $OUTPUT->footer();


?>
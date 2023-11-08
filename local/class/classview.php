<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/class/template/classview.mustache');
global $class,$CFG;
$context = context_system::instance();
// $id = $class->id;

$linkurl = new moodle_url('/local/class/classview.php');
$PAGE->set_context($context);
$strnewclass= get_string('classcreation');
$PAGE->set_url('/local/class/classview.php');

$PAGE->set_title($strnewclass);
echo $OUTPUT->header();

    $mustache = new Mustache_Engine();

    $academic = $DB->get_records('academic_year');
   
    $options1 = array();
    $options1[] = array('value' => '', 'label' => '---- Select academic start year ----');
    foreach ($academic as $academic1) {
        $timestart = $academic1->start_year;
        $timestart1 = date("d-m-Y", $timestart);
        $options1[] = array('value' => $academic1->id, 'label' => $timestart1);
    }
 
    $templateData = array(
        'startYearOptions' => $options1,
        'endYearOptions' => $options2,
    );
    
    $output = $mustache->render($template, ['templateData'=>$templateData]);
    echo $output;
echo $OUTPUT->footer();


?>

<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();
global $DB, $USER,$CFG;
$template = file_get_contents($CFG->dirroot . '/local/enquiry/template/view_enquiry.mustache');



$context = context_system::instance();
require_login();

//$linktext = "enquiry List";

$linkurl = new moodle_url('/local/enquiry/view_enquiry.php');
// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);                                                                  
$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
$PAGE->set_heading($linktext);
$PAGE->navbar->add('enquiry List', new moodle_url($CFG->wwwroot.'/local/enquiry/view_enquiry.php'));

echo $OUTPUT->header();
$mustache = new Mustache_Engine();
$academic = $DB->get_records('academic_year');

$options1 = array();
$options1[] = array('value' => '', 'label' => '---- Select Academic Year----');
foreach ($academic as $academic1) {
    $timestart = $academic1->start_year;
    $timestart1 = date("d/m/Y", $timestart);
    $timeend = $academic1->end_year;
    $timeend1 = date("d/m/Y", $timeend);
    $options1[] = array('value' => $academic1->id, 'label' => $timestart1.'--'.$timeend1);
}

$templateData = array(
    'startYearOptions' => $options1,
);

$output = $mustache->render($template, ['templateData'=>$templateData]);

echo $output;

echo $OUTPUT->footer();
     
?>

<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/enquiryreply/template/view_reply.mustache');

global $class, $CFG;
$context = context_system::instance();
// $classid = $class->id;
$linktext = "Reply Message";

$linkurl = new moodle_url('/local/enquiryreply/view_enqreply.php');
$css_link = new moodle_url('/local/css/style.css');
$view_enquiry = new moodle_url('/local/enquiry/view_enquiry.php');

$PAGE->set_context($context);
//$strnewclass= get_string('studentcreation');

$PAGE->set_url('/local/enquiryreply/view_enqreply.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);

// $PAGE->set_heading($linktext);
//$view_enquiry = '<button style="float:right; margin-right: 20px;margin-bottom:20px; background-color: #0f6cbf; color: white; border: none; border-radius: 5px; padding: 10px 20px;"><a href="/school/local/enquiry/view_enquiry.php" style="text-decoration:none; color:white;"><strong>Add Holiday</strong></a></button>';

echo $OUTPUT->header();
$userid = $USER->id;
$rec = $DB->get_records_sql("SELECT enquiry_id,date,replymsg FROM {enquiryreply} WHERE user_id = ?", array($userid));
$mustache = new Mustache_Engine();


$tableRows = [];

foreach ($rec as $records) {
    $id = $records->id;
    $startdate = $records->date;
    $replymessage = $records->replymsg;


    $tableRows[] = [
        'startDate' => $startdate,
        'message' => $replymessage,
    ];
}

$output = $mustache->render($template, ['tableRows' => $tableRows,'css_link'=>$css_link,'view_enquiry'=>$view_enquiry]);
echo $output;

echo $OUTPUT->footer();
?>


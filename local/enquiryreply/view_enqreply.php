<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/enquiryreply/template/vew_reply.mustache');

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
//$addholiday='<button style="background:transparent;border:none;"><a href="/school/local/holiday/addholiday.php" style="text-decoration:none;"><font size="50px";color="#0f6cbf";>Add Holiday</font></a></button>';
//$addholiday = '<a href="/school/local/holiday/addholiday.php"><i class="fa fa-plus-circle" style="font-size: 50px; color: #0f6cbf;"></i></a>';
//$addholiday = '<a href="/school/local/holiday/addholiday.php" style="text-decoration:none; color:#0f6cbf;"><strong>Add Holiday</strong></a>';
$view_enquiry = '<button style="float:right; margin-right: 20px;margin-bottom:20px; background-color: #0f6cbf; color: white; border: none; border-radius: 5px; padding: 10px 20px;"><a href="/school/local/enquiry/view_enquiry.php" style="text-decoration:none; color:white;"><strong>Add Holiday</strong></a></button>';

echo $OUTPUT->header();
$rec = $DB->get_records_sql("SELECT * FROM {enquiryreply}");
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

$output = $mustache->render($template, ['tableRows' => $tableRows,'css_link'=>$css_link,'addholidayy'=>$addholidayy]);
echo $output;

echo $OUTPUT->footer();
?>

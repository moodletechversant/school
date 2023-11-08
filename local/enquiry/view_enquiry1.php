<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/enquiry/template/view_enquiry1.mustache');

global $DB, $USER, $CFG, $PAGE;

$context = context_system::instance();
require_login();

$linktext = "Enquiry List";

$linkurl = new moodle_url('/local/enquiry/view_enquiry1.php');

$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_title($linktext);

echo $OUTPUT->header();
// $addcomp = '<a href="/school/local/enquiry/enquiry.php" class="ml-auto" style="text-decoration:none">
// <button class="btn-primary btn ml-auto" style="width: auto; margin-right: inherit;">+ ADD NEW</button>
// </a>';

$userid = $USER->id;

$sid = $DB->get_record_sql("SELECT user_id FROM {student} WHERE user_id = ?", array($userid));
$tid = $DB->get_record_sql("SELECT user_id FROM {teacher} WHERE user_id = ?", array($userid));

if (!empty($sid) && $sid->user_id == $userid) {

    //echo ($addcomp);
    $data = $DB->get_records_sql("SELECT * FROM {enquiry} WHERE user_id = ?", array($userid));
    $mustache = new Mustache_Engine();
    // echo $mustache->render($template);

    $tableRows = [];

    foreach ($data as $value) {
        $add = $CFG->wwwroot . '/local/enquiryreply/view_enqreply.php?id=' . $value->id;
        $student = $DB->get_record('student', array('user_id' => $value->user_id));
        $student_name = $student ? $student->s_ftname : 'Unknown';
        $tableRows[] = [
            'date' => $value->date,
            'student_name' => $student_name,
            'subject' => $value->subject,
            'enquiry' => $value->enquiry,
            'viewReplyLink' => html_writer::link($add, $OUTPUT->pix_icon('i/addblock', 'Add', 'moodle'))
       
             ];
    }
}

$output = $mustache->render($template, ['tableRows' => $tableRows]);
    echo $output;
echo $OUTPUT->footer();
?>

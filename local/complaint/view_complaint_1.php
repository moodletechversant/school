<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/complaint/template/viewcomplaint_1.mustache');

global $DB, $USER, $CFG, $PAGE;

$context = context_system::instance();
require_login();

$linktext = "Complaint List";

$linkurl = new moodle_url('/local/complaint/view_complaint_1.php');
$css_link = new moodle_url('/local/css/style.css');

$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_title($linktext);

echo $OUTPUT->header();

$userid = $USER->id;

$sid = $DB->get_record_sql("SELECT user_id FROM {student} WHERE user_id = ?", array($userid));
$tid = $DB->get_record_sql("SELECT user_id FROM {teacher} WHERE user_id = ?", array($userid));

if (!empty($tid) && $tid->user_id == $userid) {
    $data = $DB->get_records_sql("SELECT * FROM {complaint}");
    $mustache = new Mustache_Engine();
    // echo $mustache->render($template);

    $tableRows = [];

    foreach ($data as $value) {
        $add = $CFG->wwwroot . '/school/local/reply/reply.php?id=' . $value->id;
        $student = $DB->get_record('student', array('user_id' => $value->user_id));
        $student_name = $student ? $student->s_ftname : 'Unknown';

        $tableRows[] = [
            'date' => $value->date,
            'student_name' => $student_name,
            'subject' => $value->subject,
            'complaint' => $value->complaint,
            'replyLink' => html_writer::link($add, $OUTPUT->pix_icon('i/addblock', 'Add', 'moodle'))
        ];
    }
} elseif (!empty($sid) && $sid->user_id == $userid) {
    $data = $DB->get_records_sql("SELECT * FROM {complaint} WHERE user_id = ?", array($userid));
    $mustache = new Mustache_Engine();
    // echo $mustache->render($template);

    $tableRows = [];

    foreach ($data as $value) {
        $add = $CFG->wwwroot . '/school/local/reply/view_reply.php?id=' . $value->id;

        $tableRows[] = [
            'date' => $value->date,
            'subject' => $value->subject,
            'complaint' => $value->complaint,
            'viewReplyLink' => html_writer::link($add, $OUTPUT->pix_icon('i/addblock', 'Add', 'moodle'))
        ];
    }
} elseif (is_siteadmin()) {
    $data = $DB->get_records_sql("SELECT * FROM {complaint}");
    $mustache = new Mustache_Engine();
    // echo $mustache->render($template);

    $tableRows = [];

    foreach ($data as $value) {
        $add = $CFG->wwwroot . '/school/local/reply/reply.php?id=' . $value->id;
        $student = $DB->get_record('student', array('user_id' => $value->user_id));
        $student_name = $student ? $student->s_ftname : 'Unknown';

        $tableRows[] = [
            'date' => $value->date,
            'student_name' => $student_name,
            'subject' => $value->subject,
            'complaint' => $value->complaint,
            'replyLink' => html_writer::link($add, $OUTPUT->pix_icon('i/addblock', 'Add', 'moodle'))
        ];
    }
}

$academic = $DB->get_records('academic_year');

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

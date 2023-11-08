<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/complaint/template/viewcomplaint.mustache');

global $DB, $USER, $CFG, $PAGE;

$context = context_system::instance();
require_login();

$linktext = "Complaint List";

$linkurl = new moodle_url('/local/complaint/view_complaint.php');

$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_title($linktext);

echo $OUTPUT->header();
// $addcomp = '<a href="/school/local/complaint/complaint.php" class="ml-auto" style="text-decoration:none">
// <button class="btn-primary btn ml-auto" style="width: auto; margin-right: inherit;">+ ADD NEW</button>
// </a>';

$userid = $USER->id;

$sid = $DB->get_record_sql("SELECT user_id FROM {student} WHERE user_id = ?", array($userid));
$tid = $DB->get_record_sql("SELECT user_id FROM {teacher} WHERE user_id = ?", array($userid));

if (!empty($sid) && $sid->user_id == $userid) {

   // echo ($addcomp);
    $data = $DB->get_records_sql("SELECT * FROM {complaint} WHERE user_id = ?", array($userid));
    $mustache = new Mustache_Engine();
    // echo $mustache->render($template);

    $academic = $DB->get_records('academic_year');
   
    $options1 = array();
    // $options1[] = array('value' => '', 'label' => '---- Select academic start year ----');
    foreach ($academic as $academic1) {
        $timestart = $academic1->start_year;
        $timestart1 = date("Y", $timestart);
       // print_r($timestart1);exit();
      
        $options1[] = array('value' => $academic1->id, 'label' => $timestart1);
    }
    
    $templateData = array(
        'startYearOptions' => $options1,
    );
    
    
    

    $tableRows = [];

    foreach ($data as $value) {
        $add = $CFG->wwwroot . '/local/reply/view_reply.php?id=' . $value->id;
        $student = $DB->get_record('student', array('user_id' => $value->user_id));
        $student_name = $student ? $student->s_ftname : 'Unknown';
        $tableRows[] = [
            'date' => $value->date,
            'student_name' => $student_name,
            'subject' => $value->subject,
            'complaint' => $value->complaint,
            'viewReplyLink' => html_writer::link($add, $OUTPUT->pix_icon('i/addblock', 'Add', 'moodle'))
       
             ];
    }
} 
$output = $mustache->render($template, ['tableRows' => $tableRows ,'templateData' => $templateData]);
    echo $output;
echo $OUTPUT->footer();
?>

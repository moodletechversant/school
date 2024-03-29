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
$css_link = new moodle_url('/local/css/style.css');
$complaint_link = new moodle_url('/local/complaint/complaint.php');
$view_link = new moodle_url('/local/complaint/student_view.php?id');

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
        $id = $value->id;
        $add = $CFG->wwwroot . '/local/reply/view_reply.php?id=' . $value->id;
        $student = $DB->get_record('student', array('user_id' => $value->user_id));
        $student_name = $student ? $student->s_ftname : 'Unknown';
        $view = '<a href="' . $view_link . '=' . $id . '"><button style="font-size: 14px; background-color: #5e4ec2 ; color: white; border: none; padding: 8px 16px; text-align: center; text-decoration: none; display: inline-block; cursor: pointer;">View</button></a>';

             $tableRows[] = [
            'date' => $value->date,
            'student_name' => $student_name,
            'subject' => $value->subject,
           // 'complaint' => $view,
            //'complaint' =>$complaintLink,
            'complaint' => $view,
        ];
    }
} 
$output = $mustache->render($template, ['tableRows' => $tableRows ,'templateData' => $templateData,'css_link'=>$css_link,'complaint_link'=>$complaint_link]);
    echo $output;
echo $OUTPUT->footer();
?>

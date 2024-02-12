<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();


$template = file_get_contents($CFG->dirroot . '/local/complaint/template/parent_view.mustache');

global $DB, $USER, $CFG, $PAGE;

$context = context_system::instance();
require_login();

$linktext = "Complaint List";

$linkurl = new moodle_url('/local/complaint/parent_view.php');
$css_link = new moodle_url('/local/css/style.css');
$complaint_link = new moodle_url('/local/complaint/complaint.php');
$view_link = new moodle_url('/local/complaint/parent_complaint.php?id');

$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_title($linktext);

echo $OUTPUT->header();
// $addcomp = '<a href="/school/local/complaint/complaint.php" class="ml-auto" style="text-decoration:none">
// <button class="btn-primary btn ml-auto" style="width: auto; margin-right: inherit;">+ ADD NEW</button>
// </a>';

$userid = $USER->id;

$pid = $DB->get_record_sql("SELECT user_id FROM {parent} WHERE user_id = ?", array($userid));
// print_r($pid);exit();

if (!empty($pid) && $pid->user_id == $userid) {

   // echo ($addcomp);
    $data = $DB->get_records_sql("SELECT * FROM {complaint} WHERE user_id = ?", array($userid));
    $mustache = new Mustache_Engine();
    // echo $mustache->render($template);
    $tableRows = [];

    foreach ($data as $value) {
        $id = $value->id;
        $add = $CFG->wwwroot . '/local/reply/view_reply.php?id=' . $value->id;
        $parent = $DB->get_record('parent', array('user_id' => $value->user_id));
        $parent_name = $parent ? $parent->firstname : 'Unknown';
        $view = '<a href="' . $view_link . '=' . $id . '"><button style="font-size: 14px; background-color: #5e4ec2 ; color: white; border: none; padding: 8px 16px; text-align: center; text-decoration: none; display: inline-block; cursor: pointer;">View</button></a>';

             $tableRows[] = [
            'date' => $value->date,
            'parent_name' => $parent_name,
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

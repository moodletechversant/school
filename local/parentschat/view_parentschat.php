<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/parentschat/template/viewparentschat.mustache');

global $DB, $USER, $CFG, $PAGE;

$context = context_system::instance();
require_login();

$linktext = "Message List";

$linkurl = new moodle_url('/local/parentschat/view_parentschat.php');
$css_link = new moodle_url('/local/css/style.css');
$parentschat_link= new moodle_url('/local/parentschat/parentschat.php');

$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_title($linktext);

echo $OUTPUT->header();

$userid = $USER->id;

$pid1 = $DB->get_records_sql("SELECT user_id FROM {parent} WHERE user_id = ?", array($userid));
//print_r($pid1 );exit();

$mustache = new Mustache_Engine();
if (!empty($pid) && $pid == $userid) {

    $data = $DB->get_records_sql("SELECT * FROM {parentschat} WHERE pid = ?", array($pid1));
  
    $tableRows = [];

    foreach ($data as $value) {
        $add = $CFG->wwwroot . '/local/reply/view_reply.php?id=' . $value->id;
        
        $tableRows[] = [
            'date' => $value->date,
            'teacher_name' => $value->tid,
            'message' => $value->message,
           
            'viewReplyLink' => html_writer::link($add, $OUTPUT->pix_icon('i/addblock', 'Add', 'moodle'))
        ];
    }
} 

$output = $mustache->render($template, ['tableRows' => $tableRows, 'css_link' => $css_link, 'parentschat_link' => $parentschat_link]);
echo $output;

echo $OUTPUT->footer();
?>







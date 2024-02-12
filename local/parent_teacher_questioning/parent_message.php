

<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/parent_teacher_questioning/template/message_reply.mustache');

global $DB, $USER, $CFG, $PAGE;

$context = context_system::instance();
require_login();

$linktext = "Message List";

$linkurl = new moodle_url('/local/parent_teacher_questioning/view_parentschat.php');
$css_link = new moodle_url('/local/css/style.css');
$parentschat_link= new moodle_url('/local/parent_teacher_questioning/parentschat.php');
$view_message =  new moodle_url('/local/parentschat/message_parent.php');
$mid  = optional_param('id', 0, PARAM_INT);
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_title($linktext);

echo $OUTPUT->header();

$userid = $USER->id;

$pid1 = $DB->get_record_sql("SELECT user_id FROM {parent} WHERE user_id = ?", array($userid));



$mustache = new Mustache_Engine();

    $data = $DB->get_record_sql("SELECT * FROM {parents_enquiry} WHERE id=$mid AND  pid = ?", array($pid1->user_id));
   
//print_r($data);exit();
    $tableRows = [];

    
        $tid1 = $data->tid;
       $msgid=$data->id;
       $reply = $DB->get_record_sql("SELECT * FROM {teacher_reply} WHERE msgid=$msgid");
     

        $tableRows[] = [
            
            'view_message' => $data-> message,
           'reply_message' =>$reply ->replymsg,
            
        ];



$output = $mustache->render($template, ['tableRows' => $tableRows, 'css_link' => $css_link, 'parentschat_link' => $parentschat_link]);
echo $output;

echo $OUTPUT->footer();
?>






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
$view_message =  new moodle_url('/local/parentschat/message_reply.php');

$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_title($linktext);

echo $OUTPUT->header();

$userid = $USER->id;

$pid1 = $DB->get_record_sql("SELECT user_id FROM {parent} WHERE user_id = ?", array($userid));



$mustache = new Mustache_Engine();
if ($pid1->user_id == $userid) {

    $data = $DB->get_records_sql("SELECT * FROM {parentschat} WHERE pid = ?", array($pid1->user_id));
    $tableRows = [];

    foreach ($data as $value) {
        $add = $CFG->wwwroot . '/local/reply/view_reply.php?id=' . $value->id;
        $tid1 = $value->tid;
        $teacher_info = $DB->get_record_sql("SELECT * FROM {teacher} WHERE user_id = ?", array( $tid1));
        $teachername = $teacher_info->t_fname . ' ' . $teacher_info->t_mname . ' ' . $teacher_info->t_lname;
        $tableRows[] = [
            'date' => $value->date,
            'teacher_name' =>$teachername ,


            'view_message' =>  $view_message,
           
            
        ];
    }
} 

$output = $mustache->render($template, ['tableRows' => $tableRows, 'css_link' => $css_link, 'parentschat_link' => $parentschat_link]);
echo $output;

echo $OUTPUT->footer();
?>




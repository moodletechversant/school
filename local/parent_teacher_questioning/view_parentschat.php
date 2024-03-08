

<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/parent_teacher_questioning/template/viewparentschat.mustache');

global $DB, $USER, $CFG, $PAGE;

$context = context_system::instance();
require_login();

$linktext = "Message List";

$linkurl = new moodle_url('/local/parent_teacher_questioning/view_parentschat.php');
$css_link = new moodle_url('/local/css/style.css');
$parentschat_link= new moodle_url('/local/parent_teacher_questioning/parentschat.php');
$view_message =  new moodle_url('/local/parent_teacher_questioning/parent_message.php?id');

$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_title($linktext);

echo $OUTPUT->header();

$userid = $USER->id;

$pid1 = $DB->get_record_sql("SELECT user_id FROM {parent} WHERE user_id = ?", array($userid));



$mustache = new Mustache_Engine();
if ($pid1->user_id == $userid) {

    $data = $DB->get_records_sql("SELECT * FROM {parents_enquiry} WHERE pid = ?", array($pid1->user_id));
    $tableRows = [];

    foreach ($data as $value) {
        $tid1 = $value->id;
        $tid_name = $value->tid;
        $teacher_info = $DB->get_record_sql("SELECT * FROM {teacher} WHERE user_id = ?", array( $tid_name));
        $teachername = $teacher_info->t_fname . ' ' . $teacher_info->t_mname . ' ' . $teacher_info->t_lname;
        $tableRows[] = [
          'tid' =>  $tid1,
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




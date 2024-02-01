

<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/parentschat/template/viewteacherchat_1.mustache');

global $DB, $USER, $CFG, $PAGE;

$context = context_system::instance();
require_login();

$linktext = "Message List";

$linkurl = new moodle_url('/local/parentschat/view_teacherchat_1.php');
$css_link = new moodle_url('/local/css/style.css');
$view_message =  new moodle_url('/local/parentschat/reply_teacher.php?id');
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_title($linktext);

echo $OUTPUT->header();

$userid = $USER->id;

$tid = $DB->get_record_sql("SELECT user_id FROM {teacher} WHERE user_id = ?", array($userid));

if ($tid->user_id == $userid) {
    $data = $DB->get_records_sql("SELECT * FROM {parentschat} WHERE tid = ?", array($tid->user_id));


// print_r($data->pid);exit();
    $mustache = new Mustache_Engine();
    // echo $mustache->render($template);

    $tableRows = [];

    foreach ($data as $value) {
     //   firstname lastname middlename

        $data2 = $DB->get_record_sql("SELECT * FROM {parent} WHERE user_id = ?", array($value->pid));
        

        $student_info = $DB->get_record_sql("SELECT * FROM {student} WHERE user_id = ?", array( $data2->child_id));
      
        $studentname = $student_info->s_ftname . ' ' . $student_info->s_mlname . ' ' . $student_info->s_lsname;
         
        $parent_info = $DB->get_record_sql("SELECT * FROM {user} WHERE id = ?", array( $data2->user_id));
        $parentname = $parent_info->firstname . ' ' .$parent_info->middlename . ' ' .  $parent_info->lastname;
        //print_r(   $parentname   );exit();

        $tableRows[] = [
            'pid' =>  $value->id,
            'tid' =>  $userid,

            'date' => $value->date,

            'student_name' => $studentname,
            'parent_name' => $parentname,
            
            'view message' => $view_message
        ];
    }
} 


$output = $mustache->render($template, ['tableRows' => $tableRows, 'css_link' => $css_link, 'view_message' => $view_message]);

echo $output;

echo $OUTPUT->footer();
?>

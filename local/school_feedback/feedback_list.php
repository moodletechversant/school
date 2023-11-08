<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/school_feedback/template/feedback_list.mustache');
global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;
//$linktext = "Feedbacks";

$linkurl = new moodle_url('/local/school_feedback/feedback_list.php');

$PAGE->set_context($context);
//$strnewclass= get_string('studentcreation');

$PAGE->set_url('/local/school_feedback/feedback_list.php');
//$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
//$PAGE->set_heading($SITE->fullname);
//$addstudent='<button style="background:transparent;border:none;margin-bottom:20px;"><a href="/school/local/createstudent/createstudent.php" style="text-decoration:none;"><font size="50px";color="#0f6cbf";>+</font></a></button>';

echo $OUTPUT->header();
$mustache = new Mustache_Engine();
echo $mustache->render($template);
$rec = $DB->get_records_sql("SELECT sf.*, u.username
FROM {school_feedback1} sf
JOIN {user} u ON u.id = sf.user_id
");
    $table = new html_table();
    // echo $addstudent;
    $table->head = array("Name","Message");
    foreach ($rec as $records) {
       
       
       $id = $records->id; 
       $name1 = $records->username;
       $message = $records->feedback;
      
    
      //$edit='<button class="edit-button" style="border-radius: 5px; padding: 4px 18px;background-color: #0055ff;"><a href="/school/local/createstudent/editstudent.php?id='.$id.'" style="text-decoration:none;color: white; ">Edit</a></button>';
     // $delete='<button class="delete-button" style="border-radius: 5px; padding: 4px 20px;background-color: #0055ff;"><a href="/school/local/createstudent/deletestudent.php?id='.$id.'" style="text-decoration:none;color: white; ">Delete</a></button>';
        $table->data[] = array($name1,$message);
    }
    // <input type="submit" name="edit" value="edit">
    echo html_writer::table($table);
echo $OUTPUT->footer();


?>
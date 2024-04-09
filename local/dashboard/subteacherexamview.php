<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/dashboard/templates/subteacherview.mustache');

global $USER;

$context = context_system::instance();
require_login();
$userid = $USER->id;
$current_date = time();
// print_r($current_date);exit();

// Correct the navbar .
// Set the name for the page.
$linktext = "View Upcoming Exams";
//$linktext = get_string('plugin','new_plugin');
// Set the url.
// $linkurl = new moodle_url('/local/subject/viewsubject.php');
$css_link = new moodle_url('/local/css/style.css');
$back=new moodle_url('/local/dashboard/upcoming.php');
// Print the page header.
$PAGE->set_context($context);
//$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
// $PAGE->set_heading($linktext);
$PAGE->navbar->add('Upcoming Exam', new moodle_url($CFG->wwwroot.'local/dashboard/view_upcoming_exams.php'));

echo $OUTPUT->header();

// $sql = "SELECT s.*
//         FROM {subject} s
//         JOIN {division} d ON s.sub_division = d.id
//         JOIN {class} c ON d.div_class = c.id
//         JOIN {academic_year} a ON c.academic_id = a.id
//         WHERE d.div_teacherid = :userid
//         AND a.start_year >= :current_date";
//     $subjects = $DB->get_records_sql($sql, ['userid' => $userid,'current_date' => $current_date]);
$sql = "SELECT c.*
        FROM {class} c
        JOIN {division} d ON c.id = d.div_class
        JOIN {teacher_assign} ta ON d.id = ta.t_division
        JOIN {academic_year} a ON c.academic_id = a.id
        WHERE ta.user_id = :userid
        AND a.start_year >= :current_date";

$classes = $DB->get_records_sql($sql, ['userid' => $userid, 'current_date' => $current_date]);

//print_r($classes);exit();
$mustache = new Mustache_Engine();

//$academic = $DB->get_records('academic_year');
   
$options1 = array();
$options1[] = array('value' => '', 'label' => '---- Select Class ----');
foreach ($classes as $classes1) {
    $class_name= $classes1->class_name;
    $options1[] = array('value' => $classes1->id, 'label' => $class_name, 'user_id' => $userid);
}
    //print_r($options1);exit();

$templateData = array(
    'classOptions' => $options1,
    'userId' => $userid ,// Pass the user ID to the template data

);

$output = $mustache->render($template, ['templateData'=>$templateData,'css_link'=>$css_link,'back'=>$back]);
echo $output;
echo $OUTPUT->footer();
?>

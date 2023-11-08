<?php

require(__DIR__.'/../../config.php');

global $DB, $USER;

$context = context_system::instance();
require_login();

$linktext = "Upcoming Exams";

$linkurl = new moodle_url('/local/dashboard/upcomingexams.php');
// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);                                                                  
$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
$PAGE->set_heading($linktext);
$PAGE->navbar->add('Upcoming Exams', new moodle_url($CFG->wwwroot.'/local/dashboard/upcomingexams.php'));

echo $OUTPUT->header();
$userid = $USER->id;
$current_date = time();
$enrolled_courses = enrol_get_users_courses($userid);
//print_r($enrolled_courses);exit();
$enrolled_course_ids = array();
foreach ($enrolled_courses as $enrolled_course) {
    $enrolled_course_ids[] = $enrolled_course->id;
}

if (empty($enrolled_course_ids)) {
    echo "You are not enrolled in any courses.";
} else {
    $in_clause = implode(',', array_fill(0, count($enrolled_course_ids), '?'));
    $params = array_merge($enrolled_course_ids, array($current_date));
    //print_r($params);exit();

    $data = $DB->get_records_sql("SELECT * FROM {quiz} WHERE course IN ($in_clause) AND timeclose >= ?", $params);
    //print_r($data);exit();
    if (empty($data)) {
        echo "There are no upcoming exams for your enrolled courses.";
    } 
    else{
    $table = new html_table();
    $table->head = array('timeopen','timeclose', 'Quiz name');
    $table->data = array();
    $table->class = '';
    $table->id = 'quiz';
    $context = context_user::instance($USER->id, MUST_EXIST);

    foreach ($data as $value) {
        // $add = $CFG->wwwroot.'/local/reply/view_reply.php?id='.$value->id;//Add icon
        // $edit = $CFG->wwwroot.'/local/complaint/edit.php?id='.$value->id;//Edit
        // $delete = $CFG->wwwroot.'/local/complaint/delete.php?id='.$value->id;//Delete
        $dates1=date('d/m/Y',$value->timeopen);
        $dates=date('d/m/Y',$value->timeclose);
        $table->data[] = array(
            $dates1,
            $dates,
            $value->name,
           
            // html_writer::link($add, $OUTPUT->pix_icon('i/addblock','Add','moodle')), // Add icon
            // html_writer::link($edit, $OUTPUT->pix_icon('i/edit', 'Edit me', 'moodle')), // Edit icon
            // html_writer::link($delete, $OUTPUT->pix_icon('i/delete','Delete me','moodle')), // Delete icon
        ); 
    }

    echo html_writer::table($table);
    $backurl = new moodle_url('/local/dashboard/dashboard.php');
    $backbutton = html_writer::link($backurl, 'Back');
    echo $backbutton;
}
}
echo $OUTPUT->footer();

?>

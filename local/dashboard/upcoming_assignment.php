<?php

require(__DIR__.'/../../config.php');

global $DB, $USER;

$context = context_system::instance();
require_login();

$linktext = "Upcoming Assignment";

$linkurl = new moodle_url('/local/dashboard/upcoming_assignment.php');
// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);                                                                  
$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
$PAGE->set_heading($linktext);
$PAGE->navbar->add('Upcoming Assignmnet', new moodle_url($CFG->wwwroot.'/local/dashboard/upcoming_assignment.php'));

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

    $data = $DB->get_records_sql("SELECT * FROM {assign} WHERE course IN ($in_clause) AND duedate >= ?", $params);
    if (empty($data)) {
        echo "There are no upcoming assignment for your enrolled courses.";
    } 
    else{
    $table = new html_table();
    $table->head = array('Submission Date','Due date', 'Assignment name');
    $table->data = array();
    $table->class = '';
    $table->id = 'asssign_list';
    $context = context_user::instance($USER->id, MUST_EXIST);

    foreach ($data as $value) {
       // Get the course module ID from the current row of data (assuming $value is an object)
       $cmid = $value->id;

       // Load the course module record from the database
       $cm = get_coursemodule_from_instance('assign', $cmid, 0, false, MUST_EXIST);
       
       // Construct the URL for the assignment view page using the course module ID
       $view = $CFG->wwwroot.'/mod/assign/view.php?id='.$cm->id;

       

       
        // $edit = $CFG->wwwroot.'/local/complaint/edit.php?id='.$value->id;//Edit
        // $delete = $CFG->wwwroot.'/local/complaint/delete.php?id='.$value->id;//Delete
        $dates1=date('m/d/Y',$value->allowsubmissionsfromdate);
        $dates=date('m/d/Y',$value->duedate);
        $table->data[] = array(
            $dates1,
            $dates,
            $value->name,
            //<i class="fa-solid fa-eye"></i>
            //$html = html_writer::link($add, $OUTPUT->pix_icon('i/view','View','moodle'));

            // html_writer::link($add, $OUTPUT->pix_icon('i/eye','View','moodle')), // Add icon
            // html_writer::link($edit, $OUTPUT->pix_icon('i/edit', 'Edit me', 'moodle')), // Edit icon
         html_writer::link( $view, $OUTPUT->pix_icon('t/eye',get_string('view'))), // Delete icon

    
        

        ); 
    }
   // echo $view_icon;
    echo html_writer::table($table);
    $backurl = new moodle_url('/local/dashboard/dashboard.php');
    $backbutton = html_writer::link($backurl, '< Back');
    echo $backbutton;
}
}
echo $OUTPUT->footer();

?>
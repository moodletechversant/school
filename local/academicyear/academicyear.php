<?php
require(__DIR__.'/../../config.php');
require_once($CFG->dirroot.'/local/academicyear/academicyear_form.php');
global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;

$linkurl = new moodle_url('/local/academicyear/academicyear.php');
$PAGE->set_context($context);
$strnewclass= get_string('classcreation');
$PAGE->set_url('/local/academicyear/academicyear.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
// $PAGE->set_heading($SITE->fullname);
$mform=new academicyear_form();
echo $OUTPUT->header();

$returnurl = $CFG->wwwroot.'/local/dashboard/dashboardadmin.php';
if ($mform->is_cancelled()) {
    redirect($returnurl);
} 
else if ($formdata = $mform->get_data()) {
    
    $academicdata= new stdclass();
   
    $academicdata->start_year=$formdata->timestart;
    $academicdata->end_year=$formdata->timefinish;
    $DB->insert_record('academic_year',$academicdata);
    $urlto=$CFG->wwwroot.'/local/academicyear/viewacademicyear.php';
    redirect($urlto, 'Data Saved Successfully '); 
  

}
$mform->display();
echo $OUTPUT->footer();
  
   
?>

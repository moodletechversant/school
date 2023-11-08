<?php
require(__DIR__.'/../../config.php');
require_once($CFG->dirroot.'/local/school_feedback/s_feedback_form.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/school_feedback/template/feedbackform.mustache');
global $class,$CFG,$USER;
$context = context_system::instance();
// $classid = $class->id;

$linkurl = new moodle_url('/local/school_feedback/s_feedback.php');
$PAGE->set_context($context);
//$strnewclass= "Feedback";
$PAGE->set_url('/local/school_feedback/s_feedback.php');
//$PAGE->set_pagelayout('admin');
//$PAGE->set_title($strnewclass);
//$PAGE->set_heading($strnewclass);
$mform=new s_feedback_form();
echo $OUTPUT->header();
$mustache = new Mustache_Engine();
echo $mustache->render($template);
$returnurl = $CFG->wwwroot.'/local/school_feedback/s_feedback.php';
if ($mform->is_cancelled()) {
    redirect($returnurl);
} 
else if ($formdata = $mform->get_data()) {
    
    $feedback_data = new stdClass();
    
    $user_id = $USER->id;
    $user_record = $DB->get_record('user', array('id' => $user_id));
    $feedback_data->user_id = $user_id; 
    //print_r($user_record);exit();
    //$feedback_data->quality_score = $formdata->quality;
    //print_r($feedback_data->quality_score);exit();
    $feedback_data->feedback = $formdata->message; 
    //print_r($feedback_data);exit();
    $DB->insert_record('school_feedback1',$feedback_data);
    $urlto = $CFG->wwwroot.'/local/school_feedback/s_feedback.php';
    redirect($urlto, 'Data Saved Successfully '); 
  

}
$mform->display();
echo $OUTPUT->footer();
  
   
?>
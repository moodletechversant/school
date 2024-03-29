<?php
require(__DIR__.'/../../config.php');
require_once($CFG->dirroot.'/local/complaint/complaint_form.php');
require_login();
global $class,$CFG,$USER;
$context = context_system::instance();
// $classid = $class->id;

$linkurl = new moodle_url('/local/complaint/complaint.php');
$PAGE->set_context($context);
$strnewclass= "Complaint";
$PAGE->set_url('/local/complaint/complaint.php');
//$PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
$mform=new complaint_form();
echo $OUTPUT->header();

$returnurl = $CFG->wwwroot.'/local/complaint/view_complaint.php';
if ($mform->is_cancelled()) {
    redirect($returnurl);
} 
else if ($formdata = $mform->get_data()) {
    
    $complaintdata = new stdClass();
    $current_date = date('Y-m-d');
    $complaintdata->date = $current_date;

    $user_id = $USER->id;
    $sid = $DB->get_record_sql("SELECT user_id FROM {student} WHERE user_id = ?", array($user_id));
    $pid = $DB->get_record_sql("SELECT user_id FROM {parent} WHERE user_id = ?", array($user_id));
    //print_r($pid);exit();
    if ($sid) {
        // User is a student
        $urlto = $CFG->wwwroot.'/local/complaint/view_complaint.php';
    } elseif ($pid) {
        // User is a parent
        $urlto = $CFG->wwwroot.'/local/complaint/parent_view.php';
    } else {
        // User is neither a student nor a parent, handle this case as needed
        // For example, redirect to an error page or display an error message
        redirect($returnurl, 'Error: User not recognized.');
        exit;
    }
    $user_record = $DB->get_record('user', array('id' => $user_id));
    $complaintdata->user_id = $user_id; 
    //print_r($user_record);exit();
    $complaintdata->subject = $formdata->csubject;
    $complaintdata->complaint = $formdata->cmessage;    

    $DB->insert_record('complaint',$complaintdata);
    

   // $urlto = $CFG->wwwroot.'/local/complaint/view_complaint.php';
    redirect($urlto, 'Data Saved Successfully '); 
  

}
$mform->display();
echo $OUTPUT->footer();
  
   
?>



<style>
    .container{
        padding-left : 20%;
        padding-top : 50px;
        padding-bottom : 50px;
        background-color : #72aacf;  
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.7);      
    }
    .heading{
        font-family : "Times New Roman", Times, serif;

    }
    .form-class{
        font-weight : bold; 
    }
    .form-control{
        border-radius : 15px;
        background-color : #FFFFFF;

    }
    .form-control:focus{
        background-color : #CAE9F5;
        box-shadow : none;
    }
    
    .custom-select{
        border-radius : 15px;
    }
    .custom-select:focus{
        background-color : #CAE9F5;
        box-shadow : none;
    }
    /* .btn{
        background-color : black;
    } */
    .fa-calendar{
        color : black;
    }  
    .btn-primary{
        background-color : #000000de;
        border-color : black;
        border-radius : 15px;
    }
    .btn-primary:hover{
        background-color : black;
        border-color : black;
        border-radius : 15px;
    }
    .btn-primary:focus{
        background-color : black;
        border-color : black;
        border-radius : 15px;
    }
    .btn-primary:not(:disabled):not(.disabled):active, .btn-primary:not(:disabled):not(.disabled).active, .show>.btn-primary.dropdown-toggle {
    color: #fff;
    background-color: black;
    border-color: black;
    }
    .btn-secondary{
        border-radius : 15px;
    }
    .fdescription{
        display : none;
    }
    .footer-content-debugging{
        display : none;
    }


    </style>
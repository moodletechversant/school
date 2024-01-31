<?php
require(__DIR__.'/../../config.php');
require_once($CFG->dirroot.'/local/reply/reply_form.php');
global $class,$CFG,$USER;
$context = context_system::instance();
// $classid = $class->id;

$linkurl = new moodle_url('/local/reply/reply.php');
$PAGE->set_context($context);
$strnewclass= "Reply";
$PAGE->set_url('/local/reply/reply.php');
//$PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
// $PAGE->set_heading($strnewclass);
$mform=new reply_form();
echo $OUTPUT->header();

$returnurl = $CFG->wwwroot.'/local/complaint/view_complaint_1.php';
if ($mform->is_cancelled()) {
    redirect($returnurl);
} 
else if ($formdata = $mform->get_data()) {
    
    $replydata = new stdClass();
    $current_date = date('Y-m-d');
    $replydata->date = $current_date;
    
    $replydata->user_id =$id->user_id;

    $user_id = $USER->id;
    //print_r($user_id);exit();

    // $user_record = $DB->get_record('complaint', array('id' => $user_id));
    // $replydata->user_id = $user_record->user_id; 

    // print_r($replydata->user_id);exit();
    $replydata->complaint_id = $formdata->id; 
    //print_r($replydata->complaint_id);exit();
    $var1= $replydata->complaint_id;
    $user_record = $DB->get_record('complaint', array('id' => $var1));
    //print_r($user_record);exit();

    $replydata->user_id = $user_record ->user_id; 
    //print_r($replydata->user_id);exit();
    $var2= $replydata->user_id;
    // print_r($var2);exit();
    $user_record2 = $DB->get_record('complaint', array('user_id' => $var2));
    //print_r($user_record2);exit();
    $replydata->replymsg = $formdata->creplay;    
    //print_r($replydata->replymsg);exit();

    $DB->insert_record('reply',$replydata);
    $urlto = $CFG->wwwroot.'/local/complaint/view_complaint_1.php';
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
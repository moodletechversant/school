<?php
require(__DIR__.'/../../config.php');
require_once($CFG->dirroot.'/local/parentschat/parentschat_form.php');
global $class,$CFG,$USER;
$context = context_system::instance();
// $classid = $class->id;

$linkurl = new moodle_url('/local/parentschat/parentschat.php');
$PAGE->set_context($context);
$strnewclass= "Chat";
$PAGE->set_url('/local/parentschat/parentschat.php');
//$PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
$mform=new parentschat_form();
echo $OUTPUT->header();

$returnurl = $CFG->wwwroot.'/local/parentschat/view_parentschat.php';
if ($mform->is_cancelled()) {
    redirect($returnurl);
} 
else if ($formdata = $mform->get_data()) {
    
    $parentschatdata = new stdClass();
    $current_date = date('Y-m-d');
    $parentschatdata->date = $current_date;

    $user_id = $USER->id;
    $user_record = $DB->get_record('user', array('id' => $user_id));
    $parentschatdata->user_id = $user_id; 
    //print_r($user_record);exit();
    $parentschatdata->subject = $formdata->csubject;
    $parentschatdata->parentschat = $formdata->cmessage;    

    $DB->insert_record('parentschat',$parentschatdata);
    $urlto = $CFG->wwwroot.'/local/parentschat/view_parentschat.php';
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
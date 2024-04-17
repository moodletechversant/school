<?php
require(__DIR__.'/../../config.php');
require_once($CFG->dirroot.'/local/adminreg/admin_registration_form.php');
global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;

$linkurl = new moodle_url('/local/adminreg/admin_registration.php');
$PAGE->set_context($context);
$strnewclass= get_string('classcreation');
$PAGE->set_url('/local/adminreg/admin_registration.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
// $PAGE->set_heading($SITE->fullname);
$mform=new admin_registration_form();
echo $OUTPUT->header();

$returnurl = $CFG->wwwroot.'/local/dashboard/dashboardadmin.php';
if ($mform->is_cancelled()) {
    redirect($returnurl);
} 
else if ($formdata = $mform->get_data()) {
   
    
    $admindata= new stdclass();
    $admindata->name=$formdata->name;
    $admindata->username=$formdata->username;
    $admindata->email=$formdata->email; 
    $admindata->password=$formdata->password;
    $admindata->number=$formdata->number;
    $admindata->school=$formdata->school;

    $userdata= new stdclass();
    $userdata->confirmed = 1;
    $userdata->mnethostid = $CFG->mnet_localhost_id;
    $userdata->firstname=$formdata->name;
    $userdata->username=$formdata->username;
    $userdata->email=$formdata->email; 
    $userdata->password=$formdata->password;
    $userdata->phone1=$formdata->number;


    user_create_user($userdata);
    //print_r($parentdata->firstname);exit();
    $id1= $DB->get_record_sql('SELECT id FROM mdl_user ORDER BY id DESC LIMIT 1');
    $admindata->userid=$id1->id;

    $DB->insert_record('admin_registration',$admindata);
    $urlto=$CFG->wwwroot.'/local/adminreg/admin_registration.php';
    redirect($urlto, 'Data Saved Successfully '); 
  

}
$mform->display();
echo '<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>';
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

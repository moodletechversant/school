<?php

require(__DIR__.'/../../config.php');

require_once($CFG->dirroot.'/local/schoolreg/schoolreg_form.php');

global $USER;

$context = context_system::instance();
require_login();
//1234

// Correct the navbar .
// Set the name for the page.
$linktext = "School";
//$linktext = get_string('plugin','new_plugin');
// Set the url.
$linkurl = new moodle_url('/local/schoolreg/schoolreg.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
//$PAGE->set_heading($linktext);
$PAGE->navbar->add('School', new moodle_url($CFG->wwwroot.'/local/schoolreg/schoolreg.php'));

echo $OUTPUT->header();
$mform = new subject_form();

if($mform->is_cancelled()){
    $cancelurl = $CFG->wwwroot.'/local/dashboard/dashboardadmin.php';
    redirect($cancelurl);
}else if($formdata = $mform->get_data()){ 
// print_r($formdata->division);
// exit;
   $schooldata =  new stdclass();
   
    $schooldata->sch_name  = $formdata->schoolname;
    $schooldata->sch_shortname = $formdata->shortname;
    $schooldata->sch_address = $formdata->address;
    $schooldata->sch_district = $formdata->district;
    $schooldata->sch_state = $formdata->state;
    $schooldata->sch_pincode = $formdata->pincode;

    $schooldata->sch_phone = $formdata->phone;
    $schooldata->sch_logo = $formdata->logo;

    //$schooldata->sch_teachername = $formdata->teachname;
 
 
    $DB->insert_record('school_reg',  $schooldata);
    $urlto = $CFG->wwwroot.'/local/schoolreg/schoolreg.php';
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
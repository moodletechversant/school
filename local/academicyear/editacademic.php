<?php

require(__DIR__.'/../../config.php');

require_once($CFG->dirroot.'/local/academicyear/editacademic_form.php');
global $USER ,$DB;

$context = context_system::instance();
require_login();


// Correct the navbar .
// Set the name for the page.
$linktext = "Academic Year creation";
//$linktext = get_string('plugin','new_plugin');
// Set the url.
$linkurl = new moodle_url('/local/academicyear/editacademic.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
// $PAGE->set_heading($linktext);
$PAGE->navbar->add('Academic year  Details', new moodle_url($CFG->wwwroot.'/local/academicyear/editacademic.php'));

echo $OUTPUT->header();
$mform = new editacademic_form();

if($mform->is_cancelled()){
    $cancelurl = $CFG->wwwroot.'/local/academicyear/viewacademicyear.php';
    redirect($cancelurl);
}else if($formdata = $mform->get_data()){ 

    $academicdata =  new stdclass();
    $academicdata->id = $formdata->id; 
    $academicdata->start_year=$formdata->timestart;
    $academicdata->end_year=$formdata->timefinish;
    $academicdata->vacation_s_year=$formdata->vacationstart;
    $academicdata->vacation_e_year=$formdata->vacationend;
    $academicdata->school=$formdata->school_id;

//left table fieldname right file fieldname 

$DB->update_record('academic_year',$academicdata);
$urlto = $CFG->wwwroot.'/local/academicyear/viewacademicyear.php?id='.$formdata->school_id;
redirect($urlto, 'Data Saved Successfully ', 8); 

exit();
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
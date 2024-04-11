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

        $start_year = $formdata->timestart;
        $end_year = $formdata->timefinish;
        $vacation_start_year = $formdata->vacationstart;
        $vacation_end_year = $formdata->vacationend;
        $school = $formdata->school_id;

        // Check if end year is greater than start year
        if ($end_year > $start_year) {
            $academicdata = new stdClass();
            $academicdata->start_year = $start_year;
            $academicdata->end_year = $end_year;
            $academicdata->vacation_s_year = $vacation_start_year;
            $academicdata->vacation_e_year  =  $vacation_end_year;
            $academicdata->school = $school;
            
          
            // Insert record into the 'academic_year' table
            $DB->insert_record('academic_year', $academicdata);
            
            $urlto = $CFG->wwwroot.'/local/academicyear/viewacademicyear.php?id='.$formdata->school_id;
            redirect($urlto, 'Data Saved Successfully '); 
        } else {
            
            echo "End year must be greater than start year.";
        }
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
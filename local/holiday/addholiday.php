<?php
require(__DIR__.'/../../config.php');
require_once($CFG->dirroot.'/local/holiday/addholiday_form.php');
global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;

$linkurl = new moodle_url('/local/holiday/addholiday.php');
$PAGE->set_context($context);
$strnewclass= "Add Holiday";
$PAGE->set_url('/local/holiday/addholiday.php');
//$PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
//$PAGE->set_heading($strnewclass);
$mform=new addholiday_form();
echo $OUTPUT->header();

$returnurl = $CFG->wwwroot.'/local/dashboard/dashboardadmin.php';
if ($mform->is_cancelled()) {
    redirect($returnurl);
} 
else if ($formdata = $mform->get_data()) {
    
    $holidaydata = new stdClass();
    
    $holidaydata->academic_id = $formdata->academic;

    $holidaydata->from_date = $formdata->fromdate;
    $holidaydata->to_date = $formdata->todate;
    $holidaydata->holiday_name = $formdata->holidayname;


    $DB->insert_record('addholiday',$holidaydata);
    $urlto = $CFG->wwwroot.'/local/holiday/view_holiday.php';
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
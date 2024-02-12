<?php
require(__DIR__.'/../../config.php');
require_once($CFG->dirroot.'/local/enquiryreply/enquiryreply_form.php');
global $class, $CFG, $USER;

$context = context_system::instance();
$linkurl = new moodle_url('/local/enquiryreply/enquiryreply.php');
$PAGE->set_context($context);
$PAGE->set_url('/local/enquiryreply/enquiryreply.php');
$mform = new enquiryreply_form();
echo $OUTPUT->header();

$returnurl = $CFG->wwwroot.'/local/enquiry/view_enquiry.php';

if ($mform->is_cancelled()) {
    redirect($returnurl);
} elseif ($formdata = $mform->get_data()) {
    $replydata = new stdClass();
    $current_date = date('Y-m-d');
    $replydata->date = $current_date;
    $replydata->enquiry_id = $formdata->id;
    $replydata->replymsg = $formdata->ereply;

    // Fetch 'user_id' from the 'enquiry' table
    $enquiry_record = $DB->get_record('enquiry', array('id' => $replydata->enquiry_id));
    if ($enquiry_record) {
        $replydata->user_id = $enquiry_record->user_id;
    } else {
        $message = 'No Data Found';
    }

    // Check if the enquiryreply table already contains a record for the specified enquiry ID
    $existing_record = $DB->get_record('enquiryreply', array('enquiry_id' => $replydata->enquiry_id));

    if ($existing_record) {
        // If record exists, update the reply message
        $replydata->id = $existing_record->id; // Add the 'id' field for update
        $DB->update_record('enquiryreply', $replydata);
        $message = 'Data Updated Successfully';
    } else {
        // If record does not exist, insert a new record
        $DB->insert_record('enquiryreply', $replydata);
        $message = 'Data Saved Successfully';
    }

    $urlto = $CFG->wwwroot.'/local/enquiry/view_enquiry.php';
    redirect($urlto, $message);
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
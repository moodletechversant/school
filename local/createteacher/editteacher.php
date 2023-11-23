<?php

require(__DIR__.'/../../config.php');

require_once($CFG->dirroot.'/local/createteacher/editteacher_form.php');

global $DB,$USER;

$context = context_system::instance();
require_login();


// Correct the navbar .
// Set the name for the page.
$linktext = "Teacher";
//$linktext = get_string('plugin','new_plugin');
// Set the url.
$linkurl = new moodle_url('/local/createteacher/editteacher.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl); 
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
// $PAGE->set_heading($linktext);
$PAGE->navbar->add('Teacher', new moodle_url($CFG->wwwroot.'/local/createteacher/editteacher.php'));

echo $OUTPUT->header();
$mform = new editteacher_form ();

if($mform->is_cancelled()){
    $cancelurl = $CFG->wwwroot.'/local/createteacher/view_teacher.php';
    redirect($cancelurl);
}else if($formdata = $mform->get_data()){ 
//print_r($formdata);exit();
     $tchrdata =  new stdClass();
    $tchrdata->id=$formdata->id;
    $tchrdata->t_fname=$formdata->fstname;
    $tchrdata->t_mname=$formdata->midlname;
    $tchrdata->t_lname=$formdata->lsname;
    $tchrdata->t_username=$formdata->username;
    $tchrdata->t_email=$formdata->email;
    $tchrdata->t_password=$formdata->password;
    $tchrdata->t_dob=$formdata->dob;
    $tchrdata->t_address=$formdata->address;
    $tchrdata-> t_mno=$formdata->no;
    $tchrdata->t_bloodgrp=$formdata->bg;
    $tchrdata->t_qlificatn=$formdata->qln;
    $tchrdata->t_exp=$formdata->exp;
    $tchrdata->t_gender=$formdata->gender;
    $tchrdata->t_district=$formdata->district;

##moodle user creation
    $id= $DB->get_record_sql("SELECT user_id FROM mdl_teacher WHERE id= '$tchrdata->id'");
    //  print_r($id);   
    //  exit();
    $user = new stdClass();
    $user->confirmed = 1;
    $user->id=$id->user_id;
    // $user->id=15;
    $user->mnethostid = $CFG->mnet_localhost_id;
    $user->username =$formdata->username;
    $user->firstname = $formdata->fstname;
    $user->lastname = $formdata->lsname;
    $user->email = $formdata->email;;
    $user->password = $formdata->password;
    $user->phone1=$formdata->no;
    $user->address=$formdata->address;
    $user->middlename=$formdata->midlname;
    


    user_update_user($user);
 

    $update=$DB->update_record('teacher',$tchrdata);


     $urlto = $CFG->wwwroot.'/local/createteacher/view_teacher.php';
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
    
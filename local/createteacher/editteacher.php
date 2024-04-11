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


     $urlto = $CFG->wwwroot.'/local/createteacher/view_teacher.php?id='.$formdata->school_id;
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
       
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $('input[name="fstname"],input[name="midlname"],input[name="lsname"],input[name="fname"],input[name="mname"],input[name="gname"]').blur(function() {


var currVal = $(this).val();
$(this).val(currVal.charAt(0).toUpperCase() + currVal.slice(1).toLowerCase());


});

//text full lowercase
$('input[name="username"]').blur(function() {
var currVal = $(this).val();
$(this).val(currVal.toLowerCase());

});
//Validation for Qulaification
// Assuming you have jQuery loaded
// $('input[name="qln"]').blur(function() {
//     var currVal = $(this).val();

//     // Check if the entered value is numeric
//     if ($.isNumeric(currVal)) {
//         alert('Invalid input. Please enter text only.');
//         // You can also clear the input or take other actions as needed
//         $(this).val('');
//     }
// });
$('input[name="qln"]').on("keydown", function(event){
  // Allow controls such as backspace, tab etc.
  var allowedKeys = [8, 9, 16, 17, 20, 35, 36, 37, 38, 39, 40, 45, 46,191,190,188];

  // Allow letters
  for(var i = 65; i <= 90; i++){
    allowedKeys.push(i);
  }

  // Prevent default if not in the allowed keys array or if it's a number
  if(jQuery.inArray(event.which, allowedKeys) === -1 || (event.which >= 48 && event.which <= 57)){
    event.preventDefault();
  }
});


//only alphabets
$('input[name="fstname"],input[name="midlname"],input[name="lsname"]').on("keydown", function(event){
// Allow controls such as backspace, tab etc.
var arr = [8,9,16,17,20,35,36,37,38,39,40,45,46];

// Allow letters
for(var i = 65; i <= 90; i++){
  arr.push(i);
}

// Prevent default if not in array
if(jQuery.inArray(event.which, arr) === -1){
  event.preventDefault();
}


});


//only numeric value
$('input[name="fno"],input[name="mno"],input[name="gno"],input[name="no"]').keypress
(
function(event)
{
    if (event.keyCode == 46 || event.keyCode == 8)
    {
    //do nothing
    }
    else 
    {
        if (event.keyCode < 48 || event.keyCode > 57 ) 
        {
            event.preventDefault();	
        }	
    }
}
);
$(document).ready(function() {
    $('#id_error_gender_male').remove();
    $('#id_error_gender_female').remove();

    $('#id_gender_female, #id_gender_male, #id_gender_others').on('change', function() {
        if ($('#id_gender_female, #id_gender_male, #id_gender_others').length > 0) {
            // $('#id_error_gender_others').remove();
        }
    });
});
</script>

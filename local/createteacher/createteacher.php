<?php
require(__DIR__.'/../../config.php');
require_once($CFG->dirroot.'/local/createteacher/createteacher_form.php');
global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;

$linkurl = new moodle_url('/local/createteacher/createteacher.php');
$PAGE->set_context($context);
$strnewclass= get_string('teachercreation');
$PAGE->set_url('/local/createteacher/createteacher.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
// $PAGE->set_heading($SITE->fullname);
$mform=new createteacher_form();
echo $OUTPUT->header();

$returnurl = $CFG->wwwroot.'/local/dashboard/dashboardadmin.php';
if ($mform->is_cancelled()) {
    redirect($returnurl);
} 
else if ($formdata = $mform->get_data()) {
   
    $tchrdata= new stdclass();
    
    $tchrdata->t_fname=$formdata->fstname;
    $tchrdata->t_mname=$formdata->midlname;
    $tchrdata->t_lname=$formdata->lsname;
    $tchrdata->t_username=$formdata->username;
    $tchrdata->t_email=$formdata->email;
    $tchrdata->t_password=password_hash('password',PASSWORD_DEFAULT);
    $tchrdata->t_dob=$formdata->dob;
    $tchrdata->t_address=$formdata->address;
    $tchrdata-> t_mno=$formdata->no;
    // $tchrdata->t_fname=$formdata->fname;
    // $tchrdata->t_mname=$formdata->mname;
    $tchrdata->t_bloodgrp=$formdata->bg;
    $tchrdata->t_qlificatn=$formdata->qln;
    $tchrdata->t_exp=$formdata->exp;
    $tchrdata->t_gender=$formdata->gender;
    $tchrdata->t_district=$formdata->district;
    $tchrdata->school_id=$formdata->school_id;
   
    //print_r($tchrdata);exit();

    $user = new stdClass();
    $user->confirmed = 1;
    $user->mnethostid = $CFG->mnet_localhost_id;
    $user->username =$formdata->username;
    $user->firstname = $formdata->fstname;
    $user->lastname = $formdata->lsname;
    $user->email = $formdata->email;;
    $user->password = $formdata->password;
    $user->phone1=$formdata->no;
    $user->address=$formdata->address;
    $user->middlename=$formdata->midlname;
    // Create the user account.
    // $user = 
    user_create_user($user);
    $id= $DB->get_record_sql('SELECT id FROM mdl_user ORDER BY id DESC LIMIT 1');
  //  print_r($id);
  //   exit();
    $tchrdata->user_id =$id->id;
    $DB->insert_record('teacher',$tchrdata);
    $urlto = $CFG->wwwroot.'/local/createteacher/createteacher.php';
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

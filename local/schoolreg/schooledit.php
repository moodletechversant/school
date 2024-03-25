<?php

require(__DIR__.'/../../config.php');

require_once($CFG->dirroot.'/local/schoolreg/schooledit_form.php');

global $DB,$USER;

$context = context_system::instance();
require_login();


// Correct the navbar .
// Set the name for the page.
$linktext = "School";
//$linktext = get_string('plugin','new_plugin');
// Set the url.
$linkurl = new moodle_url('/local/schoolreg/schooledit.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
// $PAGE->set_heading($linktext);
$PAGE->navbar->add('School', new moodle_url($CFG->wwwroot.'/local/schoolreg/schooledit.php'));

echo $OUTPUT->header();
$id  = optional_param('id', 0, PARAM_INT);
$editdata=$DB->get_record('school_reg',array('id'=>$id));

$mform = new editstudent_form ();

if($mform->is_cancelled()){
    $cancelurl = $CFG->wwwroot.'/local/schoolreg/viewschools.php';
    redirect($cancelurl);
}else if($formdata = $mform->get_data()){ 
//print_r($formdata);exit();
      $stddata =  new stdclass();

     $stddata->id=$formdata->id;
          $schooldata->sch_name  = $formdata->schoolname;
            $schooldata->sch_shortname = $formdata->shortname;
            $schooldata->sch_address = $formdata->address;
            $schooldata->sch_district = $formdata->district;
            $schooldata->sch_state = $formdata->state;
            $schooldata->sch_pincode = $formdata->pincode;
        
            $schooldata->sch_phone = $formdata->phone;
            $schooldata->sch_logo = $formdata->logo;
    
   
        $update = $DB->update_record('school_reg', $stddata);
        
    
     
     $urlto = $CFG->wwwroot.'/local/createstudent/view_student_1.php';
     redirect($urlto, 'Data Saved Successfully '); 

}


$mform->display();
echo '<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>';

echo $OUTPUT->footer();

?>
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
$('input[name="fno"],input[name="mno"],input[name="gno"]').keypress
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

    ///---------------------------------------------/////
    $(document).ready(function() {
    $("#id_academicyear").change(function() {
    var brand_id = $(this).val();
    if(brand_id != ""){
        $.ajax({
            url:"test.php",
            data:{b_id:brand_id},
            type:'POST',
            success: function(data){
        	$("#id_class").html(data);
        	}
        });
    }
    
   
});
});

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
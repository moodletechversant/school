<?php

require(__DIR__.'/../../config.php');

require_once($CFG->dirroot.'/local/clsteacherassign/assignclsteacher_form.php');

global $USER,$SESSION;

$context = context_system::instance();
require_login();


// Correct the navbar .
// Set the name for the page.
$linktext = "Assign Class Teacher";
//$linktext = get_string('plugin','new_plugin');
// Set the url.
$linkurl = new moodle_url('/local/clsteacherassign/assignclsteacher.php');
// $school_id= optional_param('id', 0, PARAM_INT);   
$school_id  =$SESSION->schoolid;

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
//$PAGE->set_heading($linktext);
$PAGE->navbar->add('Teacher', new moodle_url($CFG->wwwroot.'/local/clsteacherassign/assignclsteacher.php'));

echo $OUTPUT->header();
$mform = new assignclsteacher_form();

if($mform->is_cancelled()){
    $cancelurl = $CFG->wwwroot.'/local/dashboard/dashboardadmin.php';
    redirect($cancelurl);
}else if($formdata = $mform->get_data()){ 
    // print_r($formdata);exit();
     $div_teacherid = $formdata->teacher;
     $var1=$formdata->class;
     $var2=$formdata->division;
     $DB->execute("UPDATE mdl_division SET div_teacherid=$div_teacherid WHERE div_class = $var1 AND id =$var2");
     $urlto = $CFG->wwwroot.'/local/clsteacherassign/assignclsteacher.php';
     redirect($urlto, 'Data Saved Successfully '); 

}



$mform->display();
echo '<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>';
echo $OUTPUT->footer();

?>

<script>

/*Script for making first character uppercase*/

// function changeTheText(string) {
// 	string = string.toLowerCase();
//     return string.charAt(0).toUpperCase() + string.slice(1);
// }

jQuery('input').on('mouseout', function() {
			jQuery(this).val(changeTheText(jQuery(this).val()));
});

$(document).ready(function() {
    $("#id_academic").change(function() {
    var brand_id = $(this).val();
    if(brand_id != ""){
        $.ajax({
            url:"test.php",
            data:{e_id:brand_id},
            type:'POST',
            success: function(data){
        	$("#id_class").html(data);
        	}
        });
    }
    
   
});
});

$(document).ready(function() {
    $("#id_class").change(function() {
    var brand_id = $(this).val();
    if(brand_id != ""){
        $.ajax({
            url:"test.php",
            data:{b_id:brand_id},
            type:'POST',
            success: function(data){
        	$("#id_division").html(data);
        	}
        });
    }
    
   
});
});
// $(document).ready(function() {
//     $("#id_division").change(function() {
//     var brand_id = $(this).val();
//     if(brand_id != ""){
//         $.ajax({
//             url:"test.php",
//             data:{t_id:brand_id},
//             type:'POST',
//             success: function(data){
//         	$("#id_teacher").html(data);
//         	}
//         });
//     }
    
   
// });
// });

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
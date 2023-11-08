<?php

require(__DIR__.'/../../config.php');
require_once($CFG->dirroot . '/user/lib.php');
require_once($CFG->dirroot.'/local/teacherassign/teacherassign_form.php');
require_once($CFG->libdir . '/enrollib.php');
require_once($CFG->dirroot . '/enrol/locallib.php');

// Load the necessary Moodle libraries
require_once($CFG->dirroot.'/enrol/manual/locallib.php');
// require_once($CFG->dirroot . '/lib.php');

global $USER;

$context = context_system::instance();
require_login();
$linktext = "Assign Teacher";
//$linktext = get_string('plugin','new_plugin');
$linkurl = new moodle_url('/local/teacherassign/teacherassign.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
// $PAGE->set_heading($linktext);
//$PAGE->navbar->add('Teacher', new moodle_url($CFG->wwwroot.'/local/teacherassign/teacherassign_form.php'));

echo $OUTPUT->header();
$mform = new teacherassign_form();

if($mform->is_cancelled()){
    $cancelurl = $CFG->wwwroot.'/local/dashboard/dashboardadmin.php';
    redirect($cancelurl);
}  
else if($formdata = $mform->get_data()){ 

     $teacherassign =  new stdclass();
     $teacherassign->t_class  = $formdata->class;
     $teacherassign->t_division = $formdata->division;
     $teacherassign->t_subject = $formdata->subject;
 
     $teacherassign->user_id  = $formdata->teacher;

     $class_ids = $DB->get_record_sql("SELECT * FROM {class} WHERE id =$formdata->class");
     $academic_ids = $DB->get_record_sql("SELECT * FROM {academic_year} WHERE id =$class_ids->academic_id");


        $role_id=3;
        // $class=$teacherassign->t_class; 
        // $class_ids= $DB->get_record_sql("SELECT * FROM mdl_class WHERE id='$class'");
        $timestart= $academic_ids->start_year;
        $timeend=$academic_ids->end_year;
        $userId=$formdata->teacher;
        $manual = enrol_get_plugin('manual');
        
        if ($manual) { 
            $course_id =$formdata->subject;;
        // get all enrolment instnace avaialable in course

            if ($instances = enrol_get_instances($course_id, false)) {
                foreach ($instances as $instance) {
                    if ($instance->enrol === 'manual') {

                        break;
                    }
                }
            }
        }
        if(!$instance){

            // if course does not have manual enrolment instnace  added, then add one
            $instance =  $manual->add_instance($course_id);
            }

            if ($manual && $instance) {
            
            // manual enrolment is enabled at system level and enrollment instnace is available in course
            //  pass enrolinstnace,
            //  user id
            //  role id [get from role table] to enrol with role
            //  start time of enrolment and endtime of enrolment
            
                $manual->enrol_user($instance, $userId, $role_id, $timestart, $timeend, ENROL_USER_ACTIVE);
            
                $status = true;
            }
            
            


     $DB->insert_record('teacher_assign',$teacherassign);
     $urlto = $CFG->wwwroot.'/local/teacherassign/teacherassign.php';
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

<script>

/*Script for making first character uppercase*/

function changeTheText(string) {
	string = string.toLowerCase();
    return string.charAt(0).toUpperCase() + string.slice(1);
}

jQuery('input').on('mouseout', function() {
			jQuery(this).val(changeTheText(jQuery(this).val()));
});

$(document).ready(function() {
    $("#id_academicyear").change(function() {
    var brand_id = $(this).val();
    if(brand_id != ""){
        $.ajax({
            url:"test.php",
            data:{a_id:brand_id},
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
            data:{c_id:brand_id},
            type:'POST',
            success: function(data){
        	$("#id_division").html(data);
        	}
        });
    }
    
   
});
});

$(document).ready(function() {

    $("#id_division").change(function() {
        var brand_id = $(this).val();
        if(brand_id != ""){
            $.ajax({
                url:"test1.php",
                data:{b_id:brand_id},
                type:'POST',
                success: function(data){
                $("#id_subject").html(data);
                }
            });
        } 
    });
});

$(document).ready(function() {

$("#id_subject").change(function() {
    var brand_id = $(this).val();
    if(brand_id != ""){
        $.ajax({
            url:"test3.php",
            data:{b_id:brand_id},
            type:'POST',
            success: function(data){
            $("#id_teacher").html(data);
            }
        });
    } 
});
});


</script>
<?php

require(__DIR__.'/../../config.php');
require_once($CFG->dirroot . '/user/lib.php');
require_once($CFG->dirroot.'/local/studentassign/assign_student_form.php');
require_once($CFG->libdir . '/enrollib.php');
require_once($CFG->dirroot . '/enrol/locallib.php');

// Load the necessary Moodle libraries
require_once($CFG->dirroot.'/enrol/manual/locallib.php');
// require_once($CFG->dirroot . '/lib.php');

global $USER;

$context = context_system::instance();
require_login();


// Correct the navbar .
// Set the name for the page.
$linktext = "Assign Student";
//$linktext = get_string('plugin','new_plugin');
// Set the url.
$linkurl = new moodle_url('/local/studentassign/assign_student.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
// $PAGE->set_heading($linktext);
$PAGE->navbar->add('Student', new moodle_url($CFG->wwwroot.'/local/studentassign/assign_student.php'));

echo $OUTPUT->header();
$mform = new assign_student_form();

if($mform->is_cancelled()){
    $cancelurl = $CFG->wwwroot.'/my';
    redirect($cancelurl);
}
    
else if($formdata = $mform->get_data()){ 
    // print_r($formdata->student );exit();

    //  $id= $DB->get_record_sql("SELECT user_id FROM mdl_student WHERE id='$formdata->student'");
     $studentassgn =  new stdclass();
     $studentassgn->s_class  = $formdata->class;
     $studentassgn->s_division = $formdata->division;
     // Loop through each student and insert a separate record for each
     foreach ($formdata->student as $studentId) {
        $userIds = $studentId;
        $studentassgn->user_id = $studentId;
        
        // Perform the enrolment for the current student
        // $course_ids = $DB->get_records_sql("SELECT course_id FROM {subject} WHERE sub_division = :division", array('division' => $studentassgn->s_division));
        $course_ids = $DB->get_records_sql("SELECT course_id FROM {subject} WHERE sub_division = $studentassgn->s_division");
        $course_idss = $DB->get_record_sql("SELECT sub_class FROM {subject} WHERE sub_division = $studentassgn->s_division");
        $class = $course_idss->sub_class;

        // $class = $studentassgn->s_class; 
        $class_ids = $DB->get_record_sql("SELECT * FROM {class} WHERE id = $class");
        $academic_ids = $DB->get_record_sql("SELECT * FROM {academic_year} WHERE id =$class_ids->academic_id");
        

        // MOODLE USER ENROLMENT
        $manual = enrol_get_plugin('manual');
        $role_id = 5;
        $timestart =$academic_ids->start_year;
        $timeend = $academic_ids->end_year;

        foreach ($course_ids as $course) {
            $course_id = $course->course_id;

            // print_r($course_id);exit();
            if ($manual) { 
                // get all enrolment instances available in the course
                if ($instances = enrol_get_instances($course_id, false)) {
                    foreach ($instances as $instance) {
                        if ($instance->enrol === 'manual') {
                            break;
                        }
                    }
                }
            }

            if (!$instance) {
                // if the course does not have a manual enrolment instance added, then add one
                $instance = $manual->add_instance($course_id);
            }

            if ($manual && $instance) {
                // manual enrolment is enabled at the system level and an enrollment instance is available in the course
                // enroll the user with the role, start time, and end time
                $manual->enrol_user($instance, $userIds, $role_id, $timestart, $timeend, ENROL_USER_ACTIVE);
                $status = true;
            }
        }  

        // Insert the record for the current student
        $DB->insert_record('student_assign', $studentassgn);
    }

     $urlto = $CFG->wwwroot.'/local/studentassign/assign_student.php';
     redirect($urlto, 'Data Saved Successfully '); 

}

$mform->display();
echo '<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>';
echo $OUTPUT->footer();
?>
<script>

/*Script for making first character uppercase*/

function changeTheText(string) {
	string = string.toLowerCase();
    return string.charAt(0).toUpperCase() + string.slice(1);
}

jQuery('input').on('mouseout', function() {
			jQuery(this).val(changeTheText(jQuery(this).val()));
});

/*Script for entering only alphabetic characters*/

// $('input[name="subname"]').bind('keyup blur', function() { 
//     $(this).val(function(i, val) {
//         return val.replace(/[^a-z\s]/gi,''); 
//     });
// });

$('input[name="subname"]').on("keydown", function(event){
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
    $("#id_class").change(function() {
    var brand_id = $(this).val();
    if(brand_id != ""){
        $.ajax({
            url:"test.php",
            data:{s_id:brand_id},
            type:'POST',
            success: function(data){
        	$("#id_student").html(data);
        	}
        });
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
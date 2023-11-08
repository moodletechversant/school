<?php

require(__DIR__.'/../../config.php');

require_once($CFG->dirroot.'/local/subject/editsubject_form.php');

global $DB,$USER;

$context = context_system::instance();
require_login();


// Correct the navbar .
// Set the name for the page.
$linktext = "Subject";
//$linktext = get_string('plugin','new_plugin');
// Set the url.
$linkurl = new moodle_url('/local/subject/editsubject.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
//$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
//$PAGE->set_heading($linktext);
$PAGE->navbar->add('Subject', new moodle_url($CFG->wwwroot.'/local/subject/editsubject.php'));

echo $OUTPUT->header();
$mform = new editsubject_form();

if($mform->is_cancelled()){
    $cancelurl = $CFG->wwwroot.'/local/subject/viewsubject.php';
    redirect($cancelurl);
}else if($formdata = $mform->get_data()){ 
//print_r($formdata);exit();
     $subjectdata =  new stdclass();

     $subjectdata->id  = $formdata->id;
     $subjectdata->sub_class  = $formdata->class;
     $subjectdata->sub_division = $formdata->division;
     $subjectdata->sub_name = $formdata->subname;
     $subjectdata->sub_shortname = $formdata->shortname;
     $subjectdata->sub_description = $formdata->description;
    //   $var=$formdata->id;
    //   print_r($var);
    //   exit;

//MOODLE COURSE CREATION******************************

        // $defaultcategory = $DB->get_field_select('course_categories', 'MIN(id)', 'parent = 0');
        $id= $DB->get_record_sql("SELECT course_id FROM mdl_subject WHERE id= '$subjectdata->id'");
        // print_r($id);
        //   exit;
        $course = new stdClass();
        $course->id =$id->course_id;
        $course->fullname =$formdata->subname;
        // $course->shortname =  $formdata->shortname;
        // $course->idnumber = '12';
        $course->summary = $formdata->description;
        // $course->summaryformat = FORMAT_PLAIN;
        // $course->format = 'topics';
        // $course->newsitems = 0;
        // $course->numsections = 5;
        // $course->category = $defaultcategory;
        // $created = create_course($course);
        // Ensure the checks only work on idnumber/shortname that are not already ours.
        update_course($course);

        
         $update=$DB->update_record('subject',$subjectdata);


     $urlto = $CFG->wwwroot.'/local/subject/viewsubject.php';
     redirect($urlto, 'Data Saved Successfully '); 

}


$mform->display();

echo '<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>';
echo $OUTPUT->footer();

?>

<script>
     ///---------------------------------------------/////
 $(document).ready(function() {
    $("#academicyear").change(function() {
    var brand_id = $(this).val();
    if(brand_id != ""){
        $.ajax({
            url:"test.php",
            data:{b_id:brand_id},
            type:'POST',
            success: function(data){
        	$("#class").html(data);
        	}
        });
    }
    
   
});
});

//--------------------------------------------/////
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
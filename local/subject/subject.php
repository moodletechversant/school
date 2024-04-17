<?php

require(__DIR__.'/../../config.php');

require_once($CFG->dirroot.'/local/subject/subject_form.php');

global $USER;

$context = context_system::instance();
require_login();
//1234

// Correct the navbar .
// Set the name for the page.
$linktext = "Subject";
//$linktext = get_string('plugin','new_plugin');
// Set the url.
$linkurl = new moodle_url('/local/subject/subject.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
//$PAGE->set_heading($linktext);
$PAGE->navbar->add('Subject', new moodle_url($CFG->wwwroot.'/local/subject/subject.php'));

echo $OUTPUT->header();
$mform = new subject_form();

if($mform->is_cancelled()){
    $cancelurl = $CFG->wwwroot.'/local/dashboard/dashboardadmin.php';
    redirect($cancelurl);
}else if($formdata = $mform->get_data()){ 
// print_r($formdata->division);
// exit;
    $subjectdata =  new stdclass();
    $academic  = $formdata->academic;
     $subjectdata->sub_class  = $formdata->class;
     $subjectdata->sub_division = $formdata->division;
     $subjectdata->sub_name = $formdata->subname;
     $subjectdata->sub_shortname = $formdata->shortname;
     $subjectdata->sub_description = $formdata->description;
    // $subjectdata->sub_teachername = $formdata->teachname;
    $classdate= $DB->get_record_sql("SELECT * FROM {academic_year} WHERE id=$academic");

// moodle course creation///////////////////
    // $this->resetAfterTest();

    $defaultcategory = $DB->get_field_select('course_categories', "MIN(id)", "parent=0");

    $course = new stdClass();
    $course->fullname = $formdata->subname;
    // $course->shortname =  $formdata->subname;
    // $course->shortname =  $formdata->shortname;
    // $course->idnumber = '123';
    $course->summary = $formdata->description;
    $course->summaryformat = 1;
    $course->newsitems=5;
    $course->format = 'topics';
    $course->startdate=$classdate->start_year;
    $course->enddate=$classdate->end_year;
    $course->enablecompletion = 1;
    $course->showactivitydates = 1;
    $course->newsitems = 0;
    $course->category = $defaultcategory;
    $original = (array) $course;

    // $created = 
    create_course($course);
    $id= $DB->get_record_sql('SELECT id FROM mdl_course ORDER BY id DESC LIMIT 1');
  //  print_r($id);
  //   exit;
    $subjectdata->course_id =$id->id;
 
    $DB->insert_record('subject',$subjectdata);
    $urlto = $CFG->wwwroot.'/local/subject/subject.php';
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

  $('#id_class').prop('disabled', true);
  $('#id_division').prop('disabled', true);
 ///---------------------------------------------/////
 $(document).ready(function() {
    $("#id_academic").change(function() {
    var brand_id = $(this).val();
    if(brand_id != ""){
        $.ajax({
            url:"test.php",
            data:{b_id:brand_id},
            type:'POST',
            success: function(data){
                $('#id_class').prop('disabled', false);
        	$("#id_class").html(data);
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
            data:{c_id:brand_id},
            type:'POST',
            success: function(data){
                $('#id_division').prop('disabled', false);
        	$("#id_division").html(data);
        	}
        });
    }
    
   
});
});

//   $("#id_class").on("change", function() {
//    var classes = $('#id_class').find(":selected").val()
// // alert(classes)
//                     jQuery.ajax({
//                                     url: 'test.php',
//                                     type: 'POST',
//                                     data: {classes:classes},
                                    
//                                     success: function(data) 
//                                     {
//                                       $('#id_division').html('');
//                                      var array = data.split(',');
                                        
//                                       // for(var i = 0; i < array.length; i++) {
//                                       //         $('#id_division').append('<option value='.array[i].'>'+array[i]+'</option>');
//                                       //       }
                                       

//                                     }
//                                })


// })

            
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
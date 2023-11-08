<?php
require(__DIR__.'/../../config.php');
require_once($CFG->dirroot.'/local/class/class_creation_form.php');
global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;

$linkurl = new moodle_url('/local/class/class_creation.php');
$PAGE->set_context($context);
$strnewclass= get_string('classcreation');
$PAGE->set_url('/local/class/class_creation.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
// $PAGE->set_heading($SITE->fullname);
$mform=new class_creation_form();
echo $OUTPUT->header();

$returnurl = $CFG->wwwroot.'/local/dashboard/dashboardadmin.php';
if ($mform->is_cancelled()) {
    redirect($returnurl);
} 
else if ($formdata = $mform->get_data()) {
   
    
    $classdata= new stdclass();
    $classdata->class_name=$formdata->name;
    
    $classdata->academic_id=$formdata->academicyear;
    $classdata->class_description=$formdata->description;
    $DB->insert_record('class',$classdata);
    $urlto=$CFG->wwwroot.'/local/class/class_creation.php';
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
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
        	$("#id_academicyear1").html(data);
        	}
        });
    }
    
   
});
});

</script>

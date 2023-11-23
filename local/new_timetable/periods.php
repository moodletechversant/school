<?php

require(__DIR__.'/../../config.php');

require_once($CFG->dirroot.'/local/new_timetable/periods_form.php');


global $USER;

$context = context_system::instance();
require_login();

// Set the name for the page.
$linktext = "Time table";
// Set the url.
$linkurl = new moodle_url('/local/new_timetable/periods.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
// $PAGE->set_heading($linktext);
$PAGE->navbar->add('Time table', new moodle_url($CFG->wwwroot.'/local/new_timetable/periods.php'));

echo $OUTPUT->header();
$mform = new periods_form();

if($mform->is_cancelled()){
    $cancelurl = $CFG->wwwroot.'/my';
    redirect($cancelurl);
}else if($formdata = $mform->get_data()){ 
 //print_r($formdata);
// exit;
$existing_record = $DB->get_record('new_timetable_periods', array(
    't_day' => $formdata->day,
));

if ($existing_record) {
    // Record already exists for the same class, division, and day.
    // You can handle the overlap as needed.
    echo '<script>alert("Timetable for this day already exists.");</script>';
} else {
    $periodsdata =  new stdclass();
    $periodsdata->t_class  = $formdata->class;
    $periodsdata->t_division = $formdata->division;
    $periodsdata->t_day = $formdata->day;
    $periodsdata->t_periods = $formdata->periods;
     
    $DB->insert_record('new_timetable_periods',$periodsdata);
  
    redirect($CFG->wwwroot.'/local/new_timetable/timetable.php');
    //redirect($urlto); 
}
}

$mform->display();
echo '<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>';
echo $OUTPUT->footer();

?>
<!-- <style>
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
    </style> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<script>

$(document).ready(function() {
  $('#id_division').empty()
  $("#id_class").prepend("<option value='' selected='selected'>none</option>");

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




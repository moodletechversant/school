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
    't_class' => $formdata->class,
    't_division' => $formdata->division,
    't_day' => $formdata->day,
));

if ($existing_record) {
    echo '<script>alert("Timetable for this day already exists.");</script>';
} else {
    $periodsdata =  new stdclass();
    $periodsdata->t_class  = $formdata->class;
    $periodsdata->t_division = $formdata->division;
    $periodsdata->t_day = $formdata->day;
    $periodsdata->t_periods = $formdata->periods;
    // $var1=$_POST['fromtime_1'];
    //  print_r( $var1);exit();
    $DB->insert_record('new_timetable_periods',$periodsdata);
    $period_id= $DB->get_record_sql('SELECT id FROM {new_timetable_periods} ORDER BY id DESC LIMIT 1');
    
    if (isset($_POST['submitbutton'])) {
                $num_periods = $formdata->periods;
                // Create an empty array to store timetable data objects
                $timetabledata_array = array(); 
                //print_r($num_periods);exit;
                for ($i = 1; $i <= $num_periods; $i++) {
                    $timetabledata =  new stdclass();
                    // Combine the selected values into a single string
                    $timetabledata->period_id=$period_id->id;
                    $timetabledata->from_time =strtotime($_POST["fromtime_$i"]);
                    $timetabledata->to_time = strtotime($_POST["totime_$i"]);
                    $timetabledata->t_subject = $_POST["subject_$i"];
                    $timetabledata->t_teacher = $_POST["teacher_$i"];
                    if (!empty($_POST["break_$i"])){
                        $timetabledata->break_type = $_POST["break_$i"];
                        $timetabledata->break_ftime = strtotime($_POST["break_fromtime_$i"]);
                        $timetabledata->break_ttime = strtotime($_POST["break_totime_$i"]);
                    }
                     else{
                        $timetabledata->break_type = '0';
                        $timetabledata->break_ftime = null;
                        $timetabledata->break_ttime = null;
                    }
                
                    $timetabledata_array[] = $timetabledata; 
                    $DB->insert_record('new_timetable',$timetabledata);
                }

    }

    redirect($CFG->wwwroot.'/local/new_timetable/periods.php');
    //redirect($urlto); 
}
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
    /*
    .break_visibility_class{
        display:none;
    }*/

    </style>
    

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
$(document).ready(function() {
    break_button_id="null"
    $('#id_class').empty().prepend("<option value='' selected='selected'>none</option>");
    $("#id_academic").prepend("<option value='' selected='selected' disabled>---Select academic year---</option>");
    $("#id_academic").change(function() {
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

  $('#id_division').empty().prepend("<option value='' selected='selected'>none</option>");
  //$("#id_class").prepend("<option value='' selected='selected'>none</option>");
    $("#id_class").change(function() {
        console.log("the value "+$("#id_class").val())
        if($("#id_class").val()!=""){
            $('#id_periods').removeAttr('disabled');
            $('#id_periods').val("")
            $('#id_periods').trigger('keyup')
        }
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
/**get number of field based on the period  */
$(document).on('click','.class_period',function(){ 
    //alert("test")
    $(this).closest('.cls_break').css("display", "block");
});


 $('#id_periods').keyup(function(){

        var period = $(this).val();
        var division_id=$("#id_division").val();
        // alert(classed);exit();
        $.ajax({
            url: 'ajax_page_periods.php',
            method: 'POST', // or 'GET'
            data: { period: period,division:division_id },
            success: function(data){
                // $("#periods_details").html('');
                $("#periods_details").html(data);
                // $('#message').text(response); // Display the response message
            },
            error: function(xhr, status, error){
                console.error(xhr.responseText);
            }
        });
    });

    $('#periods_details').on('click', '.break_button_class', function() {
       
        break_button_id = $(this).attr('id')
        
        break_dropdown_id = $(this).next().attr('id');
        $('#'+break_dropdown_id).css("display","block")
    })
    
    $("#"+break_button_id).click(function(){
        $('#'+break_dropdown_id).css("display","none")
    })

});

</script>


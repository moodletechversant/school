<?php

require(__DIR__.'/../../config.php');

require_once($CFG->dirroot.'/local/new_timetable/timetable_form.php');

global $USER;

$context = context_system::instance();
require_login();


// Correct the navbar .
// Set the name for the page.
$linktext = "Time table";
//$linktext = get_string('plugin','new_plugin');
// Set the url.
$linkurl = new moodle_url('/local/new_timetable/timetable.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
$PAGE->set_heading($linktext);
$PAGE->navbar->add('Time table', new moodle_url($CFG->wwwroot.'/local/new_timetable/timetable.php'));

echo $OUTPUT->header();
$mform = new timetable_form();

if($mform->is_cancelled()){
    $cancelurl = $CFG->wwwroot.'/local/new_timetable/admin_view_1.php';
    redirect($cancelurl);
}else if($formdata = $mform->get_data()){ 
//  print_r($formdata);exit;
  
$num_periods = $formdata->last_period;
// Create an empty array to store timetable data objects
$timetabledata_array = array(); 
//print_r($num_periods);exit;
for ($i = 1; $i <= $num_periods; $i++) {
    $timetabledata =  new stdclass();
     // Combine the selected values into a single string
    
     $timetabledata->from_time = $formdata->{"fromtime_$i"};
     $timetabledata->to_time = $formdata->{"totime_$i"};
     $timetabledata->t_subject = $formdata->{"subject_$i"};
     $timetabledata->t_teacher = $formdata->{"teacher_$i"};
      $id= $DB->get_record_sql('SELECT id,t_day FROM mdl_new_timetable_periods ORDER BY id DESC LIMIT 1');
      $timetabledata->period_id =$id->id;
      $timetabledata->days_id =$id->t_day;
      if (!empty($formdata->{"break_$i"})) {
       $timetabledata->break_type = $formdata->{"break_$i"};
       $timetabledata->break_ftime = $formdata->{"b_fromtime_$i"};
       $timetabledata->break_ttime = $formdata->{"b_totime_$i"};
  }     
  else{
    $timetabledata->break_type = '0';
    $timetabledata->break_ftime = null;
    $timetabledata->break_ttime = null;
  }
  
     $timetabledata_array[] = $timetabledata; 
      }
      // print_r($timetabledata_array[0]->break_type);exit;
      // print_r($timetabledata_array);exit();
      $DB->insert_records('new_timetable',$timetabledata_array);

      //print_r($timetabledata_array);exit();
      $urlto = $CFG->wwwroot.'/local/new_timetable/periods.php';
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<script>

$(document).ready(function() {
  $('#id_division').empty();
  $("#id_class").prepend("<option value='' selected='selected'>none</option>");

  <?php 
  for ($i = 1; $i <= 1000; $i++) { ?>
    $("#id_subject_<?php echo $i; ?>").change(function() {

      var brand_id = $(this).val();
      if (brand_id != "") {
        //alert(brand_id);
        $.ajax({
          url: "test1.php",
          data: { b_id: brand_id },
          type: 'POST',
          success: function(data) {
           // alert(b_id);
            $("#id_teacher_<?php echo $i; ?>").html(data);
          }
        });
      }
    });
  <?php } ?>
});
//Function for reset the values if 'remove break' button is clicked
function resetBreak(id) {
        var breakType = document.getElementById('id_break_' + id);
        var fromTime = document.getElementById('id_b_fromtime_' + id);
        //var fromAMPM = document.getElementById('id_b_fromampm_' + id);
        var toTime = document.getElementById('id_b_totime_' + id);
       // var toAMPM = document.getElementById('id_b_toampm_' + id);

        breakType.selectedIndex = 0;
        fromTime.selectedIndex = 0;
        //fromAMPM.selectedIndex = 0;
        toTime.selectedIndex = 0;
        //toAMPM.selectedIndex = 0;
    }
     
</script>




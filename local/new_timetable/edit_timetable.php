<?php

require(__DIR__.'/../../config.php');

require_once($CFG->dirroot.'/local/new_timetable/edit_timetable_form.php');

global $USER;

$context = context_system::instance();
require_login();

// Correct the navbar .
// Set the name for the page.
$linktext = "Time table";
//$linktext = get_string('plugin','new_plugin');
// Set the url.
$linkurl = new moodle_url('/local/new_timetable/edit_timetable.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
//$PAGE->set_heading($linktext);
$PAGE->navbar->add('Time table', new moodle_url($CFG->wwwroot.'/local/new_timetable/edit_timetable.php'));

echo $OUTPUT->header();
$mform = new edit_timetable_form();

if($mform->is_cancelled()){
    $cancelurl = $CFG->wwwroot.'/my';
    redirect($cancelurl);
}else if($formdata = $mform->get_data()){ 
 // print_r($formdata);exit;

    $timetabledata =  new stdclass();
    $timetabledata->id  = $formdata->id;
    $timetabledata->period_id  = $formdata->period_id;
    //print_r($timetabledata->period_id);exit();
     // Combine the selected values into a single string
    $from_time = $formdata->fromtime . ' ' . $formdata->fromampm;
    //print_r($from_time);exit;
    // Insert the combined value into a database column
    $timetabledata->from_time = $from_time;
    $to_time = $formdata->totime . ' ' . $formdata->fromampm;
    $timetabledata->to_time = $to_time;
    $timetabledata->t_subject = $formdata->subject;
    $timetabledata->t_teacher = $formdata->teacher;

     if (!empty($formdata->break)) {
      $timetabledata->break_type = $formdata->break;
      $b_ftime = $formdata->b_fromtime . ' ' . $formdata->b_fromampm;
    $timetabledata->break_ftime = $b_ftime;
    $b_ttime = $formdata->b_totime . ' ' . $formdata->b_fromampm;
    $timetabledata->break_ttime = $b_ttime;
  }     
  else{
    $timetabledata->break_type = '0';
    $timetabledata->break_ftime = null;
    $timetabledata->break_ttime = null;
  }
  
      $DB->update_record('new_timetable',$timetabledata);


      // print_r($timetabledata);exit();
      $urlto = $CFG->wwwroot.'/local/new_timetable/view_timetable.php';
      redirect($urlto, 'Data Saved Successfully '); 

      }


$mform->display();
echo '<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>';
echo $OUTPUT->footer();

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<script>

//Function for reset the values if 'remove break' button is clicked
function resetBreak() {
  var breakType = document.getElementById('id_break');
    var fromTime = document.getElementById('id_b_fromtime');
    var fromAMPM = document.getElementById('id_b_fromampm');
    var toTime = document.getElementById('id_b_totime');
    var toAMPM = document.getElementById('id_b_toampm');

        breakType.selectedIndex = 0;
        fromTime.selectedIndex = 0;
        fromAMPM.selectedIndex = 0;
        toTime.selectedIndex = 0;
        toAMPM.selectedIndex = 0;
    }
     
</script>




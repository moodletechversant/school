<?php

require(__DIR__.'/../../config.php');

require_once($CFG->dirroot.'/local/new_timetable/demo_form.php');

global $USER;

$context = context_system::instance();
require_login();


// Correct the navbar .
// Set the name for the page.
$linktext = "Time table";
//$linktext = get_string('plugin','new_plugin');
// Set the url.
$linkurl = new moodle_url('/local/new_timetable/demo.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
$PAGE->set_heading($linktext);
$PAGE->navbar->add('Time table', new moodle_url($CFG->wwwroot.'/local/new_timetable/demo.php'));

echo $OUTPUT->header();
$mform = new demo_form();

if($mform->is_cancelled()){
    $cancelurl = $CFG->wwwroot.'/my';
    redirect($cancelurl);
}else if($formdata = $mform->get_data()){ 
    print_r($formdata);exit();
        // Use the selectedTime variable as needed
        print_r($selectedTime);exit();
    
}

    $mform->display();
echo '<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>';
echo $OUTPUT->footer();

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <link rel="stylesheet" href="css/body.css">
  <script>
    
function updateSelectedTime() {
    var timeInput = document.getElementById("appt");
    var ampmInput = document.getElementById("ampm");
    var selectedTimeInput = document.getElementById("selectedTime");
    var selectedTime = timeInput.value + " " + ampmInput.value;
    selectedTimeInput.value = selectedTime;
}
   
</script>

  <style>
.time-picker{
    margin-left : 30%;
}
    </style>

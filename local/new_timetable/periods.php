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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
$(document).ready(function() {
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
});

$(document).ready(function() {
  $('#id_division').empty().prepend("<option value='' selected='selected'>none</option>");
  //$("#id_class").prepend("<option value='' selected='selected'>none</option>");
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
           
</script>




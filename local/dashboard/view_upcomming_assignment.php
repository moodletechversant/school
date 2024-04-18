<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/dashboard/templates/assignment_view.mustache');

global $USER ,$SESSION;

$context = context_system::instance();
require_login();
$schoolid  = $SESSION->schoolid;

// Correct the navbar .
// Set the name for the page.
$linktext = "View Upcoming Assignments";
//$linktext = get_string('plugin','new_plugin');
// Set the url.
//$linkurl = new moodle_url('/local/subject/viewsubject.php');
$css_link = new moodle_url('/local/css/style.css');
$back=new moodle_url('/local/dashboard/upcoming.php');

// Print the page header.
$PAGE->set_context($context);
//$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
// $PAGE->set_heading($linktext);
$PAGE->navbar->add('Upcoming Assignments', new moodle_url($CFG->wwwroot.'/local/dashboard/view_upcomming_assignment.php'));

echo $OUTPUT->header();

$data  = $DB->get_records_sql("SELECT * FROM {subject}");
$mustache = new Mustache_Engine();

$academic = $DB->get_records('academic_year',array('school' => $schoolid));
   
$options1 = array();
$options1[] = array('value' => '', 'label' => '---- Select academic start year ----');
foreach ($academic as $academic1) {
    $timestart = $academic1->start_year;
    $timestart1 = date("d/m/Y", $timestart);
    $timeend = $academic1->end_year;
    $timeend1 = date("d/m/Y", $timeend);
    $options1[] = array('value' => $academic1->id, 'label' => $timestart1.'--'.$timeend1);
}

$templateData = array(
    'startYearOptions' => $options1,
);

$output = $mustache->render($template, ['templateData'=>$templateData,'css_link'=>$css_link,'back'=>$back]);
echo $output;
echo $OUTPUT->footer();
?>
<script type="text/javascript">
//  $(document).ready(function() {
   
function deletesubject(id)
    {     

        var confirmation = confirm("Are you sure you want to delete this item?");
        if (confirmation) {
            var divisionn = document.getElementById("division").value; 
            if (divisionn != "") {
              
                $.ajax({
                
                    url: "test.php",
                    data: { d_id: divisionn,delete:id},
                    type: 'POST',
                    success: function(data) {
                        // alert(data);
                        $("#demo").html(data); // Corrected ID
                    }
                });
            }
        
        } 
        
    }
// });
    </script>

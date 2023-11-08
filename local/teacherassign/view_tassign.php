<?php 
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();
global $class,$CFG, $DB;

$template = file_get_contents($CFG->dirroot . '/local/teacherassign/template/assignteacher_view.mustache');

$context = context_system::instance();
// $classid = $class->id;
$linktext = "admin_view";

$linkurl = new moodle_url('/local/new_timetable/admin_view.php');

$PAGE->set_context($context);
$strnewclass= get_string('studentview');

$PAGE->set_url('/local/new_timetable/admin_view.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
// $PAGE->set_heading($SITE->fullname);

echo $OUTPUT->header();
$mustache = new Mustache_Engine();

$academic = $DB->get_records('academic_year');
   
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

$output = $mustache->render($template, ['templateData'=>$templateData]);
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
                        $("#demo").html(data); // Corrected ID
                    }
                });
            }
        
        } 
        
    }
// });
    </script>






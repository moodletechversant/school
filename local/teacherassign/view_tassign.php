<?php 
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();
$template = file_get_contents($CFG->dirroot . '/local/teacherassign/template/assignteacher_view.mustache');

global $class,$CFG, $DB;

$school_id=optional_param('id', 0, PARAM_INT);   

$css_link = new moodle_url('/local/css/style.css');
$add_new = new moodle_url('/local/teacherassign/teacherassign.php?id='.$school_id);
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

$academic = $DB->get_records('academic_year',array('school' => $school_id));
   
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

$output = $mustache->render($template, ['templateData'=>$templateData,'css_link'=>$css_link,'add_new'=>$add_new]);
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






<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/clsteacherassign/template/clsteacherassign.mustache');

global $class, $CFG, $DB, $USER,$SESSION;
$css_link = new moodle_url('/local/css/style.css');

$context = context_system::instance();
require_login();
// $school_id=optional_param('id', 0, PARAM_INT);  
$school_id  =$SESSION->schoolid;

$add_new = new moodle_url('/local/clsteacherassign/assignclsteacher.php');

$linktext = "Assigned Teacher List";

$linkurl = new moodle_url('/local/clsteacherassign/view_clsteacherassign.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_title($linktext);
$PAGE->navbar->add('Assigned Teacher List', new moodle_url($CFG->wwwroot.'/local/teacherassignment/view_clstaecherassign.php'));

echo $OUTPUT->header();

$assigned_teachers = $DB->get_records_sql("
    SELECT d.div_class, d.div_teacherid, d.div_name, t.id AS user_id, CONCAT(t.firstname, ' ', t.lastname) AS teacher_name
    FROM {division} d
    JOIN {user} t ON d.div_teacherid = t.id
");


// print_r($assigned_teachers);exit();
$mustache = new Mustache_Engine();
$academic = $DB->get_records('academic_year',array('school' => $school_id));

$options1 = array();
$options1[] = array('value' => '', 'label' => '---- Select academic start year ----');
foreach ($academic as $academic1) {
    $timestart = $academic1->start_year;
    $timestart1 = date("d-m-Y", $timestart);
    $options1[] = array('value' => $academic1->id, 'label' => $timestart1);
}

$templateData = array(
    'startYearOptions' => $options1,
    'endYearOptions' => $options2,
);


$output = $mustache->render($template, ['tableRows' => $tableRows,'templateData'=>$templateData,'css_link'=>$css_link,'add_new'=>$add_new]);
echo $output;
echo $OUTPUT->footer();

?>


<script type="text/javascript">
//  $(document).ready(function() {
   
function deleteclsteach(id)
    {   
        var confirmation = confirm("Are you sure you want to delete this item?");
        if (confirmation) {   
        
        var clsteach_delete = document.getElementById("class").value; 
         
            if (clsteach_delete != "") {
                // alert(id);
                $.ajax({
                
                    url: "test.php",
                    data: {c_id: clsteach_delete,delete:id},
                    type: 'POST',
                    success: function(data) {
                        // console.log(data);
                        $("#demo").html(data); // Corrected ID
                    }
                });
            }
            // location.reload(true) 
    }
}
// });
    </script>
<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/division/template/divisionview.mustache');
global $class, $CFG;
$context = context_system::instance();
$linktext = "View divisions";

$linkurl = new moodle_url('/local/division/div_view.php');
$css_link = new moodle_url('/local/css/style.css');
$div_creation = new moodle_url('/local/division/div_creation.php');

$PAGE->set_context($context);
$strnewclass = get_string('divcreation');

$PAGE->set_url('/local/division/div_view.php');
$PAGE->set_title($strnewclass);

echo $OUTPUT->header();
$stredit = get_string('edit');
$strdelete = get_string('delete');
$rec = $DB->get_records_sql("SELECT * FROM {division} ORDER BY div_class ASC, div_name ASC");
$mustache = new Mustache_Engine();

//echo $mustache->render($template);

$tableRows = [];


$academic = $DB->get_records('academic_year');
   
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


$output = $mustache->render($template, ['css_link'=>$css_link,'div_creation'=>$div_creation,'tableRows' => $tableRows,'templateData'=>$templateData]);
echo $output;
echo $OUTPUT->footer();
?>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<script type="text/javascript">
//  $(document).ready(function() {
   
function deletedivision(id)
    {      
        var confirmation = confirm("Are you sure you want to delete this item?");
        if (confirmation) {   
        
        var divisionn = document.getElementById("class").value; 
         
            if (divisionn != "") {
                // alert(id);
                $.ajax({
                
                    url: "test.php",
                    data: {c_id: divisionn,delete:id},
                    type: 'POST',
                    success: function(data) {
                        // console.log(data);
                        $("#demo").html(data); // Corrected ID
                    }
                });
            }
    }
}
</script>
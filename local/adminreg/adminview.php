<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/adminreg/template/adminview.mustache');
global $class,$CFG,$SESSION;

$context = context_system::instance();
$linkurl = new moodle_url('/local/adminreg/adminview.php');
$css_link = new moodle_url('/local/css/style.css');
$class_creation = new moodle_url('/local/adminreg/admin_registration.php');
$PAGE->set_context($context);
$strnewclass= "admincreation";
$PAGE->set_url('/local/adminreg/adminview.php');
$schoolid  = $SESSION->schoolid;
$PAGE->set_title($strnewclass);
echo $OUTPUT->header();
$mustache = new Mustache_Engine(); 
$academic = $DB->get_records_sql("SELECT {school_reg}.* FROM {school_reg} JOIN WHERE school = $schoolid");
   
$options1 = array();
$options1[] = array('value' => '', 'label' => '---- Select academic start year ----');
    foreach ($academic as $academic1) {
        $timestart = $academic1->start_year;
        $timestart1 = date("d-m-Y", $timestart);
        $options1[] = array('value' => $academic1->id, 'label' => $timestart1);
    }
$templateData = array(
        'startYearOptions' => $options1,
        
    );
$output = $mustache->render($template, ['schoolid'=>$schoolid,'templateData'=>$templateData,'css_link'=>$css_link,'class_creation'=>$class_creation]);
echo $output;
echo $OUTPUT->footer();


?>
<script type="text/javascript">
//  $(document).ready(function() {
   
function deleteclass(id)
    {      
        var confirmation = confirm("Are you sure you want to delete this item?");
        if (confirmation) {   
        var academic = document.getElementById("academic").value; 
            if (academic != "") {
                // alert(id);
                $.ajax({
                    url: "test.php",
                    data: {c_id: academic,delete:id},
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
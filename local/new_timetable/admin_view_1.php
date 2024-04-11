<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/new_timetable/templates/admin_view_1.mustache');

$context = context_system::instance();
$linktext = "View assigned students";
$linkurl = new moodle_url('/local/new_timetable/admin_view_1.php');

$css_link = new moodle_url('/local/css/style.css');
$periods = new moodle_url('/local/new_timetable/periods.php?id');

$PAGE->set_context($context);
$strnewclass = 'studentview';
$PAGE->set_url('/local/new_timetable/admin_view_1.php');
$PAGE->set_title($strnewclass);

//$addstudent = '<button style="background:transparent;border:none;"><a href="/school/local/studentassign/assign_student.php" style="text-decoration:none;"><font size="50px";color="#0f6cbf";>+</font></a></button>';

echo $OUTPUT->header();
$school_id  = optional_param('id', 0, PARAM_INT);
$mustache = new Mustache_Engine();
$rec = $DB->get_records('student_assign');

$academic = $DB->get_records('academic_year',array('school' => $school_id));

$options1 = array();
$options1[] = array('value' => '', 'label' => '---- Select Academic Year----');
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

$output = $mustache->render($template, ['school_id'=>$school_id,'templateData'=>$templateData,'css_link'=>$css_link,'periods'=>$periods]);

echo $output;

echo $OUTPUT->footer();
?>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<script type="text/javascript">
  
//  $(document).ready(function() {
  function deletetimetable(id)
    {      
        var confirmation = confirm("Are you sure you want to delete this item?");
        if (confirmation) {   
        
        var divisionn = document.getElementById("division").value; 
         
            if (divisionn != "") {
                // alert(id);
                $.ajax({
                
                    url: "adminajax_1.php",
                    data: {option: divisionn,delete:id},
                    type: 'POST',
                    success: function(data) {
                        // console.log(data);
                        $("#demo").html(data); // Corrected ID
                    }
                });
            }
    }
}
  
function deleteassign(id)
    {      
        var confirmation = confirm("Are you sure you want to delete this item?");
        if (confirmation) {   
        
        var assign_stud = document.getElementById("division").value; 
         
            if (assign_stud != "") {
                // alert(id);
                $.ajax({
                
                    url: "test.php",
                    data: {d_id: assign_stud,delete:id},
                    type: 'POST',
                    success: function(data) {
                        // console.log(data);
                        $("#demo").html(data); // Corrected ID
                    }
                });
            }
    }
}
$(document).ready(function(){
              $("#division").change(function(){
                var option = $(this).val();
                //alert(option);
                $.ajax({
                  type: "POST",
                  url: "adminajax_1.php",
                  data: {option: option},
                  success: function(data){
                    $("#searchresult").html(data);
                    $("#searchresult").css("display", "block");
                  }
                });
              });
            });
</script>

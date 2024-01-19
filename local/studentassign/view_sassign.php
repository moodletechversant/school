
<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
require_login();
Mustache_Autoloader::register();
$template = file_get_contents($CFG->dirroot . '/local/studentassign/template/viewassign.mustache');

// $template = file_get_contents($CFG->dirroot . '/local/studentassign/template/assignedstudent.mustache');
global $class, $CFG, $DB, $USER;
$css_link = new moodle_url('/local/css/style.css');
$add_new = new moodle_url('/local/studentassign/assign_student.php');
$context = context_system::instance();
$linktext = "View assigned students";
$linkurl = new moodle_url('/local/studentassign/view_sassign.php');

$PAGE->set_context($context);
$strnewclass = 'studentview';
$PAGE->set_url('/local/studentassign/view_sassign.php');
$PAGE->set_title($strnewclass);

echo $OUTPUT->header();
$mustache = new Mustache_Engine();

$rec = $DB->get_records('student_assign');
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

$output = $mustache->render($template, ['templateData'=>$templateData,'css_link'=>$css_link,'add_new'=>$add_new]);
echo $output;

echo $OUTPUT->footer();
?>
<script type="text/javascript"> 
function delete_assignedstudent(id)
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

    function suspend_eye(userid,academic_id)
    {     
   
                    $user_id= userid;
                    $a_id= academic_id;
                    var icon = $('#eye-'+ $user_id);
                    var isEyeVisible = icon.hasClass('fa-eye');
                    var action = isEyeVisible ? 'close' : 'open'; // Determine the action based on the current state
                    // alert( action);exit();
                    $.ajax({
                        url:  "test.php", // Your server-side script to handle the update
                        data: { user_id: $user_id, action: action, academic: $a_id},
                        type: 'POST',
                        success: function(response) 
                        {

                                    if ($.trim(response)=='success')
                                    {
                                        if (action === 'close')
                                        {
                                            
                                            icon.removeClass('fa-eye');
                                            icon.addClass('fa-eye-slash');
                                        } else {
                                            
                                            icon.removeClass('fa-eye-slash');
                                            icon.addClass('fa-eye');
                                        }
                                    } 
                                    else {
                                        alert('Failed to update eye status.');
                                    }
                        }
                    });
               
        } 
        
    </script>
<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/createstudent/templates/studview_1.mustache');

global $class, $CFG;
$context = context_system::instance();
$linktext = "View students";

$linkurl = new moodle_url('/local/createstudent/view_student_1.php');
$css_link = new moodle_url('/local/css/style.css');
$new_student = new moodle_url('/local/createstudent/createstudent.php');

$PAGE->set_context($context);
$strnewclass = get_string('studentview');

$PAGE->set_url('/local/createstudent/view_student_1.php');
$PAGE->set_title($strnewclass);

echo $OUTPUT->header();
$rec = $DB->get_records_sql("SELECT * FROM {student}");
$mustache = new Mustache_Engine();


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


$output = $mustache->render($template, ['tableRows' => $tableRows,'templateData'=>$templateData,'css_link'=>$css_link,'new_student'=>$new_student]);
echo $output;
echo $OUTPUT->footer();
?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI/tZ1Z1eSd3qWzVnUVlTf1d9S5u0XwH7OuHfjI=" crossorigin="anonymous"></script>
<script type="text/javascript">

   

    

function deletestudent(id)
    {   
        var confirmation = confirm("Are you sure you want to delete this item?");
        if (confirmation) {   
        
        var stud_delete = document.getElementById("class").value; 
         
            if (stud_delete != "") {
                // alert(id);
                $.ajax({
                
                    url: "test.php",
                    data: {c_id: stud_delete,delete:id},
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



function suspend_eye(userid)
    {     
   
                    var user_id= userid;
                   
                    var icon = $('#eye-'+ user_id);
                    var isEyeVisible = icon.hasClass('fa-eye');
                //    alert(userid)
                    var action = isEyeVisible ? 'close' : 'open'; // Determine the action based on the current state
                   // alert( action);
                    // exit();
                    $.ajax({
                        url:  "test.php", // Your server-side script to handle the update
                        data: { user_id: user_id, action: action},
                        type: 'POST',
                        success: function(response) 
                        {
                            // alert('23435')

                                    if ($.trim(response)=='success')
                                    {
                                        if (action === 'close')
                                        {
                                            
                                            icon.removeClass('fa-eye');
                                            icon.addClass('fa-eye-slash');
                                            icon.html('Unsuspend');
                                        } else {
                                            
                                            icon.removeClass('fa-eye-slash');
                                            icon.addClass('fa-eye');
                                            icon.html('suspend');
                                        }
                                    } 
                                    else {
                                        alert('Failed to update eye status.');
                                    }
                        }
                    });
               
        } 
        
</script>

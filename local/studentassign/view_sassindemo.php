<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
require_login();
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/studentassign/template/assignedstudent.mustache');

$context = context_system::instance();
$linktext = "View assigned students";
$linkurl = new moodle_url('/local/studentassign/view_sassign.php');

$PAGE->set_context($context);
$strnewclass = 'studentview';
$PAGE->set_url('/local/studentassign/view_sassign.php');
$PAGE->set_title($strnewclass);

$addstudent = '<button style="background:transparent;border:none;"><a href="/school/local/studentassign/assign_student.php" style="text-decoration:none;"><font size="50px";color="#0f6cbf";>+</font></a></button>';

echo $OUTPUT->header();

$rec = $DB->get_records('student_assign');
// print_r($rec);exit();
$mustache = new Mustache_Engine();

echo $mustache->render($template);

$table = new html_table();
echo $addstudent;

$table->head = array("Student id","Student Name", "Class", "Division", 'Edit', 'Suspend', 'Unenrol');
foreach ($rec as $record) {
    $id = $record->id;

    $user_id = $record->user_id;
    // $user_id =77;
    $classname = $record->s_class;
    $class = $DB->get_record('class', array('id' => $classname));

    $divisionname = $record->s_division;
    $division = $DB->get_record('division', array('id' => $divisionname));
    // $strdelete = get_string('delete');
    // $studentnames = explode(',', $record->user_id);
    // foreach ($user_id as $studentid) {
        $student = $DB->get_record('student', array('user_id' => $user_id));
        if ($student) {
            $row = array();
            $row[] = $user_id;
            $row[] = $student->s_ftname;
            $row[] = $class->class_name;
            $row[] = $division->div_name;
            $class=$class->id;
            // Convert timestamps to integers for comparison
            //*****************************************************************************************888
            $enrolmentTimestamp = $DB->get_record_sql("SELECT timeend FROM {user_enrolments} WHERE userid=$user_id");
            $academicEndTimestamp = $DB->get_record_sql("SELECT {academic_year}.end_year FROM {academic_year} JOIN {class} ON {class}.academic_id={academic_year}.id WHERE {class}.id=$class");
            if ($enrolmentTimestamp->timeend===$academicEndTimestamp->end_year) {
               
                $iconClass='fa-eye';
                
            }
             else {
                $iconClass='fa-eye-slash';
            }
            
            $eyeIcon = html_writer::tag('i', '', array('class' => 'fa '.$iconClass, 'id' => 'eye-' . $user_id, 'style' => 'cursor: pointer;'));
        
            
        // $eyeIcon = html_writer::tag('i', '', array('class' => 'fa fa-eye', 'id' => 'eye-' . $user_id, 'style' => 'cursor: pointer;')); // Initial eye icon
            $toggleEyeScript = "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js'></script>
            <script type='text/javascript'>
                $('#eye-" . $user_id . "').click(function() {
                    var icon = $(this);
                    var isEyeVisible = icon.hasClass('fa-eye');
                    var action = isEyeVisible ? 'close' : 'open'; // Determine the action based on the current state
                  
                    $.ajax({
                        url: 'suspend.php', // Your server-side script to handle the update
                        data: { user_id: " . $user_id . ", action: action, class: ".$class." },
                        type: 'POST',
                        success: function(response) 
                        {
                            //   alert(response);
                             
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
                });
                </script>";
            
//*****************************************************************************************888
           
            $edit = $CFG->wwwroot . '/local/studentassign/edit_assignstudent.php?id=' . $id;
            $editing = html_writer::link($edit, $OUTPUT->pix_icon('t/edit', 'edit'));
            // $unenrol = html_writer::tag('i', '', array('class' => ' fa-eye-slash', 'id' => 'eye-' . $user_id, 'style' => 'cursor: pointer;'));
            
            
            $unenrl = $CFG->wwwroot . '/local/studentassign/delete.php?id=' . $id;

        $unenrol = html_writer::tag('i', '', array('class' => 'fa fa-remove', 'id' => 'unenrol-' . $user_id, 'style' => 'cursor: pointer;'));

        $unenrolscript = "
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js'></script>
        <script type='text/javascript'>
            $(document).ready(function() {
                $('#unenrol-" . $user_id . "').click(function() {
                    var icon = $(this);
                    var user_id = " . $user_id . ";

                    var shouldDelete = confirm('Are you sure you want to delete this student?');
                    if (!shouldDelete) {
                        return; // Don't proceed if the user clicked 'Cancel'
                    }

                    $.ajax({
                        url: 'delete.php', // Your server-side script to handle the deletion
                        data: { user_id: user_id },
                        type: 'POST',
                        success: function(response) {
                            // // Handle success, update UI if needed
                            // alert(response); // Display the response from the server
                            // console.log('Student details deleted successfully:', response);
                            // Handle success, update UI if needed
                            if ($.trim(response) === 'success') {
                                // Remove the table row representing the deleted student
                                icon.closest('tr').remove(); // Remove the table row from the UI
                                console.log('Student details deleted successfully:', response);
                            } 
                            else {
                                console.error('Failed to delete student.');
                            }


                        },
                        error: function(xhr, status, error) {
                            // Handle error, show error message or take appropriate action
                            console.error('Error deleting student details:', status, error);
                        }
                    });
                });
            });
        </script>
        ";
    
            $row[] = $editing;
            $row[] = $eyeIcon . $toggleEyeScript;
            $row[] = $unenrol.$unenrolscript;
            // $row[] = $deleting;
            $table->data[] = $row;
        }
    // }
}

echo html_writer::table($table);
echo $OUTPUT->footer();
?>


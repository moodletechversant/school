<?php 
require_once(__DIR__ . '/../../config.php');

global $class,$CFG, $DB;

$context = context_system::instance();
// $classid = $class->id;
$linktext = "Attendance";

$linkurl = new moodle_url('/local/attendance/attendance.php');

$PAGE->set_context($context);
$strnewclass=$linktext;

$PAGE->set_url('/local/attendance/attendance.php');
$userid=$USER->id;

// Retrieve form data
$answer = $_POST['answer'];
 
foreach ($answer as $qid => $value) {

        $record = new stdClass();
        $record->q_id=$qid;
        $record->a_id=$value;
        $record->user_id=$userid;
       

    // $DB->insert_record("INSERT INTO mdl_student_answers (user_id, attendance) VALUES ('$userId', '$value')");
    $DB->insert_record('student_answers',$record);
}

$urlto = $CFG->wwwroot.'/local/survey/survey_studentview.php';
redirect($urlto, 'Data Saved Successfully '); 
// print_r($_POST['attendance']);
// echo "<p>Attendance saved!</p>";
// }

$conn->close();
?>

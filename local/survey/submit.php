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
if(isset($_POST['answer'])){
    $answer = $_POST['answer'];
 
    // foreach ($answer as $qid => $value) {
    
    //         $record = new stdClass();
    //         $record->q_id=$qid;
    //         $record->a_id=$value;
    //         $record->user_id=$userid;
           
    
    //     // $DB->insert_record("INSERT INTO mdl_student_answers (user_id, attendance) VALUES ('$userId', '$value')");
    //     $DB->insert_record('student_answers',$record);
    // }
    
    
    foreach ($answer as $qid => $value) {
        // Check if a record with the same q_id and user_id already exists
        $existing_record = $DB->get_record('student_answers', array('q_id' => $qid, 'user_id' => $userid));
    
        if (!$existing_record) {
            // If no existing record found, insert a new record
            $record = new stdClass();
            $record->q_id = $qid;
            $record->a_id = $value;
            $record->user_id = $userid;
    
            // Insert the record into the student_answers table
            $DB->insert_record('student_answers', $record);
            $urlto = $CFG->wwwroot.'/local/survey/survey_studentview.php';
    redirect($urlto, 'Data Saved Successfully '); 
    // $conn->close();
        } else {
            $urlto = $CFG->wwwroot.'/local/survey/survey_studentview.php';
            redirect($urlto, 'Data not Saved Successfully '); 
          
        }
    } 
}
else{
    $urlto = $CFG->wwwroot.'/local/survey/survey_studentview.php';
}


?>

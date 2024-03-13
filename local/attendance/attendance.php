<?php 
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();
global $class,$CFG, $DB;
$template = file_get_contents($CFG->dirroot . '/local/attendance/template/attendance.mustache');


$context = context_system::instance();  
// $classid = $class->id;
$linktext = "Attendance";

$linkurl = new moodle_url('/local/attendance/attendance.php');
$css_link = new moodle_url('/local/css/style.css');
$view_attendance = new moodle_url('/local/attendance/viewattend.php');
$attendance_page = new moodle_url('/local/attendance/attendance.php');

$teacher_id = $USER->id;
$PAGE->set_context($context);
$strnewclass=$linktext; 

$PAGE->set_url('/local/attendance/attendance.php');
$PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);


echo $OUTPUT->header();
$mustache = new Mustache_Engine();
$recs=$DB->get_record_sql("SELECT * FROM {division} WHERE div_teacherid=$teacher_id");
//print_r($recs);exit();
if(empty($recs))
{
echo "you are not assigned to the class incharge of any class ...you can't mark attendance of any student";
}
else{
    $division=$recs->id;
    $rec=$DB->get_records_sql("SELECT * FROM {student_assign} WHERE s_division=$division");
    $data1=array();
    foreach ($rec as $studentid) {
        $student = $DB->get_record_sql("SELECT * FROM {student} WHERE user_id=$studentid->user_id");  

        $id=$student->user_id;
        $ftname=$student->s_ftname;
        $mlname=$student->s_mlname;
        $lsname=$student->s_lsname;

        $data1[] = [ 'id'=>$id,'ftname'=>$ftname,'mlname'=>$mlname,'lsname'=>$lsname];
    }
    echo $mustache->render($template, ['attendance' => $data1,'css_link'=>$css_link,'view_attendance'=>$view_attendance,'attendance_page'=>$attendance_page,'division'=>$division]);
   }

if (isset($_POST['submit'])) {

    $radioVal = $_POST["attendance"];
    $tdate = $_POST["atdate"];
    // Create DateTime object from date string
    $date = new DateTime($tdate);
    // Get timestamp
    $timestamp = $date->getTimestamp();

    // print($tdate);
    $division = $_POST["division"];

    foreach($radioVal as $x => $val) { 

        $existing_record = $DB->get_records_sql("SELECT * FROM {attendance} WHERE stud_name = ? AND tdate = ? AND div_id = ?", array($x, $timestamp, $division));
//print_r($existing_record);exit();

if (!$existing_record) {
        $record = new stdClass();
        $record->stud_name=$x;
        $record->tdate= $timestamp;
        $record->div_id= $division;
        if($val == 'P')
        {
            $record->attendance='Present';
        }
        else if ($val == 'A')
        {
            $record->attendance='Absent';
        }
        $DB->insert_record('attendance',$record);
    }
    else { // If a record already exists, set flag to true
        $duplicate_found = true;
    }
}
if ($duplicate_found) { // Show alert only if duplicate found
    echo '<script>alert("Attendance for this user on the selected date already exists!");</script>';
}


    echo '</div>';
    $urlto = $CFG->wwwroot.'/local/attendance/viewattend.php';
    redirect($urlto, 'Data Saved Successfully '); 
}
echo $OUTPUT->footer();
?>
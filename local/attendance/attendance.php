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

    // foreach ($rec as $student) {
    // $studentnames = explode(',', $student->user_id);

    $data1=array();
    foreach ($rec as $studentid) {
   $student = $DB->get_record_sql("SELECT * FROM {student} WHERE user_id=$studentid->user_id");  
   //print_r($student);exit();

   $id=$student->user_id;
   $ftname=$student->s_ftname;
   $mlname=$student->s_mlname;
   $lsname=$student->s_lsname;

   $data1[] = [
    'id'=>$id,
    'ftname'=>$ftname,
    'mlname'=>$mlname,
    'lsname'=>$lsname
   ];
    }
echo $mustache->render($template, ['attendance' => $data1,'css_link'=>$css_link,'view_attendance'=>$view_attendance,'attendance_page'=>$attendance_page]);
   }

if (isset($_POST['submit'])) {

    $radioVal = $_POST["attendance"];
    $tdate = $_POST["atdate"];
 
    foreach($radioVal as $x => $val) { 
 
    if($val == 'P')
    {
        $record = new stdClass();

        $record->stud_name=$x;
        $record->attendance='Present';
        $record->tdate= $tdate;
   
    }
        
    else if ($val == 'A')
    {
         // Do something with the attendance data here
         $record = new stdClass();
         $record->stud_name=$x;
         $record->attendance='Absent';
         $record->tdate= $tdate;
    }
  
     
    $DB->insert_record('attendance',$record);
}
echo '</div>';
$urlto = $CFG->wwwroot.'/local/attendance/viewattend.php';
redirect($urlto, 'Data Saved Successfully '); 
}
?>
<?php 
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();
global $class, $CFG, $DB,$USER;
$template = file_get_contents($CFG->dirroot . '/local/attendance/template/attendanceedit.mustache');

$context = context_system::instance();
$linktext = "Attendance";

$PAGE->set_context($context);
$strnewclass = $linktext;
$css_link = new moodle_url('/local/css/style.css');
//$attendanceedit_page = new moodle_url('/local/attendance/attendanceedit.php');
$linkurl = new moodle_url('/local/attendance/attendanceedit.php');

$PAGE->set_url('/local/attendance/attendanceedit.php');
$PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
echo $OUTPUT->header();
$mustache = new Mustache_Engine();
$id  = optional_param('id', 0, PARAM_INT);
// print_r($id);exit();
$rec1 = $DB->get_records_sql("SELECT * FROM {attendance} WHERE id=$id");
$Datetime=$rec1[$id]->tdate;
// print_r($Datetime);exit();
$tdate_readable = date('Y-m-d', $Datetime);
$table = new html_table();
echo '<form method="POST">
              <div class="row"><div class="col-md-4">
                  <div class="form-group">
                  <input type="date" class="form-control" id="db_picker_attend" name="attendance_date" value="' . $tdate_readable . '" onchange="this.form.submit()" />
              </div></div></div>';
              
// print_r($tdate_readable);exit();

// $rec = $DB->get_record_sql("SELECT * FROM {student} WHERE user_id=$rec1->stud_name");

//echo "<form method='post'>";
//echo "<input type='hidden' name='id' value='$id'>";

//echo "<table height='500' width='800'>";
//echo "<td colspan='4'><input type='date' name='atdate' value='" . $tdate_readable . "'></td>";
// echo "<td>".$tdate_readable."</td>";
//echo "<tr><th>Roll no</th><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Student name</th><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Status</th></tr>";

$data1=array();
foreach ($rec1 as $student) {
    $rollno = $student->stud_name;
     
    $rec = $DB->get_record_sql("SELECT * FROM {student} WHERE user_id=$rollno");
    
        $ftname=$rec->s_ftname;
        $mlname=$rec->s_mlname;
        $lsname=$rec->s_lsname;
        $data1[] = ['id'=>$id,'ftname'=>$ftname,'mlname'=>$mlname,'lsname'=>$lsname];

    //echo "<tr>";
    //echo "<td>".$student->stud_name."</td>";
    //echo "<td>".$rec->s_ftname."</td>";
    //echo "<td><input type='radio' name='attendance[$student->stud_name]' value='P'> Present<input type='radio' name='attendance[$student->stud_name]' value='A'> Absent</td>";
    //echo "</tr>";
}
echo $mustache->render($template, ['attendance' => $data1,'css_link'=>$css_link,'linkurl'=>$linkurl, 'datedata'=>$tdate_readable, 'id'=>$id]);

//print_r( $rollno);exit();
// echo "<tr><td colspan='4'><input type='submit' class='btns' name='submit' value='Save Attendance'></td></tr>";
// echo "</table>";
// echo "</form>";

// Handle form submission
if (isset($_POST['submit'])) {

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $radioVal = $_POST["attendance"];
    // print_r($id);exit();
    //$tdate = $_POST["tdate_readable"];

    foreach ($radioVal as $x => $val) { 
        
        if($val == 'P')
        {
               $record1 = new stdClass();
                $record = $DB->get_record('attendance', array('stud_name' => $x));
                $record1->id = $id;
                // Modify the relevant fields
                $record1->attendance = 'Present';
       
        }
            
        else if ($val == 'A')
        {
             // Do something with the attendance data here
                $record1 = new stdClass();
                $record = $DB->get_record('attendance', array('stud_name' => $x));
                $record1->id = $id;
                // Modify the relevant fields
                $record1->attendance = 'Absent';
            //  $record = new stdClass();
            //  $record->stud_name=$x;
            //  $record->attendance='Absent';
            //  $record->tdate= $tdate;
        }
        $DB->update_record('attendance', $record1);
    }

    $urlto = $CFG->wwwroot.'/local/attendance/viewattend.php';
    redirect($urlto, 'Data Saved Successfully '); 
}

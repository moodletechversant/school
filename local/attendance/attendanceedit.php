<?php 
require_once(__DIR__ . '/../../config.php');

global $class, $CFG, $DB,$USER;

$context = context_system::instance();
$linktext = "Attendance";
$linkurl = new moodle_url('/local/attendance/attendanceedit.php');

$PAGE->set_context($context);
$strnewclass = $linktext;
 
$PAGE->set_url('/local/attendance/attendanceedit.php');
$PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);

echo $OUTPUT->header();
$id  = optional_param('id', 0, PARAM_INT);

$rec1 = $DB->get_records_sql("SELECT * FROM {attendance} WHERE id=$id");
 
// $rec = $DB->get_record_sql("SELECT * FROM {student} WHERE user_id=$rec1->stud_name");

echo "<form method='post'>";
echo "<input type='hidden' name='id' value='$id'>";

echo "<table height='500' width='800'>";
echo "<td colspan='4'><input type='date' name='atdate'></td>";
echo "<tr><th>Roll no</th><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Student name</th><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Status</th></tr>";

foreach ($rec1 as $student) {
    $rollno = $student->stud_name;
     
    $rec = $DB->get_record_sql("SELECT * FROM {student} WHERE user_id=$rollno");
    echo "<tr>";
    echo "<td>".$student->stud_name."</td>";
    echo "<td>".$rec->s_ftname."</td>";
    echo "<td><input type='radio' name='attendance[$student->stud_name]' value='P'> Present<input type='radio' name='attendance[$student->stud_name]' value='A'> Absent</td>";
    echo "</tr>";
}
//print_r( $rollno);exit();
echo "<tr><td colspan='4'><input type='submit' class='btns' name='submit' value='Save Attendance'></td></tr>";
echo "</table>";
echo "</form>";

// Handle form submission
if (isset($_POST['submit'])) {

    $id = $_POST["id"];
    $radioVal = $_POST["attendance"];
    $tdate = $_POST["atdate"];

    foreach ($radioVal as $x => $val) { 
        // Get the existing record
        // $record1 = new stdClass();
        // $record = $DB->get_record('attendance', array('stud_name' => $x, 'tdate' => $tdate));
        // $record1->id = $id;
        // // Modify the relevant fields
        // $record1->attendance = $val;

           // Set the id field in the record

        //    print_r($record1);exit();

        // Update the record




        if($val == 'P')
        {
               $record1 = new stdClass();
                $record = $DB->get_record('attendance', array('stud_name' => $x, 'tdate' => $tdate));
                $record1->id = $id;
                // Modify the relevant fields
                $record1->attendance = 'Present';
    
            // $record->stud_name=$x;
            // $record->attendance='Present';
            // $record->tdate= $tdate;
       
        }
            
        else if ($val == 'A')
        {
             // Do something with the attendance data here
                $record1 = new stdClass();
                $record = $DB->get_record('attendance', array('stud_name' => $x, 'tdate' => $tdate));
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

<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();
$template = file_get_contents($CFG->dirroot . '/local/attendance/template/viewattend.mustache');

global $class, $CFG;
$context = context_system::instance();
$linkurl = new moodle_url('/local/attendance/viewattend.php');
$css_line = new moodle_url('/local/css/style.css');
$mark_attendance = new moodle_url('/local/attendance/attendance.php');


$PAGE->set_context($context);
require_login();
$PAGE->set_url('/local/attendance/viewattend.php');
$PAGE->set_title('Attendance');

echo $OUTPUT->header();
$teacher_id = $USER->id;

$mustache = new Mustache_Engine();

$recs=$DB->get_record_sql("SELECT * FROM {division} WHERE div_teacherid=$teacher_id");
if(empty($recs))
{
echo "you are not assigned to the class incharge of any class ...you can't mark attendance of any student";
}
else{
    $division=$recs->id;
    $rec1=$DB->get_records_sql("SELECT * FROM {student_assign} WHERE s_division=$division");
    $datas=array();
    foreach ($rec1 as $studentid) {
        $student = $DB->get_record_sql("SELECT * FROM {student} WHERE user_id=$studentid->user_id");  

        $id=$student->user_id;
        $ftname=$student->s_ftname;
        $mlname=$student->s_mlname;
        $lsname=$student->s_lsname;

        $datas[] = [ 'id'=>$id,'ftname'=>$ftname,'mlname'=>$mlname,'lsname'=>$lsname];
        //print_r($data1);exit();
    }
           // print_r($data1);

   }



$selected_date = isset($_POST['attendance_date']) ? $_POST['attendance_date'] : date();
$selected_date_timestamp = strtotime($selected_date);
$data1_ids = array_column($datas, 'id'); // Extracting student IDs from $data1
$where_clause = "tdate='$selected_date_timestamp' AND stud_name IN (" . implode(',', $data1_ids) . ")";

$rec = $DB->get_records_sql("SELECT * FROM {attendance} WHERE $where_clause");

$table = new html_table();
echo '<form method="POST">
              <div class="row"><div class="col-md-4">
                  <div class="form-group">
                  <label>Select the date for view Attandence</label>
                  <input type="date" class="form-control" id="db_picker_attend" name="attendance_date" value="' . $selected_date . '" onchange="this.form.submit()" />
              </div></div></div>';
//echo '<input type="date" id="db_picker_attend" name="attendance_date" value="' . $selected_date . '" onchange="this.form.submit()">';
echo '</form>';
// print_r($rec);exit();

$data1 = [];
foreach ($rec as $value) {
  $id = $value->id;
  $rollno = $value->stud_name;
  $status = $value->attendance;

  $rec1 = $DB->get_record_sql("SELECT * FROM {student} WHERE  user_id=$rollno");
  //print_r($rec1);exit();
  $name1 = $rec1->s_ftname;

  $data1[] = [
    'id' => $id, 'rollno' => $rollno, 'name1' => $name1, 'status' => $status, 'edit' => $edit, 'delete' => $delete, 'selected_date' => $selected_date

  ];
}
//print_r($data1);exit();
echo $mustache->render($template, ['viewattend' => $data1, 'css_line' => $css_line, 'mark_attendance' => $mark_attendance]);
echo html_writer::table($table);
echo $OUTPUT->footer();

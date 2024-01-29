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
$PAGE->set_url('/local/attendance/viewattend.php');
$PAGE->set_title('Attendance');

echo $OUTPUT->header();
$mustache = new Mustache_Engine();

$selected_date = isset($_POST['attendance_date']) ? $_POST['attendance_date'] : date('Y-m-d');
//$selected_date_timestamp = strtotime($selected_date);

$rec = $DB->get_records_sql("SELECT * FROM {attendance} WHERE tdate='$selected_date'");
//print_r($rec);exit();

$table = new html_table();
echo '<form method="POST">
              <div class="row"><div class="col-md-4">
                  <div class="form-group">
                  <label>Select the date for view Attandence</label>
                  <input type="date" class="form-control" id="db_picker_attend" name="attendance_date" value="' . $selected_date . '" onchange="this.form.submit()" />
              </div></div></div>';
//echo '<input type="date" id="db_picker_attend" name="attendance_date" value="' . $selected_date . '" onchange="this.form.submit()">';
echo '</form>';

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

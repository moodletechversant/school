<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

global $CFG,$USER;
$context = context_system::instance();
require_login();
$template = file_get_contents($CFG->dirroot . '/local/attendance/template/viewattendanceparent.mustache');
$linkurl = new moodle_url('/local/attendance/viewattendanceparent.php'); 
$css_link = new moodle_url('/local/css/style.css');

$PAGE->set_context($context);
$PAGE->set_url($linkurl); 
//$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
$PAGE->navbar->add('viewattendanceparent', new moodle_url($CFG->wwwroot.'/local/attendance/viewattendanceparent.php'));
$userid = optional_param('id', 0, PARAM_INT);
echo $OUTPUT->header();
 
// Get the selected date from POST, defaulting to today's date if not set
$selected_date = isset($_POST['attendance_date']) ? $_POST['attendance_date'] : date('Y-m-d');
$selected_month = date('Y-m', strtotime($selected_date)); // Extracting year and month for the query

// Display the month selection form
echo '<form method="POST">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="month" name="attendance_date" value="' . htmlspecialchars($selected_month) . '" onchange="this.form.submit()">
                </div>
            </div>
        </div>
      </form>';

// Fetch records from the attendance table for the selected month and user
$sql = "SELECT * FROM {attendance} WHERE DATE_FORMAT(FROM_UNIXTIME(tdate), '%Y-%m') = :selected_month AND stud_name = :userid";
$params = ['selected_month' => $selected_month, 'userid' => $userid];
$rec = $DB->get_records_sql($sql, $params);

$data1 = [];

foreach ($rec as $value) {
  $id = $value->id;
  $rollno = $value->stud_name;
  $status = $value->attendance;
  $date = date('d-m-Y', $value->tdate);
  $rec1 = $DB->get_record_sql("SELECT * FROM {student} WHERE  user_id=$rollno");
  $name1 = $rec1->s_ftname;
  $data1[] = ['id' => $id, 'rollno' => $rollno, 'name1' => $name1, 'status' => $status, 'date' =>$date];
}  
$mustache = new Mustache_Engine();
echo $mustache->render($template, ['viewattendprnt' => $data1, 'css_line' => $css_link]);
echo html_writer::table($table);
echo $OUTPUT->footer();
?>
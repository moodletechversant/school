<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();
$template = file_get_contents($CFG->dirroot . '/local/attendance/template/viewattendstd.mustache');

global $class, $CFG;
$context = context_system::instance();
$linkurl = new moodle_url('/local/attendance/viewattendstd.php');

$PAGE->set_context($context);
$PAGE->set_url('/local/attendance/viewattendstd.php');
$PAGE->set_title('Attendance');
//$PAGE->set_heading($SITE->fullname);

echo $OUTPUT->header();
$mustache = new Mustache_Engine(); 

$selected_date = isset($_POST['attendance_date']) ? $_POST['attendance_date'] : date('Y-m-d');
$selected_date_formatted = date_format(date_create($selected_date), 'Y-m-d');

$rec = $DB->get_records_sql("SELECT * FROM {attendance} WHERE tdate = ?", array($selected_date_formatted));
$table = new html_table();

echo '<form method="POST">';
echo '<input type="date" name="attendance_date" value="' . $selected_date . '" onchange="this.form.submit()">';
echo '</form>';
 
//$table->head = array("Roll no", "Name", "Status");
$data1=[];
foreach ($rec as $records) {
    $id = $records->id;
    $rollno = $records->stud_name; 
    $rec1 = $DB->get_record_sql("SELECT * FROM {student} WHERE user_id=$rollno");
    $name1 = $rec1->s_ftname;
    $status = $records->attendance;
    
    $data1[]=[
        'id'=>$id,
        'rollno'=>$rollno,
        'name1'=>$name1,
        'status'=>$status
    ];
}
echo $mustache->render($template,['viewattendstd'=>$data1]);
echo html_writer::table($table);
echo $OUTPUT->footer();
?>
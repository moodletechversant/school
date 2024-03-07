<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/new_timetable/templates/studentview_1.mustache');

global $class, $CFG;
$context = context_system::instance();
$linkurl = new moodle_url('/local/new_timetable/view_timetable.php');
$css_link = new moodle_url('/local/css/style.css');

$PAGE->set_context($context);
$PAGE->set_url('/local/new_timetable/view_timetable.php');
$PAGE->set_heading($linktext);
echo $OUTPUT->header();

$current_user_id = $USER->id;
$user1= optional_param('id', 0, PARAM_INT);
// Assuming there is a table named mdl_parent with a field user_id
$parent = $DB->get_record('parent', array('user_id' => $current_user_id));
//print_r($parent);exit();
if ($parent) {
    // Assuming there is a table named mdl_student_assign with fields s_division and user_id
    $rec1 = $DB->get_records_sql("
        SELECT {new_timetable_periods}.*
        FROM {new_timetable_periods}
        INNER JOIN {student_assign} ON {student_assign}.s_division = {new_timetable_periods}.t_division
        WHERE {student_assign}.user_id = :child_user_id
    ", ['child_user_id' => $user1]);
    
//print_r($rec1);exit();
    $mustache = new Mustache_Engine();
    $tableRows = [];

    foreach ($rec1 as $records) {
        $val = $records->t_day;
        $value = $DB->get_record_sql("SELECT * FROM {days} WHERE id = $val");
        $div_id = $records->id;
        $day = $value->days;
        $daysid = $value->id;
        $day_records = array();
        $rec2 = $DB->get_records_sql("SELECT * FROM {new_timetable} WHERE period_id = $div_id");
        
        foreach ($rec2 as $records1) {
            $period_id = $records1->period_id;
            $id = $records1->id;
            $from_time = $records1->from_time;
            $to_time = $records1->to_time;
            $t_subject1 = $records1->t_subject;
            $value2 = $DB->get_record_sql("SELECT * FROM {subject} WHERE course_id = $t_subject1");
            $t_subject = $value2->sub_name;
            $val1 = $records1->t_teacher;
            $value1 = $DB->get_record_sql("SELECT t_fname FROM {teacher} WHERE user_id = $val1");
            $t_teacher = $value1->t_fname;
            $break_type = $records1->break_type;
            $break_ftime = $records1->break_ftime;
            $break_ttime = $records1->break_ttime;

            $day_records[] = array('id' => $id, 'from_time' => $from_time, 'to_time' => $to_time, 't_subject' => $t_subject, 't_teacher' => $t_teacher, 'break_type' => $break_type, 'break_ftime' => $break_ftime, 'break_ttime' => $break_ttime);
        }

        $data[] = array('days' => $day, 'records' => $day_records);
    }

    echo $mustache->render($template, ['day' => $data, 'css_link' => $css_link]);
} else {
    echo "Parent not found for the current user.";
}

echo $OUTPUT->footer();
?>

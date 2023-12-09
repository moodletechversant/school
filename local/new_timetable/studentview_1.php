<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/new_timetable/templates/studentview_1.mustache');

global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;
//$linktext = "Time Table";
$linkurl = new moodle_url('/local/new_timetable/view_timetable.php');
$css_link = new moodle_url('/local/css/style.css');


$PAGE->set_context($context);
//$strnewclass= get_string('studentview');

$PAGE->set_url('/local/new_timetable/view_timetable.php');
$PAGE->set_heading($linktext);
// $PAGE->set_pagelayout('admin');
//$PAGE->set_title($linktext);

echo $OUTPUT->header();
$current_user_id = $USER->id;
// $user_id=11;
$rec1=$DB->get_records_sql("SELECT {new_timetable_periods}.* FROM {new_timetable_periods} INNER JOIN {student_assign} ON {student_assign}.s_division={new_timetable_periods}.t_division WHERE {student_assign}.user_id=$current_user_id");
$mustache = new Mustache_Engine();

//echo $mustache->render($template);

$tableRows = [];
foreach ($rec1 as $records) {
    $val = $records->t_day;
    $value=$DB->get_record_sql("SELECT * FROM {days} WHERE id = $val");
    $div_id=$records->id;
    //print_r($div_id);exit();
    $day=$value->days;
    $daysid=$value->id;
    // print_r($daysid);
    //$period_records = array();
    $day_records= array();
    $rec2=$DB->get_records_sql("SELECT * FROM {new_timetable} WHERE period_id = $div_id");
    foreach ($rec2 as $records1) {
        $period_id = $records1->period_id;
        // print_r($period_id);exit();
        $id=$records1->id;
        $from_time=$records1->from_time;
        $to_time=$records1->to_time;
        $t_subject1=$records1->t_subject;
        // $DB->get_record_sql("SELECT * FROM {subject} WHERE course_id = $records1->t_subject");
        $value2=$DB->get_record_sql("SELECT * FROM {subject} WHERE course_id = $t_subject1");
        $t_subject=$value2->sub_name;
        
        //print_r($break);exit();
        $val1=$records1->t_teacher;
        $value1=$DB->get_record_sql("SELECT t_fname FROM {teacher} WHERE user_id = $val1");
        //print_r($value1);exit();
        $t_teacher=$value1->t_fname;
        $break_type=$records1->break_type;
        $break_ftime=$records1->break_ftime;
        $break_ttime=$records1->break_ttime;
        $days_id=$records1->days_id;
        //print_r($break_type);exit();
        // if($break != 0){
          $day_records[] = array('id' => $id,'from_time' => $from_time,'to_time' => $to_time,'t_subject' => $t_subject, 't_teacher' => $t_teacher,'break_type' => $break_type, 'break_ftime' => $break_ftime, 'break_ttime' => $break_ttime ); 
   
        }
        // $period_records = array('period_id' => $daysid);
    // print_r($day_records);exit();
        $data[] = array('days' => $day,'records' => $day_records);
    // print_r($data);exit();       
        }     
//multi-dimentional array

//print_r($days);exit();

echo $mustache->render($template,['day' => $data,'css_link'=>$css_link]);
?>
<?php
echo $OUTPUT->footer();
?>

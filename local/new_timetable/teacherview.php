<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/new_timetable/templates/teacherview.mustache');

global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;
//$linktext = "Time Table";
$linkurl = new moodle_url('/local/new_timetable/view_timetable.php');

$PAGE->set_context($context);
//$strnewclass= get_string('studentview');

$PAGE->set_url('/local/new_timetable/view_timetable.php');
$PAGE->set_heading($linktext);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);

echo $OUTPUT->header();

    $table = new html_table(); 
    $mustache = new Mustache_Engine();
    $t_teacherr=$USER->id;


    $rec=$DB->get_records_sql("SELECT {new_timetable_periods}.* FROM {new_timetable_periods} INNER JOIN {new_timetable} ON {new_timetable}.period_id={new_timetable_periods}.id WHERE {new_timetable}.t_teacher=$t_teacherr  ORDER BY {new_timetable_periods}.t_day ASC  ");

        // $rec=$DB->get_records_sql("SELECT * FROM {days}");   
        foreach ($rec as $records) {  

        $val=$records->t_day;
        $value=$DB->get_record_sql("SELECT * FROM {days} WHERE id = $val");
        $day=$value->days;

        // $daysid=$records->id; 
        $day_records= array();
        $rec2=$DB->get_records_sql("SELECT * FROM {new_timetable} WHERE days_id =$val AND t_teacher=$t_teacherr");
        // print_r($rec2);exit();
        foreach ($rec2 as $records1) {
            $period_id = $records1->period_id;
            // print_r($period_id);exit();
            $id=$records1->id;
            $from_time=$records1->from_time;
            $to_time=$records1->to_time;
            $subject=$records1->t_subject;
            $sub_name=$DB->get_record_sql("SELECT * FROM {subject} WHERE course_id = $subject");
            $t_subject= $sub_name->sub_name;
            $value1=$DB->get_record_sql("SELECT * FROM {new_timetable_periods} WHERE id = $period_id");
           
            //print_r($value1);exit();
            $class=$value1->t_class;
            $class_name=$DB->get_record_sql("SELECT * FROM {class} WHERE id = $class");
            $t_class= $class_name->class_name;

            $division=$value1->t_division;   
            $div_name=$DB->get_record_sql("SELECT * FROM {division} WHERE id = $division");
            $t_division= $div_name->div_name;

            $break_type=$records1->break_type;
            $break_ftime=$records1->break_ftime;
            $break_ttime=$records1->break_ttime;
            $days_id=$records1->days_id;

            $val1=$records1->t_teacher;
            $value1=$DB->get_record_sql("SELECT t_fname FROM {teacher} WHERE user_id = $val1");
            $t_tteacher=$value1->t_fname;
            $day_records[] = array('id' => $id,'from_time' => $from_time,'t_teacher' => $t_tteacher,'to_time' => $to_time,'t_subject' => $t_subject,'t_class' => $t_class,'t_division' => $t_division,'break_type' => $break_type, 'break_ftime' => $break_ftime, 'break_ttime' => $break_ttime ); 

            //print_r($break_type);exit();
            // if($break != 0){
              // print_r($period_records);exit();
            }
            // $period_records = array('period_id' => $daysid);
        // print_r($day_records);exit();
            $data[] = array('days' => $day,'records' => $day_records);
        // print_r($data);exit();       
            }     
    //multi-dimentional array
    $days=array('day' => $data);
    //print_r($days);exit();
   
    echo $mustache->render($template,$days);
  ?>
  <?php
    echo $OUTPUT->footer();
    ?>

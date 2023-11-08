<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/new_timetable/templates/timetable.mustache');

global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;
$linktext = "Time Table";
$linkurl = new moodle_url('/local/new_timetable/view_timetable.php');

$PAGE->set_context($context);
//$strnewclass= get_string('studentview');

$PAGE->set_url('/local/new_timetable/view_timetable.php');
$PAGE->set_heading($linktext);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);

echo $OUTPUT->header();

    $rec1=$DB->get_records_sql("SELECT * FROM {new_timetable_periods}");
    $table = new html_table();
    $mustache = new Mustache_Engine();
    $data = array();
    foreach ($rec1 as $records) {
        $val = $records->t_day;
        $value=$DB->get_record_sql("SELECT * FROM {days} WHERE id = $val");
        //print_r($value);exit();
        $day=$value->days;
        $daysid=$value->id;
        // print_r($daysid);
        //$period_records = array();
        $day_records= array();
        $rec2=$DB->get_records_sql("SELECT * FROM {new_timetable} WHERE days_id = $val");
        foreach ($rec2 as $records1) {
            $period_id = $records1->period_id;
            // print_r($period_id);exit();
            $id=$records1->id;
            $from_time=$records1->from_time;
            $to_time=$records1->to_time;
            $t_subject=$records1->t_subject;
            //print_r($break);exit();
            $val1=$records1->t_teacher;
            //print_r($val1);exit();
            $value1=$DB->get_record_sql("SELECT t_ftname FROM {teacher} WHERE user_id = $val1");
            //print_r($value1);exit();
            $t_teacher=$value1->t_ftname;
            $break_type=$records1->break_type;
            $break_ftime=$records1->break_ftime;
            $break_ttime=$records1->break_ttime;
            $days_id=$records1->days_id;
            //print_r($break_type);exit();
            // if($break != 0){
              $day_records[] = array('id' => $id,'from_time' => $from_time,'to_time' => $to_time,'t_subject' => $t_subject, 't_teacher' => $t_teacher,'break_type' => $break_type, 'break_ftime' => $break_ftime, 'break_ttime' => $break_ttime ); 
              // print_r($period_records);exit();
            }
            $period_records = array('period_id' => $daysid);
        // print_r($day_records);exit();
            $data[] = array(
                'days' => $day,
                'records' => $day_records,
                'periods' => $period_records
            );
        // print_r($data);exit();       
            }     
    //multi-dimentional array
    $days=array('day' => $data);
   
    echo $mustache->render($template,$days);
  ?>

    <a href="periods.php"><button class="btn btn-secondary add-btn mt-5"type="button">Add</button></a>

  <?php
    echo $OUTPUT->footer();
    ?>

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <link rel="stylesheet" href="css/body.css">
  
  <style>
.center {
  margin: none;
  width: 100%;
  height: 10%;

  
}
.row {
  display: flex;
  justify-content: center;
  align-items: center;

}
.card-footer{
  width: 100%;
}
#bg1{
  background-color: #e6e6e6;
}
#col1{
  background-color: #17a2b8;
}

#col2{
  background-color: #28a745;
}
#col3{
  background-color: #ffc107;
}
#f1{
  background-color: #148c9f;
}
#f2{
  background-color: #23903c;
}
#f3{
  background-color: #e6ac00;
}
/* .demopara {
  display: none;
}
    
.demohead:hover + .demopara {
  display: block;
} */



    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 550px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
        
    /* On small screens, set height to 'auto' for the grid */
    @media screen and (max-width: 767px) {
      .row.content {height: auto;} 
    }
  </style>
<?php
// include('demo.html');
require_once(__DIR__ . '/../../config.php');
// require_once(__DIR__ . '/../../lib/mustache/src/Mustache/Autoloader.php');

require_once($CFG->dirroot . '/calendar/lib.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();
$userid=$USER->id;
$tid= $DB->get_record_sql("SELECT user_id FROM mdl_teacher WHERE user_id= '$userid'");
        
if(!empty($tid) && $tid->user_id==$userid){
$template4 = file_get_contents($CFG->dirroot . '/local/dashboard/templates/teacher.mustache');


// require_once($CFG->dirroot.'/local/createstudent/demo.html');
global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;

$linkurl = new moodle_url('/local/dashboard/dashboardtchr.php');

$PAGE->set_context($context);
$strnewclass= 'Teacher Dashboard';

$PAGE->set_url('/local/dashboard/dashboardtchr.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);

echo $OUTPUT->header();
$current_time = time(); 
$current_timestamp = strtotime('now');
// print_r($current_timestamp);exit();
$sql1 = "SELECT s_name FROM {leave} WHERE f_date <= '{$current_timestamp}' AND t_date >= '{$current_timestamp}'";
$data1 = $DB->get_records_sql($sql1);
$student_id = $USER->id;
// $sql2 = "SELECT d_content FROM {diary} WHERE d_starttime <= '{$current_timestamp}' AND d_endtime >= '{$current_timestamp}' AND d_student_id ='{$student_id}'";

// d_student_id ='{$student_id}

//$sql2 ="SELECT * FROM {diary} WHERE YEAR(FROM_UNIXTIME(d_starttime)) <=  YEAR(FROM_UNIXTIME($current_timestamp)) AND MONTH(FROM_UNIXTIME(d_starttime)) <= MONTH(FROM_UNIXTIME($current_timestamp)) AND DAY(FROM_UNIXTIME(d_starttime)) <= DAY(FROM_UNIXTIME($current_timestamp)) AND YEAR(FROM_UNIXTIME(d_endtime)) >= YEAR(FROM_UNIXTIME($current_timestamp)) AND MONTH(FROM_UNIXTIME(d_endtime)) >= MONTH(FROM_UNIXTIME($current_timestamp)) AND DAY(FROM_UNIXTIME(d_endtime)) >= DAY(FROM_UNIXTIME($current_timestamp)) AND (d_student_id ='{$student_id}' OR d_student_id LIKE '%,{$student_id},%' OR d_student_id LIKE '{$student_id},%' OR d_student_id LIKE '%,{$student_id}') OR d_student_id = 'all'";
  
$sql2="SELECT *
FROM {diary}
WHERE DATE(FROM_UNIXTIME(d_starttime)) <= CURDATE() 
  AND DATE(FROM_UNIXTIME(d_endtime)) >= CURDATE() 
  AND (d_student_id = '{$student_id}' OR d_student_id = 'all' OR d_student_id LIKE '%,{$student_id}' OR d_student_id LIKE '{$student_id},%')";

$data2 = $DB->get_records_sql($sql2);

// print_r($data3);exit();

// $data2 = $DB->get_records_sql($sql2);
 //print_r($data2);exit();
$mustache = new Mustache_Engine();
$data = array(
    'myarray1' => array(),
    'diary_entries' => array(),
    'user_d_content' => '',
  
);
$data3 = $DB->get_records_sql("SELECT mdl_division.div_class, mdl_division.id
FROM mdl_division JOIN mdl_class ON mdl_division.div_class=mdl_class.id WHERE mdl_division.div_teacherid=$student_id");

foreach ($data3 as $record) {
  $div_class1 = $record->div_class;

  $div_class = $DB->get_record_sql("SELECT class_name FROM mdl_class  WHERE id=$div_class1");
  $div_class=$div_class->class_name;
  // print_r($div_class);exit();
  $id1 = $record->id;
  
  $id = $DB->get_record_sql("SELECT div_name FROM mdl_division WHERE id=$id1");
  $id = $id ->div_name;
  $data['myarray2'][] = array('div_class' => $div_class,'tid' => $id);
}
//print_r($data);exit();
foreach ($data1 as $record) {
    $sname = $record->s_name;
    $data['myarray1'][] = array('sname' => $sname);
}

foreach ($data2 as $record) {
    $d_content = $record->d_content;
    $data['diary_entries'][] = array('content' => $d_content);
    // if ($record->d_student_id == $USER->id) {
    //     $data['user_d_content'] = $d_content;
    // }
}


echo $mustache->render($template4, $data);


echo $OUTPUT->footer();
}
else{
  echo "you have no permission to access this page";
}

?>

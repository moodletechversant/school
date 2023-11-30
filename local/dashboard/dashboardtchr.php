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

//1234
// require_once($CFG->dirroot.'/local/createstudent/demo.html');

$currentMonth = date('n');
$currentWeek = ceil(date('j') / 7); // Calculate the current week of the month

if ($currentMonth >= 4 && $currentMonth <= 5) {
    $disablePromotionDiv = ''; // Enable the div
    $disablecomment = '';
} elseif (($currentMonth == 3 && $currentWeek >= 3) || ($currentMonth == 4)) {
    $disablePromotionDiv = 'pointer-events: none; '; // Disable the div
    $disablecomment1 = "this will open soon";
} else {
    $disablePromotionDiv ='pointer-events: none; '; // Disable the div
    $disablecomment = "temporarily closed";
}

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
$current_userid = $USER->id;

$current_timestamp = strtotime('now');
$sql = "SELECT s_name
        FROM {leave}
        WHERE DATE(FROM_UNIXTIME(f_date)) <= CURDATE() 
          AND DATE(FROM_UNIXTIME(t_date)) >= CURDATE()
          AND s_id IN (
            SELECT user_id
            FROM mdl_student_assign
            INNER JOIN mdl_division ON mdl_division.id = mdl_student_assign.s_division
            WHERE mdl_division.div_teacherid = $current_userid
          )
          AND l_status IN ('approved', 'pending')";
$data1 = $DB->get_records_sql($sql);
//print_r($data1);exit();

//print_r($data1);exit();
$student_id = $USER->id;

$mustache = new Mustache_Engine();
$data = array(
  'myarray1' => array(),
  'disablePromotionDiv' => $disablePromotionDiv,
  'disablecomment' => $disablecomment,
  'disablecomment1' => $disablecomment1,
);

$leaveteacher = $DB->get_records_sql("SELECT user_id FROM mdl_student_assign
    INNER JOIN mdl_division ON mdl_division.id = mdl_student_assign.s_division
    WHERE mdl_division.div_teacherid = $current_userid");
    // print_r($leaveteacher);exit();
    
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
  $firstLetter = substr($sname, 0, 1); // Extract the first letter
// 

  $data['myarray1'][] = array('sname' => $sname, 'initial' => $firstLetter);
  
}

//print_r($data);exit();

echo $mustache->render($template4, $data);


echo $OUTPUT->footer();
}
else{
  echo "you have no permission to access this page";
}

?>

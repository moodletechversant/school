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

global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;

$linkurl = new moodle_url('/local/dashboard/dashboardtchr.php');

$css_link = new moodle_url('/local/css/style.css');
$profile_view = new moodle_url('/local/profileview/viewprofilet.php');
$image1 = new moodle_url('/local/img/ic-12.svg');
$subject_enroled = new moodle_url('/local/subject/sub_teacherview.php');
$image2 = new moodle_url('/local/img/ic-23.svg');
$attendance = new moodle_url('/local/attendance/attendance.php');
$image3 = new moodle_url('/local/img/ic-24.svg');
$leaverequest = new moodle_url('/local/leaverequest/request_view.php');
$image4 = new moodle_url('/local/img/ic-25.svg');
$promotion = new moodle_url('/local/promotion/promotion.php');
$image5 = new moodle_url('/local/img/ic-26.svg');
$holiday = new moodle_url('/local/holiday/holiday_calendar.php');
$image6 = new moodle_url('/local/img/ic-27.svg');
$upcoming = new moodle_url('/local/dashboard/upcoming.php');
$image7 = new moodle_url('/local/img/ic-28.svg');
$new_timetable = new moodle_url('/local/new_timetable/teacherview.php');
$image8 = new moodle_url('/local/img/ic-7.svg');
$diary = new moodle_url('/local/diary/view_diary.php');
$image10 = new moodle_url('/local/img/ic-29.svg');
$enquiry = new moodle_url('/local/enquiry/view_enquiry.php');
$image11 = new moodle_url('/local/img/ic-31.svg');
$teacherassign = new moodle_url('/local/teacherassign/teacherlearningpath.php');
$image12 = new moodle_url('/local/img/ic-32.svg');



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
$leaveteacher = $DB->get_records_sql("SELECT user_id FROM mdl_student_assign
    INNER JOIN mdl_division ON mdl_division.id = mdl_student_assign.s_division
    WHERE mdl_division.div_teacherid = $current_userid");
    // print_r($leaveteacher);exit();

    $pendingcount = $DB->count_records_sql("SELECT COUNT(*) FROM {leave} WHERE l_status = 'pending'");

    // print_r($pendingcount);exit();
$mustache = new Mustache_Engine();
$data = array(
  'myarray1' => array(),
  
  // 'disablePromotionDiv' => $disablePromotionDiv,
  // 'disablecomment' => $disablecomment,
  // 'disablecomment1' => $disablecomment1,
);


if ($pendingcount == 0) {
  $data['leavecount'][] = array('display' => 'none');
} else {
  $data['leavecount'][] = array('count' => $pendingcount);
}


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

$bnamesCount = 1; // Counter for names
$showMore = false; // Flag to indicate if more names are available
// $sname1="click view all";
foreach ($data1 as $record) {
  $sname = $record->s_name;
  $firstLetter = substr($sname, 0, 1); // Extract the first letter

  if ($bnamesCount <= 4) {
      $data['myarray1'][] = array('sname' => $sname, 'initial' => $firstLetter);
      $bnamesCount++;
  } else {
      $showMore = true; // Set the flag if more names are available
      break; // Exit the loop as we only need 4 names
  }
}

// Add the dot entry if more names are available
if ($showMore) {
  $data['myarray1'][] = array('initial' => '.....');
}

//print_r($data);exit();

echo $mustache->render($template4,[$data,'css_link'=>$css_link,'profile_view'=>$profile_view,'image1'=>$image1,'subject_enroled'=>$subject_enroled,
'image2'=>$image2,'attendance'=>$attendance,
'image3'=>$image3,'leaverequest'=>$leaverequest,'image4'=>$image4,'promotion'=>$promotion,
'image5'=>$image5,'holiday'=>$holiday,'image6'=>$image6,'upcoming'=>$upcoming,
'image7'=>$image7,'new_timetable'=>$new_timetable,'image8'=>$image8,'diary'=>$diary,'image10'=>$image10,
'enquiry'=>$enquiry,'image11'=>$image11,'teacherassign'=>$teacherassign,'image12'=>$image12]);


echo $OUTPUT->footer();
}
else{
  echo "you have no permission to access this page";
}

?>

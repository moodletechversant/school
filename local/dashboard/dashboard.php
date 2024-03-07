<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/dashboard/templates/dashboard.mustache');

global $class, $CFG;
$context = context_system::instance();
$linktext = "Dashboard";
$linkurl = new moodle_url('/local/dashboard/dashboard.php');

$css_link = new moodle_url('/local/css/style.css');
$viewprofile= new moodle_url('/local/profileview/viewprofile.php');
$ic12= new moodle_url('/local/img/ic-12.svg');
$sub_studentview= new moodle_url('/local/subject/sub_studentview.php');
$ic5= new moodle_url('/local/img/ic-5.svg');
$student_learningpath= new moodle_url('/local/subject/student_learningpath.php');
$ic2= new moodle_url('/local/img/ic-2.svg');
$viewattendstd= new moodle_url('/local/attendance/viewattendstd.php');
$ic6= new moodle_url('/local/img/ic-6.svg');
$studentview_1= new moodle_url('/local/new_timetable/studentview_1.php');
$ic13= new moodle_url('/local/img/ic-13.svg');
$studentview_diary= new moodle_url('/local/diary/diary_stud_view.php');
$ic14= new moodle_url('/local/img/ic-14.svg');
$upcoming= new moodle_url('/local/dashboard/upcoming.php');
$ic7= new moodle_url('/local/img/ic-7.svg');
$holiday_calendar= new moodle_url('/local/holiday/holiday_calendar.php');
$ic8= new moodle_url('/local/img/ic-8.svg');
$std_viewrequest= new moodle_url('/local/leaverequest/std_viewrequest.php');
$ic15= new moodle_url('/local/img/ic-15.svg');
$view_complaint= new moodle_url('/local/complaint/view_complaint.php');
$ic9= new moodle_url('/local/img/ic-9.svg');
$survey_studentview= new moodle_url('/local/survey/survey_studentview.php');
$ic17= new moodle_url('/local/img/ic-17.svg');
$view_enquiry1= new moodle_url('/local/enquiry/view_enquiry1.php');
$ic18= new moodle_url('/local/img/ic-18.svg');
$student_div_analyticalview= new moodle_url('/local/division/student_div_analyticalview.php');
$ic19= new moodle_url('/local/img/ic-19.svg');

$PAGE->set_context($context);
echo $OUTPUT->header();

$current_time = time(); 
//print_r($current_time);exit();


$current_userid = $USER->id;

$current_timestamp = strtotime('now');
// $data1 = $DB->get_records_sql("SELECT s_name FROM {leave} WHERE (f_date <= '{$current_timestamp}' AND t_date >= '{$current_timestamp}')");
$sql = "SELECT s_name
FROM {leave}
WHERE DATE(FROM_UNIXTIME(f_date)) <= CURDATE() 
  AND DATE(FROM_UNIXTIME(t_date)) >= CURDATE()
  AND (l_status = 'approved' OR l_status = 'pending')";
$data1 = $DB->get_records_sql($sql);

//  print_r($data1);exit();

$sql2 = "SELECT *
FROM {diary}
WHERE DATE(FROM_UNIXTIME(d_starttime)) <= CURDATE() 
  AND DATE(FROM_UNIXTIME(d_endtime)) >= CURDATE() 
  AND (d_student_id = '{$student_id}' OR d_student_id = 'all' OR d_student_id LIKE '%,{$student_id}' OR d_student_id LIKE '{$student_id},%')";

$data2 = $DB->get_records_sql($sql2);

$data = array(
    'myarray1' => array(),
    'diary_entries' => array(),
    'user_d_content' => array(
        'length' => count($data2),
        'is_read_more' => (count($data2) > 1),
        'user_d_content' => '',
    ),
);

$bnamesCount = 1; // Counter for names
$showMore = false; // Flag to indicate if more names are available

foreach ($data1 as $record) {
    if (!empty($record)) { // Check if $record is not empty
        $sname = $record->s_name;
        $firstLetter = substr($sname, 0, 1); // Extract the first letter

        if ($bnamesCount <= 4) {
            $data['myarray1'][] = array('sname' => $sname, 'initial' => $firstLetter);
            $bnamesCount++;
        } else {
            $showMore = true; // Set the flag if more names are available
            break; // Exit the loop as we only need 4 names
        }
        $lastEntry = $record; // Update last entry
    } 
}
if (empty($data['myarray1'])) {
    $data['myarray2'] = true; 
}
if ($showMore) {
    $data['myarray1'][] = array('initial' => '.....');
}

$index = 0;
$lastEntry = null;

foreach ($data2 as $record) {
    $d_content = $record->d_content;
    if ($index < 1) {
        $data['diary_entries'][] = array('content' => $d_content);
    }
    if ($record->d_student_id == $USER->id) {
        $data['user_d_content']['user_d_content'] = $d_content;
    }

    $lastEntry = $d_content; // Store the last entry content
    $index++;
}

$table1 = 'attendance'; 
$condition1 = array('stud_name' => $current_userid);
$attendanceData = $DB->get_records($table1, $condition1, '', 'id, tdate, attendance');

$adata = array_fill(0, 12, 0); 

foreach ($attendanceData as $record) {
    $timestamp = strtotime($record->tdate); 
    $month = date('n', $timestamp); 

    if ($record->attendance == 'Absent') {
        $adata[$month - 1]++;
    }
}
// print_r($adata);exit();

$chartData1 = json_encode($adata); 

$table2 = 'leave'; 
$condition2 = array('s_id' => $current_userid);

$leaveData = $DB->get_records($table2, $condition2, '', 'id, f_date, t_date, l_status, n_leave');

$ldata = array_fill(0, 12, 0); 

foreach ($leaveData as $record) {
    if ($record->l_status == 'approved') {
        $f_month = date('n', $record->f_date);
        $t_month = date('n', $record->t_date);
        for ($month = $f_month; $month <= $t_month; $month++) {
            $ldata[$month - 1] += $record->n_leave; 
        }
    }
}

$chartData2 = json_encode($ldata); 

// $mustacheData = array(
//     'chartData1' => $chartData1,
//     'chartData2' => $chartData2,
//     'data' => $data
// );
// print_r($mustacheData);exit();
$mustache = new Mustache_Engine();
echo $mustache->render($template, ['chartData1' => $chartData1,
'chartData2' => $chartData2,
'data' => $data,
'css_link'=>$css_link,'viewprofile'=>$viewprofile,
'ic12'=>$ic12,'sub_studentview'=>$sub_studentview,'ic5'=>$ic5,'student_learningpath'=>$student_learningpath,
'ic2'=>$ic2,'viewattendstd'=>$viewattendstd,'ic6'=>$ic6,'studentview_1'=>$studentview_1,
'ic13'=>$ic13,'studentview_diary'=>$studentview_diary,'ic14'=>$ic14,'upcoming'=>$upcoming,
'ic7'=>$ic7,'holiday_calendar'=>$holiday_calendar,'ic8'=>$ic8,'std_viewrequest'=>$std_viewrequest,
'ic15'=>$ic15,'view_complaint'=>$view_complaint,'ic9'=>$ic9,'survey_studentview'=>$survey_studentview,
'ic17'=>$ic17,'view_enquiry1'=>$view_enquiry1,'ic18'=>$ic18,
'student_div_analyticalview'=>$student_div_analyticalview,'ic19'=>$ic19]);

echo $OUTPUT->footer();

?>

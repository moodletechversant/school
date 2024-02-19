<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/dashboard/templates/parent.mustache');

global $class, $CFG;
$context = context_system::instance();
$linktext = "Dashboard";
$linkurl = new moodle_url('/local/dashboard/dashboardparent.php');
$PAGE->set_context($context);
echo $OUTPUT->header();

$current_time = time(); 
//print_r($current_time);exit();


$current_userid = $USER->id;
// print_r($current_userid);exit();


$current_timestamp = strtotime('now');
// $data1 = $DB->get_records_sql("SELECT s_name FROM {leave} WHERE (f_date <= '{$current_timestamp}' AND t_date >= '{$current_timestamp}')");
// $sql = "SELECT s_name
// FROM {leave}
// WHERE DATE(FROM_UNIXTIME(f_date)) <= CURDATE() 
//   AND DATE(FROM_UNIXTIME(t_date)) >= CURDATE()
//   AND (l_status = 'approved' OR l_status = 'pending')";
// $data1 = $DB->get_records_sql($sql);

// //  print_r($data1);exit();

// $sql2 = "SELECT *
// FROM {diary}
// WHERE DATE(FROM_UNIXTIME(d_starttime)) <= CURDATE() 
//   AND DATE(FROM_UNIXTIME(d_endtime)) >= CURDATE() 
//   AND (d_student_id = '{$current_userid}' OR d_student_id = 'all' OR d_student_id LIKE '%,{$current_userid}' OR d_student_id LIKE '{$current_userid},%')";

// $data2 = $DB->get_records_sql($sql2);
//  print_r($data2);exit();


// $data = array(
//     'myarray1' => array(),
//     'diary_entries' => array(),
//     'user_d_content' => array(
//         'length' => count($data2),
//         'is_read_more' => (count($data2) > 1),
//         'user_d_content' => '',
//     ),
// );

// $lastEntry = end($data2); // Get the last entry from $data2
// if ($lastEntry) {
//     $data['diary_entries'][] = array('content' => $lastEntry->d_content);
// }
// $bnamesCount = 1; // Counter for names
// $showMore = false; // Flag to indicate if more names are available
// // $sname1="click view all";
// foreach ($data1 as $record) {
//     $sname = $record->s_name;
//     $firstLetter = substr($sname, 0, 1); // Extract the first letter

//     if ($bnamesCount <= 4) {
//         $data['myarray1'][] = array('sname' => $sname, 'initial' => $firstLetter);
//         $bnamesCount++;
//     } else {
//         $showMore = true; // Set the flag if more names are available
//         break; // Exit the loop as we only need 4 names
//     }
// }

// // Add the dot entry if more names are available
// if ($showMore) {
//     $data['myarray1'][] = array('initial' => '.....');
// }


// if($bnamesCount>4){
//     $dots1='...';
// }
// else{
//     $dots1='';
// }
// $dots=array('dots1'=>$dots1);

// $index = 0;
// $lastEntry = null;

// foreach ($data2 as $record) {
//     $d_content = $record->d_content;
//     if ($index < 1) {
//         $data['diary_entries'][] = array('content' => $d_content);
//     }
//     if ($record->d_student_id == $USER->id) {
//         $data['user_d_content']['user_d_content'] = $d_content;
//     }

//     $lastEntry = $d_content; // Store the last entry content
//     $index++;
// }



// $table1 = 'attendance'; 
// $condition1 = array('stud_name' => $current_userid);
// $attendanceData = $DB->get_records($table1, $condition1, '', 'id, tdate, attendance');

// $adata = array_fill(0, 12, 0); 

// foreach ($attendanceData as $record) {
//     $timestamp = strtotime($record->tdate); 
//     $month = date('n', $timestamp); 

//     if ($record->attendance == 'Absent') {
//         $adata[$month - 1]++;
//     }
// }
// // print_r($adata);exit();


// $chartData1 = json_encode($adata); 

// $table2 = 'leave'; 
// $condition2 = array('s_id' => $current_userid);

// $leaveData = $DB->get_records($table2, $condition2, '', 'id, f_date, t_date, l_status, n_leave');

// $ldata = array_fill(0, 12, 0); 

// foreach ($leaveData as $record) {
//     if ($record->l_status == 'approved') {
//         $f_month = date('n', $record->f_date);
//         $t_month = date('n', $record->t_date);
//         for ($month = $f_month; $month <= $t_month; $month++) {
//             $ldata[$month - 1] += $record->n_leave; 
//         }
//     }
// }

// $chartData2 = json_encode($ldata); 

// $mustacheData = array(
//     'chartData1' => $chartData1,
//     'chartData2' => $chartData2,
//     'data' => $data
// );
// print_r($mustacheData);exit();
$mustache = new Mustache_Engine();
echo $mustache->render($template);

echo $OUTPUT->footer();

?>

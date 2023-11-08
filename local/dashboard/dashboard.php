<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/dashboard/templates/dashboard.mustache');

global $class, $CFG;
$context = context_system::instance();
$linktext = "Dashboard";
$linkurl = new moodle_url('/local/dashboard/dashboard.php');
$PAGE->set_context($context);
echo $OUTPUT->header();

$current_time = time(); 


$current_userid = $USER->id;

$current_timestamp = strtotime('now');
// $data1 = $DB->get_records_sql("SELECT s_name FROM {leave} WHERE (f_date <= '{$current_timestamp}' AND t_date >= '{$current_timestamp}')");
$sql = "SELECT s_name
FROM {leave}
WHERE DATE(FROM_UNIXTIME(f_date)) <= CURDATE() 
  AND DATE(FROM_UNIXTIME(t_date)) >= CURDATE()";
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

// $lastEntry = end($data2); // Get the last entry from $data2
// if ($lastEntry) {
//     $data['diary_entries'][] = array('content' => $lastEntry->d_content);
// }

foreach ($data1 as $record) {
    $sname = $record->s_name;
    $firstLetter = substr($sname, 0, 1); // Extract the first letter
// print_r($firstLetter);exit();

    $data['myarray1'][] = array('sname' => $sname, 'initial' => $firstLetter);
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

$mustacheData = array(
    'chartData1' => $chartData1,
    'chartData2' => $chartData2,
    'data' => $data
);
// print_r($mustacheData);exit();
$mustache = new Mustache_Engine();
echo $mustache->render($template, $mustacheData);

echo $OUTPUT->footer();

?>

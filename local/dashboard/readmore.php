<?php
// include('demo.html');
require_once(__DIR__ . '/../../config.php');
// require_once(__DIR__ . '/../../lib/mustache/src/Mustache/Autoloader.php');

require_once($CFG->dirroot . '/calendar/lib.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template4 = file_get_contents($CFG->dirroot .'/local/dashboard/templates/readmore.mustache');

// require_once($CFG->dirroot.'/local/createstudent/demo.html');
global $class, $CFG, $OUTPUT, $PAGE;
$userid= $USER->id;
$context = context_system::instance();
// $classid = $class->id;

$linkurl = new moodle_url('/local/dashboard/readmore.php');

$PAGE->set_context($context);
$strnewclass = 'Notification';

$PAGE->set_url('/local/dashboard/readmore.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);

echo $OUTPUT->header();
$var="SELECT * FROM {student} WHERE user_id=$userid";
$recs=$DB->get_record_sql($var);

$sql2 = "SELECT * FROM {diary} WHERE (d_student_id = '{$recs->user_id}' OR d_student_id LIKE '%,{$recs->user_id},%' OR d_student_id LIKE '{$recs->user_id},%' OR d_student_id LIKE '%,{$recs->user_id}') OR d_student_id = 'all'";
    $rec1 = $DB->get_records_sql($sql2);
// print_r($rec1);exit();
    $table = new html_table();
    $mustache = new Mustache_Engine();
    $data = array();
    foreach ($rec1 as $records) {
        $content=$records->d_content;

        $dateFormat = 'd-m-Y';
        $s_timestamp=$records->d_starttime;
        $stime = date($dateFormat, $s_timestamp);

        $e_timestamp=$records->d_endtime;
        $etime = date($dateFormat, $e_timestamp);
       
        // print_r($day_records);exit();
            $data[] = array(
                'content' => $content,
                's_time' =>$stime,
                'e_time' =>$etime);
        // print_r($data);exit();       
            }     
    //multi-dimentional array
    $days=array('day' => $data);
    //print_r($data);exit(); 
    echo $mustache->render($template4,$days);
 
    echo $OUTPUT->footer();
    ?>

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
 
<style>
    
</style>

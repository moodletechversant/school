<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/diary/templates/diary_stud_view.mustache');

global $class, $CFG;
$context = context_system::instance();
$linktext = "Dashboard";
$linkurl = new moodle_url('/local/diary/diary_stud_view.php');
$stud_view_diary = new moodle_url('/local/diary/diary_stud.php?id');
$style = new moodle_url('/local/css/style.css');
$PAGE->set_context($context);
echo $OUTPUT->header();
$current_time = time(); 
//print_r($current_time);exit();
$current_user_id = $USER->id;
//print_r($USER->id);exit();
$var="SELECT * FROM {student} WHERE user_id=$current_user_id";
$recs=$DB->get_record_sql($var);

    $sql = "SELECT * FROM {diary} WHERE (d_student_id = '{$recs->user_id}' OR d_student_id LIKE '%,{$recs->user_id},%' OR d_student_id LIKE '{$recs->user_id},%' OR d_student_id LIKE '%,{$recs->user_id}') OR d_student_id = 'all' ORDER BY d_starttime DESC, d_endtime DESC";
    $rec = $DB->get_records_sql($sql);
          // print_r($rec);exit();

    if (!empty($rec)) {
        foreach ($rec as $records) {
        $id = $records->id; 
        $studname = $records->d_studentname;
        $subject = $records->d_subject;
        $fullcontent = $records->d_content;
        $contentLength = strlen($fullcontent);
        // print_r($contentLength);exit();
      if($contentLength>50){
        $content = substr($fullcontent, 0, 50) . '......';
      }
      else{
        $content = $records->d_content;
      }
        $option = $records->d_option;
        $suboption =$records->d_suboption;
        $dateFormat = 'd F Y';
        $s_timestamp=$records->d_diary_created;
        $stime = date($dateFormat, $s_timestamp);
        $current_date=date('d F Y');
        if($stime==$current_date){
          $stime = 'Today';

        }
        $e_timestamp=$records->d_endtime;
        $etime = date($dateFormat, $e_timestamp);
        $data[] =  array('id'=>$id, 'd_studentname' => $studname,'d_subject' => $subject,'d_content' => $content,'d_option' => $option, 'd_suboption' => $suboption, 's_time' => $stime, 'e_time' => $etime); 
        //echo $mustache->render($template1,$data); 
     } 

    } else{
      echo '<div class="mt-5" style="color: rgb(52, 112, 124); font-size: 20px; text-align: center;"><b>There is nothing to display...</b></div>';
    } 
    $diarydata = array('diary' => $data,'stud_view_diary'=>$stud_view_diary,'style'=>$style);
$mustache = new Mustache_Engine();
echo $mustache->render($template,$diarydata);

echo $OUTPUT->footer();

?>

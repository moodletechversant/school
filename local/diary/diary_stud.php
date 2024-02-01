<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/diary/templates/diary_stud.mustache');

global $class, $CFG;
$context = context_system::instance();
$linktext = "Dashboard";
$linkurl = new moodle_url('/local/diary/diary_stud.php');
$style = new moodle_url('/local/css/style.css');

$PAGE->set_context($context);
echo $OUTPUT->header();
$current_time = time(); 
//print_r($current_time);exit();
$id_diary  = optional_param('id', 0, PARAM_INT);
$current_user_id = $USER->id;
    $rec = $DB->get_records_sql("SELECT * FROM {diary} WHERE id=$id_diary ");
          // print_r($rec);exit();

    if (!empty($rec)) {
        foreach ($rec as $records) {
        $id = $records->id; 
        $subject = $records->d_subject;
        $content = $records->d_content;
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
     } 

    } else{
      echo '<div class="mt-5" style="color: rgb(52, 112, 124); font-size: 20px; text-align: center;"><b>There is nothing to display...</b></div>';
    } 
    $diarydata = array('diary' => $data,'stylee'=>$style);
$mustache = new Mustache_Engine();
echo $mustache->render($template,$diarydata);

echo $OUTPUT->footer();

?>

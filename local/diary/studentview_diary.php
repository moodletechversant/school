<?php
// include('demo.html');
require_once(__DIR__ . '/../../config.php');
// require_once(__DIR__ . '/../../lib/mustache/src/Mustache/Autoloader.php');


require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/diary/templates/studentview_diary.mustache');
$template1 = file_get_contents($CFG->dirroot . '/local/diary/templates/studentview_diary1.mustache');


// require_once($CFG->dirroot.'/local/createstudent/demo.html');
global $USER,$class,$CFG;
$context = context_system::instance();
require_login();
// $classid = $class->id;
$linktext = "Student diary";

$linkurl = new moodle_url('/local/diary/studentview_diary.php');

$PAGE->set_context($context);
$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
//$PAGE->set_heading($linktext);
// $PAGE->set_heading($SITE->fullname);
// $PAGE->requires->html('/demo.html');
// $addstudent='<button style="background:transparent;border:none;"><a href="/school/local/createstudent/createstudent.php" style="text-decoration:none;"><font size="50px";color="#0f6cbf";>+</font></a></button>';


echo $OUTPUT->header();

$current_user_id = $USER->id;
//print_r($USER->id);exit();
$var="SELECT * FROM {student} WHERE user_id=$current_user_id";
$recs=$DB->get_record_sql($var);

    $sql = "SELECT * FROM {diary} WHERE (d_student_id = '{$recs->user_id}' OR d_student_id LIKE '%,{$recs->user_id},%' OR d_student_id LIKE '{$recs->user_id},%' OR d_student_id LIKE '%,{$recs->user_id}') OR d_student_id = 'all'";
    $rec = $DB->get_records_sql($sql);
    //print_r($rec);exit();
     $table = new html_table();
     $mustache = new Mustache_Engine();
     echo $mustache->render($template,$data);
     if (!empty($rec)) {
    foreach ($rec as $records) {
    $id = $records->id; 
    $studname = $records->d_studentname;
    $subject = $records->d_subject;
    $content = $records->d_content;
    $option = $records->d_option;
    $suboption =$records->d_suboption;

    $data =  array('id'=>$id, 'd_studentname' => $studname,'d_subject' => $subject,'d_content' => $content,'d_option' => $option, 'd_suboption' => $suboption); 
    echo $mustache->render($template1,$data); 
 } 
} else{
  echo '<div class="mt-5" style="color: rgb(52, 112, 124); font-size: 20px; text-align: center;"><b>There is nothing to display...</b></div>';
} 
    echo $OUTPUT->footer();

?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
    
    const myIcons = document.querySelectorAll('.arrow');
    const myParagraphs = document.querySelectorAll('.hide');
    


    myIcons.forEach((icon, index) => {
      icon.addEventListener('click', () => {
        if (myParagraphs[index].style.display === 'block') {
          myParagraphs[index].style.display = 'none';
          icon.classList.remove('fa-angle-up');
        } else {
          myParagraphs[index].style.display = 'block';
          icon.classList.add('fa-angle-up');
        }
      });
    });

   
  

    </script>
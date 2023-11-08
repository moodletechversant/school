<?php
// include('demo.html');
require_once(__DIR__ . '/../../config.php');
// require_once(__DIR__ . '/../../lib/mustache/src/Mustache/Autoloader.php');


require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/diary/templates/view_diary.mustache');
$template1 = file_get_contents($CFG->dirroot . '/local/diary/templates/view_diary1.mustache');


// require_once($CFG->dirroot.'/local/createstudent/demo.html');
global $class,$CFG;
$context = context_system::instance();
require_login();
// $classid = $class->id;
$linktext = "View diary";

$linkurl = new moodle_url('/local/diary/view_diary.php');

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

     $rec=$DB->get_records_sql("SELECT * FROM {diary}");
     //$rec = $DB->get_records_sql('SELECT d.*, u.username FROM {diary} d INNER JOIN {user} u ON d.d_student_id = u.id');
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
    const mySend = document.querySelectorAll('.send');


    myIcons.forEach((icon, index) => {
      icon.addEventListener('click', () => {
        if (myParagraphs[index].style.display === 'block') {
          myParagraphs[index].style.display = 'none';
          mySend[index].style.display = 'none';
          icon.classList.remove('fa-angle-up');
        } else {
          myParagraphs[index].style.display = 'block';
          mySend[index].style.display = 'block';

          icon.classList.add('fa-angle-up');
        }
      });
    });

   
  

    </script>
<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

global $CFG,$USER;

$context = context_system::instance();
require_login();
$template = file_get_contents($CFG->dirroot . '/local/progresscard/template/progresscard.mustache');
$linkurl = new moodle_url('/local/subject/progresscard.php'); 
// Print the page header.
$css_link = new moodle_url('/local/css/style.css');
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
// $PAGE->set_heading($linktext);
$PAGE->navbar->add('progresscard', new moodle_url($CFG->wwwroot.'/local/progresscard/progresscard.php'));
$user_id=$USER->id;
echo $OUTPUT->header();

$childids=$DB->get_record_sql("SELECT child_id FROM {parent} WHERE user_id=$user_id");
$childid=$childids->child_id;
$student_details=array();
$student_details=$DB->get_records_sql("SELECT user_id,s_ftname,s_mlname,s_lsname FROM {student} WHERE user_id=$childid");
//print_r($student_details);exit();

foreach($student_details as $student){

    $sname = $student->s_ftname;
    $smname = $student->s_mlname;
    $slame = $student->s_lsname;
    $fname=$sname." ".$smname." ".$slame; 
    $val1 =$student->user_id;

    //print_r($fname);exit();

$rec1 = $DB->get_record_sql("SELECT d.div_class,d.id, d.div_name, d.div_teacherid, t.t_fname, c.academic_id, c.class_name
    FROM {student_assign} sa
    INNER JOIN {division} d ON sa.s_division = d.id
    INNER JOIN {teacher} t ON d.div_teacherid = t.user_id
    INNER JOIN {class} c ON d.div_class = c.id
    WHERE sa.user_id = $val1");
//    print_r($rec1);exit();

    $classname=$rec1->class_name;
    $division=$rec1->div_name;
    $division_id=$rec1->id;
    $classteacher=$rec1->t_fname;
    $academic_id=$rec1->academic_id;

  $rec2= $DB->get_records_sql("SELECT * FROM {academic_year} WHERE id=$academic_id"); 
  foreach($rec2 as $data){
    $startyear=$data->start_year;
    $endyear=$data->end_year; 
    $startyear1=date("d-m-Y", $startyear);
    $endyear1=date("d-m-Y", $endyear);
    $academic_year=$startyear1."  to  ".$endyear1;
    //print_r($academic_year);exit();
  
  
$subject=$DB->get_records_sql("SELECT course_id FROM {subject} WHERE sub_division=$division_id");
//print_r($subject);exit();
foreach($subject as $sub){
 $course_id=$sub->course_id;
 $coursename=$DB->get_record_sql("SELECT fullname FROM {course} WHERE id=$course_id");
 $course_name=$coursename->fullname;
 
 $demo = $DB->get_records_sql("SELECT q.name, q.sumgrades AS quiz_sumgrades, q.grade AS quiz_grade, qa.sumgrades AS attempt_sumgrades, qg.grade AS grade
FROM {quiz} q 
INNER JOIN {quiz_attempts} qa ON q.id = qa.quiz 
INNER JOIN {quiz_grades} qg ON qa.quiz = qg.quiz 
WHERE qg.userid = $val1 AND q.course = $course_id");
foreach($demo as $row){
    $exam_name=$row->name;
    $marktotal=$row->quiz_sumgrades;
    $gradetotal=$row->quiz_grade;
    $markgained=$row->attempt_sumgrades;
    $gradegained=$row->grade;

$exam[] = array('exam_name' => $exam_name,'marktotal' => $marktotal,'gradetotal'=>$gradetotal,'markgained'=>$markgained,'gradegained'=>$gradegained);
}
$profile[] = array('course_name' => $course_name,'exam'=>$exam);
}
$profile1[] = array('academic_year' => $academic_year,'profile'=>$profile);
}
$profile2[] = array('fname'=>$fname,'classname' => $classname,'division'=>$division,'classteacher'=>$classteacher,'academic_year'=>$academic_year,'profile1'=>$profile1);
//print_r($profile2);exit();
}
 $mustache = new Mustache_Engine();
 echo $mustache->render($template,['profile2'=>$profile2,'css_link'=>$css_link]);
 echo $OUTPUT->footer();
 ?>


<?php
// include('demo.html');
require_once(__DIR__ . '/../../config.php');
// require_once(__DIR__ . '/../../lib/mustache/src/Mustache/Autoloader.php');

require_once($CFG->dirroot . '/calendar/lib.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

global $class,$CFG,$USER;
$context = context_system::instance();
$user=$USER->id;
$template = file_get_contents($CFG->dirroot . '/local/profileview/template/profilet.mustache');

$linkurl = new moodle_url('/local/profileview/viewprofilet.php');
$css_link = new moodle_url('/local/css/style.css');
$img_link = new moodle_url('/local/img/logo.svg');
$img_link1 = new moodle_url('/local/img/dummy-user.png');
$img_link2 = new moodle_url('/local/img/tabler_dots.svg');
$course_view = new moodle_url('/course/view.php?id');

$PAGE->set_context($context);
$strnewclass= 'Profile';

$PAGE->set_url('/local/profileview/viewprofilet.php');
;
$PAGE->set_title($strnewclass);

 echo $OUTPUT->header();

$rec = $DB->get_records_sql("SELECT * FROM {teacher} WHERE user_id = ?", array($user));

$tprofile = array();
$scourses1 = array();
foreach ($rec as $teacher) {
  $val1 =$teacher->user_id;
    $tname = $teacher->t_fname;
   
    $tmname = $teacher->t_mname;
    $tlname = $teacher->t_lname;
    $fname=$tname." ".$tmname." ".$tlname; 
    // print_r($fname);exit();
    $email = $teacher->t_email;

    $dob = $teacher->t_dob;
    $dob1 = date("d-m-Y", $dob);
   
    $address = $teacher->t_address;
    $no = $teacher->t_mno;

    $tprofile[] = array('name' => $fname, 'email' => $email, 'dob' => $dob1, 'address' => $address, 'no' => $no);
    $assign = $rec1 = $DB->get_records_sql("
        SELECT {course}.fullname, {course}.id, {user_enrolments}.userid 
        FROM {course} 
        JOIN {enrol} ON {enrol}.courseid = {course}.id 
        JOIN {user_enrolments} ON {user_enrolments}.enrolid = {enrol}.id 
        WHERE {user_enrolments}.userid = ?", array($val1));


    $assignt = array();
foreach ($assign as $record) {
  $fullname = $record->fullname;
  $courseid = $record->id;
  $userid = $record->userid;
  $sub = $DB->get_record_sql("SELECT * FROM {subject} WHERE course_id= ?", array($courseid));
  $did = $sub->sub_division;
    
    $div = $DB->get_record_sql("SELECT * FROM {division} WHERE id = ?", array($did));
    $divname=$div->div_name;
        
    $clsname=$div->div_class;
  
    $cls = $DB->get_record_sql("SELECT * FROM {class} WHERE id = ?", array($clsname));
   
    $clsname1=$cls->class_name;

    $cdname = $clsname1 . ' ' . $divname; 

  
 
  $assignt[] = array('subjects' => $fullname,'id' =>$courseid, 'class' => $cdname);    
}

}

$scourses1=array('courses' => $assignt);
$tprofile1 = array('teachers' => $tprofile);

$mustache = new Mustache_Engine();



$mergedArray = array_merge($scourses1, $tprofile1,['css_link'=>$css_link,'img_link1'=>$img_link1,'img_link2'=>$img_link2,'img_link'=>$img_link,'course_view'=>$course_view]);


echo $mustache->render($template,$mergedArray);


echo $OUTPUT->footer();


?>









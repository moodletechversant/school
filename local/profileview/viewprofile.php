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
$template = file_get_contents($CFG->dirroot . '/local/profileview/template/profile.mustache');

$linkurl = new moodle_url('/local/profileview/viewprofile.php');
$css_link = new moodle_url('/local/css/style.css');
$img_link = new moodle_url('/local/img/logo.svg');
$img_link1 = new moodle_url('/local/img/dummy-user.png');
$img_link2 = new moodle_url('/local/img/tabler_dots.svg');

$img_link3 = new moodle_url('/local/img/circum_mobile-3.svg');
$img_link4 = new moodle_url('/local/img/uiw_date.svg');
$img_link5 = new moodle_url('/local/img/ph_address-book.svg');

$course_view = new moodle_url('/course/view.php?id');

$PAGE->set_context($context);
$strnewclass= 'Profile';

$PAGE->set_url('/local/profileview/viewprofile.php');
;
$PAGE->set_title($strnewclass);

echo $OUTPUT->header();

$student = $DB->get_record_sql("SELECT * FROM {student} WHERE user_id=$user");
// print_r($student);exit();
$sprofile = array(); 
$scourses1 = array(); 

$studentt = $DB->get_record_sql("SELECT * FROM {student_assign} WHERE user_id=$user");
if(!empty($studentt)){
$s_division = $studentt->s_division;
$value=$DB->get_record_sql("SELECT * FROM {division} WHERE id=$s_division");
$value1=$DB->get_record_sql("SELECT * FROM {teacher} WHERE user_id=$value->div_teacherid");
$clstcher1=$value1->t_fname;
}
    $sname = $student->s_ftname;
    $smname = $student->s_mlname;
    $slame = $student->s_lsname;
    $fname=$sname." ".$smname." ".$slame; 
    $email = $student->s_email;
    $dob = $student->s_dob;
    $dob1 = date("d-m-Y", $dob);
   
    $address = $student->s_address;
    $no = $student->s_gno;

    $rec2 = $DB->get_record_sql("SELECT d.div_class, d.div_name, d.div_teacherid, t.t_fname, c.class_name
    FROM {student_assign} sa
    INNER JOIN {division} d ON sa.s_division = d.id
    INNER JOIN {teacher} t ON d.div_teacherid = t.user_id
    INNER JOIN {class} c ON d.div_class = c.id
    WHERE sa.user_id = $user");
    //  print_r($rec2);exit();

  $rec1 = $DB->get_records_sql("SELECT {course}.fullname,{course}.id FROM {course} JOIN {enrol} ON
    {enrol}.courseid = {course}.id JOIN {user_enrolments}
    ON {user_enrolments}.enrolid = {enrol}.id where {user_enrolments}.userid=$user");
// print_r($rec1);exit();
    // $subjects = array(); // Create a new subjects array for each student
    // $empty=!empty($rec1);
    // if(!empty($rec1)){
      foreach ($rec1 as $course) {
        $cid = $course->id;
        $subjects1 = $course->fullname;
        $teacher_assignments = $DB->get_records_sql("SELECT * FROM {teacher_assign} WHERE t_subject = ?", array($cid));
    // print_r($teacher_assignments);exit();
        foreach ($teacher_assignments as $teacher_assignment) {
            $teacher1 = $teacher_assignment->user_id;
            $teacher_info = $DB->get_record_sql("SELECT * FROM {teacher} WHERE user_id = ?", array($teacher1));
            $teachername = $teacher_info->t_fname.''.$teacher_info->t_mname.' '.$teacher_info->t_lname;
            // Now you can use $teachername for further processing.
        }
    
          $subjects[] = array('subjects' => $subjects1,'id' =>$cid,'teacher' => $teachername);
  
      }
    // }
    // else{
    //   $subjects1="you are not assigned to any classes contact your class teacher";
    //   $subjects[] = array('subjects' => $subjects1);
    // }
    
    $sprofile[] = array('name' => $fname, 'email' => $email, 'dob' => $dob1, 'address' => $address, 'no' => $no,'classname'=>$rec2->class_name ,'divisionname'=>$rec2->div_name,'classteacher' =>$clstcher1, 'subjects' =>$subjects);
    $scourses1=array('courses' => $subjects,'empty_course'=>!empty($rec1));
  $sprofile1 = array('students' => $sprofile);
$mustache = new Mustache_Engine();
$mergedArray = array_merge($scourses1, $sprofile1,['css_link'=>$css_link,'img_link1'=>$img_link1,'img_link2'=>$img_link2,'img_link'=>$img_link,'course_view'=>$course_view,'img_link3'=>$img_link3,'img_link4'=>$img_link4,'img_link5'=>$img_link5]);
echo $mustache->render($template,$mergedArray);
echo $OUTPUT->footer();
?>


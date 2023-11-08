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

$PAGE->set_context($context);
$strnewclass= 'Profile';

$PAGE->set_url('/local/profileview/viewprofile.php');
;
$PAGE->set_title($strnewclass);

echo $OUTPUT->header();

$rec = $DB->get_records_sql("SELECT * FROM {student} WHERE user_id=$user");
$current_user_id=$USER->id;

//print_r($rec);exit();
$sprofile = array(); 
$scourses1 = array(); 
foreach ($rec as $student) {
 
  $val = $student->s_class;
  // print_r($val);exit();
  $value=$DB->get_record_sql("SELECT * FROM {division} WHERE div_class=$val");

  
  $clstcher = $value->div_teacherid;
  $value1=$DB->get_record_sql("SELECT * FROM {teacher} WHERE user_id=$clstcher");

  $clstcher1=$value1->t_fname;

$val1 =$student->user_id;
// print_r($val1);exit();

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
    ON {user_enrolments}.enrolid = {enrol}.id where {user_enrolments}.userid=$val1");
// print_r($rec1);exit();
    // $subjects = array(); // Create a new subjects array for each student
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


   
    $sprofile[] = array('name' => $fname, 'email' => $email, 'dob' => $dob1, 'address' => $address, 'no' => $no,'classname'=>$rec2->class_name ,'divisionname'=>$rec2->div_name,'classteacher' =>$clstcher1, 'subjects' =>$subjects);

  }

  $scourses1=array('courses' => $subjects);
  //print_r( $scourses1);exit();
$sprofile1 = array('students' => $sprofile);
// print_r($sprofile1);exit();
$mustache = new Mustache_Engine();



$mergedArray = array_merge($scourses1, $sprofile1);
//print_r($mergedArray);exit();


echo $mustache->render($template,$mergedArray);


echo $OUTPUT->footer();


?>



<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <link rel="stylesheet" href="css/profile.css">
  

</head>


<?php
// include('demo.html');
require_once(__DIR__ . '/../../config.php');
// require_once(__DIR__ . '/../../lib/mustache/src/Mustache/Autoloader.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();
if(is_siteadmin()){

$template4 = file_get_contents($CFG->dirroot . '/local/dashboard/templates/admin.mustache');

// require_once($CFG->dirroot.'/local/createstudent/demo.html');
global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;
$linktext = "View students";

$linkurl = new moodle_url('/local/dashboard/dashboardadmin.php');
$csspath = new moodle_url('/local/css/style.css');
$academicyr_view = new moodle_url('/local/academicyear/viewacademicyear.php?id');
$schoolreg_view = new moodle_url('/local/schoolreg/viewschools.php?id');
$class_view = new moodle_url('/local/class/classview.php?id');
$div_view = new moodle_url('/local/division/div_view.php?id');
$subject_view = new moodle_url('/local/subject/viewsubject.php?id');
$teacher_view = new moodle_url('/local/createteacher/view_teacher.php?id');
$student_view = new moodle_url('/local/createstudent/view_student_1.php?id');
$assign_view = new moodle_url('/local/dashboard/assignts.php?id');
$timetable_view = new moodle_url('/local/new_timetable/admin_view_1.php?id');
$holidays_view = new moodle_url('/local/holiday/view_holiday.php?id');
$survey_view = new moodle_url('/local/survey/survey_adminview.php?id');
$complaint_view = new moodle_url('/local/complaint/view_complaint_1.php?id');
$upcoming_view = new moodle_url('/local/dashboard/upcoming.php?id');


$academicyr_img = new moodle_url('/local/img/academic.svg');
$schoolreg_img = new moodle_url('/local/img/schoolreg.svg');
$class_img = new moodle_url('/local/img/ic-3.svg');
$div_img = new moodle_url('/local/img/ic-4.svg');
$subject_img = new moodle_url('/local/img/ic-5.svg');
$teacher_img = new moodle_url('/local/img/ic-2.svg');
$student_img = new moodle_url('/local/img/ic-1.svg');
$assign_img = new moodle_url('/local/img/ic-6.svg');
$timetable_img = new moodle_url('/local/img/ic-7.svg');
$holidays_img = new moodle_url('/local/img/ic-8.svg');
$survey_img = new moodle_url('/local/img/ic-21.svg');
$complaint_img = new moodle_url('/local/img/ic-9.svg');
$upcoming_img = new moodle_url('/local/img/ic-10.svg');

$PAGE->set_context($context);
$strnewclass= 'Admin Dasboard';
$PAGE->set_url('/local/dashboard/dashboardadmin.php');
$PAGE->set_title($strnewclass);
echo $OUTPUT->header();
$mustache = new Mustache_Engine();
$id  = optional_param('id', 0, PARAM_INT);
// print_r($id);
$schools = $DB->get_records('school_reg');
// $schools = $DB->get_record('school_reg', array(), '*', 'id ASC');
    $options1 = array();
    
if($id==0){
  $schoolid =reset($schools)->id;
}else{
  $schoolid=$id;
}

      foreach ($schools as $school) {
        if(isset($id) && $id == $school->id) {
          $options1[] = array('value' => $school->id, 'label' => $school->sch_name, 'selected' => true);
          // $schoolid=$school->id;
        } else {
          $options1[] = array('value' => $school->id, 'label' => $school->sch_name);
          // $schoolid=$id;
      }

      }
    $templateData = array(
        'schoolOptions' => $options1
        
    );
    // print_r($schoolid);
echo $mustache->render($template4,['csspath' => $csspath,'templateData'=>$templateData,'schoolid'=>$schoolid,'schoolreg_view'=>$schoolreg_view,'academicyr_view'=>$academicyr_view,
'class_view'=>$class_view,'div_view'=>$div_view,'subject_view'=>$subject_view,'teacher_view'=>$teacher_view,
'student_view'=>$student_view,'assign_view'=>$assign_view,'timetable_view'=>$timetable_view,
'holidays_view'=>$holidays_view,'survey_view'=>$survey_view,'complaint_view'=>$complaint_view,
'upcoming_view'=>$upcoming_view,
'academicyr_img'=>$academicyr_img,
'schoolreg_img'=>$schoolreg_img,
'class_img'=>$class_img,'div_img'=>$div_img,'subject_img'=>$subject_img,
'teacher_img'=>$teacher_img,'student_img'=>$student_img,'assign_img'=>$assign_img,
'timetable_img'=>$timetable_img,
'holidays_img'=>$holidays_img,'survey_img'=>$survey_img,'complaint_img'=>$complaint_img,
'upcoming_img'=>$upcoming_img,


]);
echo $OUTPUT->footer();
}
else{
  echo "you have no permission to access the page";
}

?>

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
$academicyr_view = new moodle_url('/local/academicyear/viewacademicyear.php');
$class_view = new moodle_url('/local/class/classview.php');
$div_view = new moodle_url('/local/division/div_view.php');
$subject_view = new moodle_url('/local/subject/viewsubject.php');
$teacher_view = new moodle_url('/local/createteacher/view_teacher.php');
$student_view = new moodle_url('/local/createstudent/view_student_1.php');
$assign_view = new moodle_url('/local/dashboard/assignts.php');
$timetable_view = new moodle_url('/local/new_timetable/admin_view_1.php');
$holidays_view = new moodle_url('/local/holiday/view_holiday.php');
$survey_view = new moodle_url('/local/survey/survey_adminview.php');
$complaint_view = new moodle_url('/local/complaint/view_complaint_1.php');
$upcoming_view = new moodle_url('/local/dashboard/upcoming.php');

$academicyr_img = new moodle_url('/local/img/academic.svg');
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
echo $mustache->render($template4,['csspath' => $csspath,'academicyr_view'=>$academicyr_view,
'class_view'=>$class_view,'div_view'=>$div_view,'subject_view'=>$subject_view,'teacher_view'=>$teacher_view,
'student_view'=>$student_view,'assign_view'=>$assign_view,'timetable_view'=>$timetable_view,
'holidays_view'=>$holidays_view,'survey_view'=>$survey_view,'complaint_view'=>$complaint_view,
'upcoming_view'=>$upcoming_view,
'academicyr_img'=>$academicyr_img,
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

<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir.'/completionlib.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
require_login();
Mustache_Autoloader::register();
$template = file_get_contents($CFG->dirroot . '/local/dashboard/templates/learningpath.mustache');
global $class,$CFG;
$context = context_system::instance();
$linkurl = new moodle_url('/local/dashboard/demo_learningpath.php');

$csspath = new moodle_url('/local/css/style.css');
$image1 = new moodle_url('/local/img/sub-icon-1.svg');

$PAGE->set_context($context);
$strnewclass= get_string('studentview');
$PAGE->set_url('/local/dashboard/demo_learningpath.php');
$PAGE->set_title($strnewclass);
echo $OUTPUT->header();
$mustache = new Mustache_Engine();

$id  = optional_param('id', 0, PARAM_INT);
$courseid = $id;
$modinfo = get_fast_modinfo($courseid);
$sections = $modinfo->get_section_info_all();

// $data = [
//     'sections' => [],
// ];
$course_name=$DB->get_record_sql("SELECT * FROM {course} WHERE id=$courseid");
// print_r($course_name->fullname);
$course_namee=$course_name->fullname;
foreach ($sections as $section_item) {
   
    // Prepare section data
        $course = $section_item->course;
        // print_r($section_item);
        $section_id = $section_item->id;
        $section_name =$section_item->name;                                  
        $userid=$USER->id;
       
        $module_completed=$DB->get_records_sql("SELECT COUNT(*) AS total_records FROM {course_modules} 
                                    INNER JOIN {course_modules_completion} ON 
                                    {course_modules}.id={course_modules_completion}.coursemoduleid where
                                     {course_modules}.course=$course AND {course_modules}.section=$section_id AND 
                                     {course_modules_completion}.userid=$userid");
    /////*******************************/
        // print_r($module_completed);exit(); 
        $total_modules=$DB->get_records_sql("SELECT COUNT(*) AS total_records FROM {course_modules} where course=$course AND section=$section_id");                                              
  
        $modules = $DB->get_records_sql("SELECT * FROM {course_modules} WHERE course = $course AND section = $section_id");
        $day_records= array();
        foreach ($modules as $module) {
            // Prepare module data
            if($module->deletioninprogress==0){

                $mod = $modinfo->get_cm($module->id);
                $module_name = $mod->name;                                        
                $mid=$mod->section;
                $miid=$mod->id;
                $course1=$course;
                $total_modules2=$DB->get_records_sql("SELECT * FROM {course_modules_completion} where coursemoduleid=$miid AND userid= $userid"); 
           
                $day_records[] = array('module_name' => $module_name,
                'module_section' => $mid,
                'module_id' => $miid,
                'course1' => $course1,
                'completeed' =>  (count($total_modules2) > 0) ); 
        }
      
        }
        $data[] = array(
            'course' => $course,
            'course_namee'=>$course_namee,
            'section_id' => $section_id,
            'section_name' => $section_name,
            'userid' => $userid,
            'completed' => ($module_completed == $total_modules),
            'day_records' => $day_records
        );  
        // $data['sections'][] = $sectionData;
}
echo $mustache->render($template,['sections' => $data,'course_namee'=>$course_namee,'csspath'=>$csspath,'image1'=>$image1]);

//$sections=array('sections' => $data,'course_namee'=>$course_namee);
//echo $mustache->render($template,$sections,['csspath'=>$csspath,'image1'=>$image1]);
//echo $mustache->render($template,['sections' => $data,'course_namee'=>$course_namee,'csspath'=>$csspath,'image1'=>$image1]);
// $output = $mustache->render($template,$sections); 
echo $OUTPUT->footer();
?>



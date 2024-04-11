<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/academicyear/template/academic.mustache');

global $class, $CFG;
$context = context_system::instance();

$linkurl = new moodle_url('/local/academicyear/viewacademicyear.php');
$PAGE->set_context($context);
$strnewacademic = 'Academic year creation';
$PAGE->set_url('/local/academicyear/viewacademicyear.php');
$PAGE->set_title($strnewacademic);

echo $OUTPUT->header();


$mustache = new Mustache_Engine();
$id  = optional_param('id', 0, PARAM_INT);

$csspath = new moodle_url("/local/css/style.css");
$addnew_academic = new moodle_url("/local/academicyear/academicyear.php");
$academic_yr_edit = new moodle_url("/local/academicyear/editacademic.php?id");
$academic_yr_delete = new moodle_url("/local/academicyear/delete.php");


$tableRows = []; // Initialize an empty array to store the table rows
$rec = $DB->get_records_sql("SELECT * FROM {academic_year} WHERE school=$id ORDER BY start_year ASC  ");
foreach ($rec as $records) {
    $id = $records->id;
    $timestart = $records->start_year;
    $timestart1 = date("d-m-Y", $timestart);
    $timeend = $records->end_year;
    $timeend1 = date("d-m-Y", $timeend);
    $vacationstart = $records->vacation_s_year;
    $vacationstart1 = date("d-m-Y", $vacationstart);
    $vacationend = $records->vacation_e_year;
    $vacationend1 = date("d-m-Y", $vacationend);
    $sid = $records->school;
    
    $school = $DB->get_record('school_reg', ['id' => $sid]);

    if ($school) {
        $schoolname = $school->sch_name;
    } else {
        $schoolname = 'Unknown'; 
    }

    $tableRows[] = [
        'id' => $id,
        'timestart' => $timestart1,
        'timeend' => $timeend1,
        'vacationstart' => $vacationstart1,
        'vacationend' => $vacationend1,
        'school' => $schoolname,
    ];
}


$output = $mustache->render($template, ['tableRows' => $tableRows,'csspath' => $csspath,'addnew_academic' => $addnew_academic,'academic_yr_edit' => $academic_yr_edit,'academic_yr_delete'=>$academic_yr_delete]);
echo $output;

echo $OUTPUT->footer();
?>

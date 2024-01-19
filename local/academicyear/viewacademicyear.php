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

$rec = $DB->get_records_sql("SELECT * FROM {academic_year} ORDER BY start_year ASC");
$mustache = new Mustache_Engine();

$csspath = new moodle_url("/local/css/style.css");
$addnew_academic = new moodle_url("/local/academicyear/academicyear.php");
$academic_yr_edit = new moodle_url("/local/academicyear/editacademic.php?id");
$academic_yr_delete = new moodle_url("/local/academicyear/delete.php");


$tableRows = [];

foreach ($rec as $records) {
    $id = $records->id;
    $timestart = $records->start_year;
    $timestart1 = date("d-m-Y", $timestart);
    $timeend = $records->end_year;
    $timeend1 = date("d-m-Y", $timeend);

    // $edit = $CFG->wwwroot . '/local/academicyear/editacademic.php?id=' . $records->id;
    // $delete = $CFG->wwwroot . '/local/academicyear/delete.php?id=' . $records->id;

    // $editing = '<button style="border-radius: 5px; padding: 4px 18px;background-color: #0055ff;"><a href="' . $edit . '" style="text-decoration:none;color: white; ">Edit</a></button>';
    // $deleting = '<button style="border-radius: 5px; padding: 4px 20px;background-color: #0055ff;"><a href="' . $delete . '" style="text-decoration:none;color: white; ">Delete</a></button>';
     $tableRows[] = [
        'id'=> $id,
        'timestart' => $timestart1,
        'timeend' => $timeend1,
        
    ];
}


$output = $mustache->render($template, ['tableRows' => $tableRows,'csspath' => $csspath,'addnew_academic' => $addnew_academic,'academic_yr_edit' => $academic_yr_edit,'academic_yr_delete'=>$academic_yr_delete]);
echo $output;

echo $OUTPUT->footer();
?>

<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/holiday/templates/viewholiday.mustache');

global $class, $CFG;
$context = context_system::instance();
// $classid = $class->id;
$linktext = "Holiday List";
$school_id=optional_param('id', 0, PARAM_INT);   

$linkurl = new moodle_url('/local/holiday/addholiday.php');
$css_link = new moodle_url('/local/css/style.css');
$editholiday = new moodle_url('/local/holiday/editholiday.php?id');
$deleteholiday = new moodle_url('/local/holiday/deleteholiday.php?id');
$addholidayy = new moodle_url('/local/holiday/addholiday.php');

$PAGE->set_context($context);
//$strnewclass= get_string('studentcreation');

$PAGE->set_url('/local/holiday/addholiday.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);

echo $OUTPUT->header();
$rec = $DB->get_records_sql("SELECT {addholiday}.* FROM {addholiday} JOIN {academic_year} ON {addholiday}.academic_id={academic_year}.id WHERE {academic_year}.school=$school_id");
$mustache = new Mustache_Engine();

$tableRows = [];

foreach ($rec as $records) {
    $id = $records->id;
    $startdate = $records->from_date;
    $date1 = date("d-m-Y", $startdate);
    $enddate = $records->to_date;
    $date2 = date("d-m-Y", $enddate);
    $holiday = $records->holiday_name;

    // Check if the start date is in the past
    $past_date = ($startdate < time());

    // Disable edit and delete buttons for past dates
    if ($past_date) {
        $edit = '<a href="#" disabled><i class="fa fa-edit" style="font-size:24px;color:#ccc"></i></a>';
        $delete = '<a href="#" disabled><i class="fa fa-trash" style="font-size:24px;color:#ccc"></i></a>';
    } else {
        $edit = '<a href="'.$editholiday.'=' . $id . '"><i class="fa fa-edit" style="font-size:24px;color:#0055ff"></i></a>';
        $delete = '<a href="'.$deleteholiday.'=' . $id . '" style="color:blue;" onclick="return confirm(\'Are you sure you want to delete this record?\')"><i style="font-size:24px" class="fa fa-trash-o" ></i><a>';
    }

    $tableRows[] = [
        'startDate' => $date1,
        'endDate' => $date2,
        'holiday' => $holiday,
        'editButton' => $edit,
        'deleteButton' => $delete,
    ];
}
$output = $mustache->render($template, ['tableRows' => $tableRows,'css_link'=>$css_link,'addholidayy'=>$addholidayy]);
echo $output;

echo $OUTPUT->footer();
?>

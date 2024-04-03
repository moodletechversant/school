<?php
require_once(__DIR__ . '/../../config.php');
global $class,$CFG;
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
require_login();
Mustache_Autoloader::register();

$template1 = file_get_contents($CFG->dirroot . '/local/holiday/templates/head1.mustache');


$context = context_system::instance();
// $classid = $class->id;
$linktext = "Holiday Calendar";

$css_link = new moodle_url('/local/css/style.css');
$linkurl = new moodle_url('/local/holiday/addholiday.php');
$editholiday = new moodle_url('/local/holiday/editholiday.php?id');
$deleteholiday = new moodle_url('/local/holiday/deleteholiday.php?id');

$PAGE->set_context($context);
//$strnewclass= get_string('studentcreation');

$PAGE->set_url('/local/holiday/holiday_calendar.php');
$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);


//$addholiday = '<button style="float:right; margin-right: 20px;margin-bottom:20px; background-color: #0f6cbf; color: white; border: none; border-radius: 5px; padding: 10px 20px;"><a href="/school/local/holiday/addholiday.php" style="text-decoration:none; color:white;"><strong>Add Holiday</strong></a></button>';


    echo $OUTPUT->header();

    $academic = $DB->get_records('academic_year');
  
    $current_year = date("Y"); // Get the current year using PHP date() function

$rec1 = $DB->get_records_sql("
    SELECT ah.*, ay.start_year, ay.end_year
    FROM {addholiday} AS ah
    INNER JOIN {academic_year} AS ay ON ah.academic_id = ay.id
    WHERE YEAR(FROM_UNIXTIME(ay.start_year)) = $current_year
    OR YEAR(FROM_UNIXTIME(ay.end_year)) = $current_year
");

       //print_r($rec1);exit();

//$options1 = array();

    // $options1[] = array('' => '---- Select academic_year ----');
    $academic = $DB->get_records('academic_year');
    $current_year = date("Y");
    $options1 = array();
    
    $rec = $DB->get_records_sql("SELECT * FROM {addholiday} WHERE YEAR(FROM_UNIXTIME(from_date)) = ?", array($current_year));
   
$rec1 = $DB->get_records_sql("
SELECT ah.*, ay.start_year, ay.end_year
FROM {addholiday} AS ah
INNER JOIN {academic_year} AS ay ON ah.academic_id = ay.id
WHERE YEAR(FROM_UNIXTIME(ay.start_year)) = $current_year
OR YEAR(FROM_UNIXTIME(ay.end_year)) = $current_year
");
$current_date = date("Y-m-d");

$options1 = array();
$academic_id = $DB->get_records_sql("SELECT * FROM {academic_year}");


    
    foreach ($academic_id as $academic) {
        $timestart = $academic->start_year;
        $timeend = $academic->end_year;
        
        $timestart1 = date("d/m/Y", $timestart);
        $timeend1 = date("d/m/Y", $timeend);
        
        $options1[] = array('value' => $academic->id, 'label' => $timestart1 . '-' . $timeend1);
    }


    $templateData = array('startYearOptions' => $options1);
    $table = new html_table();
    
    $table->head = array("Start Date","End Date","Holiday",'Edit','Delete');
    $mustache = new Mustache_Engine();
    // echo $mustache->render($template);
    if (!empty($rec1)) {
        $hasHoliday = false; // Flag to check if any holidays exist
    
        foreach ($rec1 as $records) {
            $id = $records->id; 
            $startdate = strtotime($records->from_date);
            $enddate = strtotime($records->to_date);
    
            $date1 = date("d-m-Y", $startdate);
            $day = date("d", $startdate);   
            $month = date("M", $startdate); 
            $dayName = date("l", $startdate);
    
            $date2 = date("d-m-Y", $enddate);
            $holiday = $records->holiday_name;
    
            $isPastDate = (time() > $startdate) ? true : false;
            $pastDateClass = $isPastDate ? 'past-date' : ''; 
            
            if (time() >= $startdate && time() <= $enddate) {
                $tableRows[] =  [
                    'holiday' => $holiday,
                    'day' => $day,
                    'month' => $month,
                    'dayName' => $dayName,
                    'pastDateClass' => $pastDateClass
                ]; 
                $hasHoliday = true; // Set the flag to true if a holiday exists in the date range
                break; // Exit the loop as soon as a holiday is found
            }
        }
        $currentMonth = date('m');

       
        $currentMonthName = date('F', mktime(0, 0, 0, $currentMonth, 1));
        
       
        $nextMonth = date('m', strtotime('+1 month'));
        
       
        $nextMonthName = date('F', mktime(0, 0, 0, $nextMonth, 1));
        
        // If no holiday is found, add a single vacation entry
        if (!$hasHoliday) {
            $vacation = 'Summer vacation: ' .  $currentMonthName . ' - ' . $nextMonthName;
                        $tableRows[] = [
                'vacation' => $vacation,
               
            ];
        }
    }
    
    
    
    echo $mustache->render($template1, ['tableRows' => $tableRows, 'css_link' => $css_link, 'templateData' => $templateData]);
        // <input type="submit" name="edit" value="edit">

echo $OUTPUT->footer();


?>
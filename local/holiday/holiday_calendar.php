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
    $rec=$DB->get_records_sql("SELECT * FROM {addholiday} ORDER BY from_date ASC");
    //echo $addholiday;

    $table = new html_table();
    
    $table->head = array("Start Date","End Date","Holiday",'Edit','Delete');
    $mustache = new Mustache_Engine();
    // echo $mustache->render($template);
    foreach ($rec as $records) {
       
       
       $id = $records->id; 
       $startdate = $records->from_date;
       $date1 = date("d-m-Y", $startdate);

       $day = date("d", $startdate);   // Extract the day
       $month = date("M", $startdate); // Extract the month
       $dayName = date("l", $startdate);

       $enddate = $records->to_date;
       $date2 = date("d-m-Y", $enddate);

       $holiday =$records->holiday_name;

       // Check if start date is in the past
   $isPastDate = (time() > $startdate) ? true : false;
//    print_r($isPastDate);
   $pastDateClass = $isPastDate ? 'past-date' : ''; // Add class 'past-date' if it's a past date
// print_r($pastDateClass);exit();
    
       $edit = '<a href="'.$editholiday.'='.$id.'"><i class="fa fa-edit" style="font-size:24px;color:#0055ff"></i></a>';
       $delete = '<a href="'.$deleteholiday.'='.$id.'"><i class="fa fa-trash" style="font-size:24px;color:#0055ff"></i></a>';
        
       $tableRows[] =  ['date1' => $date1,'date2' => $date2,'holiday' => $holiday,'day'=>$day,'month'=>$month,'dayName'=>$dayName,'pastDateClass' => $pastDateClass]; 
    //    echo $mustache->render($template1,$data); 
   
    }
    echo $mustache->render($template1, ['tableRows' => $tableRows ,'css_link' =>$css_link]);
    // <input type="submit" name="edit" value="edit">

echo $OUTPUT->footer();


?>
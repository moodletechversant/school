<?php
require(__DIR__.'/../../config.php');
global $CFG ,$USER;
$userid= $USER->id;// $template = file_get_contents($CFG->dirroot . '/local/class/template/demo.mustache');
//$context = context_system::instance();
require_login();



  if(!empty($_POST['year1']) || !empty($_POST['year2'])){
    $year1=$_POST['year1'];
    $year2=$_POST['year2'];
    // echo "Both year and status are set.";
    $rec = $DB->get_records_sql(
        "SELECT * FROM {addholiday} WHERE YEAR(FROM_UNIXTIME(from_date)) = ? OR YEAR(FROM_UNIXTIME(to_date)) = ?",
        array($year1, $year2)
    );
    
  
    
  }
//print_r($rec);exit();
$var = ''; // Initialize the variable outside the loop
if (!empty($rec)) {
    foreach ($rec as $records) {
       
        $id = $records->id; 
        $startdate = $records->from_date;
        $date1 = date("d-m-Y", $startdate);
        $day = date("d", $startdate);   // Extract the day
        $month = date("M", $startdate); // Extract the month
        $dayName = date("l", $startdate);
        $enddate = $records->to_date;
        $date2 = date("d-m-Y", $enddate);
        $holiday = $records->holiday_name;
        // Check if start date is in the past
        $isPastDate = (time() > $startdate) ? true : false;
        $pastDateClass = $isPastDate ? 'past-date' : ''; // Add class 'past-date' if it's a past date

        // Concatenate HTML content for each holiday record
        $var .= '<div class="col-md-6 '.$pastDateClass.'">
                    <div class="Holiday-box">
                        <div class="hday-lt">
                            <p>'.$month.'</p>
                            <h5>'.$day.'</h5>
                        </div>
                        <div class="hday-txt">
                            <h4>'.$holiday.'</h4>
                            <p>'.$dayName.'</p>
                        </div>
                    </div>
                </div>';
    }
}

// Wrap the concatenated HTML content with the surrounding HTML structure
$html = '<div class="form-wrap">
            <div class="container">
                <div class="col-md-10 col-10 mx-auto col-lg-6">
                    <div class="form-card card">
                        <h4 class="mb-3">Holiday Calendar</h4>
                        <div class="row holiday-wrap">'.$var.'</div>
                    </div>
                </div>
            </div>
        </div>';

echo $html;


<?php
require(__DIR__.'/../../config.php');
global $CFG ,$USER;
$userid= $USER->id;// $template = file_get_contents($CFG->dirroot . '/local/class/template/demo.mustache');
//$context = context_system::instance();
require_login();



//   if(!empty($_POST['year1']) || !empty($_POST['year2'])){
//     $year1=$_POST['year1'];
//     $year2=$_POST['year2'];
//     // echo "Both year and status are set.";
//     $aca = $DB->get_record_sql("SELECT * FROM {academic_year} WHERE YEAR(FROM_UNIXTIME(start_year)) = $year1");
    
// $aca_id=$aca->id;

//     $rec = $DB->get_records_sql(
//         "SELECT * FROM {addholiday} WHERE academic_id=$aca_id"
//     );
    
  
    
//   }


// if(!empty($_POST['year1']) || !empty($_POST['year2'])){
//     $year1 = $_POST['year1'];
//     $year2 = $_POST['year2'];
// // print_r($year2);
//     // Query to get academic years between year1 and year2
//     $acad_years = $DB->get_records_sql(
//         "SELECT * FROM {academic_year} 
//         WHERE YEAR(FROM_UNIXTIME(start_year)) BETWEEN ? AND ?",
//         array($year1, $year2)
//     );
    
//     $aca_ids = [];
//     foreach ($acad_years as $aca) {
//         $aca_ids[] = $aca->id;
//     }

//     // Convert academic year ids array to comma-separated string
//     $aca_ids_list = implode(',', $aca_ids);

//     // Fetch holidays based on the academic years found
//     if (!empty($aca_ids_list)) {
//         $rec = $DB->get_records_sql(
//             "SELECT * FROM {addholiday} WHERE academic_id IN ($aca_ids_list)"
//         );
//     }
// }


if(!empty($_POST['year1']) || !empty($_POST['year2'])){
    $year1 = $_POST['year1'];
    $year2 = $_POST['year2'];
    $month1 = $_POST['month1']; // Fetch start month
    $month2 = $_POST['month2']; // Fetch end month

    // Combine year and month for comparison in SQL
    $start_date = $year1 . '-' . $month1 . '-01'; // Assuming the first day of the month for start date
    $end_date = $year2 . '-' . $month2 . '-31';  // Assuming the last day of the month for end date

    // Query to get academic years between year1 and year2 (with month filter)
    $acad_years = $DB->get_records_sql(
        "SELECT * FROM {academic_year} 
        WHERE DATE(FROM_UNIXTIME(start_year)) BETWEEN ? AND ?",
        array($start_date, $end_date)
    );
    
    $aca_ids = [];
    foreach ($acad_years as $aca) {
        $aca_ids[] = $aca->id;
    }

    // Convert academic year ids array to comma-separated string
    $aca_ids_list = implode(',', $aca_ids);

    // Fetch holidays based on the academic years found
    if (!empty($aca_ids_list)) {
        $rec = $DB->get_records_sql(
            "SELECT * FROM {addholiday} WHERE academic_id IN ($aca_ids_list)"
        );
    }
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


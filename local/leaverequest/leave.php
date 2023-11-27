<?php
require(__DIR__.'/../../config.php');
require_once($CFG->dirroot.'/local/leaverequest/leave_form.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

//$template = file_get_contents($CFG->dirroot . '/local/leaverequest/templates/leave.mustache');
global $class,$CFG,$USER,$DB;


// print_r($currentDate);exit();

$context = context_system::instance();
// $classid = $class->id;

$linkurl = new moodle_url('/local/leaverequest/leave.php');
$PAGE->set_context($context);
$strnewclass= "Request Leave ";
$PAGE->set_url('/local/leaverequest/leave.php');
//$PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
//$PAGE->set_heading($strnewclass);
$mform=new leave_form();

$current_user_id = $USER->id;
$current_user_name = $USER->username;

$name=$DB->get_record_sql("SELECT * FROM {student} WHERE user_id=$current_user_id ");

$currentTimestamp = time();
//print_r($currentTimestamp);exit();
// $currentTimestampAsString = date('Y-m-d H:i:s', $currentTimestamp);

//print_r($currentTimestamp);exit();
echo $OUTPUT->header();
//$mustache = new Mustache_Engine();
//echo $mustache->render($template);
$returnurl = $CFG->wwwroot.'/local/leaverequest/std_viewrequest.php';
if ($mform->is_cancelled()) {
    redirect($returnurl);
} 
else if ($formdata = $mform->get_data()) {

    // $user_id = 3;
    $new_leave_sdate = $formdata->fdate; // The date for which the user is applying for leave
    $new_leave_edate = $formdata->tdate;

    $sdate = date('Ymd',$new_leave_sdate);
    $edate = date('Ymd',$new_leave_edate);

    $result =$DB->get_records_sql(" SELECT * FROM {leave} WHERE
    s_id = $current_user_id AND (
    (
        DATE_FORMAT(FROM_UNIXTIME(f_date), '%Y%m%d') <= $sdate AND DATE_FORMAT(FROM_UNIXTIME(t_date), '%Y%m%d') >= $sdate
    )
    OR
    (
        DATE_FORMAT(FROM_UNIXTIME(f_date), '%Y%m%d') <= $edate AND DATE_FORMAT(FROM_UNIXTIME(t_date), '%Y%m%d') >= $edate
    ))");
// print_r($result);
    // $result =$DB->get_record_sql("SELECT * FROM {{leave}} WHERE s_id = $current_user_id AND f_date <= $new_leave_sdate AND end_date >= $new_leave_sdate OR   (DATE_FORMAT(FROM_UNIXTIME(end_date), '%Y%m%d') <= $new_leave_edate AND end_date >= $new_leave_edate");
    // $result = $conn->query($sql);
    if ($new_leave_edate >= $new_leave_sdate) {   
            if(!empty($result)){ 
                // Leave request already exists for the specified date
                echo '<script>alert("Error: Leave request already exists for the specified date");</script>';

                $urlto = $CFG->wwwroot.'/local/leaverequest/leave.php';
                redirect($urlto); 
            
            } else {
                        $lvedata= new stdclass();
                        $fdate=$formdata->fdate;


                        $lvedata->f_date=$formdata->fdate;
                        $lvedata->t_date=$formdata->tdate;
                        $lvedata->n_leave=$formdata->nleave;


                        $lvedata->type=$formdata->ltype;
                        $lvedata->subject=$formdata->subject;
                        $lvedata->s_id=$current_user_id;
                        $lvedata->s_name=$name->s_ftname;  
                        $lvedata->note=$formdata->note;
                        $lvedata->l_status='pending';
                        $lvedata->created_date=$currentTimestamp;
                        $lvedata->created_by=$current_user_id;
                        $lvedata->modified_date=$currentTimestamp;
                        $lvedata->modified_by=$current_user_id;
                        //print_r($lvedata);exit();

        
                        $DB->insert_record('leave',$lvedata);
                        // $sql = "UPDATE mdl_leave SET created_date = '$currentTimestamp' WHERE id";
                        // $DB->execute($sql);
                        $urlto = $CFG->wwwroot.'/local/leaverequest/std_viewrequest.php';
                        redirect($urlto, 'Data Saved Successfully '); 
                    
            } 
    }
    else {
           echo '<script>alert("Error: End year must be greater than start year");</script>';
           $urlto = $CFG->wwwroot.'/local/leaverequest/leave.php';
           redirect($urlto); 
    }


}
$mform->display();
echo $OUTPUT->footer();
  
   
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- <script>
$("#id_nleave").click(function(){


  var dd1 =   $('#id_fdate_day :selected').text();
  var mm1 =   $('#id_fdate_month :selected').text();
  var yy1 =   $('#id_fdate_year :selected').text();

  var dd =   $('#id_tdate_day :selected').text();
  var mm =   $('#id_tdate_month :selected').text();
  var yy =   $('#id_tdate_year :selected').text();


 var day1 =  dd1+"/"+mm1+"/"+yy1
 var day = dd+"/"+mm+"/"+yy

 // var time_difference = day.getTime() - day1.getTime();
  //    var result = time_difference / (1000 * 60 * 60 * 24);

  var startDay = new Date(day1);  
    var endDay = new Date(day);  
    var millisBetween =  endDay.getTime() - startDay.getTime();  
    var days = millisBetween / (1000 * 3600 * 24);  
    // return Math.round(Math.abs(days));  
// alert(days )
$("#id_nleave").val(days)
})
  </script> -->



  <script>
$(".dbpicker").click(function(){
  var dd1 = $('#id_fdate_day :selected').text();
  var mm1 = $('#id_fdate_month :selected').text();
  var yy1 = $('#id_fdate_year :selected').text();

  var dd = $('#id_tdate_day :selected').text();
  var mm = $('#id_tdate_month :selected').text();
  var yy = $('#id_tdate_year :selected').text();

  var day1 = dd1+"/"+mm1+"/"+yy1;
  var day = dd+"/"+mm+"/"+yy;

  var startDay = new Date(day1);  
  var endDay = new Date(day);  
  var millisBetween = endDay.getTime() - startDay.getTime();  
  var days = millisBetween / (1000 * 3600 * 24); 

  if (startDay.getTime() === endDay.getTime()) {
    days = 1;
  } else if (days < 0) {
    days = 0;
  } else if (days === 1) {
    days = 2;
  } else {
    days += 1;
  }

  $("#id_nleave").val(days);
})
</script>


<style>
    .container{
        padding-left : 20%;
        padding-top : 50px;
        padding-bottom : 50px;
        background-color : #72aacf;  
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.7);      
    }
    .heading{
        font-family : "Times New Roman", Times, serif;

    }
    .form-class{
        font-weight : bold; 
    }
    .form-control{
        border-radius : 15px;
        background-color : #FFFFFF;

    }
    .form-control:focus{
        background-color : #CAE9F5;
        box-shadow : none;
    }
    
    .custom-select{
        border-radius : 15px;
    }
    .custom-select:focus{
        background-color : #CAE9F5;
        box-shadow : none;
    }
    /* .btn{
        background-color : black;
    } */
    .fa-calendar{
        color : black;
    }  
    .btn-primary{
        background-color : #000000de;
        border-color : black;
        border-radius : 15px;
    }
    .btn-primary:hover{
        background-color : black;
        border-color : black;
        border-radius : 15px;
    }
    .btn-primary:focus{
        background-color : black;
        border-color : black;
        border-radius : 15px;
    }
    .btn-primary:not(:disabled):not(.disabled):active, .btn-primary:not(:disabled):not(.disabled).active, .show>.btn-primary.dropdown-toggle {
    color: #fff;
    background-color: black;
    border-color: black;
    }
    .btn-secondary{
        border-radius : 15px;
    }
    .fdescription{
        display : none;
    }
    .footer-content-debugging{
        display : none;
    }


    </style>
    <!-- $user_id = 3;
$new_leave_date = "2023-11-04";  // The date for which the user is applying for leave

// Check if leave already exists for the given date and user
$sql = "SELECT * FROM leave_table WHERE user_id = $user_id AND start_date <= '$new_leave_date' AND end_date >= '$new_leave_date'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Leave request already exists for the specified date
    echo "Leave is already applied for this date.";
} else {
    // Process the new leave request (insert into the database, etc.)
    // For simplicity, let's assume you have a function called applyLeave() for this
    applyLeave($user_id, $new_leave_date);
    echo "Leave request successful!";
} -->
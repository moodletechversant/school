<?php
require(__DIR__.'/../../config.php');
require_once($CFG->dirroot.'/local/leaverequest/editleave_form.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

//$template = file_get_contents($CFG->dirroot . '/local/leaverequest/templates/leaveedit.mustache');
global $class,$CFG,$USER;
$context = context_system::instance();
// $classid = $class->id;

$linkurl = new moodle_url('/local/leaverequest/editleave.php');
$PAGE->set_context($context);
$strnewclass= "Edit Leave Request";
$PAGE->set_url('/local/leaverequest/editleave.php');
//$PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
//$PAGE->set_heading($strnewclass);
$mform=new editleave_form();

$current_user_id = $USER->id;
$current_user_name = $USER->username;

//print_r($current_user_name);exit();
echo $OUTPUT->header();
//$mustache = new Mustache_Engine();
//echo $mustache->render($template);
$returnurl = $CFG->wwwroot.'/local/leaverequest/leave.php';
if ($mform->is_cancelled()) {
    redirect($returnurl);
} 
else if ($formdata = $mform->get_data()) {
 // $id= $DB->get_record_sql('SELECT id FROM mdl_user ORDER BY id DESC LIMIT 1');
 //$lvedata->s_id=$id->id;
//   $lvedata= new stdclass();



// $lvedata->id=$formdata->id;
// $lvedata->f_date=$formdata->fdate;
// $lvedata->t_date=$formdata->tdate;
//   $lvedata->n_leave=$formdata->nleave;
 
// $update=$DB->update_record('leave',$lvedata);




$lvedata = new stdClass();

$lvedata->id = $formdata->id;
$lvedata->f_date = $formdata->fedate;
$lvedata->t_date = $formdata->tedate;
$lvedata->n_leave = $formdata->nleave;
$lvedata->rsn_leave = $formdata->reason;

$sql = "UPDATE mdl_leave SET f_date = :f_date, t_date = :t_date, n_leave = :n_leave, rsn_leave = :rsn_leave WHERE id = :id";
$params = [
    'id' => $lvedata->id,
    'f_date' => $lvedata->f_date,
    't_date' => $lvedata->t_date,
    'n_leave' => $lvedata->n_leave,
    'rsn_leave' => $lvedata->rsn_leave
];
$DB->execute($sql, $params);


$urlto = $CFG->wwwroot.'/local/leaverequest/request_view.php';
redirect($urlto, 'Data Saved Successfully '); 
  

}
$mform->display();
echo $OUTPUT->footer();
  
   
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

 
  <script>
$(".custom-select").click(function(){
  var dd1 = $('#id_fedate_day :selected').text();
  var mm1 = $('#id_fedate_month :selected').text();
  var yy1 = $('#id_fedate_year :selected').text();

  var dd = $('#id_tedate_day :selected').text();
  var mm = $('#id_tedate_month :selected').text();
  var yy = $('#id_tedate_year :selected').text();

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
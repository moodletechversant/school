<?php
require_once(__DIR__ . '/../../config.php');

require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/leaverequest/templates/request_view.mustache');
global $CFG;
$id=$_GET['id'];

$context = context_system::instance();
// $classid = $class->id;
$linktext = "View Leave Request";
 

$linkurl = new moodle_url('/local/leaverequest/templates/request_view.mustache');

$PAGE->set_context($context);
$strnewclass= 'View requests'; 

$PAGE->set_url('/local/leaverequest/request_view.php');
//$PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
//$PAGE->set_heading($strnewclass);
echo $OUTPUT->header();
$mustache = new Mustache_Engine();
$currentyear = date('Y');

$data=$DB->get_records_sql("SELECT * FROM {leave} WHERE  YEAR(FROM_UNIXTIME(f_date))=$currentyear");
    $table = new html_table();
   
   
    $current_time = time(); 
      // print_r($data);exit();
      $academic = $DB->get_records('academic_year');
   
      $options1 = array();
      // $options1[] = array('value' => '', 'label' => '---- Select academic start year ----');
      foreach ($academic as $academic1) {
          $timestart = $academic1->start_year;
          $timestart1 = date("Y", $timestart);
         // print_r($timestart1);exit();
        
          $options1[] = array('value' => $academic1->id, 'label' => $timestart1);
      }
      
      $templateData = array(
          'startYearOptions' => $options1,
      );
      

    $data1=[]; 
    foreach($data as $value){

          $edit=$CFG->wwwroot.'/local/leaverequest/editleave.php?id='.$value->id;

          $id=$value->id;
          $sid=$value->s_id;
          $sname=$value->s_name;
          $fdate =$value->f_date;
          $fdate1 = date("d-m-Y", $fdate);
          $tdate =$value->t_date;
          $tdate1 = date("d-m-Y", $tdate);
          $nleave=$value->n_leave;
          $sub=$value->subject;
        
$status = $value->l_status; 
// if($current_time >= $tdate){
//   $status_colored = '<span style="color: gre;">'.$status.'</span>';
// }
// else{
//   $status_colored = '<span style="color: green;">'.$status.'</span>';

// }



          
          $edit=$value->edit;
        
    
          $data1[] = [
            'id'=>$id,
            'sid'=>$sid,    
            'sname' => $sname,
            'fdate1' => $fdate1,
            'tdate1'=>$tdate1,
            'edit'=>$edit,
            'nleave'=>$nleave,    
            'sub' => $sub,
            'status' => $status,
            'showContent' => ($current_time >= $tdate)
              ];    
          // $data3=['showContent' => ($current_time >= $tdate)];
    }
    // echo $mustache->render($template,$data3);
 echo $mustache->render($template, ['leave' => $data1 ,'templateData' =>$templateData]);

echo html_writer::table($table);
echo $OUTPUT->footer();


?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>






<script>
$(document).ready(function(){
 

  $(".click_ok").click(function() 
  {

    var row = $(this).closest('tr'); 
    var id = row.find('td:nth-child(1)').text();

   //alert(id)


    
  $.ajax({
                    type: "POST",
                    url: "approve.php",
                    data: {id:id},
                    success: function(data) {
                      
                    //  alert("response :: "+data)
                      location.reload(true)
                           },
                });
  });
});
</script>

<script>
$(document).ready(function() {
  $(".click_not").click(function() {
    var row = $(this).closest('tr'); 
    var id = row.find('td:nth-child(1)').text();
    var reason = prompt("Please enter the reason for denying leave:", "");
    if (reason != null && reason != "") {
      $.ajax({
        type: "POST",
        url: "denied.php",
        data: {id: id, reason: reason},
        success: function(data) {
          // Update the table cell with the reason for denying leave
          row.find('td:nth-child(4)').text(reason);
          
          // Reload the page to reflect the changes
          location.reload(true);
        },
        error: function(xhr, status, error) {
          alert("Error: " + error);
        }
      });
    }
  });
});

</script>
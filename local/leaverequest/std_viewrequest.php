<?php
require_once(__DIR__ . '/../../config.php');

require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/leaverequest/templates/stdview.mustache');
global $CFG ,$USER;
$userid= $USER->id;
$id=$_GET['id'];
$context = context_system::instance();
$linktext = "View Leave Request";

$linkurl = new moodle_url('/local/leaverequest/request_view.php');

$PAGE->set_context($context);
$strnewclass= 'View requests';

$PAGE->set_url('/local/leaverequest/request_view.php');
$PAGE->set_title($strnewclass);


echo $OUTPUT->header();
// $addleave = '<a href="/school/local/leaverequest/leave.php" class="ml-auto" style="text-decoration:none">
// <button class="btn-primary btn ml-auto" style="width: auto; margin-right: inherit;">+ ADD NEW</button>
// </a>';
// echo $addleave;
$currentyear = date('Y');
$data=$DB->get_records_sql("SELECT * FROM {leave} WHERE s_id=$userid AND YEAR(FROM_UNIXTIME(f_date))=$currentyear");

$current_time = time(); 

$mustache = new Mustache_Engine();
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



//print_r($currentyear);exit();


$tableRows = [];


    foreach ($data as $value) {

        $delete=$CFG->wwwroot.'/local/leaverequest/delete.php?id='.$value->id;
        $id=$value->id;
        $sid=$value->s_id;
        $sname=$value->s_name;
        $tname=$value->modified_by;
       
    $name=$DB->get_record_sql("SELECT * FROM {user} WHERE id=$tname");
       
        
        $apdate=$value->created_date;
       

        $apdate1= date("d-m-Y" ,$apdate);
        $fdate =$value->f_date;
        $fdate1 = date("d-m-Y", $fdate);
    
    $tdate =$value->t_date;
    $tdate1 = date("d-m-Y", $tdate);

    $dadate=$value->modified_date;

     $dadate1= date("d-m-Y" ,$dadate);
    if ($value->l_status !== "approved") {
 
      $delete = ' <a href="/school/local/leaverequest/delete.php?id='.$value->id.'" class="action-table" onclick="deleteItem()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M16 1.75V3h5.25a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1 0-1.5H8V1.75C8 .784 8.784 0 9.75 0h4.5C15.216 0 16 .784 16 1.75Zm-6.5 0V3h5V1.75a.25.25 0 0 0-.25-.25h-4.5a.25.25 0 0 0-.25.25ZM4.997 6.178a.75.75 0 1 0-1.493.144L4.916 20.92a1.75 1.75 0 0 0 1.742 1.58h10.684a1.75 1.75 0 0 0 1.742-1.581l1.413-14.597a.75.75 0 0 0-1.494-.144l-1.412 14.596a.25.25 0 0 1-.249.226H6.658a.25.25 0 0 1-.249-.226L4.997 6.178Z"></path><path d="M9.206 7.501a.75.75 0 0 1 .793.705l.5 8.5A.75.75 0 1 1 9 16.794l-.5-8.5a.75.75 0 0 1 .705-.793Zm6.293.793A.75.75 0 1 0 14 8.206l-.5 8.5a.75.75 0 0 0 1.498.088l.5-8.5Z"></path></svg> Delete</a>
      ';



    } else {
   $delete = ' <a class="action-table" style="text-decoration:none;color:#b9bab8;" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M16 1.75V3h5.25a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1 0-1.5H8V1.75C8 .784 8.784 0 9.75 0h4.5C15.216 0 16 .784 16 1.75Zm-6.5 0V3h5V1.75a.25.25 0 0 0-.25-.25h-4.5a.25.25 0 0 0-.25.25ZM4.997 6.178a.75.75 0 1 0-1.493.144L4.916 20.92a1.75 1.75 0 0 0 1.742 1.58h10.684a1.75 1.75 0 0 0 1.742-1.581l1.413-14.597a.75.75 0 0 0-1.494-.144l-1.412 14.596a.25.25 0 0 1-.249.226H6.658a.25.25 0 0 1-.249-.226L4.997 6.178Z"></path><path d="M9.206 7.501a.75.75 0 0 1 .793.705l.5 8.5A.75.75 0 1 1 9 16.794l-.5-8.5a.75.75 0 0 1 .705-.793Zm6.293.793A.75.75 0 1 0 14 8.206l-.5 8.5a.75.75 0 0 0 1.498.088l.5-8.5Z"></path></svg> Delete</a>
      ';  }

        $nleave=$value->n_leave;
       $sub=$value->subject;
  

     $status = $value->l_status;
     $reason = $value->l_denied; 
     //print_r($reason);exit();
//      if ($status === null) {
//       $status = $value->l_status;
//   }
     if ($status == "denied") {
         $status = '<span class="denied-tooltip" title="'.$reason.'">Denied</span>';
     }
     $namet = $name->firstname . " " . $name->middlename . " " . $name->lastname;
     $tableRows[] = [
      'rollno' =>  $sid,
      'student_name' =>$sname,
      'Applied_date' =>$apdate1,
      'from' => $fdate1,
      'to' => $tdate1,
      'numberofleaves' =>$nleave,
      'reason' => $sub,
      'status' =>  $status,  
     'approved_denied' =>$namet,
     'date' => $dadate1,
      'delete' =>  $delete,
  ];
    echo ' <input type="hidden" class="hidden_c" id="hidden_f" name="custId" value='.$id.'>';  




}

$output = $mustache->render($template, ['tableRows' => $tableRows, 'templateData' => $templateData,]);
    echo $output;
   
   
echo $OUTPUT->footer();


?>


<script>
 function deleteItem(id) {
    var confirmDelete = confirm("Are you sure you want to delete this item?");
    if (confirmDelete) {
        $.ajax({
            type: 'POST',
            url: '/school/local/leaverequest/delete.php',
            data: { id: id },
            success: function(response) {
                // Handle the response from the server here
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });
    }
}

</script>





<?php
require(__DIR__.'/../../config.php');
//$context = context_system::instance();
require_login();
global $CFG ,$USER;
$userid= $USER->id;

$leaverequest=new moodle_url('/local/leaverequest/editleave.php?id');
// $leave_delete=new moodle_url('/local/leaverequest/leave_delete.php?id');

$img1=new moodle_url('/local/img/tick.svg');
$img2=new moodle_url('/local/img/untick.svg');
$current_time = time(); 

if(!empty($_POST['year']) && !empty($_POST['statuss'])){
  $year=$_POST['year'];
  $status=$_POST['statuss'];
  // echo "Both year and status are set.";
  $leave = $DB->get_records_sql("SELECT * FROM {leave} WHERE YEAR(FROM_UNIXTIME(f_date))=$year AND l_status='$status'");

}
elseif(isset($_POST['year']) && empty($_POST['statuss'])){
  $year=$_POST['year'];
  // echo "Only year is set.";
  $leave = $DB->get_records_sql("SELECT * FROM {leave} WHERE YEAR(FROM_UNIXTIME(f_date))=$year");

}
elseif(empty($_POST['year']) && !empty($_POST['statuss'])){
  $status=$_POST['statuss'];
  //echo "Only status is set."
  $leave = $DB->get_records_sql("SELECT * FROM {leave} WHERE  l_status='$status'");


}




if(!empty($leave)){
    $var = '
    <div class="table-responsive custom-table">
    <table class="table mb-0">
      <thead>
        <tr>
        <th scope="col">
        <div class="wrap-t">Id</div>
      </th>
        <th scope="col">
            <div class="wrap-t">Roll no</div>
          </th>
          <th scope="col">
            <div class="wrap-t">Student name</div>
          </th>
          
           <th scope="col">
            <div class="wrap-t">From</div>
          </th>
          <th scope="col">
          <div class="wrap-t">To</div>
        </th>
        <th scope="col">
          <div class="wrap-t">No of Leave days</div>
        </th>
        <th scope="col">
          <div class="wrap-t">Reason</div>
        </th>

        <th scope="col">
          <div class="wrap-t">Approved</div>
        
          <div class="wrap-t">Denied</div>
        </th>
         <th scope="col">
          <div class="wrap-t">Status</div>
        </th>
        <th scope="col">
          <div class="wrap-t">Edit</div>
        </th>  
      </tr>
      </thead>
      <tbody>';
}
      foreach ($leave as $value) {


        
        // $edit=$CFG->wwwroot.'/local/leaverequest/editleave.php?id='.$value->id;
        $id=$value->id;
        $sid=$value->s_id;
        $sname=$value->s_name;
        $fdate =$value->f_date;
        $fdate1 = date("d-m-Y", $fdate);
        $tdate =$value->t_date;
        $tdate1 = date("d-m-Y", $tdate);
        $nleave=$value->n_leave;
        $sub=$value->subject;
        $status=$value->l_status;
        
        if ($current_time >= $tdate) {
          // if yes, disable the edit button
          $edit='<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
          <path d="M11.013 1.427a1.75 1.75 0 0 1 2.474 0l1.086 1.086a1.75 1.75 0 0 1 0 2.474l-8.61 8.61c-.21.21-.47.364-.756.445l-3.251 .93a.75.75 0 0 1-.927-.928l.929-3.25c.081-.286.235-.547.445-.758l8.61-8.61Zm.176 4.823L9.75 4.81l-6.286 6.287a.253.253 0 0 0-.064.108l-.558 1.953 1.953-.558a.253.253 0 0 0 .108-.064Zm1.238-3.763a.25.25 0 0 0-.354 0L10.811 3.75l1.439 1.44 1.263-1.263a.25.25 0 0 0 0-.354Z">
          </path>
          <span>Edit</span>
          </svg>';
      } else {
          // if not, enable the edit button
          $edit='<a href="'.$leaverequest.'='.$id.'" >
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
            <path d="M11.013 1.427a1.75 1.75 0 0 1 2.474 0l1.086 1.086a1.75 1.75 0 0 1 0 2.474l-8.61 8.61c-.21.21-.47.364-.756.445l-3.251 .93a.75.75 0 0 1-.927-.928l.929-3.25c.081-.286.235-.547.445-.758l8.61-8.61Zm.176 4.823L9.75 4.81l-6.286 6.287a.253.253 0 0 0-.064.108l-.558 1.953 1.953-.558a.253.253 0 0 0 .108-.064Zm1.238-3.763a.25.25 0 0 0-.354 0L10.811 3.75l1.439 1.44 1.263-1.263a.25.25 0 0 0 0-.354Z">
            </path>
          </svg><span>Edit</span>
          </a>';
      }
  
      $tick='<img class="click_ok fa fa-check" src="'.$img1.'" width="20px" />';
      $untick='<img class="click_not fa fa-close" src="'.$img2.'" width="20px" />';

       // $var1 .='';
    $var .='
    <tr>    <td><div class="wrap-t">'.$id.'</div></td>
                <td><div class="wrap-t">'.$sid.'</div></td>
                <td><div class="wrap-t">'.$sname.'</div></td>
               <td><div class="wrap-t">'.$fdate1.'</div></td>   
                <td><div class="wrap-t">'.$tdate1.'</div></td>
                <td><div class="wrap-t">'.$nleave.'</div></td>
                <td><div class="wrap-t">'.$sub.'</div></td>
                <td><div class="wrap-t">'.$tick.'</div></td>
                <td><div class="wrap-t">'.$untick.'</div></td>
                <td><div class="wrap-t">'.$status.'</div></td>   
                <td><div class="wrap-t">'. $edit.'</div></td>
                
                </td>
            </tr>';
            echo ' <input type="hidden" class="hidden_c1" id="hidden_f1" name="custId1" value='.$id.'>';  

    }
   

    if(!empty($leave)){
    $var .='</tbody>
        </table>
    </div>
    <div class="table-pagination">
        <nav aria-label="Page navigation example">
            <ul class="pagination">    
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link active" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>';
} else {
    $var = "No details are found";
}

echo $var;
?>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>






<script>
$(document).ready(function(){
 

  $(".click_ok").click(function()
  {

    var row = $(this).closest('tr'); 
    var id = row.find('td:nth-child(1)').text();

   // alert(id)


    
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









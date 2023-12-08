<?php
require(__DIR__.'/../../config.php');
//$context = context_system::instance();
require_login();
global $CFG ,$USER;
$userid= $USER->id;

$leave_reqst_delete=new moodle_url('l/ocal/leaverequest/delete.php?id');

if(isset($_POST['year']) && isset($_POST['statuss'])){
  $year=$_POST['year'];
  $status=$_POST['statuss'];
  echo "Both year and status are set.";
  $leave = $DB->get_records_sql("SELECT * FROM {leave} WHERE YEAR(FROM_UNIXTIME(f_date))=$year AND l_status='$status'");

}
elseif(isset($_POST['year'])){
  $year=$_POST['year'];
  echo "Only year is set.";
  $leave = $DB->get_records_sql("SELECT * FROM {leave} WHERE YEAR(FROM_UNIXTIME(f_date))=$year");

}
elseif(isset($_POST['statuss'])){
  $status=$_POST['statuss'];
  echo "Only status is set.";
  $leave = $DB->get_records_sql("SELECT * FROM {leave} WHERE  l_status='$status'");
}

    if(!empty($leave)){
        $var .= '
        <div class="table-responsive custom-table">
         <table class="table mb-0">
           <thead>
             <tr>
             <th scope="col">
                 <div class="wrap-t">Roll no</div>
               </th>
               <th scope="col">
                 <div class="wrap-t">Student name</div>
               </th>
               <th scope="col">
                 <div class="wrap-t">Applied date</div>
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
               <div class="wrap-t">Status</div>
             </th>
             <th scope="col">
               <div class="wrap-t">Approved/Denied by</div>
             </th>
              <th scope="col">
               <div class="wrap-t">Approved/Denied date</div>
             </th>
             <th scope="col">
               <div class="wrap-t">Delete</div>
             </th>  
           </tr>
           </thead>
           <tbody>';
       
    }
    else{
        echo "no details are found";
    }

    foreach ($leave as $value) {
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
      
      $delete = ' <a href="'.$leave_reqst_delete.'='.$value->id.'" class="action-table" onclick="deleteItem()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M16 1.75V3h5.25a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1 0-1.5H8V1.75C8 .784 8.784 0 9.75 0h4.5C15.216 0 16 .784 16 1.75Zm-6.5 0V3h5V1.75a.25.25 0 0 0-.25-.25h-4.5a.25.25 0 0 0-.25.25ZM4.997 6.178a.75.75 0 1 0-1.493.144L4.916 20.92a1.75 1.75 0 0 0 1.742 1.58h10.684a1.75 1.75 0 0 0 1.742-1.581l1.413-14.597a.75.75 0 0 0-1.494-.144l-1.412 14.596a.25.25 0 0 1-.249.226H6.658a.25.25 0 0 1-.249-.226L4.997 6.178Z"></path><path d="M9.206 7.501a.75.75 0 0 1 .793.705l.5 8.5A.75.75 0 1 1 9 16.794l-.5-8.5a.75.75 0 0 1 .705-.793Zm6.293.793A.75.75 0 1 0 14 8.206l-.5 8.5a.75.75 0 0 0 1.498.088l.5-8.5Z"></path></svg> Delete</a>
      ';
      
      } else {
      $delete = ' <a class="action-table" style="text-decoration:none;color:#b9bab8;" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M16 1.75V3h5.25a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1 0-1.5H8V1.75C8 .784 8.784 0 9.75 0h4.5C15.216 0 16 .784 16 1.75Zm-6.5 0V3h5V1.75a.25.25 0 0 0-.25-.25h-4.5a.25.25 0 0 0-.25.25ZM4.997 6.178a.75.75 0 1 0-1.493.144L4.916 20.92a1.75 1.75 0 0 0 1.742 1.58h10.684a1.75 1.75 0 0 0 1.742-1.581l1.413-14.597a.75.75 0 0 0-1.494-.144l-1.412 14.596a.25.25 0 0 1-.249.226H6.658a.25.25 0 0 1-.249-.226L4.997 6.178Z"></path><path d="M9.206 7.501a.75.75 0 0 1 .793.705l.5 8.5A.75.75 0 1 1 9 16.794l-.5-8.5a.75.75 0 0 1 .705-.793Zm6.293.793A.75.75 0 1 0 14 8.206l-.5 8.5a.75.75 0 0 0 1.498.088l.5-8.5Z"></path></svg> Delete</a>
      ';  }
      
      $nleave=$value->n_leave;
      $sub=$value->subject;
      $status = $value->l_status;
      $reason = $value->l_denied; 
      //print_r($reason);exit();
      if ($status === null) {
      $status = 'pending';
      }
      if ($status == "denied") {
         $status = '<span class="denied-tooltip" title="'.$reason.'">Denied</span>';
      }
      $namet = $name->firstname . " " . $name->middlename . " " . $name->lastname;
      // $var1 .='';
    $var .='
    <tr>
                <td><div class="wrap-t">'.$sid.'</div></td>
                <td><div class="wrap-t">'.$sname.'</div></td>
                <td><div class="wrap-t">'.$apdate1.'</div></td>
                <td><div class="wrap-t">'.$fdate1.'</div></td>   
                <td><div class="wrap-t">'.$tdate1.'</div></td>
                <td><div class="wrap-t">'.$nleave.'</div></td>
                <td><div class="wrap-t">'.$sub.'</div></td>
                <td><div class="wrap-t">'.$status.'</div></td>   
                <td><div class="wrap-t">'.$namet.'</div></td>
                <td><div class="wrap-t">'.$dadate1.'</div></td>
                <td><div class="wrap-t">'.$delete.'</div></td>
                
                </td>
            </tr>';
            echo ' <input type="hidden" class="hidden_c" id="hidden_f" name="custId" value='.$id.'>';  

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

    }
echo $var;

?>
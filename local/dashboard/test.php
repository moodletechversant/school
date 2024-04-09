<?php
require(__DIR__.'/../../config.php');
//$context = context_system::instance();
require_login();
global $DB,$USER;
$userid=$USER->id;

//$logo1 = new moodle_url('/course/view.php?id');
//$editsubject = new moodle_url('/local/subject/editsubject.php?id');
$current_date = time();
if(isset($_POST['b_id'])){
    $bid= $_POST['b_id'];
    $models = $DB->get_records_sql("SELECT * from {class} where academic_id='$bid'");
    $select_data = '<option value="" selected disabled>---- Select Class ----</option>';
    
    foreach($models as $keys =>$model){
    $select_data .='<option value =' .$model->id.'>' .$model->class_name.'</option>';
    }
    echo $select_data;
}

if(isset($_POST['c_id'])){
    $cid= $_POST['c_id'];
    if($cid==0){
        $select_data .= '<option value="" selected disabled>---- Select Division----</option>';
    }
    else{
    $models = $DB->get_records_sql("SELECT * from {division} where div_class='$cid'");
    $select_data .= '<option value="" selected disabled>---- Select Division----</option>';

    foreach($models as $model){
        $select_data .='<option value =' .$model->id.'>' .$model->div_name.'</option>';
        }
    }
    echo $select_data;
}


if(isset($_POST['d_id'])){
    $did= $_POST['d_id'];
    if($did==0){
        $select_data .= '<option value="" selected disabled>---- Select Subject----</option>';
    }
    else{
        $models = $DB->get_records_sql(" SELECT * FROM mdl_subject JOIN mdl_course ON mdl_subject.course_id = mdl_course.id
        WHERE sub_division = $did; ");
            $select_data .= '<option value="" selected disabled>--- Select Subject ---</option>';

    foreach($models as $model){
        $select_data .='<option value =' .$model->id.'>' .$model->fullname.'</option>';
        }
    }
    echo $select_data;
}






if(isset($_POST['s_id'])){
    $sid= $_POST['s_id'];
    
    // print_r($sid);exit();
    $models = $DB->get_records_sql("SELECT * FROM {quiz} WHERE course = $sid");
    // print_r($models);exit();
    if(!empty($models)){
        $var = '
        <div class="table-responsive custom-table">
         <table class="table mb-0">
           <thead>
             <tr>
             <th scope="col">
                 <div class="wrap-t">Quiz Name</div>
               </th>
               <th scope="col">
                 <div class="wrap-t">Time open</div>
               </th>
               <th scope="col">
                 <div class="wrap-t">Time close</div>
               </th>
                <th scope="col">
                 <div class="wrap-t">Status</div>
               </th>
               <th scope="col">
                 <div class="wrap-t">Action</div>
               </th>
             </tr>
           </thead>
           <tbody>';
       
    }
    else{
        echo "no details are found";
    }

    foreach ($models as $model) {
    //$class = $DB->get_record_sql(" SELECT * FROM {class} WHERE id = $model->sub_class");
    // $division = $DB->get_record_sql(" SELECT * FROM {division} WHERE id = $model->sub_division");
    $id=$model->id;
            $cm = get_coursemodule_from_instance('quiz', $id, 0, false, MUST_EXIST);
            $editsubject = $CFG->wwwroot.'/mod/quiz/view.php?id='.$cm->id;

    $qname = $model->name;
    $opentime = date('d-m-Y',$model->timeopen);
    $closetime = date('d-m-Y',$model->timeclose);
    $status = '';
    if ($current_date < $model->timeopen) {
        $status = 'Not Started';
    } elseif ($current_date >= $model->timeopen && $current_date <= $model->timeclose) {
        $status = 'In Progress';
    } elseif ($current_date > $model->timeclose) {
        $status = 'Late';
    }
    // $division = $division->div_name;
    // $var1 .='';
    $var .='
    <tr>
                <td><div class="wrap-t">'.$qname.'</div></td>
                <td><div class="wrap-t">'.$opentime.'</div></td>
                <td><div class="wrap-t">'.$closetime.'</div></td>
                <td><div class="wrap-t">'.$status.'</div></td>  
                <td><div class="wrap-t">
                <a href="'.$editsubject.'" class="action-table" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                        <path
                        d="M11.013 1.427a1.75 1.75 0 0 1 2.474 0l1.086 1.086a1.75 1.75 0 0 1 0 2.474l-8.61 8.61c-.21.21-.47.364-.756.445l-3.251 .93a.75.75 0 0 1-.927-.928l.929-3.25c.081-.286.235-.547.445-.758l8.61-8.61Zm.176 4.823L9.75 4.81l-6.286 6.287a.253.253 0 0 0-.064.108l-.558 1.953 1.953-.558a.253.253 0 0 0 .108-.064Zm1.238-3.763a.25.25 0 0 0-.354 0L10.811 3.75l1.439 1.44 1.263-1.263a.25.25 0 0 0 0-.354Z">
                        </path>
                    </svg>Add/Edit Content</a>
                    </div>
                </td>
            </tr>';

    }
   

    if(!empty($models)){
    $var .='</tbody>
        </table>
    </div>
    <!-- <div class="table-pagination">
        <nav aria-label="Page navigation example">
        <ul class="pagination">    
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link active" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
        </nav>
    </div>-->';

    }
echo $var;
}




if(isset($_POST['a_id'])){
    $aid= $_POST['a_id'];
    
    //  print_r($aid);exit();
    $models = $DB->get_records_sql("SELECT * FROM {assign} WHERE course = $aid");
    // print_r($models);exit();
    if(!empty($models)){
        $var = '
        <div class="table-responsive custom-table">
         <table class="table mb-0">
           <thead>
             <tr>
             <th scope="col">
                 <div class="wrap-t">Assignment Name</div>
               </th>
               <th scope="col">
                 <div class="wrap-t">Submission Date</div>
               </th>
               <th scope="col">
                 <div class="wrap-t">Due Date</div>
               </th>
                <th scope="col">
                 <div class="wrap-t">Status</div>
               </th>
               <th scope="col">
                 <div class="wrap-t">Action</div>
               </th>
             </tr>
           </thead>
           <tbody>';
       
    }
    else{
        echo "no details are found";
    }

    foreach ($models as $model) {
    //$class = $DB->get_record_sql(" SELECT * FROM {class} WHERE id = $model->sub_class");
    // $division = $DB->get_record_sql(" SELECT * FROM {division} WHERE id = $model->sub_division");
    $id=$model->id;
        // print_r($id);exit();

    $cm = get_coursemodule_from_instance('assign', $id, 0, false, MUST_EXIST);
    $editsubject = $CFG->wwwroot.'/mod/assign/view.php?id='.$cm->id;
    $assign_name=$model->name;
    $dates1=date('d-m-Y',$model->allowsubmissionsfromdate);
    $dates=date('d-m-Y',$model->duedate);
    $status = '';
    if ($current_date < $model->allowsubmissionsfromdate) {
        $status = 'Not Started';
    } elseif ($current_date >= $model->allowsubmissionsfromdate && $current_date <= $model->duedate) {
        $status = 'In Progress';
    } elseif ($current_date > $model->duedate) {
        $status = 'Late';
    }
    // $division = $division->div_name;
    // $var1 .='';
    $var .='
    <tr>
                <td><div class="wrap-t">'.$assign_name.'</div></td>
                <td><div class="wrap-t">'.$dates1.'</div></td>
                <td><div class="wrap-t">'.$dates.'</div></td>
                <td><div class="wrap-t">'.$status.'</div></td>  
                <td><div class="wrap-t">
                <a href="'.$editsubject.'" class="action-table" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                        <path
                        d="M11.013 1.427a1.75 1.75 0 0 1 2.474 0l1.086 1.086a1.75 1.75 0 0 1 0 2.474l-8.61 8.61c-.21.21-.47.364-.756.445l-3.251 .93a.75.75 0 0 1-.927-.928l.929-3.25c.081-.286.235-.547.445-.758l8.61-8.61Zm.176 4.823L9.75 4.81l-6.286 6.287a.253.253 0 0 0-.064.108l-.558 1.953 1.953-.558a.253.253 0 0 0 .108-.064Zm1.238-3.763a.25.25 0 0 0-.354 0L10.811 3.75l1.439 1.44 1.263-1.263a.25.25 0 0 0 0-.354Z">
                        </path>
                    </svg>Add/Edit Content</a>
                    </div>
                </td>
            </tr>';

    }
   

    if(!empty($models)){
    $var .='</tbody>
        </table>
    </div>
    <!-- <div class="table-pagination">
        <nav aria-label="Page navigation example">
        <ul class="pagination">    
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link active" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
        </nav>
    </div>-->';

    }
echo $var;
}

if(isset($_POST['f_id'])){
    $fid= $_POST['f_id'];
    // print_r($fid);
    
    $models = $DB->get_records_sql("SELECT * FROM {quiz} WHERE course = $fid");
         // print_r($models);
    if(!empty($models)){
 $var = '
 <div class="table-responsive custom-table">
  <table class="table mb-0">
    <thead>
      <tr>
      <th scope="col">
          <div class="wrap-t">Quiz Name</div>
        </th>
        <th scope="col">
          <div class="wrap-t">Time open</div>
        </th>
        <th scope="col">
          <div class="wrap-t">Time close</div>
        </th>
        <th scope="col">
          <div class="wrap-t">Status</div>
        </th>
        <th scope="col">
          <div class="wrap-t">Action</div>
        </th>
      </tr>
    </thead>
    <tbody>';

    }
    else{
        echo "no details are found";
    }
// $models = $DB->get_records_sql(" SELECT c.*, a.* FROM {class} c INNER JOIN {academic_year} a ON c.academic_id = a.id
// WHERE c.academic_id = $bid");

foreach ($models as $model) {
    //$class = $DB->get_record_sql(" SELECT * FROM {class} WHERE id = $model->sub_class");
    // $division = $DB->get_record_sql(" SELECT * FROM {division} WHERE id = $model->sub_division");
    $id=$model->id;
            $cm = get_coursemodule_from_instance('quiz', $id, 0, false, MUST_EXIST);
            $editsubject = $CFG->wwwroot.'/mod/quiz/view.php?id='.$cm->id;

    $qname = $model->name;
    $opentime = date('d-m-Y',$model->timeopen);
    $closetime = date('d-m-Y',$model->timeclose);
    $status = '';
    if ($current_date < $model->timeopen) {
        $status = 'Not Started';
    } elseif ($current_date >= $model->timeopen && $current_date <= $model->timeclose) {
        $status = 'In Progress';
    } elseif ($current_date > $model->timeclose) {
        $status = 'Late';
    }
    // $division = $division->div_name;
    // $var1 .='';
    $var .='
    <tr>
                <td><div class="wrap-t">'.$qname.'</div></td>
                <td><div class="wrap-t">'.$opentime.'</div></td>
                <td><div class="wrap-t">'.$closetime.'</div></td>
                <td><div class="wrap-t">'.$status.'</div></td>  
                <td><div class="wrap-t">
                <a href="'.$editsubject.'" class="action-table" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                        <path
                        d="M11.013 1.427a1.75 1.75 0 0 1 2.474 0l1.086 1.086a1.75 1.75 0 0 1 0 2.474l-8.61 8.61c-.21.21-.47.364-.756.445l-3.251 .93a.75.75 0 0 1-.927-.928l.929-3.25c.081-.286.235-.547.445-.758l8.61-8.61Zm.176 4.823L9.75 4.81l-6.286 6.287a.253.253 0 0 0-.064.108l-.558 1.953 1.953-.558a.253.253 0 0 0 .108-.064Zm1.238-3.763a.25.25 0 0 0-.354 0L10.811 3.75l1.439 1.44 1.263-1.263a.25.25 0 0 0 0-.354Z">
                        </path>
                    </svg>Add/Edit Content</a>
                    </div>
                </td>
            </tr>';

    }
   

if(!empty($models)){
$var .='</tbody>
    </table>
  </div>
  <!-- <div class="table-pagination">
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
        <li class="page-item"><a class="page-link active" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
      </ul>
    </nav>
  </div>-->';

}
echo $var;
}






if(isset($_POST['m_id'])){
  $mid= $_POST['m_id'];
  
  //  print_r($aid);exit();
  $models = $DB->get_records_sql("SELECT * FROM {assign} WHERE course = $mid");
  // print_r($models);exit();
  if(!empty($models)){
      $var = '
      <div class="table-responsive custom-table">
       <table class="table mb-0">
         <thead>
           <tr>
           <th scope="col">
               <div class="wrap-t">Assignment Name</div>
             </th>
             <th scope="col">
               <div class="wrap-t">Submission Date</div>
             </th>
             <th scope="col">
               <div class="wrap-t">Due Date</div>
             </th>
              <th scope="col">
               <div class="wrap-t">Status</div>
             </th>
             <th scope="col">
               <div class="wrap-t">Action</div>
             </th>
           </tr>
         </thead>
         <tbody>';
     
  }
  else{
      echo "no details are found";
  }

  foreach ($models as $model) {
  //$class = $DB->get_record_sql(" SELECT * FROM {class} WHERE id = $model->sub_class");
  // $division = $DB->get_record_sql(" SELECT * FROM {division} WHERE id = $model->sub_division");
  $id=$model->id;
      // print_r($id);exit();

  $cm = get_coursemodule_from_instance('assign', $id, 0, false, MUST_EXIST);
  $editsubject = $CFG->wwwroot.'/mod/assign/view.php?id='.$cm->id;
  $assign_name=$model->name;
  $dates1=date('d-m-Y',$model->allowsubmissionsfromdate);
  $dates=date('d-m-Y',$model->duedate);
  $status = '';
  if ($current_date < $model->allowsubmissionsfromdate) {
      $status = 'Not Started';
  } elseif ($current_date >= $model->allowsubmissionsfromdate && $current_date <= $model->duedate) {
      $status = 'In Progress';
  } elseif ($current_date > $model->duedate) {
      $status = 'Late';
  }
  // $division = $division->div_name;
  // $var1 .='';
  $var .='
  <tr>
              <td><div class="wrap-t">'.$assign_name.'</div></td>
              <td><div class="wrap-t">'.$dates1.'</div></td>
              <td><div class="wrap-t">'.$dates.'</div></td>
              <td><div class="wrap-t">'.$status.'</div></td>  
              <td><div class="wrap-t">
              <a href="'.$editsubject.'" class="action-table" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                      <path
                      d="M11.013 1.427a1.75 1.75 0 0 1 2.474 0l1.086 1.086a1.75 1.75 0 0 1 0 2.474l-8.61 8.61c-.21.21-.47.364-.756.445l-3.251 .93a.75.75 0 0 1-.927-.928l.929-3.25c.081-.286.235-.547.445-.758l8.61-8.61Zm.176 4.823L9.75 4.81l-6.286 6.287a.253.253 0 0 0-.064.108l-.558 1.953 1.953-.558a.253.253 0 0 0 .108-.064Zm1.238-3.763a.25.25 0 0 0-.354 0L10.811 3.75l1.439 1.44 1.263-1.263a.25.25 0 0 0 0-.354Z">
                      </path>
                  </svg>Add/Edit Content</a>
                  </div>
              </td>
          </tr>';

  }
 

  if(!empty($models)){
  $var .='</tbody>
      </table>
  </div>
  <!-- <div class="table-pagination">
      <nav aria-label="Page navigation example">
      <ul class="pagination">    
          <li class="page-item"><a class="page-link" href="#">Previous</a></li>
          <li class="page-item"><a class="page-link active" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">Next</a></li>
      </ul>
      </nav>
  </div>-->';

  }
echo $var;
}










if(isset($_POST['h_id'])){
  $hid= $_POST['h_id'];
  $userid = $USER->id;

//echo $userid;


  if($hid==0){
      $select_data .= '<option value="" selected disabled>---- Select Division----</option>';
  }
  else{
   $models = $DB->get_records_sql("SELECT {division}.id,{division}.div_name FROM {division} 
     INNER JOIN {teacher_assign} ON  {teacher_assign}.t_division={division}.id where {teacher_assign}.t_class='$hid' AND {teacher_assign}.user_id=$userid");
  //$models = $DB->get_records_sql("SELECT * from {division} where div_class='$hid'");

 // echo $models;
  $select_data .= '<option value="" selected disabled>---- Select Division----</option>';

  foreach($models as $model){
      $select_data .='<option value =' .$model->id.'>' .$model->div_name.'</option>';
      }
  }
  echo $select_data;
}



if(isset($_POST['j_id'])){
  $jid= $_POST['j_id'];
  $userid = $USER->id;

  // echo $jid;

  if($jid==0){
      $select_data .= '<option value="" selected disabled>---- Select Subject----</option>';
  }
  else{
      // $models = $DB->get_records_sql(" SELECT * FROM mdl_subject JOIN mdl_course ON mdl_subject.course_id = mdl_course.id
      // WHERE sub_division = $jid; ");
      $models = $DB->get_records_sql("SELECT {subject}.id, {subject}.sub_name 
        FROM {subject} 
        INNER JOIN {teacher_assign} ON {teacher_assign}.t_subject = {subject}.course_id 
        WHERE {teacher_assign}.t_division = $jid AND {teacher_assign}.user_id = $userid
    ");
    
      // echo $models;exit();

          $select_data .= '<option value="" selected disabled>--- Select Subject ---</option>';

  foreach($models as $model){
      $select_data .='<option value =' .$model->id.'>' .$model->sub_name.'</option>';
      }
  }
  echo $select_data;
}





if(isset($_POST['k_id'])){
  $kid= $_POST['k_id'];
  //echo $kid;
  // print_r($sid);exit();
  $subjectdata = $DB->get_records_sql("SELECT * FROM {subject} WHERE id = $kid");
 //print_r($subjectdata);exit();
foreach($subjectdata as $coursedata){
$courseid=$coursedata->course_id;
}
//print_r($courseid);exit();
  $models = $DB->get_records_sql("SELECT * FROM {quiz} WHERE course = $courseid");
  //print_r($models);exit();
  if(!empty($models)){
      $var = '
      <div class="table-responsive custom-table">
       <table class="table mb-0">
         <thead>
           <tr>
           <th scope="col">
               <div class="wrap-t">Quiz Name</div>
             </th>
             <th scope="col">
               <div class="wrap-t">Time open</div>
             </th>
             <th scope="col">
               <div class="wrap-t">Time close</div>
             </th>
              <th scope="col">
               <div class="wrap-t">Status</div>
             </th>
             <th scope="col">
               <div class="wrap-t">Action</div>
             </th>
           </tr>
         </thead>
         <tbody>';
     
  }
  else{
      echo "no details are found";
  }

  foreach ($models as $model) {
  //$class = $DB->get_record_sql(" SELECT * FROM {class} WHERE id = $model->sub_class");
  // $division = $DB->get_record_sql(" SELECT * FROM {division} WHERE id = $model->sub_division");
  $id=$model->id;
          $cm = get_coursemodule_from_instance('quiz', $id, 0, false, MUST_EXIST);
          $editsubject = $CFG->wwwroot.'/mod/quiz/view.php?id='.$cm->id;

  $qname = $model->name;
  $opentime = date('d-m-Y',$model->timeopen);
  $closetime = date('d-m-Y',$model->timeclose);
  $status = '';
  if ($current_date < $model->timeopen) {
      $status = 'Not Started';
  } elseif ($current_date >= $model->timeopen && $current_date <= $model->timeclose) {
      $status = 'In Progress';
  } elseif ($current_date > $model->timeclose) {
      $status = 'Late';
  }
  // $division = $division->div_name;
  // $var1 .='';
  $var .='
  <tr>
              <td><div class="wrap-t">'.$qname.'</div></td>
              <td><div class="wrap-t">'.$opentime.'</div></td>
              <td><div class="wrap-t">'.$closetime.'</div></td>
              <td><div class="wrap-t">'.$status.'</div></td>  
              <td><div class="wrap-t">
              <a href="'.$editsubject.'" class="action-table" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                      <path
                      d="M11.013 1.427a1.75 1.75 0 0 1 2.474 0l1.086 1.086a1.75 1.75 0 0 1 0 2.474l-8.61 8.61c-.21.21-.47.364-.756.445l-3.251 .93a.75.75 0 0 1-.927-.928l.929-3.25c.081-.286.235-.547.445-.758l8.61-8.61Zm.176 4.823L9.75 4.81l-6.286 6.287a.253.253 0 0 0-.064.108l-.558 1.953 1.953-.558a.253.253 0 0 0 .108-.064Zm1.238-3.763a.25.25 0 0 0-.354 0L10.811 3.75l1.439 1.44 1.263-1.263a.25.25 0 0 0 0-.354Z">
                      </path>
                  </svg>Add/Edit Content</a>
                  </div>
              </td>
          </tr>';

  }
 

  if(!empty($models)){
  $var .='</tbody>
      </table>
  </div>
  <!-- <div class="table-pagination">
      <nav aria-label="Page navigation example">
      <ul class="pagination">    
          <li class="page-item"><a class="page-link" href="#">Previous</a></li>
          <li class="page-item"><a class="page-link active" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">Next</a></li>
      </ul>
      </nav>
  </div>-->';

  }
echo $var;
}




if(isset($_POST['p_id'])){
  $pid= $_POST['p_id'];
  $subjectdata1 = $DB->get_records_sql("SELECT * FROM {subject} WHERE id = $pid");
 //print_r($subjectdata);exit();
foreach($subjectdata1 as $coursedata2){
$assigncourseid=$coursedata2->course_id;
}
  //  print_r($aid);exit();
  $models = $DB->get_records_sql("SELECT * FROM {assign} WHERE course = $assigncourseid");
  // print_r($models);exit();
  if(!empty($models)){
      $var = '
      <div class="table-responsive custom-table">
       <table class="table mb-0">
         <thead>
           <tr>
           <th scope="col">
               <div class="wrap-t">Assignment Name</div>
             </th>
             <th scope="col">
               <div class="wrap-t">Submission Date</div>
             </th>
             <th scope="col">
               <div class="wrap-t">Due Date</div>
             </th>
              <th scope="col">
               <div class="wrap-t">Status</div>
             </th>
             <th scope="col">
               <div class="wrap-t">Action</div>
             </th>
           </tr>
         </thead>
         <tbody>';
     
  }
  else{
      echo "no details are found";
  }

  foreach ($models as $model) {
  //$class = $DB->get_record_sql(" SELECT * FROM {class} WHERE id = $model->sub_class");
  // $division = $DB->get_record_sql(" SELECT * FROM {division} WHERE id = $model->sub_division");
  $id=$model->id;
      // print_r($id);exit();

  $cm = get_coursemodule_from_instance('assign', $id, 0, false, MUST_EXIST);
  $editsubject = $CFG->wwwroot.'/mod/assign/view.php?id='.$cm->id;
  $assign_name=$model->name;
  $dates1=date('d-m-Y',$model->allowsubmissionsfromdate);
  $dates=date('d-m-Y',$model->duedate);
  $status = '';
  if ($current_date < $model->allowsubmissionsfromdate) {
      $status = 'Not Started';
  } elseif ($current_date >= $model->allowsubmissionsfromdate && $current_date <= $model->duedate) {
      $status = 'In Progress';
  } elseif ($current_date > $model->duedate) {
      $status = 'Late';
  }
  // $division = $division->div_name;
  // $var1 .='';
  $var .='
  <tr>
              <td><div class="wrap-t">'.$assign_name.'</div></td>
              <td><div class="wrap-t">'.$dates1.'</div></td>
              <td><div class="wrap-t">'.$dates.'</div></td>
              <td><div class="wrap-t">'.$status.'</div></td>  
              <td><div class="wrap-t">
              <a href="'.$editsubject.'" class="action-table" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                      <path
                      d="M11.013 1.427a1.75 1.75 0 0 1 2.474 0l1.086 1.086a1.75 1.75 0 0 1 0 2.474l-8.61 8.61c-.21.21-.47.364-.756.445l-3.251 .93a.75.75 0 0 1-.927-.928l.929-3.25c.081-.286.235-.547.445-.758l8.61-8.61Zm.176 4.823L9.75 4.81l-6.286 6.287a.253.253 0 0 0-.064.108l-.558 1.953 1.953-.558a.253.253 0 0 0 .108-.064Zm1.238-3.763a.25.25 0 0 0-.354 0L10.811 3.75l1.439 1.44 1.263-1.263a.25.25 0 0 0 0-.354Z">
                      </path>
                  </svg>Add/Edit Content</a>
                  </div>
              </td>
          </tr>';

  }
 

  if(!empty($models)){
  $var .='</tbody>
      </table>
  </div>
  <!-- <div class="table-pagination">
      <nav aria-label="Page navigation example">
      <ul class="pagination">    
          <li class="page-item"><a class="page-link" href="#">Previous</a></li>
          <li class="page-item"><a class="page-link active" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">Next</a></li>
      </ul>
      </nav>
  </div>-->';

  }
echo $var;
}



?>
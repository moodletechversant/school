<?php
require(__DIR__.'/../../config.php');
//$context = context_system::instance();
require_login();
global $DB;

if (isset($_POST['e_id'])) {
    $eid = $_POST['e_id'];

    $models = $DB->get_records_sql("SELECT * FROM {class} WHERE academic_id='$eid'");

    if (!empty($models)) {
        $selected_data = '<option>---- Select Class ----</option>';

        foreach ($models as $model) {
            $class_data = $model->class_name;
            $selected_data .= '<option value="' . $model->id . '">' . $class_data . '</option>';
        }

        echo $selected_data;
    } else {
        $selected_data .= '<option value="">No Class found</option>';
        echo $selected_data;
    }
}

if(isset($_POST['b_id'])){
    $cid= $_POST['b_id'];
    $models = $DB->get_records_sql("SELECT div_name,id from {division} where div_class='$cid' AND div_teacherid IS NULL");
    // $select_data = '<option value="" selected disabled>---- Choose a model ----</option>';
    $select_data .= '<option value="" selected disabled>----Select Division----</option>';
    foreach($models as $keys =>$model){
    $select_data .='<option value =' .$model->id.'>' .$model->div_name.'</option>';
    }
    echo $select_data;
}

if(isset($_POST['t_id'])){
    $cid= $_POST['t_id'];
    $models = $DB->get_records_sql("SELECT * from {teacher} where user_id NOT EXISTS (
        SELECT * FROM {division} WHERE  FIND_IN_SET({division}.div_teacherid, user_id))");
    // $select_data = '<option value="" selected disabled>---- Choose a model ----</option>';
    $select_data .= '<option value="" selected disabled>----Select Division----</option>';
    foreach($models as $keys =>$model){
    $select_data .='<option value =' .$model->user_id .'>' .$model->t_fname.'</option>';
    }
    echo $select_data;
}


if (isset($_POST['c_id'])) {
    $did = $_POST['c_id'];
    $delete=$_POST['delete'];
    //echo $delete;
    if ($division = $DB->get_record('division', array('id' => $delete))) {
        $division->div_teacherid = null;
        $DB->update_record('division', $division);     
    }
    $models = $DB->get_records_sql("SELECT * FROM {division}  WHERE div_class = $did");

    //print_r( $models);exit();
    if(!empty($models)){
        $var = '
        <div class="table-responsive custom-table">
         <table class="table mb-0">
           <thead>
             <tr>
             <th scope="col">
             <div class="wrap-t">Teacher Name</div>
           </th>
               <th scope="col">
                 <div class="wrap-t">Division</div>
               </th>
               <th scope="col">
               <div class="wrap-t">Qualification</div>
               </th>
               <th scope="col">
               <div class="wrap-t">Action</div>
               </th>
             </tr>
           </thead>
           <tbody>';
       
    foreach ($models as $model) {

        if($model->div_teacherid){
            
    $teacher = $DB->get_record_sql(" SELECT * FROM {teacher} WHERE user_id = $model->div_teacherid");
    //print_r($teacher);exit();
    //$class = $DB->get_record_sql(" SELECT * FROM {class} WHERE id = $model->div_class");
   // print_r($class);exit();
    //$division = $DB->get_record_sql(" SELECT * FROM {division} WHERE id = $model->id");
    //print_r($division);exit();
    $id = $model->id;
    $teacher_name = $teacher->t_fname;
    $qualification = $teacher->t_qlificatn;    
    $division = $model->div_name;
    // $var1 .='';
    $var .='
    <tr>
                <td><div class="wrap-t">'.$teacher_name.'</div></td>
                <td><div class="wrap-t">'.$division.'</div></td>
                <td><div class="wrap-t">'.$qualification.'</div></td>
                <td><div class="wrap-t">
                <a onclick="deleteclsteach('.$id.')" href="#"  class="action-table"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M16 1.75V3h5.25a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1 0-1.5H8V1.75C8 .784 8 .784 8 .784h.006C8 .784 8 .784 8 .784h4.5C15.216 0 16 .784 16 1.75Zm-6.5 0V3h5V1.75a.25.25 0 0 0-.25-.25h-4.5a.25.25 0 0 0-.25.25ZM4.997 6.178a.75.75 0 1 0-1.493.144L4.916 20.92a1.75 1.75 0 0 0 1.742 1.58h10.684a1.75 1.75 0 0 0 1.742-1.581l1.413-14.597a.75.75 0 0 0-1.494-.144l-1.412 14.596a.25.25 0 0 1-.249.226H6.658a.25.25 0 0 1-.249-.226L4.997 6.178Z"></path><path d="M9.206 7.501a.75.75 0 0 1 .793.705l.5 8.5A.75.75 0 1 1 9 16.794l-.5-8.5a.75.75 0 0 1 .705-.793Zm6.293.793A.75.75 0 1 0 14 8.206l-.5 8.5a.75.75 0 0 0 1.498.088l.5-8.5Z"></path></svg>Suspend</a></div>
                </td>
            </tr>';
        }
    }
    $var .='</tbody>
        </table>
    </div>
    <!--<div class="table-pagination">
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
else{
    $var = '<div class="error-message">No Details are found for this selected class.</div>';
}
echo $var;
}
?>
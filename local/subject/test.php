<?php
require(__DIR__.'/../../config.php');
//$context = context_system::instance();
require_login();
global $DB;
$logo1 = new moodle_url('/course/view.php?id');
$editsubject = new moodle_url('/local/subject/editsubject.php?id');

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
    $delete=$_POST['delete'];
    // echo $delete;
    if( $delete>0){
        $DB->delete_records('subject', array('course_id'=> $delete));
        $DB->delete_records('course', array('id'=> $delete));
        
    }
    
    $models = $DB->get_records_sql(" SELECT * FROM mdl_subject JOIN mdl_course ON mdl_subject.course_id = mdl_course.id
  WHERE sub_division = $did; ");
 //print_r( $models);exit();
    if(!empty($models)){
        $var = '
        <div class="table-responsive custom-table">
         <table class="table mb-0">
           <thead>
             <tr>
             <th scope="col">
                 <div class="wrap-t">Class</div>
               </th>
               <th scope="col">
                 <div class="wrap-t">Division</div>
               </th>
               <th scope="col">
                 <div class="wrap-t">Subject</div>
               </th>
                <th scope="col">
                 <div class="wrap-t">Description</div>
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
    $class = $DB->get_record_sql(" SELECT * FROM {class} WHERE id = $model->sub_class");
    $division = $DB->get_record_sql(" SELECT * FROM {division} WHERE id = $model->sub_division");

    $id = $model->course_id;
    $sub_name = $model->fullname;
    $sub_description = $model->sub_description;
    $class = $class->class_name;
    $division = $division->div_name;
    // $var1 .='';
    $var .='
    <tr>
                <td><div class="wrap-t">'.$class.'</div></td>
                <td><div class="wrap-t">'.$division.'</div></td>
                <td><div class="wrap-t">'.$sub_name.'</div></td>
                <td><div class="wrap-t">'.$sub_description.'</div></td>  
                <td><div class="wrap-t">
                <a href="'.$logo1.'='.$id.'" class="action-table" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                        <path
                        d="M11.013 1.427a1.75 1.75 0 0 1 2.474 0l1.086 1.086a1.75 1.75 0 0 1 0 2.474l-8.61 8.61c-.21.21-.47.364-.756.445l-3.251 .93a.75.75 0 0 1-.927-.928l.929-3.25c.081-.286.235-.547.445-.758l8.61-8.61Zm.176 4.823L9.75 4.81l-6.286 6.287a.253.253 0 0 0-.064.108l-.558 1.953 1.953-.558a.253.253 0 0 0 .108-.064Zm1.238-3.763a.25.25 0 0 0-.354 0L10.811 3.75l1.439 1.44 1.263-1.263a.25.25 0 0 0 0-.354Z">
                        </path>
                    </svg>Add/Edit Content</a>
                        <a href="'.$editsubject.'='.$id.'" class="action-table" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                            <path
                            d="M11.013 1.427a1.75 1.75 0 0 1 2.474 0l1.086 1.086a1.75 1.75 0 0 1 0 2.474l-8.61 8.61c-.21.21-.47.364-.756.445l-3.251 .93a.75.75 0 0 1-.927-.928l.929-3.25c.081-.286.235-.547.445-.758l8.61-8.61Zm.176 4.823L9.75 4.81l-6.286 6.287a.253.253 0 0 0-.064.108l-.558 1.953 1.953-.558a.253.253 0 0 0 .108-.064Zm1.238-3.763a.25.25 0 0 0-.354 0L10.811 3.75l1.439 1.44 1.263-1.263a.25.25 0 0 0 0-.354Z">
                            </path>
                    </svg> Edit</a>
                    
                    <a onclick="deletesubject('.$id.')" href="#" class="action-table"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M16 1.75V3h5.25a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1 0-1.5H8V1.75C8 .784 8 .784 8 .784h.006C8 .784 8 .784 8 .784h4.5C15.216 0 16 .784 16 1.75Zm-6.5 0V3h5V1.75a.25.25 0 0 0-.25-.25h-4.5a.25.25 0 0 0-.25.25ZM4.997 6.178a.75.75 0 1 0-1.493.144L4.916 20.92a1.75 1.75 0 0 0 1.742 1.58h10.684a1.75 1.75 0 0 0 1.742-1.581l1.413-14.597a.75.75 0 0 0-1.494-.144l-1.412 14.596a.25.25 0 0 1-.249.226H6.658a.25.25 0 0 1-.249-.226L4.997 6.178Z"></path><path d="M9.206 7.501a.75.75 0 0 1 .793.705l.5 8.5A.75.75 0 1 1 9 16.794l-.5-8.5a.75.75 0 0 1 .705-.793Zm6.293.793A.75.75 0 1 0 14 8.206l-.5 8.5a.75.75 0 0 0 1.498.088l.5-8.5Z"></path></svg> Delete</a>
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
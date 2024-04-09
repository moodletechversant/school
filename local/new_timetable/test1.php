<?php 

require(__DIR__.'/../../config.php');
//$context = context_system::instance();
require_login();
global $DB;

if(isset($_POST['b_id'])){
    $bid= $_POST['b_id'];
    // $c_id = $DB->get_records_sql("SELECT course_id from {subject} where course_id='$bid'");
    // $tname=$model->user_id;
    $models=$DB->get_records_sql("SELECT {teacher}.t_fname,{teacher}.user_id from {teacher} INNER JOIN {teacher_assign} ON {teacher}.user_id={teacher_assign}.user_id where {teacher_assign}.t_subject='$bid'");
    $select_data = '<option value="" selected disabled>---- Teacher ----</option>';
    
    foreach($models as $keys =>$model){
    $select_data .='<option value =' .$model->user_id.'>' .$model->t_fname.'</option>';
    }
    echo $select_data;
}

?>



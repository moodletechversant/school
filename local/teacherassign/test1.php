

<?php
require(__DIR__.'/../../config.php');
//$context = context_system::instance();
require_login();
global $DB;

if(isset($_POST['b_id'])){
    $bid= $_POST['b_id'];
    $models = $DB->get_records_sql("SELECT sub_name,course_id from {subject} where sub_division='$bid'");
    $select_data .= '<option value="" selected disabled>---- Choose a Subject ----</option>';
    
    foreach($models as $keys =>$model){
    $select_data .='<option value =' .$model->course_id.'>' .$model->sub_name.'</option>';
    }
    echo $select_data;
}
?>
<?php 

require(__DIR__.'/../../config.php');
//$context = context_system::instance();
require_login();
global $DB;

if(isset($_POST['b_id'])){
    $bid= $_POST['b_id'];
    $models = $DB->get_records_sql("SELECT * from {class} where academic_id='$bid'");
    $select_data = '<option value="" selected disabled>---- Select class ----</option>';
    
    foreach($models as $keys =>$model){
    $select_data .='<option value =' .$model->id.'>' .$model->class_name.'</option>';
    }
    echo $select_data;
}

if(isset($_POST['c_id'])){
    $cid= $_POST['c_id'];
    $models = $DB->get_records_sql("SELECT div_name,id from {division} where div_class='$cid'");
    // $select_data = '<option value="" selected disabled>---- Choose a model ----</option>';
    
    foreach($models as $keys =>$model){
    $select_data .='<option value =' .$model->id.'>' .$model->div_name.'</option>';
    }
    echo $select_data;
}

?>



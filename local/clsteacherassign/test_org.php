

<?php
require(__DIR__.'/../../config.php');
//$context = context_system::instance();
require_login();
global $DB;

if(isset($_POST['b_id'])){
    $bid= $_POST['b_id'];
    $models = $DB->get_records_sql("SELECT div_name,id from {division} where div_class='$bid' AND div_teacherid IS NULL");
    // $select_data = '<option value="" selected disabled>---- Choose a model ----</option>';
    $select_data .= '<option value="" selected disabled>----Select Division----</option>';
    foreach($models as $keys =>$model){
    $select_data .='<option value =' .$model->id.'>' .$model->div_name.'</option>';
    }
    echo $select_data;
}
?>
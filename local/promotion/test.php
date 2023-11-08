<?php
// Connect to the database
require(__DIR__.'/../../config.php');

require_login();
global $DB, $USER,$CFG;

  if(isset($_POST['b_id'])){
    $bid= $_POST['b_id'];
    $models = $DB->get_records_sql("SELECT * from {class} WHERE academic_id='$bid'");
    if (!empty($models)) {
    $select_data = '<option value="" selected disabled>---- Select Class ----</option>';
    
    foreach($models as $keys =>$model){
    $select_data .='<option value =' .$model->id.'>' .$model->class_name.'</option>';
    }
    echo $select_data;
}
else {
    $select_data .= '<option value="">No Class found</option>';
    echo $select_data;
}
}
 


if (isset($_POST['c_id'])) {
  $cid = $_POST['c_id'];
  if ($cid == 0) {
      $select_data .= '<option value="" selected disabled>---- Select Division----</option>';
  } else {
      $models = $DB->get_records_sql("SELECT * FROM {division} WHERE div_class = '$cid'");
      
      $select_data .= '<option value="" selected disabled>---- Select Division----</option>';

      if (empty($models)) {
          $select_data .= '<option value="" disabled>No divisions found</option>';
      } else {
          foreach ($models as $model) {
              $select_data .= '<option value="' . $model->id . '">' . $model->div_name . '</option>';
          }
      }
  }
  echo $select_data;
}


//FAILED STUDENTS



?>

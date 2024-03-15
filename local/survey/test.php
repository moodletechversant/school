<?php
// Connect to the database
require(__DIR__.'/../../config.php');

require_login();
global $DB, $USER;
// Retrieve the selected option value
 


  if (isset($_POST['option'])) {
    $bid = $_POST['option'];
  
    $models = $DB->get_records_sql("SELECT * FROM {class} WHERE academic_id='$bid'");
  
    if (!empty($models)) {
        $select_data = '<option>---- Select Class ----</option>';
  
        foreach ($models as $model) {
            $class_data = $model->class_name;
            $select_data .= '<option value="' . $model->id . '">' . $class_data . '</option>';
        }
  
        echo $select_data;
    } else {
        $select_data .= '<option value="">No Class found</option>';
        echo $select_data;
    }
  }
  if (isset($_POST['option1'])) {
  $cid = $_POST['option1'];
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


  if(isset($_POST['academicYearOption'])){
    $bid = $_POST['academicYearOption']; // Retrieve 'option2' value
    $models = $DB->get_records_sql("SELECT * FROM {academic_year} WHERE id='$bid'");
  
    if (!empty($models)) {
        $select_data = '<option>---- Select Survey ----</option>';
  
        foreach ($models as $model) {
            $start_year = $model->start_year;
            $end_year = $model->end_year;
            $survey_q = $DB->get_records_sql("SELECT * FROM {customsurvey} WHERE survey_from BETWEEN  $start_year AND   $end_year AND survey_to BETWEEN  $start_year AND   $end_year");

            foreach ($survey_q as $survey) {
                $survey_name = $survey->survey_name;
                $survey_id = $survey->id;
                $select_data .= '<option value="' .  $survey_id . '">' . $survey_name . '</option>';
            }
        }
  
        echo $select_data;
    } else {
        $select_data = '<option value="">No survey found</option>';
        echo $select_data;
    }
}



?>

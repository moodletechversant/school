<?php
// Connect to the database
require(__DIR__.'/../../config.php');

require_login();
global $DB, $USER;
// Retrieve the selected option value
  if(isset($_POST['option'])){
        $option1 = $_POST['option'];
        $user=$USER->id;
        // Retrieve the corresponding option from a database or other data source
        $corresponding_option = $DB->get_records_sql("SELECT {class}.id,{class}.class_name FROM {teacher_assign}
        INNER JOIN {class} ON  {teacher_assign}.t_class={class}.id where ({class}.academic_id)='$option1' AND {teacher_assign}.user_id=$user");
        // Generate the HTML for the corresponding option
        $html .= '<option value="" selected disabled>---- Choose a Class ----</option>';
        foreach ($corresponding_option as $option) {
          $html .= '<option value="' . $option->id. '">' . $option->class_name . '</option>';
        }
        // Return the HTML
        echo $html;
  }
  if(isset($_POST['option1'])){
      $option1 = $_POST['option1'];
      $user=$USER->id;
      // Retrieve the corresponding option from a database or other data source
      $corresponding_option = $DB->get_records_sql("SELECT {division}.id,{division}.div_name FROM {division} 
      INNER JOIN {teacher_assign} ON  {teacher_assign}.t_division={division}.id where {teacher_assign}.t_class='$option1' AND {teacher_assign}.user_id=$user");
      // Generate the HTML for the corresponding option
      $html = '<option value="" selected disabled>---- Choose a division ----</option>';
      foreach ($corresponding_option as $option) {
        $html .= '<option value="' . $option->id. '">' . $option->div_name . '</option>';
      }
      // Return the HTML
      echo $html;
  }
?>

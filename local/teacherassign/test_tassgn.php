<?php
// Connect to the database
require(__DIR__.'/../../config.php');

require_login();
global $DB, $USER;
$teacher_id = $USER->id;
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

  if(isset($_POST['option2'])){
     $division = $_POST['option2']; 
    $rec1=$DB->get_records_sql("SELECT * FROM {student_assign}  WHERE s_division=$division"); 
    $html = '<option value="" selected disabled>---- Choose student name ----</option>';
    foreach ($rec1 as $records) {
      // $studentnames = explode(',', $records->user_id);

      // foreach ($studentnames as $studentid) {

          $student = $DB->get_record_sql("SELECT * FROM {student} WHERE user_id=$records->user_id");
          $id=$student->user_id;
          $html .= '<option value="' . $records->user_id. '">' . $student->s_ftname.$student->s_mlname.$student->s_lsname . '</option>';
        }
    // Return the HTML
    echo $html;
}


if(isset($_POST['option3'])){

  $id  =$_POST['option3'];
  $sassign = $DB->get_record_sql("SELECT * FROM {student_assign} WHERE user_id=$id");
  $div=$sassign->s_division	;


  $subjects = $DB->get_records_sql("SELECT {teacher_assign}.* FROM {teacher_assign} JOIN {student_assign} ON {student_assign}.s_division={teacher_assign}.t_division WHERE {teacher_assign}.user_id=$teacher_id AND {teacher_assign}.t_division=$div");
  $html = '<option value="" selected disabled>---- Choose student name ----</option>';
  foreach($subjects as $subject){
    $subjectt=$subject->t_subject;
    
    $subjectss = $DB->get_record_sql("SELECT * FROM {subject} WHERE course_id=$subjectt");

    // $options1[] = array('value' => $subjectss->course_id, 'label' => $subjectss->sub_name);
    $html .= '<option value="' . $subjectss->course_id. '">' . $subjectss->sub_name . '</option>';
        
    // print_r($subjectss);exit();
  }

 // Return the HTML
 echo $html;
}
?>

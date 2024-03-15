<?php
require(__DIR__.'/../../config.php');
global $DB,$CFG;
// require_login();
$var = '
<div class="table-responsive custom-table">
  <table class="table mb-0">
    <thead>
      <tr>
        <th scope="col">
          <div class="wrap-t">Question</div>
        </th>
        <th scope="col">
          <div class="wrap-t">Answer</div>
        </th>
        
      </tr>
    </thead>
    <tbody>';
if (isset($_POST['userid']) && isset($_POST['surveryid'])) {
    $userid = $_POST['userid'];
    $surveryid = $_POST['surveryid'];

    $s_question = ''; // Initialize $s_question outside the loop

    $surveydata = $DB->get_records_sql("SELECT * FROM {customsurvey_question} WHERE survey_id = ?", array($surveryid));
    $qust_ids = array();
    foreach ($surveydata as $surveydata1) {

        $qust_ids[] = $surveydata1->id;
        $s_question .= " " . $surveydata1->survey_question; // Concatenate the survey questions
        $qust_id_list = implode(",", $qust_ids);
        $sql_query = "SELECT * FROM {student_answers} WHERE user_id = ? AND q_id IN ($qust_id_list)";
        $answers = $DB->get_records_sql($sql_query, array($userid));
       foreach ($answers as $answer) {
    if ($answer->user_id != "" && !empty($answer)) {
        $a_id = $answer->a_id;
        $survey_answer = $DB->get_record_sql("SELECT * FROM {customsurvey_answer} WHERE id = ?", array($a_id));
        $survey_answer_value = $survey_answer->survey_answer;
    } else {
        $survey_answer_value = "Survey not submitted"; // Default message if no answer is found
    }
}
if($survey_answer_value==""){
    $survey_answer_value ="Survey not submitted";
}
        $var .= '
    
          <tr>
            <td><div class="wrap-t">' . $s_question . '</div></td> 
            <td><div class="wrap-t">' . $survey_answer_value . '</div></td> 
           
          </tr>
        ';
    $a_id="";
    $s_question = "";
    $survey_answer_value="";
    }
    
    // Output specific properties or elements of $surveydata and $userdata
    
    $var .= '
    </tbody>
  </table>
</div>


';
    
    // echo  $userid ."".$s_question."-".$survey_answer_value; // Output the HTML table
    echo    $var;


}
?>

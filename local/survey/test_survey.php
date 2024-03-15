<?php
require(__DIR__.'/../../config.php');
global $DB,$CFG;
require_login();
$view_reply=new moodle_url('/local/reply/reply.php?id');

if (isset($_POST['division'])) {
  $did = $_POST['division'];

  $models = $DB->get_records_sql("SELECT * FROM {student_assign} WHERE s_division='$did'");
 
  if (!empty($models)) {
      $var = '
      <div class="table-responsive custom-table">
        <table class="table mb-0">
          <thead>
            <tr>
              <th scope="col">
                <div class="wrap-t">Name</div>
              </th>
              <th scope="col">
                <div class="wrap-t">Question</div>
              </th>
              <th scope="col">
                <div class="wrap-t">Answers</div>
              </th>
            </tr>
          </thead>
          <tbody>';
          
          foreach ($models as $model) {
            $id = $model->id;
            $user_id = $model->user_id;    
            $userdata = $DB->get_record_sql("SELECT * FROM {student} WHERE user_id = $user_id");
        
            if ($userdata) {
                $name = $userdata->s_ftname;
        
                if (isset($_POST['survey'])) {
                    $sid = $_POST['survey'];
                } else {
                    $sid = '';
                }
        
                $surveydata = $DB->get_records_sql("SELECT * FROM {customsurvey_question} WHERE survey_id = $sid");
                foreach ($surveydata as $surveydata1) {
                    $qust_id = $surveydata1->id;
                    $s_question = $surveydata1->survey_question;
                }
        
                $answer = $DB->get_record_sql("SELECT * FROM {student_answers} WHERE user_id = $user_id AND q_id = $qust_id");

                if ($answer === null) {
                    $answer = "No answer found for user_id $user_id and question ID $qust_id";
                }
        
                $a_id = $answer->a_id;

                $answeremoji = $DB->get_record_sql("SELECT * FROM {customsurvey_answer} WHERE id = $a_id");               

                $ans = $answeremoji->survey_answer;

        
                $var .= '
                <tr>
                    <td><div class="wrap-t">' . $name . '</div></td>
                    <td><div class="wrap-t">' . $s_question . $ans . '</div></td>
                    <td>
                        <div class="wrap-t">
                            <a href="complaint_details.php?id=' . $id . '">
                                <button style="font-size: 14px; background-color: #5e4ec2; color: white; border: none; padding: 8px 16px; text-align: center; text-decoration: none; display: inline-block; cursor: pointer;">View</button>
                            </a>
                        </div>
                    </td>
                </tr>';
            }
        }
        
        $var .= '
          </tbody>
        </table>
      </div>';
  }

else {
        $var = '<p>No records found for the selected division.</p>';
    }
    
    echo $var;
}


?>
 <!-- 
 <td><div class="wrap-t">'.$complaint.'</div></td>  
 <td><div class="wrap-t"><a href="'.$view_reply.'='.$id.'" class="action-table" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                        <path
                          d="M11.013 1.427a1.75 1.75 0 0 1 2.474 0l1.086 1.086a1.75 1.75 0 0 1 0 2.474l-8.61 8.61c-.21.21-.47.364-.756.445l-3.251 .93a.75.75 0 0 1-.927-.928l.929-3.25c.081-.286.235-.547.445-.758l8.61-8.61Zm.176 4.823L9.75 4.81l-6.286 6.287a.253.253 0 0 0-.064.108l-.558 1.953 1.953-.558a.253.253 0 0 0 .108-.064Zm1.238-3.763a.25.25 0 0 0-.354 0L10.811 3.75l1.439 1.44 1.263-1.263a.25.25 0 0 0 0-.354Z">
                        </path>
                      </svg>Reply</a>

                    </div>
                </td> -->
                
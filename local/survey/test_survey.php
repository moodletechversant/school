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
                <div class="wrap-t">Question-Answer</div>
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
        
                // $surveydata = $DB->get_records_sql("SELECT * FROM {customsurvey_question} WHERE survey_id = $sid");
                $s_question="";
                $var .= '
                <tr>
                    <td><div class="wrap-t">' . $name . '</div></td>
                   
            <td><button onclick="viewname()" id='. $user_id.'_'. $sid.' class="view_answer" >View Answer</a></button></td>
            </tr>';
              //   foreach ($surveydata as $surveydata1) {
              //     $qust_id = $surveydata1->id;
              //     // $s_question = $surveydata1->survey_question;
                


              //     $s_question.=" ".$surveydata1->survey_question;
              //     $answer = $DB->get_record_sql("SELECT * FROM {student_answers} WHERE user_id = $user_id AND q_id = $qust_id");
              
              // $a_id = $answer->a_id;
                           
              
              // if($a_id=="")
              //{
               
                // }

//               else{
// $survey_answer = $DB->get_record_sql("SELECT * FROM {customsurvey_answer} WHERE id = $a_id");

//               $survey_answer_value = $survey_answer->survey_answer;
             

        
//                 $var .= '
//                 <tr>
//                     <td><div class="wrap-t">' . $name . '</div></td>
//                     <td><div class="wrap-t">' . ($s_question)  . ' - '.  $survey_answer_value. '</div></td>

//                 </tr>';
                
//               }

              
              // $s_question="";
              // $name="";
             

              // }
             
             
            }
        }
        
       
  }

else {
        $var = '<p>No records found for the selected division.</p>';
    }
    
    echo $var;
}
// print_r();exit();


?>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
      <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script>
     
      $(document).ready(function() {
  

        $(".view_answer").click(function(){
          id = $(this).attr("id").toString();
          idmain = id.split("_")
          userid = idmain[0];
          surveryid = idmain[1]
      //  alert(userid+" "+surveryid)
        
       $.ajax({
        type: "POST",
        url: "test_survey1.php", 
        data: {userid: userid, surveryid:surveryid },
        success: function(response){ 
        //  alert(response)
          
         $("#modaldata").html(response)
          

        $(".modal").css('display','block')
            
        }
        
      });
  })
  
})
  
  
      
                  
  </script>

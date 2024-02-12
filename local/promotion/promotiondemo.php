<?php 
require_once(__DIR__ . '/../../config.php');

global $class,$CFG, $DB;

$context = context_system::instance();
// $classid = $class->id;
$linktext = "attendance";

$linkurl = new moodle_url('/local/promotion/promotion.php');

$PAGE->set_context($context);
$strnewclass= get_string('studentview');

$PAGE->set_url('/local/promotion/promotion.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
// $PAGE->set_heading($SITE->fullname);
$teacher_id = $USER->id;

echo $OUTPUT->header();

    // Get the list of enrolled students
    // $context = context_course::instance($course->id);

    $recs=$DB->get_record_sql("SELECT * FROM {division} WHERE div_teacherid=$teacher_id");
   
    // $students = $DB->get_records_sql("SELECT * FROM {student}");
   
 
   
  if (!empty($recs))
  {
        $division=$recs->id;
        $students=$DB->get_records_sql("SELECT * FROM {student_assign} WHERE s_division=$division");
        $academic = $DB->get_records_sql("SELECT * FROM {academic_year}");
           // Display the Moodle form
    echo '<form method="POST">';
    ///////passed students//////////////////
      echo '<table align="center" border="0"><tr><th align="right" class="thh">passed students</th><th class="thh">failed students</th></tr><tr><td class="tdd" >';
              echo '<table align="center">';

                    ////////Academic Year sELECT////////////////////////
                    echo '<tr><th>Academic Year</th>
                          <th><select class="form-control" id="academic-year" name="academic-year" required style="width: 200px; height: 30px;">';
                          echo '<option value="select academic Year" name="select academic Year" selected>select academic Year</option>';
                    foreach($academic as $academic){
                      
                        echo '<option value="' . $academic->start_year . '">' . $academic->start_year . '</option>';
                    }

                    echo '</select></th></tr>
                    ';
                    /////////////////////////////////////////////////////

                      ////////cLASS sELECT////////
                      $classes  = $DB->get_records('class');
                      echo '
                          <tr><th>Class</th>
                              <th><select class="form-control" id="class" name="class" required style="width: 200px; height: 30px;">';
                              // echo '<option value="select academic class" selected>';
                              foreach($classes as $class){
                                  // echo '<option value="' . $class->id . '">' . $class->class_name . '</option>';
                              }
                      echo '</select></th></tr>';
                      //////////////////////////////////////////////////////

                      ////////Division sELECT////////
                      $divisions  = $DB->get_records('division');

                      echo '

                      <tr><th>Division</th>
                              <th><select class="form-control" id="division" name="division" required style="width: 200px; height: 30px;">';
                              // echo '<option value="select academic division" selected>';
                      foreach($divisions as $division){
                          // echo '<option value="' . $division->id . '">' . $division->div_name . '</option>';
                      }
                      echo '</select></th></tr>';
                      ///////////////////////////////////////////////
              echo '</table>';
              echo '</td><td class="tdd">';
///////////////////////////////FAILED STUDENTS/////////////////////////////////////////////////////
                // $students = $DB->get_records_sql("SELECT * FROM {student}");
                $academic = $DB->get_records_sql("SELECT * FROM {academic_year}");
                echo '<table align="center">';

                        ////////Academic Year sELECT/////////////////////////////////
                        echo '<tr><th>Academic Year</th>
                              <th><select class="form-control" id="academic-year1" name="academic-year1" style="width: 200px; height: 30px;">';
                              echo '<option value="select academic Year" name="select academic Year" selected>select academic Year</option>';
                        foreach($academic as $academic){
                          
                            echo '<option value="' . $academic->start_year . '">' . $academic->start_year . '</option>';
                        }

                        echo '</select></th></tr>
                        ';
                        //////////////////////////////////////////////////////////////

                        ////////cLASS sELECT////////
                        $classes  = $DB->get_records('class');
                        echo '
                            <tr><th>Class</th>
                                <th><select class="form-control" id="class1" name="class1"  style="width: 200px; height: 30px;">';
                                // echo '<option value="select academic class" selected>';
                                foreach($classes as $class){
                                    // echo '<option value="' . $class->id . '">' . $class->class_name . '</option>';
                                }
                        echo '</select></th></tr>';
                        ///////////////////////////////////////////////////////////////

                        ////////Division sELECT////////
                        $divisions  = $DB->get_records('division');

                        echo '

                        <tr><th>Division</th>
                                <th><select class="form-control" id="division1" name="division1"  style="width: 200px; height: 30px;">';
                                // echo '<option value="select academic division" selected>';
                        foreach($divisions as $division){
                            // echo '<option value="' . $division->id . '">' . $division->div_name . '</option>';
                        }
                        echo '</select></th></tr>';
                        ///////////////////////////////////////////////
              echo '</table></td></tr>';
        echo '</table>';

        //////////////////////////////////////////////////////////
        echo '<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>';
          
        echo '<script>
          $(document).ready(function(){
            $("#academic-year").change(function(){
              var option = $(this).val();
              $.ajax({
                type: "POST",
                url: "test1.php",
                data: {option: option},
                success: function(response){
                  $("#class").html(response);
                }
              });
            });
          });
          </script>
          ';



        echo '<script>
          $(document).ready(function(){
            $("#class").change(function(){
              var option = $(this).val();
              $.ajax({
                type: "POST",
                url: "test.php",
                data: {option: option},
                success: function(response){
                  $("#division").html(response);
                }
              });
            });
          });
          </script>
          ';

          ///////////////////////failed students////////
          echo '<script>
          $(document).ready(function(){
            $("#academic-year1").change(function(){
              var option = $(this).val();
              $.ajax({
                type: "POST",
                url: "test1.php",
                data: {option: option},
                success: function(response){
                  $("#class1").html(response);
                }
              });
            });
          });
          </script>
          ';



        echo '<script>
          $(document).ready(function(){
            $("#class1").change(function(){
              var option = $(this).val();
              $.ajax({
                type: "POST",
                url: "test.php",
                data: {option: option},
                success: function(response){
                  $("#division1").html(response);
                }
              });
            });
          });
          </script>
          ';

        echo '</div>';

        echo '<style>
        .hello{
          
          color: #f8f6fe;
            background: #2f204b;
            
        }
        .hello1{
        
          background: #d9caf3;
        
        }
        </style>';
        // Display the list of students with attendance checkboxes
      
        echo '<br><table class="table" style="width:70%;" align="center">';
        echo '<thead><tr><th class="hello" >Student Name</th><th class="hello">Pass</th><th class="hello">Fail</th></tr></thead>';
        echo '<tbody>';
        foreach ($students as $student) {
          $studentnames = explode(',', $student->user_id);

          foreach ($studentnames as $studentid) {

            $student = $DB->get_record_sql("SELECT * FROM {student} WHERE user_id=$studentid");
            echo '<tr>';
            echo '<td class="hello1">' .$student->s_ftname." ".$student->s_mlname." ".$student->s_lsname. '</td>';
            echo '<td class="hello1"><div class="form-check">';
            echo '<input class="form-check-input" type="radio" name="attendance[' . $student->user_id . ']" value="pass" checked>';
            echo '<label class="form-check-label">pass</label>';

            echo '</div></td><td class="hello1"><div class="form-check">';
            echo '<input class="form-check-input" type="radio" name="attendance[' . $student->user_id . ']" value="fail">';
            echo '<label class="form-check-label">fail</label>';
            echo '</div></td>';
            echo '</tr>';
          }
        }
       echo '</tbody>
        <tr><td colspan="3"> <button type="submit" class="btn btn-primary" name="submit">Submit</button></td></tr></table>';
   
    echo '</form>';
  }
  else{
            // Display the Moodle form
              echo '<table align="center" border="0">
                      <tr><th align="right" class="thh">Information</th>
          
                      <tr><td class="tdd" >you are not assigned to the class incharge of any class ...you cant do promotion of any student</td></tr>';
}
 

// Check if the form has been submitted
if (isset($_POST['submit'])) {
  // Get the attendance data from the form
  // $date = $_POST['date'];
  // $attendance = $_POST['attendance'];
  $academic = $_POST['academic-year'];
  $class = $_POST['class'];
  $division = $_POST['division'];
  $attendance = $_POST['attendance'];
  ////////////////////FAILED STUDENTS///////////////////////////////
  $academic1 = $_POST['academic-year1'];
  $class1 = $_POST['class1'];
  $division1 = $_POST['division1'];
  // $attendance = $_POST['attendance'];


  // Loop through the attendance data and update the database
  foreach ($attendance as $student_id => $status) {

    if($status == 'pass')
    {
        
      $record = new stdClass();
      $record->status = $status;
      $record->s_class = $class;
      $record->s_division = $division;
      $record->user_id=$student_id;
  // print_r( $record->status );
  // exit();
      $DB->insert_record('student_assign', $record, false);
    }
    elseif ($status == 'fail') {
      $record = new stdClass();
      $record->status = $status;
      $record->s_class = $class1;
      $record->s_division = $division1;
      $record->user_id=$student_id;
  // print_r( $record->status );
  // exit();
      $DB->insert_record('student_assign', $record, false);
    }


  }

  $urlto = $CFG->wwwroot.'/local/promotion/promotion.php';
  redirect($urlto, 'Data Saved Successfully '); 
}

    echo $OUTPUT->footer();



?>

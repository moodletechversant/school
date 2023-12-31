<?php 
require_once(__DIR__ . '/../../config.php');

global $class,$CFG, $DB;

$context = context_system::instance();
// $classid = $class->id;
$linktext = "admin_view";

$linkurl = new moodle_url('/local/new_timetable/admin_view.php');

$PAGE->set_context($context);
$strnewclass= get_string('studentview');

$PAGE->set_url('/local/new_timetable/admin_view.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
// $PAGE->set_heading($SITE->fullname);

echo $OUTPUT->header();
$students = $DB->get_records_sql("SELECT * FROM {student}");
$academic = $DB->get_records_sql("SELECT * FROM {academic_year}");
echo '<form method="POST">';
///////passed students//////////////////
  echo '<table align="center" border="0"><tr><td class="tdd" >';
          echo '<table align="center">';

          ////////Academic Year sELECT/////////////////////////////////
          echo '<tr><th>Academic Year</th>
                <th><select class="form-control" id="academic-year" name="academic-year" required style="width: 200px; height: 30px;">';
                echo '<option value ="select academic Year" name="select academic Year" selected>select academic Year</option>';
          foreach($academic as $academic){
            
              echo '<option value ="' . $academic->start_year . '">' . $academic->start_year . '</option>';
          }

          echo '</select></th></tr>
          ';
          //////////////////////////////////////////////////////////////

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
          ///////////////////////////////////////////////////////////////

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
          echo '</table> </form>
          <br>
          <div id="searchresult"></div>';

          echo '<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>';
      
          echo '<script>
            $(document).ready(function(){
              $("#academic-year").change(function(){
                var option = $(this).val();
                $.ajax({
                  type: "POST",
                  url: "test4.php",
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
                  url: "test3.php",
                  data: {option: option},
                  success: function(response){
                    $("#division").html(response);
                  }
                });
              });
            });
            </script>
            ';


            echo '<script>
            $(document).ready(function(){
              $("#division").change(function(){
                var option = $(this).val();
                $.ajax({
                  type: "POST",
                  url: "adminajax.php",
                  data: {option: option},
                  success: function(response){
                    $("#searchresult").html(response);
                    $("#searchresult").css("display", "block");
                  }
                });
              });
            });
            </script>
            ';
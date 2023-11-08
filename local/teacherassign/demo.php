<?php 
require_once(__DIR__ . '/../../config.php');

global $class,$CFG, $DB;
$context = context_system::instance();
$linktext = "attendance";
$linkurl = new moodle_url('/local/teacherassign/teacherlearningpath.php');
$PAGE->set_context($context);
$strnewclass= get_string('studentview');
$PAGE->set_url('/local/teacherassign/teacherlearningpath.php');
$PAGE->set_title($strnewclass);

$teacher_id = $USER->id;
echo $OUTPUT->header();
$subjects = $DB->get_records_sql("SELECT mdl_teacher_assign.* FROM mdl_teacher_assign JOIN mdl_student_assign ON mdl_student_assign.s_division=mdl_teacher_assign.t_division WHERE mdl_teacher_assign.user_id=$teacher_id");

echo '<form method="POST">';
///////passed students//////////////////
  echo '<table align="center" border="0"><tr><td class="tdd" >';
        //   echo '<table align="center">';

          ////////Academic Year sELECT/////////////////////////////////
          echo '<tr>
                <th><select class="form-control" id="academic-year" name="academic-year" required style="width: 200px; height: 30px;">';
                echo '<option value ="select academic Year" name="" selected>select academic Year</option>';
          foreach($subjects as $subject){
            $subjectt=$subject->t_subject;

            $subjectss = $DB->get_record_sql("SELECT * FROM mdl_subject WHERE id=$subjectt");
              echo '<option value ="' . $subjectss->id . '">' . $subjectss->sub_name . '</option>';
          }

          echo '</select></th></tr>
          ';
          //////////////////////////////////////////////////////////////

          echo '</select></th></tr>';
          ///////////////////////////////////////////////
          echo '</table> </form>';

?>
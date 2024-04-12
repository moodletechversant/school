<?php
// include('demo.html');
require_once(__DIR__ . '/../../config.php');
// require_once(__DIR__ . '/../../lib/mustache/src/Mustache/Autoloader.php');


require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/survey/templates/survey_adminview.mustache');
$delete = new moodle_url('/local/survey/deletesurvey.php?id');
$answer = new moodle_url('/local/survey/viewsurveyanswer.php?id');
$create_survey = new moodle_url('/local/survey/survey.php?id');
$edit_survey = new moodle_url('local/survey/editsurvey.php?id');
global $class,$CFG;
$context = context_system::instance();
require_login();
$linktext = "Survey";

$linkurl = new moodle_url('/local/survey/survey_adminview.php');


$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_title($linktext);

echo $OUTPUT->header();
$data = array();
// $rec1 = $DB->get_records_sql("SELECT * FROM {customsurvey} ORDER BY id DESC");
$current_year = date("Y");
$current_month = date("m");
$current_date = date("d");
// print_r($current_month);exit();
$school_id  = optional_param('id', 0, PARAM_INT);
$rec1 = $DB->get_records_sql("
SELECT cs.*, ay.start_year, ay.end_year
FROM {customsurvey} AS cs
INNER JOIN {academic_year} AS ay ON cs.academic_id = ay.id
WHERE (YEAR(FROM_UNIXTIME(ay.start_year)) = $current_year AND MONTH(FROM_UNIXTIME(ay.start_year))<=$current_month AND DAY(FROM_UNIXTIME(ay.start_year))<=$current_date)
OR (YEAR(FROM_UNIXTIME(ay.end_year)) = $current_year AND MONTH(FROM_UNIXTIME(ay.end_year)) >= $current_month AND DAY(FROM_UNIXTIME(ay.end_year)) >= $current_date)
");
// print_r($rec1);exit();

$options1 = array();
$academic_id = $DB->get_records_sql("SELECT * FROM {academic_year} WHERE school=$school_id");
    foreach ($academic_id as $academic) {
        $timestart = $academic->start_year;
        $timeend = $academic->end_year;
        
        $timestart1 = date("d/m/Y", $timestart);
        $timeend1 = date("d/m/Y", $timeend);
        
        $options1[] = array('value' => $academic->id, 'label' => $timestart1 . '-' . $timeend1);
    }
    $templateData = array('startYearOptions' => $options1);
    $mustache = new Mustache_Engine();

$current_time =time();
$current_date=date('d-m-Y');
// print_r($current_time);exit();
if (!empty($rec1)) {
  // $hassurvey = false; // Flag to check if any survey exist

      foreach ($rec1 as $record1) {
        $id = $record1->id;
        $surname = $record1->survey_name;

        $surveyfrom = $record1->survey_from;
        $from = date("d-m-Y", $surveyfrom);
        // $surveyfrom = strtotime($from);

        $surveyto = $record1->survey_to;
        $to = date("d-m-Y", $surveyto);
        // $surveyto = strtotime($to);

        if ($current_date>=$from && $current_date<=$to) {
            $surveyfromFormatted = $from;
            $surveytoFormatted = $to;

            // $surveyfromFormatted = date("d-m-Y", $surveyfrom);
            // $surveytoFormatted = date("d-m-Y", $surveyto);

            $rec2 = $DB->get_records_sql("SELECT * FROM {customsurvey_question} WHERE survey_id = $id");
            $survey_questions = array();

            foreach ($rec2 as $record2) {
                $id2 = $record2->id;
                $surveyid = $record2->survey_id;
                $surquestion = $record2->survey_question;

                $survey_questions[] = array('id2' => $id2, 'survey_id' => $surveyid, 'survey_question' => $surquestion);
            }
            $disabled = true;
            $data[] = array('id' => $id, 'surname' => $surname, 'survey_from' => $surveyfromFormatted, 'survey_to' => $surveytoFormatted, 'q_survey' => $survey_questions, 'disabled2' =>  $disabled);
          }
            elseif($current_time>$surveyto) {
              $surveyfromFormatted = date("d-m-Y", $surveyfrom);
              $surveytoFormatted = date("d-m-Y", $surveyto);
        
              $rec2 = $DB->get_records_sql("SELECT * FROM {customsurvey_question} WHERE survey_id = $id");
              $survey_questions = array();
        
              foreach ($rec2 as $record2) {
                  $id2 = $record2->id;
                  $surveyid = $record2->survey_id;
                  $surquestion = $record2->survey_question;
        
                  $survey_questions[] = array('id2' => $id2, 'survey_id' => $surveyid, 'survey_question' => $surquestion);
              }
              $disabled = true;
              $data[] = array('id' => $id, 'surname' => $surname, 'survey_from' => $surveyfromFormatted, 'survey_to' => $surveytoFormatted, 'q_survey' => $survey_questions, 'disabled' =>  $disabled);
          }

        elseif($current_time<$surveyfrom ) {
            $surveyfromFormatted = date("d-m-Y", $surveyfrom);
            $surveytoFormatted = date("d-m-Y", $surveyto);

            $rec2 = $DB->get_records_sql("SELECT * FROM {customsurvey_question} WHERE survey_id = $id");
            $survey_questions = array();

            foreach ($rec2 as $record2) {
                $id2 = $record2->id;
                $surveyid = $record2->survey_id;
                $surquestion = $record2->survey_question;

                $survey_questions[] = array('id2' => $id2, 'survey_id' => $surveyid, 'survey_question' => $surquestion);
            }
            $disabled = true;
            $data[] = array('id' => $id, 'surname' => $surname, 'survey_from' => $surveyfromFormatted, 'survey_to' => $surveytoFormatted, 'q_survey' => $survey_questions, 'disabled1' =>  $disabled);
        }
      }
}

$surveyname = array('school_id'=>$school_id,'survey' => $data,'delete' => $delete,'answer' =>$answer,'templateData' => $templateData,'create_survey'=>$create_survey,'edit_survey'=>$edit_survey);
echo $mustache->render($template, $surveyname);

        // print_r($data2);exit();

  ?>

  <?php
    echo $OUTPUT->footer();
    ?>

<!-- <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <link rel="stylesheet" href="css/style.css">
   -->
<style>
   
    </style>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
   <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" ></script>
  
   <script>
  

    const myIcons = document.querySelectorAll('.arrow');
    const myParagraphs = document.querySelectorAll('.hide');

    myIcons.forEach((icon, index) => {
      icon.addEventListener('click', () => {
        if (myParagraphs[index].style.display === 'block') {
          myParagraphs[index].style.display = 'none';
          icon.classList.remove('fa-angle-up');
        } else {
          myParagraphs[index].style.display = 'block';
          icon.classList.add('fa-angle-up');
        }
      });
    });

    </script>

<?php
// include('demo.html');
require_once(__DIR__ . '/../../config.php');
// require_once(__DIR__ . '/../../lib/mustache/src/Mustache/Autoloader.php');


require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/survey/templates/survey_adminview.mustache');
$delete = new moodle_url('/local/survey/deletesurvey.php?id');

// require_once($CFG->dirroot.'/local/createstudent/demo.html');
global $class,$CFG;
$context = context_system::instance();
require_login();
// $classid = $class->id;
$linktext = "Survey";

$linkurl = new moodle_url('/local/survey/survey_adminview.php');

$PAGE->set_context($context);
$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
//$PAGE->set_heading($linktext);
// $PAGE->set_heading($SITE->fullname);
// $PAGE->requires->html('/demo.html');
// $addstudent='<button style="background:transparent;border:none;"><a href="/school/local/createstudent/createstudent.php" style="text-decoration:none;"><font size="50px";color="#0f6cbf";>+</font></a></button>';

echo $OUTPUT->header();
$data = array();
$rec1 = $DB->get_records_sql("SELECT * FROM {customsurvey} ORDER BY id DESC");

$mustache = new Mustache_Engine();

$current_time =time();
$current_date=date('d-m-Y');
// print_r($current_time);exit();

foreach ($rec1 as $record1) {
  $id = $record1->id;
  $surname = $record1->survey_name;

  $surveyfrom = $record1->survey_from;
  $from = date("d-m-Y", $surveyfrom);
  // $surveyfrom = strtotime($from);

  $surveyto = $record1->survey_to;
  $to = date("d-m-Y", $surveyto);
  // $surveyto = strtotime($to);

  if ($current_date >=$from && $current_date<= $to) {
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
      elseif($current_time >$surveyto) {
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

  elseif($current_time < $surveyfrom ) {
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

$surveyname = array('survey' => $data,'delete' => $delete);
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

<?php
// include('demo.html');
require_once(__DIR__ . '/../../config.php');
// require_once(__DIR__ . '/../../lib/mustache/src/Mustache/Autoloader.php');


require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/survey/templates/survey_studentview.mustache');

// require_once($CFG->dirroot.'/local/createstudent/demo.html');
global $class,$CFG;
$context = context_system::instance();
require_login();
// $classid = $class->id;
$linktext = "Survey";

$linkurl = new moodle_url('/local/survey/survey_studentview.php');

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
$rec1 = $DB->get_records_sql("SELECT * FROM {customsurvey}");

$mustache = new Mustache_Engine();
$current_time = time();

$imagePaths = $DB->get_records_sql("SELECT * FROM {customsurvey_answer}");

$dataa['imagePaths'] = array();

foreach ($imagePaths as $imagePath) {
    $imo_path = new moodle_url($imagePath->imo_path);

    $dataa['imagePaths'][] = array('src' => $imo_path,'id'=>$imagePath->id,'answer'=>$imagePath->survey_answer);
}
// print_r($dataa);exit();
foreach ($rec1 as $record1) {
    $id = $record1->id;
    $surname = $record1->survey_name;

    $surveyfrom = $record1->survey_from;
    $from = date("d-m-Y", $surveyfrom);
    $surveyfrom = strtotime($from);
  
    $surveyto = $record1->survey_to;
    $to = date("d-m-Y", $surveyto);
    $surveyto = strtotime($to);
  
    if ($current_time >= $surveyfrom && $current_time <= $surveyto) {
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

    $data[] = array('id' => $id, 'surname' => $surname, 'q_survey' => $survey_questions, 'ans' => $dataa);
}
}

$surveyname = array('survey' => $data);
// print_r($surveyname);exit();
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

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
    

    </script>


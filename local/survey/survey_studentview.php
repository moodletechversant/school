<?php
// include('demo.html');
require_once(__DIR__ . '/../../config.php');
// require_once(__DIR__ . '/../../lib/mustache/src/Mustache/Autoloader.php');


require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/survey/templates/survey_studentview.mustache');
// require_once($CFG->dirroot.'/local/createstudent/demo.html');
global $class,$CFG,$USER;
$context = context_system::instance();
require_login();
// $classid = $class->id;
$linktext = "Survey";
$linkurl = new moodle_url('/local/survey/survey_studentview.php');
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
echo $OUTPUT->header();
$data = array();
$rec1 = $DB->get_records_sql("SELECT * FROM {customsurvey}");


$customsurvey_question = $DB->get_records_sql("SELECT sa.* FROM {student_answers} sa JOIN {customsurvey_question} cq ON cq.id=sa.q_id
JOIN {customsurvey} cs ON cs.id=cq.survey_id WHERE sa.user_id=$USER->id");

// print_r($customsurvey_question);exit();

$mustache = new Mustache_Engine();
$current_time = time();
$current_date=date('d-m-Y');

$imagePaths = $DB->get_records_sql("SELECT * FROM {customsurvey_answer}");

$dataa['imagePaths'] = array();
if(empty($rec1 )){
    echo "no new survey available";

}
else{

    foreach ($imagePaths as $imagePath) {
        $imo_path = new moodle_url($imagePath->imo_path);
        $dataa['imagePaths'][] = array('src' => $imo_path,'id'=>$imagePath->id,'answer'=>$imagePath->survey_answer);
    }
    foreach ($rec1 as $record1) {
        $id = $record1->id;
        $surname = $record1->survey_name;
        $surveyfrom = $record1->survey_from;
        $from = date("d-m-Y", $surveyfrom);
        $surveyfrom = strtotime($from);
        $surveyto = $record1->survey_to;
        $to = date("d-m-Y", $surveyto);
        $surveyto = strtotime($to);
        if ($current_date >= $from && $current_date <= $to) {
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
    echo $mustache->render($template, $surveyname);
}

  ?>

  <?php
    echo $OUTPUT->footer();
    ?>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>



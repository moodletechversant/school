<?php

require(__DIR__.'/../../config.php');

require_once($CFG->dirroot.'/local/survey/editsurvey_form.php');
require_once($CFG->dirroot.'/lang/en/moodle.php');

global $USER;

$context = context_system::instance();
require_login();


// Correct the navbar .
// Set the name for the page.
$linktext = "Survey";
//$linktext = get_string('plugin','new_plugin');
// Set the url.
$linkurl = new moodle_url('/local/survey/editsurvey.php');


// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
//$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
$PAGE->set_heading($linktext);
$PAGE->navbar->add('Survey', new moodle_url($CFG->wwwroot.'/local/survey/editsurvey.php'));

echo $OUTPUT->header();
$mform = new editsurvey_form();
if($mform->is_cancelled()){
    $cancelurl = $CFG->wwwroot.'/local/survey/survey_adminview.php';
    redirect($cancelurl);
}
else if ($formdata = $mform->get_data()) {
    // echo "Academic Year: " . $formdata->academicyear;

    $surveydata = new stdClass();
    $surveydata->id = $formdata->id;
    $surveydata->survey_name = $formdata->surname;
    $surveydata->survey_from = $formdata->surveyfrom;
    $surveydata->survey_to = $formdata->surveyto;
   $surveydata->academic_id = $formdata->academicyear;
    $surveyid = $DB->update_record('customsurvey', $surveydata);
    // print_r($surveydata);exit();

    // Retrieve existing survey questions
    $editdata = $DB->get_records_sql("SELECT * FROM {customsurvey_question} WHERE survey_id = ?", array($formdata->id));

    // Update questions
    foreach ($editdata as $index => $question) {
        $field_name = 'question1' . ($index + 1);
        $questiondata = new stdClass();
        $questiondata->id = $question->id;
        $questiondata->survey_question = $formdata->{$field_name};
        $DB->update_record('customsurvey_question', $questiondata);
    }

    $newQuestions = $formdata->question; //
    foreach ($newQuestions as $newQuestion) {
        if (!empty($newQuestion)) {
        $questiondata = new stdClass();
        $questiondata->survey_id = $formdata->id;
        $questiondata->survey_question = $newQuestion;
        // print_r($questiondata);exit();
        $DB->insert_record('customsurvey_question', $questiondata);
        }
    }
    $urlto = $CFG->wwwroot . '/local/survey/survey_adminview.php?id='.$formdata->school_id;
    redirect($urlto, 'Data Saved Successfully');
}
$mform->display();
echo $OUTPUT->footer();
?>
<style>
   
   .delete-icon {
        color: #1d2125; /* Replace 'red' with the desired color value */
    }
    </style>
<script>
    
    let counter = 2;

function showAlert() {
    const questionName = 'Question ' + counter;

    const questionHTML = `
        <div id="div_label_${counter}" class="demo col-md-3 col-form-label d-flex pb-0 pr-md-0">
            <div class="form-label-addon d-flex align-items-center align-self-start"></div>
        </div>
        <div id="div_text_${counter}" class="demo col-md-9 form-inline align-items-start felement" data-fieldtype="text" id="yui_3_17_2_1_1688446578057_166" style="margin-bottom: 20px;">
            <input type="text" class="form-control" name="question[]" id="id_question_${counter}" placeholder="Enter your question" value="" data-initial-value="" style="width: 50%;">
            <div class="form-control-feedback invalid-feedback" id="id_error_question_${counter}"></div>
            <i class="icon fa fa-trash fa-fw pt-2 pl-3" id="delete_icon_${counter}" title="delete this question" role="img" aria-label="Calendar" onclick="hideQuestion('div_label_${counter}', 'div_text_${counter}'); resetBreak();"></i>
        </div>
    `;

    $("#fitem_id_question").append(questionHTML);
    counter++;
}

function hideQuestion(questionId, deleteIconId) {
    const questionDiv = document.getElementById(questionId);
    const deleteIconDiv = document.getElementById(deleteIconId);

    questionDiv.remove();
    deleteIconDiv.remove();
}




</script>
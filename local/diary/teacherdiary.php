
<?php

require(__DIR__.'/../../config.php');

require_once($CFG->dirroot.'/local/diary/teacherdiary_form.php');

require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/diary/templates/diary.mustache');

global $USER;

$context = context_system::instance();
require_login();


// Correct the navbar .
// Set the name for the page.
$linktext = "Teacher diary";
//$linktext = get_string('plugin','new_plugin');
// Set the url.
$linkurl = new moodle_url('/local/diary/teacherdiary.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
//$PAGE->set_heading($linktext);
$PAGE->navbar->add('Teacher diary', new moodle_url($CFG->wwwroot.'/local/diary/teacherdiary.php'));

echo $OUTPUT->header();
$mustache = new Mustache_Engine();

$mform = new teacherdiary_form();

$current_user_id = $USER->id;
$current_username = $USER->username;
$current_time = date('Y-m-d H:i:s');

if ($mform->is_cancelled()) {
    $cancelurl = $CFG->wwwroot.'/my';
    redirect($cancelurl);
} elseif ($formdata = $mform->get_data()) {
    //print_r($formdata);exit();
    $diarydata = new stdClass();
    $diarydata->d_student_id = implode(',', $formdata->student);
    //$diarydata->d_student_id = $formdata->student;
    $diarydata->d_subject = $formdata->subject;
    $diarydata->d_content = $formdata->content;
    $diarydata->d_starttime = $formdata->sdate;
    $diarydata->d_endtime = $formdata->edate;
    $diarydata->d_option = $formdata->option;

    if (!empty($formdata->suboption_text)) {
        $diarydata->d_suboption = $formdata->suboption_text;
    } elseif (!empty($formdata->suboption)) {
        $diarydata->d_suboption = $formdata->suboption;
    } else {
        $diarydata->d_suboption = null;
    }
    
    $diarydata->user_id =$current_user_id;
    $diarydata->d_username = $current_username;


    if ($formdata->student[0] == '0') {
        $diarydata->d_student_id = 'all';
        //$recs = $DB->get_records('student');
        //$diarydata->d_studentname = implode(',', array_column($recs, 's_ftname'));
        $diarydata->d_studentname = 'All students';
    } else {
        $diarydata->d_student_id = implode(',', $formdata->student);
        $student_ids = implode(',', $formdata->student);
        $sql = "SELECT s_ftname FROM {student} WHERE user_id IN ($student_ids)";
        $recs = $DB->get_records_sql($sql);
        //print_r($recs);exit();
        foreach ($recs as $rec) {
            $diarydata->d_studentname .= $rec->s_ftname . ',';
        }
    }
    
     //print_r($diarydata);exit();
    $DB->insert_record('diary', $diarydata);
    $urlto = $CFG->wwwroot.'/local/diary/teacherdiary.php';
    redirect($urlto, 'Data Saved Successfully');
    
}
echo $mustache->render($template);
$mform->display();
//echo '<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>';
echo $OUTPUT->footer();

?>
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script>

function showSubDropdown(selectElement) {
            var subselectElement = document.getElementById('subselect');
            var textInputElement = document.getElementById('id_suboption_text');

            if (selectElement.value == 'others') {
                subselectElement.style.display = 'none';
                textInputElement.style.display = 'block';
            } else if (selectElement.value == 'academics') {
                subselectElement.removeAttribute('disabled');
                subselectElement.style.display = 'inline-block';
                textInputElement.style.display = 'none';
            } else {
                subselectElement.setAttribute('disabled', 'disabled');
                subselectElement.style.display = 'inline-block';
                textInputElement.style.display = 'none';
            }
        }

        function updateTextBox(radio)

 {
    var selectedOption = radio.value;
    var id = radio.name.replace('yesno_', '');
    var textbox = $('#id_text_' + id);
    $.ajax({
        type: "POST",
        url: "timetable.php",
        data: { option: selectedOption },
        success: function(result) {
            textbox.val(result);
        },
        error: function() {
            alert("Error");
        }
    });
}



</script>



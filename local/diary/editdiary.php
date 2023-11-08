<?php

require(__DIR__.'/../../config.php');

require_once($CFG->dirroot.'/local/diary/editdiary_form.php');

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
$linkurl = new moodle_url('/local/diary/editdiary.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
//$PAGE->set_heading($linktext);
$PAGE->navbar->add('Teacher diary', new moodle_url($CFG->wwwroot.'/local/diary/editdiary.php'));

echo $OUTPUT->header();
$mustache = new Mustache_Engine();

$mform = new editdiary_form();

if ($mform->is_cancelled()) {
    $cancelurl = $CFG->wwwroot.'/my';
    redirect($cancelurl);
} elseif ($formdata = $mform->get_data()) {
    $diarydata = new stdClass();
    $diarydata->id  = $formdata->id;
    $diarydata->d_subject = $formdata->subject;
    $diarydata->d_content = $formdata->content;
    $diarydata->d_option = $formdata->option;

    if (!empty($formdata->suboption_text)) {
        $diarydata->d_suboption = $formdata->suboption_text;
    } elseif (!empty($formdata->suboption)) {
        $diarydata->d_suboption = $formdata->suboption;
    } else {
        $diarydata->d_suboption = null;
    }
//print_r($diarydata);exit();
    $DB->update_record('diary', $diarydata);
    $urlto = $CFG->wwwroot.'/local/diary/view_diary.php';
    redirect($urlto, 'Data Saved Successfully');
    
}
echo $mustache->render($template);
$mform->display();
//echo '<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>';
echo $OUTPUT->footer();

?>

<script type='text/javascript'>

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

</script>




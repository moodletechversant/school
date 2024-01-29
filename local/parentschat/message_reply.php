<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/formslib.php');

class messagereply_form extends moodleform {

    public function definition() {
        $mform = $this->_form;

        // Add your form elements here
        //$mform->addElement('header', 'header', 'CHAT');

        // Example: Add a text input field
        $mform->addElement('text', 'yourmessage', 'Your Message');
        $mform->setType('yourmessage', PARAM_TEXT);
        $mform->addElement('text', 'reply', 'reply');
        $mform->setType('reply', PARAM_TEXT);

      
    }
}

$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/local/parentschat/message_reply.php'));
$PAGE->set_title("Parent's Chat View");

echo $OUTPUT->header();

$userid = $USER->id;

$pid1 = $DB->get_record_sql("SELECT user_id FROM {parent} WHERE user_id = ?", array($userid));

if ($pid1->user_id == $userid) {
    $data = $DB->get_records_sql("SELECT * FROM {parentschat} WHERE pid = ?", array($pid1->user_id));

    foreach ($data as $value) {
        $add = $CFG->wwwroot . '/local/reply/view_reply.php?id=' . $value->id;
        $tid1 = $value->tid;

        // Create an instance of messagereply_form for each record
        $form = new messagereply_form();

        // Set the form data
        $form->set_data(['yourmessage' => $value->message]);

        // Display the form
        $form->display();

       
    }
}

echo $OUTPUT->footer();
?>

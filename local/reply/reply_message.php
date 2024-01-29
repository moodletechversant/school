<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/formslib.php');

class messagereply_form extends moodleform {

    public function definition() {
        $mform = $this->_form;

        // Add your form elements here
      //  $mform->addElement('header', 'header', 'Your Form Header');

        // Example: Add a text input field
        $mform->addElement('text', 'pmessage', 'parent message');
        $mform->setType('pmessage', PARAM_TEXT);
        $mform->addElement('text', 'treply', 'Your reply');
        $mform->setType('treply', PARAM_TEXT);
       
        $this->add_action_buttons();
    }
}

$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/local/parentschat/message_reply.php'));
$PAGE->set_title("Teacher's Chat View");

echo $OUTPUT->header();

$userid = $USER->id;


$data = $DB->get_records_sql("SELECT * FROM {parentschat} WHERE tid = ?", array($userid));

   

    foreach ($data as $value) {
        
        // Create an instance of messagereply_form for each record
        $form = new messagereply_form();

        // Set the form data
        $form->set_data(['pmessage' => $value->message]);

        // Display the form
        $form->display();

        
    }


echo $OUTPUT->footer();
?>






<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/formslib.php');

class messagereply_form extends moodleform {

    public function definition() {
        $mform = $this->_form;

        // Add your form elements here
        $mform->addElement('text', 'pmessage', 'Parent Message');
        $mform->setType('pmessage', PARAM_TEXT);
        $mform->addElement('text', 'treply', 'Your Reply');
        $mform->setType('treply', PARAM_TEXT);

        $this->add_action_buttons();
    }

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        // Add your custom validation logic here

        return $errors;
    }
}

$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/local/parentschat/message_reply.php'));
$PAGE->set_title("Teacher's Chat View");

echo $OUTPUT->header();

$userid = $USER->id;

// Check if the form is submitted
if ($data = $form->get_data()) {
    // Perform database insertion here
    $record = new stdClass();
    $record->pmessage = $data->pmessage;
    $record->treply = $data->treply;
    $record->timestamp = time();
    $record->tid = $userid;

    $DB->insert_record('teacherchat', $record);

    echo 'Record inserted successfully!';
}

// Fetch data from the parentschat table
$data = $DB->get_records_sql("SELECT * FROM {parentschat} WHERE tid = ?", array($userid));

foreach ($data as $value) {
    // Create an instance of messagereply_form for each record
    $form = new messagereply_form();

    // Set the form data
    $form->set_data(['pmessage' => $value->message]);

    // Display the form
    $form->display();
}

echo $OUTPUT->footer();
?>

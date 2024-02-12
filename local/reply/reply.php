<?php
require(__DIR__.'/../../config.php');
require_once($CFG->dirroot.'/local/reply/reply_form.php');
global $class, $CFG, $USER;

$context = context_system::instance();
$linkurl = new moodle_url('/local/reply/reply.php');
$PAGE->set_context($context);
$strnewclass = "Reply";
$PAGE->set_url('/local/reply/reply.php');
$mform = new reply_form();
echo $OUTPUT->header();

$returnurl = $CFG->wwwroot.'/local/complaint/view_complaint_1.php';

if ($mform->is_cancelled()) {
    redirect($returnurl);
} elseif ($formdata = $mform->get_data()) {
    $replydata = new stdClass();
    $current_date = date('Y-m-d');
    $replydata->date = $current_date;
    $replydata->complaint_id = $formdata->id;
    $replydata->replymsg = $formdata->creplay;

    // Fetch 'user_id' from the 'complaint' table
    $complaint_record = $DB->get_record('complaint', array('id' => $replydata->complaint_id));
    if ($complaint_record) {
        $replydata->user_id = $complaint_record->user_id;
    } else {
        $message = 'No Datas Found';
        // Handle the case where the 'complaint' record doesn't exist
        // You might want to redirect or display an error message here
    }

    // Check if the reply table already contains a record for the specified complaint ID
    $existing_record = $DB->get_record('reply', array('complaint_id' => $replydata->complaint_id));

    if ($existing_record) {
        // If record exists, update the reply message
        $replydata->id = $existing_record->id; // Add the 'id' field for update
        $DB->update_record('reply', $replydata);
        $message = 'Data Updated Successfully';
    } else {
        // If record does not exist, insert a new record
        $DB->insert_record('reply', $replydata);
        $message = 'Data Saved Successfully';
    }

    $urlto = $CFG->wwwroot.'/local/complaint/view_complaint_1.php';
    redirect($urlto, $message);
}

$mform->display();
echo $OUTPUT->footer();
?>

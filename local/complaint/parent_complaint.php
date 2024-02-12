<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

global $DB, $CFG, $USER, $PAGE, $OUTPUT;

$context = context_system::instance();
require_login();

//$view_reply = new moodle_url('/local/reply/view_reply.php?id');


// Assuming you get the complaint ID from the URL parameter
$complaintId = optional_param('id', 0, PARAM_INT);

// Fetch complaint details based on the complaint ID
$complaint = $DB->get_record('complaint', array('id' => $complaintId));
$linkurl = new moodle_url('/local/complaint/parent_view.php');
$css_link = new moodle_url('/local/css/style.css');

$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_title($linktext);
$PAGE->set_title('Complaint Details');

echo $OUTPUT->header();
//$PAGE->set_heading('Complaint Details');


if ($complaint) {
    $iconClass='fa-eye';
    // Load and render the Mustache template
    $template = file_get_contents($CFG->dirroot . '/local/complaint/template/complaint/parent_complaint.mustache');
    $add = $CFG->wwwroot . '/local/reply/view_reply.php?id=' . $complaint->id;
    //$view = '<a href="' . $add . '=' . $complaint->id . '"><button style="font-size: 14px; background-color: #5e4ec2 ; color: white; border: none; padding: 8px 16px; text-align: center; text-decoration: none; display: inline-block; cursor: pointer;">View Reply</button></a>';
    $view = '<a href="'.$add.'"><i class="fa '.$iconClass.'" style="font-size:24px;color:#0055ff"></i></a>';

    $templateData []= [
        'complaint' => $complaint->complaint,
        'viewReplyLink' => $view,

    ];
    $mustache = new Mustache_Engine();
    $output = $mustache->render($template,  ['tableRows' => $templateData,'css_link'=>$css_link,'complaint_link'=>$linkurl]);
    echo $output;
} else {
    echo '<div class="error-message">Complaint not found.</div>';
}

echo $OUTPUT->footer();
?>

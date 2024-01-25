<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

global $DB, $CFG, $USER, $PAGE, $OUTPUT;

$context = context_system::instance();
require_login();

$view_reply = new moodle_url('/local/reply/reply.php?id');

// Assuming you get the complaint ID from the URL parameter
$complaintId = optional_param('id', 0, PARAM_INT);

// Fetch complaint details based on the complaint ID
$complaint = $DB->get_record('complaint', array('id' => $complaintId));
$linkurl = new moodle_url('/local/complaint/view_complaint_1.php');
$css_link = new moodle_url('/local/css/style.css');

$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_title('Complaint Details');

echo $OUTPUT->header();

if ($complaint) {
    // Load and render the Mustache template
    $templatePath = $CFG->dirroot . '/local/complaint/template/complaint_details.mustache';
    
    if (file_exists($templatePath)) {
        $iconClass='fa-plus';

        $template = file_get_contents($templatePath);
        $mustache = new Mustache_Engine();
        $view = '<a href="'.$view_reply.'"><i class="fa '.$iconClass.'" style="font-size:24px;color:#0055ff"></i></a>';

        $templateData = [
            'complaint' => $complaint->complaint,
            'viewReplyLink' => $view,
            
        ];
        
        $output = $mustache->render($template, ['tableRows' => [$templateData]]);
        echo $output;
    } else {
        echo '<div class="error-message">Template file not found.</div>';
    }
} else {
    echo '<div class="error-message">Complaint not found.</div>';
}

echo $OUTPUT->footer();
?>

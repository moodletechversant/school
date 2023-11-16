<?php

require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/dashboard/templates/upcoming_event.mustache');

global $DB, $USER, $OUTPUT, $PAGE;

$context = context_system::instance();
require_login();

$linkurl = new moodle_url('/local/event/upcoming_events.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);                                                                  
//$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
$PAGE->set_heading($linktext);
$PAGE->navbar->add('Upcoming Activities', new moodle_url($CFG->wwwroot.'/local/dashboard/upcoming_activities.php'));

echo $OUTPUT->header();
$userid = $USER->id;
$current_date = time();

$upcoming_events = $DB->get_records_sql("
    SELECT *
    FROM {event}
    WHERE timestart >= ? AND visible = ? AND eventtype IN (?, ?)
    ORDER BY timestart ASC",
    array($current_date, 1, 'user','site')
);
//print_r($upcoming_events);exit();
$mustache = new Mustache_Engine();
$tableRows = [];
$table->head = array('Event Date', 'Event Name');

if (!empty($upcoming_events))  {
    // $table = new html_table();
    // $table->head = array('Event Date', 'Event Name');
    // $table->data = array();
    // $table->class = '';
    // $table->id = 'event_list';
   
    foreach ($upcoming_events as $event) {
        
        $cmid = $event->id;
//print_r($cmid);exit();
        $event_date = date("d-m-Y", $event->timestart);
        $event_name = $event->name;

        $tableRows[] = [
            'id'=> $id,
            'Event_date' => $event_date,
            'Event_name' => $event_name,
        ];
        // $table->data[] = array(
        //     $event_date,
        //     $event_name,
        // );
    }

    // echo html_writer::table($table);
    // $backurl = new moodle_url('/local/dashboard/dashboard.php');
    // $backbutton = html_writer::link($backurl, '< Back');
    // echo $backbutton;
}
else{
    $tableRows[] = [
        'Event_date' => 'There are no upcomming events',
    ];
   
}

$output = $mustache->render($template, ['tableRows' => $tableRows]);
echo $output;

echo $OUTPUT->footer();
?>

<?php

require(__DIR__.'/../../config.php');
require_once($CFG->dirroot . '/message/lib.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/reply/templates/view_reply.mustache');

global $DB, $USER;

$context = context_system::instance();
require_login();

$linktext = "Reply Message";
$linkurl = new moodle_url('/local/reply/view_reply.php');
// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);                                                                  
$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
echo $OUTPUT->header();

$id =intval($_GET['id']);
//print_r($id);exit();
$userid = $USER->id;
$data  = $DB->get_records_sql("SELECT id,complaint_id,date,replymsg FROM {reply} WHERE complaint_id=? LIMIT 1", array($id));
if (!empty($data)) {
  $mustache = new Mustache_Engine();
      $options1 = array(); 
      foreach($data as $value){
      
       $options1[] = array('date' =>  $value->date, 'reply' => $value->replymsg,'delete'=>$value->id);
      }
      $output = $mustache->render($template, ['reply_delete' => $options1]);
} 
else{
  echo "No reply found in the database"; 
    }
   
    echo $output;
    echo $OUTPUT->footer();
     
?>

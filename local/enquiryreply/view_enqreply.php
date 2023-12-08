<style>
  .next {
  background-color: #04AA6D;
  color: white;
  
}
a {
  text-decoration: none;
  display: inline-block;
  padding: 8px 16px;
}

</style>
<?php

require(__DIR__.'/../../config.php');
require_once($CFG->dirroot . '/message/lib.php');

global $DB, $USER;

$context = context_system::instance();
require_login();

$linktext = "Reply Message";

$linkurl = new moodle_url('/local/enquiryreply/view_enqreply.php');
$view_enquiry = new moodle_url('/local/enquiry/view_enquiry.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);                                                                  
$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
$PAGE->set_heading($linktext);

$PAGE->navbar->add('Reply List', new moodle_url($CFG->wwwroot.'/local/enquiryreply/view_enqreply.php'));

echo $OUTPUT->header();

echo'<a href="'.$view_enquiry.'" class="next">&laquo; Previous</a><br><br>';

// $backurl = new moodle_url('/local/enquiry/view_enquiry.php');
// $backbutton = html_writer::link($backurl, '< Back');
// echo $backbutton;

$id =intval($_GET['id']);
//print_r($id);exit();
$userid = $USER->id;
//$complaintid=$complaint->complaint_id;
//print_r($complaintid);exit();
$data  = $DB->get_records_sql("SELECT id,enquiry_id,date,replymsg FROM {enquiryreply} WHERE enquiry_id=? LIMIT 1", array($id));
//print_r($data);exit();
if (empty($data)) {
  
  echo "No reply found in the database";
  //echo '<div style="font-size: 20px;">No data found in the database</div>';

} 
// if (count($data) == 0) {
//   $message = get_string('no_data_found', 'local_complaint');
//   redirect($CFG->wwwroot . '/error.php?errormessage=' . urlencode($message));
// } 

else{
 //$stredit   = get_string('edit');
 $table =new html_table();
      $table ->head=array('Date','Message');
      $table->data = array();
      $table->class = '';
      $table->id = 'reply_list';
      $context = context_user::instance($USER->id, MUST_EXIST);
      
      foreach($data as $value){
        
    
    //$add=$CFG->wwwroot.'/local/reply/viewreply.php?id='.$value->id;//Add icon
    //$edit=$CFG->wwwroot.'/local/reply/edit.php?id='.$value->id;//Edit
    
    
    
   // print_r($userid);exit();
    //$user_record = $DB->get_record('user', array('id' => $user_id));
  
     $table->data[]=array(
      //$value->id,
     $value->date,
     //$value->user_id,
     $value->replymsg,
     
     //$adding = html_writer::link($add, $OUTPUT->pix_icon('i/addblock','Add','moodle')),//Add icon
     //$editing = html_writer::link($edit, $OUTPUT->pix_icon('i/edit', 'Edit me', 'moodle')),//Edit icon
     
     ); 
      }
  
      //exit();
      // $table->data2 = array();
     
      echo html_writer::table($table);
   


    }
    
      echo $OUTPUT->footer();
     
?>

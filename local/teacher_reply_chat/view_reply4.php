<?php
require(__DIR__.'/../../config.php');
require_once($CFG->dirroot . '/message/lib.php');

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
// Set the page heading.
$PAGE->set_heading($linktext);
$PAGE->navbar->add('Reply List', new moodle_url($CFG->wwwroot.'/local/reply/view_reply.php'));

echo $OUTPUT->header();
$id =intval($_GET['id']);
$data  = $DB->get_records_sql("SELECT id,complaint_id,date,replymsg FROM {reply} WHERE complaint_id=? LIMIT 1", array($id));

if (empty($data)) {
  echo "No replay found in the database";
} else {
  $table = new html_table();
  $table->head = array('Id', 'Date', 'Message', 'Delete', 'Add');
  $table->data = array();
  $table->class = '';
  $table->id = 'reply_list';
  $context = context_user::instance($USER->id, MUST_EXIST);
  
  foreach($data as $value) {
    $delete = $CFG->wwwroot.'/local/reply/delete.php?id='.$value->id;//Delete
    $table->data[] = array(
      $value->id,
      $value->date,
      $value->replymsg,
      html_writer::link($delete, $OUTPUT->pix_icon('i/delete', 'Delete me', 'moodle')),//Delete icon
      '<a href="complaint/complaint.php" onclick="showReplyForm()">Add</a>'
    ); 
  }

  echo html_writer::table($table);
  
  // Display the form for adding a new reply message as a dropdown message box
  ?>
  <div id="reply-form" style="display:none;">
    <form method="POST" action="<?php echo $CFG->wwwroot; ?>/local/reply/add_reply.php">
      <label for="replymsg">Message:</label>
      <textarea name="replymsg"></textarea>
      <input type="hidden" name="complaint_id" value="<?php echo $id; ?>">
      <input type="submit" value="Submit">
      <a href="#" onclick="hideReplyForm()">Cancel</a>
    </form>
  </div>
  <script>
    function showReplyForm() {
      document.getElementById("reply-form").style.display = "block";
    }
    function hideReplyForm() {
      document.getElementById("reply-form").style.display = "none";
    }
  </script>
  <?php
}

echo $OUTPUT->footer();
?>

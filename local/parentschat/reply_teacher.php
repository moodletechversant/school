

<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/parentschat/template/teacher_reply.mustache');

global $DB, $USER, $CFG, $PAGE;

$context = context_system::instance();
require_login();

$linktext = "Message List";

$linkurl = new moodle_url('/local/parentschat/view_parentschat.php');
$css_link = new moodle_url('/local/css/style.css');
$parentschat_link= new moodle_url('/local/parentschat/parentschat.php');
$view_message =  new moodle_url('/local/parentschat/message_parent.php');
$message_id  = optional_param('id', 0, PARAM_INT);
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_title($linktext);

echo $OUTPUT->header();

$userid = $USER->id;

$pid1 = $DB->get_record_sql("SELECT user_id FROM {parent} WHERE user_id = ?", array($userid));
//print_r($message_id);exit();


$mustache = new Mustache_Engine();

    $data = $DB->get_records_sql("SELECT * FROM {parentschat} WHERE tid = $userid AND id=$message_id");
   // print_r($data);exit();
    $tableRows = [];

    foreach ($data as $value) {
        $tid1 = $value->tid;
        $teacher_chat = $DB->get_record_sql("SELECT * FROM {teacherchat} WHERE msgid = $message_id");
       print_r();exit();
        $tableRows[] = [
            
            'view_message' => $value-> message,
            'messageid'=>$message_id,
            'teacherchat'=> !empty($teacher_chat),
            'replymessage'=> $teacher_chat->replymsg
            
        ];
    }


$output = $mustache->render($template, ['tableRows' => $tableRows, 'css_link' => $css_link, 'parentschat_link' => $parentschat_link]);
echo $output;

// if (isset($_POST['submit'])) {

//         $crnt_dat=time();
//         // print_r($crnt_dat);exit();
//         $record = new stdClass();
//         $record->msgid =$_POST['hiddn'];
//         $record->date=$crnt_dat;
//         $record->replymsg =$_POST['reply_message'];
       
//     // print_r( $record->status );
//     // exit();
//         $DB->insert_record('teacherchat', $record, false);
      

//     $urlto = $CFG->wwwroot.'/local/parentschat/view_teacherchat_1.php?id='.$message_id;
//     redirect($urlto, 'Data Saved Successfully '); 
// }



echo $OUTPUT->footer();
?>


<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI/tZ1Z1eSd3qWzVnUVlTf1d9S5u0XwH7OuHfjI=" crossorigin="anonymous"></script>
<script type="text/javascript">

   

function replysubmit() {
    var replyid = $("#hiddn").val();  // Use jQuery to get the value
    var reply_message = $("#reply_message").val(); 
    
// alert(reply_message);exit();
    if (replyid != "") {
        $.ajax({
            url: "reply_test.php",
            data: {message_id: replyid,replymessage:reply_message},
            type: 'POST',
            success: function(data) {
                // alert(data)
                // $("#teacherchat").html(data);
            }
        });
    }
    // location.reload(true) 
}


</script>



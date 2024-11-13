<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/adminreg/template/adminview.mustache');
global $class,$CFG,$SESSION;

$context = context_system::instance();
$linkurl = new moodle_url('/local/adminreg/adminview.php');
$css_link = new moodle_url('/local/css/style.css');
$class_creation = new moodle_url('/local/adminreg/admin_registration.php');
$admin_edit = new moodle_url("/local/adminreg/admin_edit.php?id");

$PAGE->set_context($context);
$strnewclass= "admincreation";
$PAGE->set_url('/local/adminreg/adminview.php');
$schoolid  = $SESSION->schoolid;
$PAGE->set_title($strnewclass);
echo $OUTPUT->header();
$mustache = new Mustache_Engine();
$admin_details = $DB->get_records_sql("SELECT * FROM {admin_registration}  WHERE school = $schoolid");
if($admin_details){
    foreach ($admin_details as $admin_detail) {
        $id =$admin_detail->id ;
        $name =$admin_detail->name ;
        $username=$admin_detail->username;
        $email=$admin_detail->email;
        $mob_number=$admin_detail->number;
        $tableRows[] = [
            'id'=>$id,
            'name'=>$name,
            'username'=>$username,
            'email'=>$email,
            'mob_number'=>$mob_number
        ];
    }
}
$output = $mustache->render($template,['css_link'=>$css_link,'tableRows'=>$tableRows,'admin_edit'=>$admin_edit]);
echo $output;
echo $OUTPUT->footer();


?>
<script type="text/javascript">
function deleteadmin(id)
    {
        var confirmation = confirm("Are you sure you want to delete this item?");
        if (confirmation) {

                // alert(id);
                $.ajax({

                    url: "test.php",
                    data: {admin_delete:id},
                    type: 'POST',
                    success: function(data) {
                        if (data == 'success') {
                            // Remove the table row from the DOM
                            $('#admin_table tr[data-id="' + id + '"]').remove();
                            $('#'+id+'_row').remove();
                        } else {
                            alert("Failed to delete record.");
                        }
                    }
                });

            // location.reload(true)
    }
}
</script>










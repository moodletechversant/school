
<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/schoolreg/templates/schoolview.mustache');

global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;
$linktext = "View Schools";

$linkurl = new moodle_url('/local/schoolreg/viewschools.php');
$css_link = new moodle_url('/local/css/style.css');
$create_school = new moodle_url('/local/schoolreg/schoolreg.php');
$edit_school = new moodle_url('/local/schoolreg/schooledit.php?id');
$delete_school = new moodle_url('/local/schoolreg/deleteschool.php?id');

$PAGE->set_context($context);
$strnewclass= 'schoolcreation';

$PAGE->set_url('/local/schoolreg/viewschools.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
// $PAGE->set_heading($SITE->fullname);

echo $OUTPUT->header();
    $rec=$DB->get_records_sql("SELECT * FROM {school_reg}");
    $mustache = new Mustache_Engine();

    //echo $mustache->render($template);
    $table = new html_table();
    $tableRows = [];
    foreach ($rec as $records) {

        


       $id = $records->id; 
       $name = $records->sch_name;
       $shortname = $records->sch_shortname;
    
       $address =$records->sch_address;
       $district =$records->sch_district;
       $state =$records->sch_state;
       $pincode =$records->sch_pincode;

       $number =$records->sch_phone;
      $edit='<button style="border-radius: 5px; padding: 4px 18px;background-color: #0055ff;"><a href="/school/local/schoolreg/schooledit.php?id='.$id.'" style="text-decoration:none;color: white; ">Edit</a></button>';
      $delete='<button style="border-radius: 5px; padding: 4px 20px;background-color: #0055ff;"><a href="/school/local/schoolreg/deleteschool.php?id='.$id.'" style="text-decoration:none;color: white; ">Delete</a></button>';

      // Display the image in the table cell.
     
            
      if ($isSuspended == 1) {
        $iconClass = 'fa-eye-slash';
        $actionText = 'Unsuspend';
      } else {
        $iconClass = 'fa-eye';
        $actionText = 'Suspend';
      }
        $tableRows[] = [
         'id' =>$id,
         'name' => $name,
         'shortname' => $shortname,
         'address' => $address,
         'district' => $district,
         'number' => $number,
         'state' => $state,
         'pincode' => $pincode,
         'editButton' => $edit,
         'deleteButton' => $delete
     ];
    }
    //print_r($tableRows);exit();
    $output = $mustache->render($template, ['tableRows' => $tableRows,'css_link'=>$css_link,'create_school'=>$create_school,'edit_school'=>$edit_school,'delete_school'=>$delete_school]);
    echo $output;
    // <input type="submit" name="edit" value="edit">
    //echo html_writer::table($table);
echo $OUTPUT->footer();


?>


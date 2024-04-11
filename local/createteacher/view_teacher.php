

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src='https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js'></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js'></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
  
  <script type="text/javascript">
    $(document).ready(function() {
        $("#teacher").DataTable( {
            dom: 'Bfrtip',
            buttons: [
            {
                extend: 'pdfHtml5',
                download: 'save',
                exportOptions: {
                    columns: ':lt(11)' // Include only the first 11 columns
                },
                customize: function(doc) {
                    // Modify the PDF document layout
                    doc.content.splice(0, 1, {
                        text: ' Teachers List', // Replace the heading text
                        fontSize: 16,
                        alignment: 'center',
                        margin: [0, 0, 0, 10]
                    });
                    doc.defaultStyle.fontSize = 6;
                    doc.styles.tableHeader.fontSize = 6;
                }
            }
        ]
        } );
    } );
  </script>


<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/createteacher/template/teacherview.mustache');

global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;
$linktext = "View teachers";

$linkurl = new moodle_url('/local/createteacher/view_teacher.php');
$css_link = new moodle_url('/local/css/style.css');
$create_teacher = new moodle_url('/local/createteacher/createteacher.php?id');
$edit_teacher = new moodle_url('/local/createteacher/editteacher.php?id');
$delete_teacher = new moodle_url('/local/createteacher/deleteteacher.php?id');

$PAGE->set_context($context);
$strnewclass= get_string('teachercreation');

$PAGE->set_url('/local/createteacher/view_teacher.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
// $PAGE->set_heading($SITE->fullname);

echo $OUTPUT->header();
    $school_id  = optional_param('id', 0, PARAM_INT);
    $rec=$DB->get_records_sql("SELECT * FROM {teacher} where school_id=$school_id");
    $mustache = new Mustache_Engine();

    //echo $mustache->render($template);
    $table = new html_table();
    $tableRows = [];
    //$table->head = array("Full Name","Username","Email ID","DoB","Address","Mobile no","Blood group","Qualification","Experience","Gender","District",'Edit','Delete');
    foreach ($rec as $records) {
       $id = $records->id; 
       $name = $records->t_fname. $records->t_mname.$records->t_lname;
       $username = $records->t_username;
       $email = $records->t_email;
       $dob=date("d-m-Y", $records->t_dob);
       $address =$records->t_address;
       $number =$records->t_mno;
       $bg =$records->t_bloodgrp;
       $qln =$records->t_qlificatn;
       $exp =$records->t_exp;
       $gender =$records->t_gender;
       $district =$records->t_district;
    
      $edit='<button style="border-radius: 5px; padding: 4px 18px;background-color: #0055ff;"><a href="/school/local/createteacher/editteacher.php?id='.$id.'" style="text-decoration:none;color: white; ">Edit</a></button>';
      //print($edit);exit();
      $delete='<button style="border-radius: 5px; padding: 4px 20px;background-color: #0055ff;"><a href="/school/local/createteacher/deleteteacher.php?id='.$id.'" style="text-decoration:none;color: white; ">Delete</a></button>';
       // $table->data[] = array($name,$username, $email,$dob, $address,$number,$bg,$qln, $exp,$gender,$district,$edit,$delete);

        $tableRows[] = [
         'id' =>$id,
         'name' => $name,
         'username' => $username,
         'email' => $email,
         'dob' => $dob,
         'address' => $address,
         'number' => $number,
         'bg' => $bg,
         'qln' => $qln,
         'exp' => $exp,
         'gender' => $gender,
         'district' => $district,
         'editButton' => $edit,
         'deleteButton' => $delete
     ];
    }
    //print_r($tableRows);exit();
    $output = $mustache->render($template, ['school_id'=>$school_id,'tableRows' => $tableRows,'css_link'=>$css_link,'create_teacher'=>$create_teacher,'edit_teacher'=>$edit_teacher,'delete_teacher'=>$delete_teacher]);
    echo $output;
    // <input type="submit" name="edit" value="edit">
    //echo html_writer::table($table);
echo $OUTPUT->footer();


?>


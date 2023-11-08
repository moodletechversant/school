
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
        $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                 'csv', 'excel', 'pdf'
            ]
        } );
    } );
  </script>

<link rel="stylesheet" href="https://codepen.io/gymratpacks/pen/VKzBEp#0">
        <link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/style.css">


<?php 
require_once(__DIR__ . '/../../config.php');

global $class, $CFG, $DB;

$context = context_system::instance();
// $classid = $class->id;
$linktext = "Report";

$linkurl = new moodle_url('/local/report/report.php');

$PAGE->set_context($context);
$strnewclass = $linktext;

$PAGE->set_url('/local/report/report.php');
$PAGE->set_pagelayout('standard');
$PAGE->set_title($strnewclass);


echo $OUTPUT->header();

$template = file_get_contents($CFG->dirroot . '/local/report/templates/reporthead.mustache');

$rec = $DB->get_records_sql("SELECT * FROM {student}");

$sreport = array();
foreach ($rec as $student) {
    $sid = $student->id;
    $sname = $student->s_ftname;
    $email = $student->s_email;


    $dob =$student->s_dob;
      $dob1 = date("d-m-Y", $dob);
   
    $address = $student->s_address;
    $no = $student->s_gno;

    $sreport[] = array('id' => $sid, 'name' => $sname, 'email' => $email, 'dob' => $dob1, 'address' => $address, 'no' => $no);
}

$sreport1 = array('students' => $sreport);

$mustache = new Mustache_Engine();

echo $mustache->render($template, $sreport1);

?>

 
 

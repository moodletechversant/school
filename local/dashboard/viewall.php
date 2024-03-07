


<?php
// include('demo.html');
require_once(__DIR__ . '/../../config.php');
 require_once(__DIR__ . '/../../lib/mustache/src/Mustache/Autoloader.php');

require_once($CFG->dirroot . '/calendar/lib.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template4 = file_get_contents($CFG->dirroot .'/local/dashboard/templates/leavelist.mustache');

// require_once($CFG->dirroot.'/local/createstudent/demo.html');
global $class, $CFG, $OUTPUT, $PAGE;
$userid= $USER->id;
$context = context_system::instance();
// $classid = $class->id;

$linkurl = new moodle_url('/local/dashboard/viewall.php');

$PAGE->set_context($context);
$strnewclass = 'leaverequest';

$PAGE->set_url('/local/dashboard/viewall.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);

echo $OUTPUT->header();
$sql = "SELECT s_name
FROM {leave}
WHERE DATE(FROM_UNIXTIME(f_date)) <= CURDATE() 
  AND DATE(FROM_UNIXTIME(t_date)) >= CURDATE()
  AND (l_status = 'approved' OR l_status = 'pending')";
$data1 = $DB->get_records_sql($sql);
if (empty($data1)) {
  echo "Everyone is present today";
} else {
$table = new html_table();
    $mustache = new Mustache_Engine();
    $data = array();
foreach ($data1 as $rec1) {
    $sname = $rec1->s_name;
        
            $data[] = array(
                'name' => $sname);
             
            }     
   
    $leaves=array('leave' => $data);
    
    echo $mustache->render($template4, $leaves);
          }
    echo $OUTPUT->footer();
    ?>


<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

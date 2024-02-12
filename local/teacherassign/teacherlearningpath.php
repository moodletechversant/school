<?php 
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/teacherassign/template/teacherlearningpath.mustache');

global $class,$CFG, $DB;
$context = context_system::instance();
$linktext = "Learning Path";
$linkurl = new moodle_url('/local/teacherassign/template/teacherlearningpath.mustache');
$css_link=new moodle_url('/local/css/style.css');

$PAGE->set_context($context);
$strnewclass= get_string('studentview');
$PAGE->set_url('/local/teacherassign/teacherlearningpath.php');
$PAGE->set_heading($linktext);
$PAGE->set_title($strnewclass);

$teacher_id = $USER->id;
echo $OUTPUT->header(); 
$mustache = new Mustache_Engine();
$academic = $DB->get_records('academic_year'); 

$options1 = array();
$options1[] = array('value' => '', 'label' => '-- Select Academic Year --');
foreach ($academic as $academic1) {
    $timestart = $academic1->start_year;
    $timestart1 = date("d-m-Y", $timestart);
    $timeend = $academic1->end_year;
    $timeend1 = date("d-m-Y", $timeend);
    $options1[] = array('value' => $academic1->id, 'label' => $timestart1.'--'.$timeend1);
}

$templateData = array(
    'startYearOptions' => $options1,
);

$output = $mustache->render($template, ['templateData'=>$templateData,'css_link'=>$css_link]);

echo $output;

echo $OUTPUT->footer();

// //Academic Year  
// $students = $DB->get_records_sql("SELECT * FROM {teacher_assign}");
// $academics = $DB->get_records_sql("SELECT * FROM {academic_year}");
// $options1 = array();
// $options1[] = array('value' => '', 'label' => 'Select');
// //echo '<form method="POST">';

// //echo '<table align="center" border="0"><tr><td class="tdd" >';
//          // echo '<table align="center">';

//           ////////Academic Year sELECT/////////////////////////////////
//           //echo '<tr><th>Academic Year</th>
//                // <th><select class="form-control" id="academic-year" name="academic-year" required style="width: 200px; height: 30px;">';
//                 //echo '<option value ="select academic Year" name="academic-year" selected>select academic Year</option>';
              
//           foreach($academics as $academic){
//                 $timestart = $academic->start_year;
//                 $timeend = $academic->end_year;
//                 $timestart1 = date("d/m/Y", $timestart);
//                $timeend1 = date("d/m/Y", $timeend);
//              // echo '<option value ="' . $academic->id . '">' . $timestart1.'----'.$timeend1 . '</option>';
//               $options1[] = array('value' => $academic1->id, 'label' => $timestart1.'----'.$timeend1);
//           }
//           $templateData = array(
//             'Options' => $options1
//         );
//           //Class
//           $classes  = $DB->get_records_sql("SELECT * FROM mdl_class");
//           $options2 = array();
//           $options2[] = array('value' => '', 'label' => 'Select');

//           foreach($classes as $class){
//             //$options2[] = array('value' => $class->id, 'label' => $class->class_name);

//           }

//           // ////////cLASS sELECT////////
//           // $classes  = $DB->get_records_sql("SELECT * FROM mdl_class");
          
//           // echo '
//           //     <tr><th>Class</th>
//           //         <th><select class="form-control" id="class" name="class" required style="width: 200px; height: 30px;">';
//           //         echo '<option value ="class" name="class" selected>---- Choose a Class ----</option>';
//           //         foreach($classes as $class){
//           //           //   echo '<option value="' . $class->id . '">' . $class->class_name . '</option>';
//           //         }
//           // echo '</select></th></tr>';
//           // /////////////////////////////////////////////////////////////

//           ////////Division sELECT////////
//           $divisions  = $DB->get_records_sql("SELECT * FROM mdl_division");

//           // echo '

//           // <tr><th>Division</th>
//           //         <th><select class="form-control" id="division" name="division" required style="width: 200px; height: 30px;">';
//           //         echo '<option value ="division" name="division" selected>---- Choose a division ----</option>';
//           foreach($divisions as $division){
//               // echo '<option value="' . $division->id . '">' . $division->div_name . '</option>';
//           }
          
//           $output = $mustache->render($template, ['templateData'=>$templateData]);
//           echo $output;
          
          
          
          // <br>
          // <span class="d-block p-2 bg-dark text-white">  click students name to view their learning path of the selected subject</span>
          // <br>
          // <div id="searchresult"></div>';
     

          // echo '<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>';
      
          // echo '<script>
          //   $(document).ready(function(){
          //     $("#academic-year").change(function(){
          //       var option = $(this).val();
          //       $.ajax({
          //         type: "POST",
          //         url: "test_tassgn.php",
          //         data: {option: option},
          //         success: function(response){
          //           $("#class").html(response);
          //         }
          //       });
          //     });
          //   });
          //   </script>
          //   ';
      
      
      
          // echo '<script>
          //   $(document).ready(function(){
          //     $("#class").change(function(){
          //       var option1 = $(this).val();
          //       $.ajax({
          //         type: "POST",
          //         url: "test_tassgn.php",
          //         data: {option1: option1},
          //         success: function(response){
          //           $("#division").html(response);
          //         }
          //       });
          //     });
          //   });
          //   </script>
          //   ';
 

          //   echo '<script>
          //   $(document).ready(function(){
          //     $("#division").change(function(){
          //       var option = $(this).val();
          //       $.ajax({
          //         type: "POST",
          //         url: "test_tassign2.php",
          //         data: {option: option},
          //         success: function(response){
          //           $("#searchresult").html(response);
          //           $("#searchresult").css("display", "block");
          //         }
          //       });
          //     });
          //   });
          //   </script>
          //   ';

?>
<!-- 
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <style>
    .card {
      margin-bottom: 1rem;
    }
    
    .list-view .row > [class*='col-'] {
      max-width: 100%;
      flex: 0 0 100%;
    }
    
    .list-view .card {
      flex-direction: row;
    }
    
    @media (max-width: 575.98px) {
      .list-view .card {
        flex-direction: column;
      }
    }
    
    .list-view .card > .card-img-top {
      width: auto;
    }
    
    .list-view .card .card-body {
      display: inline-block;
    }
  </style>
</head>
  
<script>
  function showList(e) {
    var $gridCont = $('.grid-container');
    e.preventDefault();
    $gridCont.hasClass('list-view') ? $gridCont.removeClass('list-view') : $gridCont.addClass('list-view');
  }
  
  function gridList(e) {
    var $gridCont = $('.grid-container');
    e.preventDefault();
    $gridCont.removeClass('list-view');
  }
  
  $(document).on('click', '.btn-grid', gridList);
  $(document).on('click', '.btn-list', showList);
</script> -->
<?php
// Connect to the database
require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();

$template = file_get_contents($CFG->dirroot . '/local/subject/template/course.mustache');

require_login();
global $DB;
echo '<form><div id="searchresult">';

// Retrieve the selected option value
if(isset($_POST['option'])){
    $option1 = $_POST['option']; 
    $data = array();
    $rec1=$DB->get_records_sql("SELECT * FROM {subject} WHERE sub_division=$option1");
    $mustache = new Mustache_Engine();
    foreach($rec1 as $record1){
        $courseid = $record1->course_id;
        $subject = $record1->sub_name;
        $description = $record1->sub_description;
        $data[] = array('fullname' => $subject, 'description' => $description, 'id' => $courseid);
    }
    
    //Multi-dimentional array
    $subjects = array('sub' => $data);
    echo $mustache->render($template,$subjects);
  }
  echo '</div></form>';
  ?>


<?php
require_once(__DIR__ . '/../../config.php');

require_once($CFG->dirroot . '/calendar/lib.php');
require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();


$template4 = file_get_contents($CFG->dirroot . '/local/dashboard/templates/cmplnt_feedbck.mustache');

global $class,$CFG;
$context = context_system::instance();


$linkurl = new moodle_url('/local/dashboard/cmplnt_feedbck.php');

$PAGE->set_context($context);
$strnewclass= 'Teacher Dashboard';

$PAGE->set_url('/local/dashboard/cmplnt_feedbck.php');

echo $OUTPUT->header();
$current_time = time(); 

$mustache = new Mustache_Engine();
echo $mustache->render($template4);
echo $OUTPUT->footer();


?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <link rel="stylesheet" href="css/body.css">
  
  <style>
.center {
  margin: none;
  width: 100%;
  height: 10%;

  
}
.row {
  display: flex;
  justify-content: center;
  align-items: center;

}
.card-footer{
  width: 100%;
}
#bg1{
  background-color: #e6e6e6;
}
#col1{
  background-color: #17a2b8;
}

#col2{
  background-color: #28a745;
}
#col3{
  background-color: #ffc107;
}
#col4{
  background-color: #CF9FFF;
}

#col5{
  background-color: #CF9FFF;
  
}


#f1{
  background-color: #148c9f;
}
#f2{
  background-color: #23903c;
}
#f3{
  background-color: #e6ac00;
}
#f4{
  background-color: #CF9FFF;
}



    / Set height of the grid so .sidenav can be 100% (adjust as needed) /
    .row.content {height: 550px}
    
    / Set gray background color and 100% height /
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
        
    / On small screens, set height to 'auto' for the grid /
    @media screen and (max-width: 867px) {
      .row.content {height: auto;} 
    }


    @keyframes floatAnimation {
  0% {
    transform: translateX(100%);
  }
  100% {
    transform: translateX(-100%);
  }
}




#movingHeading {
    width: 100%;
    white-space: nowrap;
    overflow: hidden;
    animation: marquee 10s linear infinite;
  }
  
  @keyframes marquee {
    0% {
      transform: translateX(0);
      color: red;
    }
    100% {
      transform: translateX(100%);
      color: blue;
    }
  }
  </style>
</head>
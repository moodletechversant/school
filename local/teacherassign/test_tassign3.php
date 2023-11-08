<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="/school/local/css/style.css" />
</head>
<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/completionlib.php');
require_login();
global $class,$CFG,$DB;
$context = context_system::instance();

if(isset($_POST['option'])){
    $option1 = $_POST['option']; 

    $id  = optional_param('id', 0, PARAM_INT);
    $courseid = $option1;
    $modinfo = get_fast_modinfo($courseid);
    $sections = $modinfo->get_section_info_all();
    $course_name=$DB->get_record_sql("SELECT * FROM {course} WHERE id=$courseid");
    // print_r($course_name->fullname);
    $course_namee=$course_name->fullname;

$var.='<body>

<div class="form-wrap">
<div class="cointainer">
<div class="col-md-11 col-11 mx-auto col-lg-8">
    <h2 style="margin-bottom: 30px;"> <img src="/school/local/img/sub-icon-1.svg" width="45px"/>'.$course_namee.' </h2>
    
    <div class="accordion" id="accordionPanelsStayOpenExample">';

//loop1
$numberWords = array('One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten');
$counter = 0; // Initialize the counter

foreach ($sections as $section_item) {

    $course = $section_item->course;
    // print_r($section_item);
    $section_id = $section_item->id;
    $section_name =$section_item->name;                                  
    $userid=$_POST['id']; 
    // $userid=50;
    // print_r($userid);exit();
    /////*******************************/
    $module_completed=$DB->get_records_sql("SELECT COUNT(*) AS total_records FROM {course_modules} 
    INNER JOIN {course_modules_completion} ON 
    {course_modules}.id={course_modules_completion}.coursemoduleid where
     {course_modules}.course=$course AND {course_modules}.section=$section_id AND 
     {course_modules_completion}.userid=$userid");
    /////*******************************/
    // print_r($module_completed);exit(); 
    $total_modules=$DB->get_records_sql("SELECT COUNT(*) AS total_records 
    FROM {course_modules} where course=$course AND section=$section_id");                                              


      $var.='  <div class="accordion-item">';
        //if
        if ($module_completed == $total_modules) { 

         $var.='  <h2 class="accordion-header" id="panelsStayOpen-headingOne">
         <button class="accordion-button collapsed completed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
             <g clip-path="url(#clip0_2647_1259)">
             <path fill-rule="evenodd" clip-rule="evenodd" d="M21.546 5.11107C21.8272 5.39236 21.9852 5.77382 21.9852 6.17157C21.9852 6.56931 21.8272 6.95077 21.546 7.23207L10.303 18.4751C10.1544 18.6237 9.97805 18.7416 9.7839 18.822C9.58976 18.9024 9.38167 18.9438 9.17153 18.9438C8.96138 18.9438 8.75329 18.9024 8.55915 18.822C8.365 18.7416 8.1886 18.6237 8.04003 18.4751L2.45403 12.8901C2.31076 12.7517 2.19649 12.5862 2.11787 12.4032C2.03926 12.2202 1.99788 12.0233 1.99615 11.8242C1.99442 11.625 2.03237 11.4275 2.10779 11.2431C2.18322 11.0588 2.29459 10.8913 2.43543 10.7505C2.57627 10.6096 2.74375 10.4983 2.92809 10.4228C3.11244 10.3474 3.30996 10.3095 3.50913 10.3112C3.7083 10.3129 3.90513 10.3543 4.08813 10.4329C4.27114 10.5115 4.43666 10.6258 4.57503 10.7691L9.17103 15.3651L19.424 5.11107C19.5633 4.97168 19.7287 4.8611 19.9108 4.78566C20.0928 4.71022 20.288 4.67139 20.485 4.67139C20.6821 4.67139 20.8772 4.71022 21.0593 4.78566C21.2413 4.8611 21.4067 4.97168 21.546 5.11107Z" fill="black"/>
             </g>
             <defs>
             <clipPath id="clip0_2647_1259">
             <rect width="24" height="24" fill="white"/>
             </clipPath>
             </defs>
             </svg> '.$section_name .'
         </button>
 </h2>';
        }
        //if close

        //else
        else{

        $var.=' <h2 class="accordion-header  " id="panelsStayOpen-headingOne">
        <button class="accordion-button active" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M12 2C10.0222 2 8.08879 2.58649 6.4443 3.6853C4.79981 4.78412 3.51809 6.3459 2.76121 8.17317C2.00433 10.0004 1.8063 12.0111 2.19215 13.9509C2.578 15.8907 3.53041 17.6725 4.92894 19.0711C6.32746 20.4696 8.10929 21.422 10.0491 21.8079C11.9889 22.1937 13.9996 21.9957 15.8268 21.2388C17.6541 20.4819 19.2159 19.2002 20.3147 17.5557C21.4135 15.9112 22 13.9778 22 12C22 10.6868 21.7413 9.38642 21.2388 8.17317C20.7363 6.95991 19.9997 5.85752 19.0711 4.92893C18.1425 4.00035 17.0401 3.26375 15.8268 2.7612C14.6136 2.25866 13.3132 2 12 2ZM10 16.5V7.5L16 12L10 16.5Z" fill="black"/>
            </svg>'.$section_name .'</button></h2>';
        }
        //else close


          $var.='<div id="panelsStayOpen-collapse' . $numberWords[$counter] . '" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
            <div class="accordion-body">
              <ul class="timeline">';
              $modules = $DB->get_records_sql("SELECT * FROM {course_modules} WHERE course=$course AND section=$section_id");
                                      
                //loop2
                foreach ($modules as $module) { 
                    $mod = $modinfo->get_cm($module->id);
                    $module_name = $mod->name;                                        
                    $mid=$mod->section;
                    $miid=$mod->id;
                    $course1=$course;
                    $total_modules2=$DB->get_records_sql("SELECT * FROM {course_modules_completion} where coursemoduleid=$miid AND userid= $userid"); 
                 
                //if
                if (count($total_modules2) > 0)  {
                    $var.='<li class="timeline-item">
                            <div class="timeline-marker completed"></div>
                            <div class="timeline-content">
                                <h3 class="timeline-title">'.$module_name .'</h3>
                                <p></p>
                            </div>
                            </li>';
                }
                //if closed
                //else open
                else{
                $var.='<li class="timeline-item">
                      
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h3 class="timeline-title">'.$module_name .'</h3>
                                <p></p>
                        </div>
                    </li>';
                }
                //else closed
                }
                 //loop2 closed

                 $counter++;

                $var.=' 
                </ul>
            </div>
          </div>
        </div>';
}
//loop1 closed
      $var.=' </div>
    </div>

  </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
  crossorigin="anonymous"></script>
</body>
';
echo $var;
}
?>
<?php
// include('demo.html');
require_once(__DIR__ . '/../../config.php');
// require_once($CFG->libdir.'/coursecatlib.php');
require_once($CFG->libdir.'/completionlib.php');
global $class,$CFG;
$context = context_system::instance();
// $classid = $class->id;
// $linktext = "View students";
$linkurl = new moodle_url('/local/dashboard/learning path.php');
$PAGE->set_context($context);
$strnewclass= get_string('studentview');
$PAGE->set_url('/local/dashboard/learning path.php');
// $PAGE->set_pagelayout('admin');
$PAGE->set_title($strnewclass);
echo $OUTPUT->header();
$id  = optional_param('id', 0, PARAM_INT);
$courseid = $id ;
$modinfo = get_fast_modinfo($courseid);
$sections = $modinfo->get_section_info_all();
?>
    <!DOCTYPE html>
    <html>
    <head>
        
        <style>
        /* Set the style for the nodes */
        .node {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #00990d;
            border: 2px solid #00990d;
            text-align: center;
            line-height: 20px;
            color: white;
            position: relative;
            top: 8px;
        }
        .anode {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #990000;
            border: 2px solid #990000;
            text-align: center;
            line-height: 20px;
            color: white;
            position: relative;
            top: 8px;
        }
        .nodeb{
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: white;
            border: 2px solid #00990d;
            text-align: center;
            line-height: 24px;
            color: white;
            position: relative;
            top: 5px;
        }
        
        .node1{
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: white;
            border: 2px solid #990000;
            text-align: center;
            line-height: 24px;
            color: white;
            position: relative;
            top: 5px;
        }

    .node2{
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: black;
            /* border: 2px solid #660066; */
            text-align: center;
            line-height: 24px;
            color: white;
            position: relative;
            top: 10px;
        }
        /* Set the style for the lines */
        .line {
            display: inline-block;
            height: 1px;
            width: 15px;
            background-color: black;
            margin-top: 24px;
        }

        .pair-container {
            display: flex;
            align-items: center;
        }
        .list-group-item {
            position: relative;
            display: block;
            padding: .75rem 1.25rem;
            background-color: #fff;
            border: 0px ;
            }
        </style>
    </head>
    <body>
        
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <!-- <h1>Learning Path</h1> -->
            <br>
            <ul class="list-group" style="list-style-type:none;">
                <li class="list-group-item">              
                            <?php         
                            foreach ($sections as $section_item) {

                                    $course = $section_item->course;
                                    // print_r($section_item);
                                    $section_id = $section_item->id;
                                    $section_name =$section_item->name;                                  
                                    $userid=$USER->id;
                                    // print_r($section_name);exit();
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
                              
                                    if ($module_completed == $total_modules) { ?>

                                            <div class="node"  title="<?php echo $section_name; ?>  completed"></div>
                                            <span class="line"></span>
                                            <?php
                                    } 
                                    else {
                                        ?>
                                        <div class="anode"  title="<?php echo $section_name; ?> Pending"></div>
                                            <span class="line"></span>
                                            <?php 

                                    }
                                        $modules = $DB->get_records_sql("SELECT * FROM {course_modules} WHERE course=$course AND section=$section_id");
                                        
                                        foreach ($modules as $module) { 
                                            // print_r($module->deletioninprogress);exit();
                                            if($module->deletioninprogress==0){
                                                $mod = $modinfo->get_cm($module->id);
                                                $module_name = $mod->name;                                        
                                                $mid=$mod->section;
                                                $miid=$mod->id;
                                                $course1=$course;
                                                $total_modules2=$DB->get_records_sql("SELECT * FROM {course_modules_completion} where coursemoduleid=$miid AND userid= $userid"); 


                                                if (count($total_modules2) > 0)  { ?>
                                                <div class="nodeb" title="<?php echo $module_name; ?> completed"></div>  <?php } 
                                                else { ?>
                                                <div class="node1" title="<?php echo $module_name; ?> Pending"></div>  <?php  }?>
                                                
                                                <span class="line"></span>
                                            <?php
                                            }  
                                        }
                                       
                                    
                                                             
                                } 
                                 // Assuming the sections array is not empty                          
                                    ?>                                                       
                <div class="node2"></div>
                </li>
            </ul>
            </div>
        </div>
        </div>
    </body>
    </html>
<?php
echo $OUTPUT->footer();


?>


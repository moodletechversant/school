<!-- teacher_assign -->
<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Form for editing a users profile
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package core_user
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Moodle page.
}

require_once($CFG->dirroot.'/lib/formslib.php');
require_once($CFG->dirroot.'/user/lib.php');

class assignclsteacher_form extends moodleform {

    public function definition() {
        global $DB, $USER, $CFG, $COURSE,$SESSION ;
        // $school_id=optional_param('id', 0, PARAM_INT); 
   
        $school_id  =$SESSION->schoolid;


        $mform = $this->_form;
        $clsteacher_assign=$CFG->wwwroot.'/local/clsteacherassign/view_clsteacherassign.php';

        
        
        $attributes = 'size="30"';

        $mform->addElement('html', '<h2 class="text-center heading mb-5">Assign Class Teacher</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');
        $mform->addElement('hidden','school_id',$school_id);

        // $editorclasslist = null;
        // $filemanagerclasslist = null;


        //-----------Form creation-----------
        //Academic Year 
        $academic  = $DB->get_records('academic_year',array('school' => $school_id));
        //    $classes  = $DB->get_records('class');
            $options1 = array();
            $options1=array(''=>'---- Select academic_year ----');
            foreach($academic as $academics){
            $options1 [$academics->id] = date('d-m-Y',$academics->start_year);
            }

            $mform->addElement('select', 'academic','Academic Year',$options1);
         //Class 


             $classes  = $DB->get_records('class');
             $options1 = array();
             $options1=array(''=>'---- Select a class ----');
             foreach($classes as $class){
            $options1 [$class->id] = $class->class_name;
             }
 
             $mform->addElement('select', 'class','Class',$options1);
 
          //Division 
 
             $divisions  = $DB->get_records('division');
             $options2 = array();
             $options2=array(''=>'---- Select a division ----');
             foreach($divisions as $division){
             $options2 [$division->id] = $division->div_name;
             }
             $mform->addElement('select', 'division','Division',$options2);
         //teacher name

           
        //  $teacher  = $DB->get_records('teacher');


         $teacher = $DB->get_records_sql("SELECT * from {teacher} ");
       
         $options3 = array();
         foreach($teacher as $teachers){
            // $name=$teachers->t_fname;
            // print_r($name);
            // exit();
            // $options2 [$name] = $name;
         $options3[$teachers->user_id] = $teachers->t_fname;
         }

         $mform->addElement('select', 'teacher','teacher',$options3);
        //  $mform->addElement('select', 'student', 'Student', $options3);

         // Disable selected student's name from select list
        //  if ($selected_student = $mform->getElementValue('teacher')) {
        //      $mform->disabledIf('teacher', "id = $selected_student");
        //  }

         
         $mform->addElement('html', '</div>');


         
             $this->add_action_buttons();
             $mform->addElement('html','<a href = "'.$clsteacher_assign.'" style="text-decoration:none">');
             $mform->addElement('button', 'btn', 'View Assigned Class Teacher'); 
             $mform->addElement('html','</a>');
             $mform->addElement('html', '</div>');
            //  $mform->addElement('html','<a href = "viewsubject.php" style="text-decoration:none">');
            //  $mform->addElement('button', 'btn', 'Assign teacher'); 
            //  $mform->addElement('html','</a>');
  
  
    }

}





?>


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

class teacherassign_form extends moodleform {
    
    public function definition() {
        global $DB, $USER, $CFG, $COURSE;

        $mform = $this->_form;
        // $editorclasslist = null;
        // $filemanagerclasslist = null;

        $attributes = 'size="30"';

        //-----------Form creation-----------
        $mform->addElement('html', '<h2 class="text-center heading mb-5">Assign teacher</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');

        //Academic Year 
        $academic  = $DB->get_records('academic_year');
        $options1 = array();
        $options1=array(''=>'---- Select academic year ----');
        foreach($academic  as $academic1 ){
            $timestart = $academic1->start_year;
            $timeend = $academic1->end_year;
        $timestart1 = date("d/m/Y", $timestart);
        $timeend1 = date("d/m/Y", $timeend);
        $options1 [$academic1->id] = $timestart1.'----'.$timeend1;
        }

        $mform->addElement('select', 'academicyear','Academic start',$options1);
        $mform->addRule('academicyear', 'academic year missing', 'required', null);
         // //Class   
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


          //subject 
          $subjects  = $DB->get_records('subject');
          $options3 = array();
          $options3=array(''=>'---- Select a subject ----');
          foreach($subjects as $subject){
          $options3 [$subject->course_id] = $subject->sub_name;
          }
          $mform->addElement('select', 'subject','Subject',$options3);

        // Get list of teachers
                $teachers = $DB->get_records('teacher');
                
                //  $classes  = $DB->get_records('class');
                $options4 = array();
                $options4=array(''=>'---- Select a teacher ----');
                foreach( $teachers as  $teacher){
                $options4 [$teacher->user_id] = $teacher->t_fname;
                }
            // Add teacher element to the form
            $mform->addElement('select', 'teacher', 'Teacher', $options4);

            $mform->addElement('html', '</div>');



             $this->add_action_buttons();

             $mform->addElement('html','<a href = "view_tassign.php" style="text-decoration:none">');
             $mform->addElement('button', 'btn', 'Assign teacher'); 
             $mform->addElement('html','</a>');

             $mform->addElement('html', '</div>');

  
  
    }

}





?>

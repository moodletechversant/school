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
 * User sign-up form.
 *
 * @package    core
 * @subpackage auth
 * @copyright  1999 onwards Martin Dougiamas  http://dougiamas.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot . '/user/editlib.php');
require_login();

class edit_assignstudent_form extends moodleform {
    function definition() {
        global $USER, $CFG, $COURSE, $DB;
        $urlto=$CFG->wwwroot.'/local/teacherassign/editassign.php';
     
        $mform = $this->_form;

        $id  = optional_param('id', 0, PARAM_INT);
        $mform->addElement('hidden','id',$id);

        $mform->addElement('html', '<h2 class="text-center heading mb-5">Assign teacher</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');
        // $table = new html_table();

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





        $editdata=$DB->get_record('teacher_assign',array('id'=>$id));
        
        $t_ftname = $DB->get_record_sql("SELECT * FROM {teacher} WHERE  user_id= $editdata->user_id");
      
        $editdata1=$DB->get_record('class',array('id'=>$editdata->t_class));
        $mform->setDefault('academicyear',$editdata1->academic_id);
        // $mform->setDefault('academicyear1',$editdata1->academic_id);

        $mform->setDefault('t_ftname',$t_ftname->t_class);
        $mform->setDefault('class',$editdata->s_class);
        $mform->setDefault('division',$editdata->t_division );
        $mform->setDefault('subject',$editdata->t_subject );
        
        
        $mform->addElement('html', '</div>');

        $this->add_action_buttons();

        $mform->addElement('html', '</div>');
        // $mform->addElement('html','<a href = "div_view.php" style="text-decoration:none">');
        // $mform->addElement('button', 'btn', 'View divisions'); 
        // $mform->addElement('html','</a>');
 
    }
    
  
}
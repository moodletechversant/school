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
        $urlto=$CFG->wwwroot.'/local/studentassign/edit_assignstudent.php';
     
        $mform = $this->_form;



        $mform->addElement('html', '<h2 class="text-center heading mb-5">Student Assign</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');
        // $table = new html_table();
        $id  = optional_param('id', 0, PARAM_INT);
        $mform->addElement('hidden','id',$id);

        //Student Name

         $mform->addElement('text', 's_ftname', 'Student Name'); 
         $mform->addRule('s_ftname', ' Student Name missing', 'required', null);
         $mform->hardFreeze('s_ftname'); // Disable the element
         //Class 

        //-----------Form creation-----------
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

        $js = <<<JS
         document.addEventListener("DOMContentLoaded", function() {
         var selectElement = document.getElementById("id_academicyear");
         selectElement.disabled = true;
         });
         JS;
 
         // Add the JavaScript to the form
         $mform->addElement('html', "<script>{$js}</script>");
        // //Class       
        $classes = $DB->get_records_sql("SELECT * FROM {class}");     
         $options1 = array();
         $options1=array(''=>'---- Select a class ----');
         foreach($classes as $class){
         $options1 [$class->id] = $class->class_name;
         }

         $mform->addElement('select', 'class','Class',$options1);
          
         $js = <<<JS
         document.addEventListener("DOMContentLoaded", function() {
         var selectElement = document.getElementById("id_class");
         selectElement.disabled = true;
         });
         JS;
 
         // Add the JavaScript to the form
         $mform->addElement('html', "<script>{$js}</script>");
        //  //Division 
         $divisions  = $DB->get_records('division');
         $options2 = array();
         $options2=array(''=>'---- Select a division ----');
         foreach($divisions as $division){
            $options2 [$division->id] = $division->div_name;
            }
         $mform->addElement('select', 'division','Division',$options2);

        $editdata=$DB->get_record('student_assign',array('id'=>$id));
        
        $s_ftname = $DB->get_record_sql("SELECT * FROM {student} WHERE  user_id= $editdata->user_id");
      
        $editdata1=$DB->get_record('class',array('id'=>$editdata->s_class));
        $mform->setDefault('academicyear',$editdata1->academic_id);
        $mform->setDefault('academicyear1',$editdata1->academic_id);

        $mform->setDefault('s_ftname',$s_ftname->s_ftname);
        $mform->setDefault('class',$editdata->s_class);
        $mform->setDefault('division',$editdata->s_division );
        
        
        $mform->addElement('html', '</div>');

        $this->add_action_buttons();

        $mform->addElement('html', '</div>');
       
    }
    
  
}
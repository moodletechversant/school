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

class editsubject_form extends moodleform {

    public function definition() {
        global $DB, $USER, $CFG, $COURSE;

        $mform = $this->_form;

        $mform->addElement('html', '<h2 class="text-center heading mb-5">Edit subject</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');

        // $editorclasslist = null;
        // $filemanagerclasslist = null;

        $attributes = 'size="30"';

        $id  = optional_param('id', 0, PARAM_INT);
        $id1=$DB->get_record('subject',array('course_id'=>$id));

        // print_r($id);exit();
        //-----------Form creation-----------

         //ID

            $mform->addElement('hidden','id',$id1->id);
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
    
        $mform->addElement('select', 'academicyear','Academic year',$options1);
    
        $js = <<<JS
        document.addEventListener("DOMContentLoaded", function() {
        var selectElement = document.getElementById("id_academicyear");
        selectElement.disabled = true;
        });
        JS;

        // Add the JavaScript to the form
        $mform->addElement('html', "<script>{$js}</script>");
    
                                  
         //Class 

         $classes  = $DB->get_records('class');
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
      //Division 

         $divisions  = $DB->get_records('division');
         $options2 = array();
         $options2=array(''=>'---- Select a division ----');
         foreach($divisions as $division){
         $options2 [$division->id] = $division->div_name;
         }
         $mform->addElement('select', 'division','Division',$options2);
         $js = <<<JS
         document.addEventListener("DOMContentLoaded", function() {
         var selectElement = document.getElementById("id_division");
         selectElement.disabled = true;
         });
         JS;
 
         // Add the JavaScript to the form
         $mform->addElement('html', "<script>{$js}</script>");
         //Subject name

             $mform->addElement('text', 'subname','Subject Name',$attributes);
             $mform->addRule('subname', 'sub name missing', 'required', null);

              //Subject short name

            $mform->addElement('text', 'shortname','Subject Short Name',$attributes);
            $mform->addRule('shortname', 'sub short name missing', 'required', null);



         //Description 

             $mform->addElement('textarea', 'description','Description','wrap="virtual" rows="5" cols="5"');
             $mform->addRule('description', 'sub description missing', 'required', null);

         //Edit

             $editdata=$DB->get_record('subject',array('course_id'=>$id));


             $academic=$DB->get_record('class',array('id'=>$editdata->sub_class));

             $mform->setDefault('academicyear',$academic->academic_id);

        //  print_r($editdata);exit();
             $mform->setDefault('class',$editdata->sub_class);
             $mform->setDefault('division',$editdata->sub_division);
             $mform->setDefault('subname',$editdata->sub_name);
             $mform->setDefault('shortname',$editdata->sub_shortname);
             $mform->setDefault('description',$editdata->sub_description);
             

             $mform->addElement('html', '</div>');

         //Buttons

             $this->add_action_buttons();

             $mform->addElement('html','<a href = "viewsubject.php" style="text-decoration:none">');
             $mform->addElement('button', 'btn', 'View subjects'); 
             $mform->addElement('html','</a>');
             
             $mform->addElement('html', '</div>');
  
    }

}





?>

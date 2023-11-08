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

class subject_form extends moodleform {

    public function definition() {
        global $DB, $USER, $CFG, $COURSE;

        $mform = $this->_form;

        $mform->addElement('html', '<h2 class="text-center heading mb-5">Subject Creation</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');
        // $editorclasslist = null;
        // $filemanagerclasslist = null;

        $attributes = 'size="30"';

        //-----------Form creation-----------
        //Academic Year 
            $academic  = $DB->get_records('academic_year');
        //    $classes  = $DB->get_records('class');
            $options1 = array();
            $options1=array(''=>'---- Select academic_year ----');
            foreach($academic as $academics){
                $timestart = $academics->start_year;
                $timeend = $academics->end_year;
            $timestart1 = date("d/m/Y", $timestart);
            $timeend1 = date("d/m/Y", $timeend);
            $options1 [$academics->id] =$timestart1.'-'.$timeend1;
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
            //    print_r($options2);
            //    exit;
         //Subject name

             $mform->addElement('text', 'subname','Subject Name',$attributes);
             $mform->addRule('subname', 'sub name missing', 'required', null);
        //Subject short name

            $mform->addElement('text', 'shortname','Subject Short Name',$attributes);
            $mform->addRule('shortname', 'sub short name missing', 'required', null);


         //Description 

             $mform->addElement('textarea', 'description','Description','wrap="virtual" rows="5" cols="5"');
             $mform->addRule('description', 'sub description missing', 'required', null);

         //Teacher    

            //  $teachers  = $DB->get_records('teacher');
            //  $options3 = array();
            //  foreach($teachers as $teacher){
            //  $options3 [$teacher->t_name] = $teacher->t_name;
            //  }
            //  $mform->addElement('select', 'teachname','Teacher name',$options3);


            $mform->addElement('html', '</div>');
             
             $this->add_action_buttons();

             $mform->addElement('html','<a href = "viewsubject.php" style="text-decoration:none">');
             $mform->addElement('button', 'btn', 'View subjects'); 
             $mform->addElement('html','</a>');
  
             $mform->addElement('html', '</div>');
    }

}





?>

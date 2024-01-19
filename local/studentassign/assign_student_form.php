<!-- student_assign -->
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



class assign_student_form extends moodleform {

    public function definition() {
        global $DB, $USER, $CFG, $COURSE;

        $mform = $this->_form;     

        $mform->addElement('html', '<h2 class="text-center heading mb-5">Student Assign</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');
        // $editorclasslist = null;
        // $filemanagerclasslist = null;

        $attributes = 'size="30"';

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

        // //Class       
        $classes = $DB->get_records_sql("SELECT * FROM {class}");     
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

        // Auto complete......................................

        $students = $DB->get_records('student');
        $studentNames = array();
        $studentNames[]='';
        foreach ($students as $student) {
            $studentNames[$student->user_id] = $student->s_ftname; // Assuming the name field in the student table is 'name'
        }

        $options = array(
            'multiple' => true,
            'noselectionstring' => get_string('allareas', 'search'),
        );
        // $mform->addElement('autocomplete', 'areaids', get_string('searcharea', 'search'), $areanames, $options);

        $mform->addElement('autocomplete', 'student', 'Students', $studentNames, $options);

  
    

        $mform->addElement('html', '</div>');
        //moodle button      
        $this->add_action_buttons();
        $mform->addElement('html','<a href = "view_sassign.php" style="text-decoration:none">');
        $mform->addElement('button', 'btn', 'View Assigned Student'); 
        $mform->addElement('html','</a>');
        
        $mform->addElement('html', '</div>');
    }

}





?>

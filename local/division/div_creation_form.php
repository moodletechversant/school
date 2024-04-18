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
class div_creation_form extends moodleform {
    function definition() {
        global $USER, $CFG, $DB ,$SESSION;
        $schoolid  = $SESSION->schoolid;

        $mform = $this->_form;
        $div_view=$CFG->wwwroot.'/local/division/div_view.php';

        $mform->addElement('html', '<h2 class="text-center heading mb-5">Division creation</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');

       // $id= optional_param('id', 0, PARAM_INT);   
// print_r($id);exit();
        $mform->addElement('hidden','school_id',$school_id);

       //$schoolid=1;
//-----------Form creation-----------

         //Academic Year 
        //  $academic  = $DB->get_records('academic_year'); 
         $academic = $DB->get_records('academic_year', array('school' => $schoolid));
             //    $classes  = $DB->get_records('class');
       $options1 = array();
       $options1=array(''=>'---- Select academic_year ----');
       foreach($academic as $academics){
       $options1 [$academics->id] = date("d-m-Y",$academics->start_year);
       }

       $mform->addElement('select', 'academic','Academic Year',$options1);

        
         //Class 
        // $current_year = date("Y");
        // $clist = $DB->get_records_sql("SELECT * FROM {class} WHERE YEAR(FROM_UNIXTIME(time_start)) = $current_year");
        $classes  = $DB->get_records('class');
            $options1 = array();
            $options1=array(''=>'---- Select a class ----');
            foreach($classes as $class){
            $options1 [$class->id] = $class->class_name;
            }

        $mform->addElement('select', 'class','Class',$options1);
        
        //division 
        $mform->addElement('text', 'name', 'div Name'); 
        $mform->addRule('name', 'div name missing', 'required', null);

        

        $mform->addElement('text', 'bstrength', 'No of boys');
        $mform->addRule('bstrength', 'No of boys missing', 'required', null);
        $mform->setDefault('bstrength',0);

        $mform->addElement('text', 'gstrength', 'No of girls');
        $mform->addRule('gstrength', 'No of girls missing', 'required', null);
        $mform->setDefault('gstrength',0);

        $mform->addElement('text', 'strength', 'Total strength');
        $mform->addRule('strength', 'div strength missing', 'required', null);

        $mform->addElement('textarea', 'description', 'Description about Division');


        $mform->addElement('html', '</div>');

        $this->add_action_buttons();
        $mform->addElement('html','<a href = "'.$div_view.'" style="text-decoration:none">');
        $mform->addElement('button', 'btn', 'View divisions'); 
        $mform->addElement('html','</a>');

        $mform->addElement('html', '</div>');
        
    }   
}  
    

    
    


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

class class_creation_form extends moodleform {
    function definition() {
       // $userid  = optional_param('userid', 0, PARAM_INT);
        $urlto=$CFG->wwwroot.'/local/class/class_creation.php';
        global $USER, $CFG, $DB;
        $classview=$CFG->wwwroot.'/local/class/classview.php';
        $table = new html_table();
        $id  = optional_param('id', 0, PARAM_INT);
        $mform = $this->_form;
        $mform->addElement('html', '<h2 class="text-center heading mb-5">Class creation</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');

     
         // $mform->addElement('text', 'name', 'Class Name', 'maxlength="100" size="30"');
        $mform->addElement('text', 'name', 'Class Name'); 
        $mform->addRule('name', 'Class name missing', 'required', null); // Add elements to your form

     

        $academic  = $DB->get_records_sql("SELECT * FROM {academic_year} WHERE id=$id");
        $options1 = array();
        $options1=array(''=>'---- Select academic start year ----');
        foreach($academic  as $academic1 ){
            $timestart = $academic1->start_year;
        $timestart1 = date("d-m-Y", $timestart);
        $options1 [$academic1 ->id] = $timestart1;
        }

        $mform->addElement('select', 'academicyear','Academic start',$options1);
        $mform->addRule('academicyear', 'academic year missing', 'required', null);
        
        $options2 = array();
        $options2=array(''=>'---- Select academic end year ----');
        foreach($academic  as $academic2 ){
            $timestart = $academic2->end_year;
        $timestart1 = date("d-m-Y", $timestart);
        $options2 [$academic2 ->id] = $timestart1;
        }
        $mform->addElement('select', 'academicyear1','Academic end',$options2);

        $js = <<<JS
        document.addEventListener("DOMContentLoaded", function() {
        var selectElement = document.getElementById("id_academicyear1");
        selectElement.disabled = true;
        });
        JS;

        // Add the JavaScript to the form
        $mform->addElement('html', "<script>{$js}</script>");

        $mform->addElement('textarea', 'description', 'Description about Class');
        // $mform->addElement('textarea', 'description', 'Description about Class');
        $mform->addElement('html', '</div>');
        $this->add_action_buttons();

        $mform->addElement('html','<a href ='. $classview.'  style="text-decoration:none">');
        $mform->addElement('button', 'btn', 'View Class list'); 
        $mform->addElement('html','</a>');
        $mform->addElement('html', '</div>');
        
    }
    
  
}
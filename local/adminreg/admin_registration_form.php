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

class admin_registration_form extends moodleform {
    function definition() {
        
       // $userid  = optional_param('userid', 0, PARAM_INT);
        $urlto=$CFG->wwwroot.'/local/adminreg/admin_registration.php';
        global $USER, $CFG, $DB;
        $classview=$CFG->wwwroot.'/local/adminreg/admin_registration.php';
        $table = new html_table();
        $id  = optional_param('id', 0, PARAM_INT);
        $mform = $this->_form;
        $mform->addElement('html', '<h2 class="text-center heading mb-5">Admin creation</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');

     
        $mform->addElement('text', 'name', 'Name'); 
        $mform->addRule('name', 'Admin name missing', 'required', null); // Add elements to your form

        $mform->addElement('text', 'username', 'username'); 
        $mform->addRule('username', 'Admin username missing', 'required', null); // Add elements to your form


        $mform->addElement('text', 'email', 'email'); 
        $mform->addRule('email', 'Admin email missing', 'required', null); // Add elements to your form

        $mform->addElement('password', 'password', 'password'); 
        $mform->addRule('password', 'Admin password missing', 'required', null); // Add elements to your form
       
        $mform->addElement('text', 'number', 'phone number'); 
        $mform->addRule('number', 'Admin phone number missing', 'required', null); // Add elements to your form

        $schools  = $DB->get_records_sql("SELECT * FROM {school_reg}");
        $options1 = array();
        $options1=array(''=>'---- Select school ----');
        foreach($schools  as $school ){
            $sch_name = $school->sch_name;
        $options1 [$school ->id] = $sch_name;
        }

        $mform->addElement('select', 'school','school',$options1);
        $mform->addRule('school', 'school missing', 'required', null);

        $mform->addElement('html', '</div>');
        $this->add_action_buttons();

        $mform->addElement('html','<a href ='. $classview.'  style="text-decoration:none">');
        $mform->addElement('button', 'btn', 'View Class list'); 
        $mform->addElement('html','</a>');
        $mform->addElement('html', '</div>');
        
    }
    
  
}
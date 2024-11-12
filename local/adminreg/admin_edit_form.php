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

class editacademic_form extends moodleform {
    function definition() {

        $urlto=$CFG->wwwroot.'/local/adminreg/admin_edit.php';
        global $USER, $CFG, $COURSE, $DB, $SESSION;
        $mform = $this->_form;

        $id  = optional_param('id', 0, PARAM_INT);
        $school_id  = $SESSION->schoolid;
        $mform->addElement('html', '<h2 class="text-center heading mb-5">Edit Admin Details</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');
        $mform->addElement('hidden','id',$id);
        $mform->addElement('hidden','school_id',$school_id);
        
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

        $editdata=$DB->get_record('admin_registration',array('id'=>$id));

        $mform->setDefault('name',$editdata->name);
        $mform->setDefault('username',$editdata->username);
        $mform->setDefault('email',$editdata->email);
        $mform->setDefault('password',$editdata->password);
        $mform->setDefault('number',$editdata->number);
        $mform->addElement('html', '</div>');
        $this->add_action_buttons();
        $mform->addElement('html', '</div>');
       
    }
    
  
}
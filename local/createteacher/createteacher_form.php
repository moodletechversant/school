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
class createteacher_form extends moodleform {
    function definition() {
        global $USER, $CFG, $DB;
        $view_teacher = $CFG->wwwroot.'/local/createteacher/view_teacher.php';
        
        $mform = $this->_form;
        $mform->addElement('html', '<h2 class="text-center heading mb-5">Teacher creation</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');

        $id  = optional_param('id', 0, PARAM_INT);

        $mform->addElement('hidden','id',$id);


        $mform->addElement('text', 'fstname', 'Teacher First Name'); 
        $mform->addRule('fstname', 'First name  missing', 'required', null);

        $mform->addElement('text', 'midlname', 'Middle  Name'); 
        $mform->addRule('midlname', ' Middle Name missing', null);

        $mform->addElement('text', 'lsname', 'Last Name'); 
        $mform->addRule('lsname', 'Last Name missing', 'required', null);


        // $mform->addElement('password', 'password1', 'Enter your password'); 
        // $mform->addRule('password1', 'Password field missing', 'required', null);
        $mform->addElement('text', 'username', 'Username'); 
        $mform->setType('username', PARAM_RAW);
        $mform->addRule('username', 'Username missing', 'required', null);

        // $mform->addElement('text', 'email', 'Email Address'); 
        // $mform->addRule('email', 'email missing', 'required', null);
        $mform->addElement('text', 'email', 'Email Address');
        $mform->addRule('email', 'Enter a valid email', 'email', null, 'client');
        $mform->addRule('email', 'Email is required', 'required', null, 'client');

        $mform->addElement('passwordunmask', 'password', get_string('password'), 'size="20"');
        $mform->addRule('password', 'Password field missing', 'required', null);
        $mform->disabledIf('password', 'auth', 'in', $cannotchangepass);

        // $mform->addHelpButton('password', 'password');
        $mform->setType('password', core_user::get_property_type('password'));
        
        $mform->addElement('date_selector', 'dob','Dob', get_string('from'));
        $mform->addRule('dob', 'dob missing', 'required', null);

        $mform->addElement('textarea', 'address', 'Address');
        $mform->addRule('address', 'address missing', 'required', null);

        $mform->addElement('text', 'no', 'Mobile no.','maxlength="10"'); 
        $mform->addRule('no', 'Mobile no missing', 'required', null);

        // $mform->addElement('text', 'fname', 'Name of Father'); 
        // $mform->addRule('fname', 'father name missing', 'required', null);


        // $mform->addElement('text', 'mname', 'Name of Mother'); 
        // $mform->addRule('mname', 'mother name missing', 'required', null);

        $mform->addElement('text', 'bg', 'Blood group');
 
        $mform->addElement('text', 'qln', 'Qualification'); 
        $mform->addRule('mname', 'Qualification missing', 'required', null);

        $mform->addElement('text', 'exp', 'Experience'); 
        

        $mform->addElement('radio', 'gender', 'Gender', 'Male', 'male');
            $mform->addElement('radio', 'gender', '', 'Female', 'female');
            $mform->addElement('radio', 'gender', '', 'others', 'others');
 

            $options = array();
            $options ['Alappuzha'] = 'Alappuzha';
            $options ['Ernakulam'] = 'Ernakulam';
            $options ['Idukki'] = 'Idukki';
            $options ['Kannur'] = 'Kannur';
            $options ['Kasargod'] = 'Kasargod';
            $options ['Kollam'] = 'Kollam';
            $options ['Kottayam'] = 'Kottayam';
            $options ['Kozhikode'] = 'Kozhikode';
            $options ['Malappuram'] = 'Malappuram';
            $options ['Palakkad'] = 'Palakkad';
            $options ['Pathanamthitta'] = 'Pathanamthitta';
            $options ['Thiruvanandapuram'] = 'Thiruvanandapuram';
            $options ['Thrissur'] = 'Thrissur';
            $options ['Wayanad'] = 'Wayanad';
            
            $mform->addElement('select', 'district', 'Select Your District', $options);

        $mform->addElement('html', '</div>');
        $this->add_action_buttons();
        $mform->addElement('html','<a href = "'.$view_teacher.'" style="text-decoration:none">');
        $mform->addElement('button', 'btn', 'View teachers'); 
        $mform->addElement('html','</a>');
        
        $mform->addElement('html', '</div>');
    }

    public function validation($data, $files) {
        global $DB;
        $errors = parent::validation($data, $files);
        if (!empty($data['bg'])) {
        $validBloodGroups = array('A', 'B', 'AB', 'O');
        $enteredBloodGroup = strtoupper($data['bg']);
        if (!in_array($enteredBloodGroup, $validBloodGroups)) {
        $errors['bg'] = "Invalid blood group";
        }
        }
        return $errors;
        }

      

    }
    


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

class editteacher_form extends moodleform {
    function definition() {
        global $USER, $CFG, $COURSE, $DB;
        $urlto=$CFG->wwwroot.'/local/createteacher/editteacher.php';
     
        $mform = $this->_form;
        $mform->addElement('html', '<h2 class="text-center heading mb-5">Update Teacher</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');

        // $table = new html_table();
        $id  = optional_param('id', 0, PARAM_INT);
        $mform->addElement('hidden','id',$id);
        $mform->addElement('text', 'fstname', 'Teacher First Name'); 
        $mform->addRule('fstname', 'First name  missing', 'required', null);

        $mform->addElement('text', 'midlname', 'Teacher Middle  Name'); 
        $mform->addRule('midlname', ' Middle Name missing', null);

        $mform->addElement('text', 'lsname', 'Teacher Last Name'); 
        $mform->addRule('lsname', 'Last Name missing', 'required', null);

        $mform->addElement('text', 'username', 'Username'); 
        $mform->setType('username', PARAM_RAW);
        $mform->addRule('username', 'Username missing', 'required', null);
        $mform->addElement('text', 'email', 'Email Address');
        $mform->addRule('email', 'Enter a valid email', 'email','client');
        $mform->addRule('email', 'Email address is required', 'required', null);
        $mform->addElement('passwordunmask', 'password', get_string('password'), 'size="20"');
        $mform->addRule('password', 'Password field missing', 'required', null);
        $mform->disabledIf('password', 'auth', 'in', $cannotchangepass);
       
        $mform->addElement('date_selector', 'dob','Dob', get_string('from'));
        $mform->addRule('dob', 'dob missing', 'required', null);

        $mform->addElement('textarea', 'address', 'Address');
        $mform->addRule('address', 'address missing', 'required', null);

        $mform->addElement('text', 'no', 'Mobile no.','maxlength="10"'); 
        $mform->addRule('no', 'Mobile no missing', 'required', null);


        $mform->addElement('text', 'bg', 'Blood group');
        $mform->addRule('bg', 'Blood group is required', 'required', null);

        $mform->addElement('text', 'qln', 'Qualification'); 
        $mform->addRule('qln', 'Qualification missing', 'required', null);

        $mform->addElement('text', 'exp', 'Experience'); 
        $mform->addRule('exp', ' Experience is required', 'required', null);


        $mform->addElement('radio', 'gender', 'Gender', 'Male', 'male');
            $mform->addElement('radio', 'gender', '', 'Female', 'female');
            $mform->addElement('radio', 'gender', '', 'others', 'others');
            $mform->addRule('gender', ' Gender is required', 'required', null);

            $options = array(
                '' => 'Select a district', // Initial option
                'Alappuzha' => 'Alappuzha',
                'Ernakulam' => 'Ernakulam',
                'Idukki' => 'Idukki',
                'Kannur' => 'Kannur',
                'Kasargod' => 'Kasargod',
                'Kollam' => 'Kollam',
                'Kottayam' => 'Kottayam',
                'Kozhikode' => 'Kozhikode',
                'Malappuram' => 'Malappuram',
                'Palakkad' => 'Palakkad',
                'Pathanamthitta' => 'Pathanamthitta',
                'Thiruvanandapuram' => 'Thiruvanandapuram',
                'Thrissur' => 'Thrissur',
                'Wayanad' => 'Wayanad'
            );
            
            $mform->addElement('select', 'district', 'District', $options);
            $mform->addRule('district', 'District is required', 'required', null);


        $editdata=$DB->get_record('teacher',array('id'=>$id));
 

        $mform->setDefault('fstname',$editdata->t_fname);
        $mform->setDefault('midlname',$editdata->t_mname);
        $mform->setDefault('lsname',$editdata->t_lname);
        $mform->setDefault('username',$editdata->t_username);
        $mform->setDefault('email',$editdata->t_email);
        $mform->setDefault('dob',$editdata->t_dob);
        $mform->setDefault('address',$editdata->t_address);
        $mform->setDefault('no',$editdata->t_mno);
        $mform->setDefault('bg',$editdata->t_bloodgrp);
        
        $mform->setDefault('qln',$editdata->t_qlificatn);
        $mform->setDefault('exp',$editdata->t_exp);
        $mform->setDefault('gender',$editdata->t_gender);
        $mform->setDefault('district',$editdata->t_district);
        
        $mform->addElement('html', '</div>');
        $this->add_action_buttons();
        $mform->addElement('html', '</div>');
        // $mform->addElement('html','<a href = "div_view.php" style="text-decoration:none">');
        // $mform->addElement('button', 'btn', 'View divisions'); 
        // $mform->addElement('html','</a>');
 
    }
    
    public function validation($data, $files) {
        global $DB;
        $errors = parent::validation($data, $files);
        if (!empty($data['bg'])) {
            $validBloodGroups = array('A-','A+' ,'B+', 'AB+','AB-' ,'O+','O-');
            $enteredBloodGroup = strtoupper($data['bg']);
        if (!in_array($enteredBloodGroup, $validBloodGroups)) {
        $errors['bg'] = "Invalid blood group";
        }
        }
        return $errors;
        }
}
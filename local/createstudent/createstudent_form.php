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
class createstudent_form extends moodleform {
    function definition() {
        global $USER, $CFG, $DB;

        $mform = $this->_form;
        $mform->addElement('html', '<h2 class="text-center heading mb-5">Student creation</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');
        // $id  = optional_param('id', 0, PARAM_INT);

        // $mform->addElement('hidden','id',$id);   
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

        //Personal Details
        $mform->addElement('text', 'fstname', 'Student First Name'); 
        $mform->addRule('fstname', 'First name  missing', 'required', null);

        $mform->addElement('text', 'midlname', 'Student Middle  Name'); 
        $mform->addRule('midlname', ' Middle Name missing', null);

        $mform->addElement('text', 'lsname', 'Student Last Name'); 
        $mform->addRule('lsname', 'Last Name missing', 'required', null);

        $mform->addElement('text', 'username', 'Username'); 
        $mform->addRule('username', 'Username missing', 'required', null);

        // $mform->addElement('text', 'email', 'Email Address'); 
        // $mform->addRule('email', 'email missing', 'required', null);
        $mform->addElement('text', 'email', 'Email Address');
        $mform->addRule('email', 'Enter a valid email', 'email', null, 'client');
        $mform->addRule('email', 'Email is required', 'required', null, 'client');

        $mform->addElement('passwordunmask', 'password', get_string('password'), 'size="20"');
        $mform->addRule('password', 'Password field missing', 'required', null);
        $mform->disabledIf('password', 'auth', 'in', $cannotchangepass);



      
       
        $mform->addElement('date_selector', 'dob','Dob', get_string('from'));
        $mform->addRule('dob', 'dob missing', 'required', null);

        $mform->addElement('textarea', 'address', 'Address');
        $mform->addRule('address', 'address missing', 'required', null);

        $mform->addElement('text', 'fname', 'Name of Father'); 
        $mform->addRule('fname', 'father name missing', 'required', null);

        $mform->addElement('text', 'fno', 'Mobile no.','maxlength="10"'); 
        $mform->addRule('fno', 'Mobile no.missing', 'required', null);
 
 
        $mform->addElement('text', 'mname', 'Name of Mother'); 
        $mform->addRule('mname', 'mother name missing', 'required', null);

        $mform->addElement('text', 'mno', 'Mobile no.','maxlength="10"'); 
        $mform->addRule('mno', 'Mobile no.missing', 'required', null);
 
 
        $mform->addElement('text', 'gname', 'Name of Gurdian'); 
        $mform->addRule('gname', 'Gurdian name missing', 'required', null);

        $mform->addElement('text', 'gno', 'Mobile no.','maxlength="10"'); 
        $mform->addRule('gno', 'Mobile no.missing', 'required', null);
 

        $mform->addElement('text', 'bg', 'Blood group'); 


        $mform->addElement('radio', 'gender', 'Gender', 'Male', 'male');
        $mform->addElement('radio', 'gender', '', 'Female', 'female');
        $mform->addElement('radio', 'gender', '', 'others', 'others');
        // $mform->addRule('gender', 'gender missing', 'required', null);
 

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
        
        $mform->addElement('select', 'district', 'District', $options);

        //Class 
               // $current_year = date("Y");
               // $clist = $DB->get_records_sql("SELECT * FROM {class} WHERE YEAR(FROM_UNIXTIME(time_start)) = $current_year");
               $classes  = $DB->get_records('class');
               $options1 = array();
               $options1=array(''=>'---- Select a class ----');
               foreach($classes as $class){
                   $options1 [$class->id] = $class->class_name;
               }
      
              $mform->addElement('select', 'class','Select Class you applying',$options1);

    
   
        //$mform->addRule('bg', 'div name missing', 'required', null);


        // $clist  = $DB->get_records('class');
        // $options1 = array();
        // foreach($clist as $list){
        // $options1 [$list->class_name] = $list->class_name;
        // }
        // $mform->addElement('select', 'cname', 'Class Name', $options1); 

      
        // $dlist  = $DB->get_records('division');
        // $options2 = array();

        // foreach($dlist as $list){
        // $options2 [$list->div_name] = $list->div_name;
        // }
        // $mform->addElement('select', 'dname','Division', $options2); 

      
        
       
      
        $mform->addElement('html', '</div>');
      
        $this->add_action_buttons();
        $mform->addElement('html','<a href = "view_student_1.php" style="text-decoration:none">');
        $mform->addElement('button', 'btn', 'View students'); 
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
    


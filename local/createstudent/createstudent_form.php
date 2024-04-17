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
        global $USER, $CFG, $DB, $SESSION;
        $returnurl = $CFG->wwwroot.'/local/createstudent/view_student_1.php';
        $schoolid  = $SESSION->schoolid;

        $mform = $this->_form;
        $mform->addElement('html', '<h2 class="text-center heading mb-5">Student creation</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');
        // $id  = optional_param('id', 0, PARAM_INT);

        // $mform->addElement('hidden','id',$id);   
        //Academic Year 
        $academic  = $DB->get_records_sql("SELECT * FROM {academic_year} WHERE school = $schoolid");
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
        $mform->addRule('email', 'Enter a valid email', 'email','client');
        $mform->addRule('email', 'Email address is required', 'required', null);
        
       // $mform->addRule('email', 'Email is required', 'required', null, 'client');

        $mform->addElement('passwordunmask', 'password', get_string('password'), 'size="20"');
        $mform->addRule('password', 'Password field missing', 'required', null);
        $mform->disabledIf('password', 'auth', 'in', $cannotchangepass);



      
       
        $mform->addElement('date_selector', 'dob','Dob', get_string('from'));
        $mform->addRule('dob', 'dob missing', 'required', null);

        $mform->addElement('textarea', 'address', 'Address');
        $mform->addRule('address', 'address missing', 'required', null);

        $mform->addElement('text', 'fname', 'Name of Father'); 
        $mform->addRule('fname', 'father name missing', 'required', null);

        $mform->addElement('text', 'fno', 'Mobile no.', array('maxlength' => 10));
        $mform->addRule('fno', 'Mobile number must be exactly 10 characters long', 'rangelength', array(10, 10));
        $mform->addRule('fno', 'Mobile number is required', 'required', null);

 
 
        $mform->addElement('text', 'mname', 'Name of Mother'); 
        $mform->addRule('mname', 'mother name missing', 'required', null);

        $mform->addElement('text', 'mno', 'Mobile no.', array('maxlength' => 10));
        $mform->addRule('mno', 'Mobile number must be exactly 10 characters long', 'rangelength', array(10, 10));
        $mform->addRule('mno', 'Mobile number is required', 'required', null);

       
 
 
        $mform->addElement('text', 'gname', 'Name of Gurdian'); 
        $mform->addRule('gname', 'Gurdian name missing', 'required', null);

        $mform->addElement('text', 'gno', 'Mobile no.', array('maxlength' => 10));
        $mform->addRule('gno', 'Mobile number must be exactly 10 characters long', 'rangelength', array(10, 10));
        $mform->addRule('gno', 'Mobile number is required', 'required', null);


       
 

      
        $bloodgroup = array(
            '' => 'Select a blood group', 
            'A+' => 'A+',
            'A-' => 'A-',
            'B+' => 'B+',
            'B-' => 'B-',
            'AB+' => 'AB+',
            'AB-' => 'AB-',
            'O+' => 'O+',
            'O-' => 'O-',
            
        );
        
        $mform->addElement('select', 'bg', 'Blood group', $bloodgroup);
        $mform->addRule('bg', 'Blood group is required', 'required', null);

        $mform->addElement('radio', 'gender', 'Gender', 'Male', 'male');
        
        $mform->addElement('radio', 'gender', '', 'Female', 'female');
        
        $mform->addElement('radio', 'gender', '', 'Others', 'others');
       
    

        $mform->addRule('gender', 'Please select a gender', 'required', null);
        

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
              $mform->addRule('class', 'Class is required', 'required', null);

        //--------Parent section--------//

        $mform->addElement('html', '<h4>Parent details</h4>'); 
        $radioButtons = array();
        $radioButtons[] = $mform->createElement('radio', 'existing', '', 'Yes', 'yes');
        $radioButtons[] = $mform->createElement('radio', 'existing', '', 'No', 'no');
        $select = $mform->addGroup($radioButtons, 'existing_group', 'Are you a registered parent?', array(' '), false);
        $mform->addRule('existing_group', 'This field is required', 'required', null);


        $mform->addElement('html', '<div class="suboption" style="display: none;">'); 
        $parents = $DB->get_records_sql("SELECT * FROM {parent}");
        $subOptions = array('');
        foreach ($parents as $parent) {
            $user_id = $parent->user_id;
            $user_records = $DB->get_records_sql("SELECT * FROM {user} WHERE id = ?", array($user_id));
            foreach ($user_records as $user_record) {
                $label = $user_record->firstname . ' (' . $user_record->email . ')';
                $subOptions[$user_record->id] = $label;
            }
        }
        $subselect = $mform->addElement('autocomplete', 'subselect','' , $subOptions, array('placeholder' => 'Search parent'));

        //--------div for existing children--------//
        $mform->addElement('html', '<div id="details_container">'); 
        $mform->addElement('html', '</div>'); 
        //--------end of div--------//

        // Add a checkbox element to the form
        //$mform->addElement('advcheckbox', 'confirm_checkbox', 'The above given details are correct');


        $mform->addElement('html', '</div>'); 

        //--------Adding the text box to the form--------//
        //$mform->addElement('text', 'child', '', array('value' => $textbox_value, 'disabled' => 'disabled'));
        //-----------------------------------------------//


        // Add onchange attribute to individual radio buttons
        $radioButtons[0]->updateAttributes(array('onchange' => 'showSubDropdown(this)'));
        $radioButtons[1]->updateAttributes(array('onchange' => 'showSubDropdown(this)'));

        //Parent details
        $mform->addElement('html', '<div class="parent_details" style="display: none;">'); 
        $mform->addElement('text', 'p_fstname', 'Parent first name'); 

        $mform->addElement('text', 'p_surname', 'Parent surname'); 
        $mform->addRule('p_surname', ' Surname missing', null);

        $mform->addElement('text', 'p_lsname', 'Parent last name'); 

        $mform->addElement('text', 'p_mno', 'Mobile no.','maxlength="10"'); 

        $mform->addElement('text', 'p_email', 'Email Address');
        $mform->addRule('p_email', 'Enter a valid email', 'email', null, 'client');

        $mform->addElement('text', 'p_username', 'Username'); 

        $mform->addElement('passwordunmask', 'p_password', get_string('password'), 'size="20"');
        $mform->disabledIf('p_password', 'auth', 'in', $cannotchangepass);

        $mform->addElement('html', '</div>');   

        //--------End of parent section--------//

        $mform->addElement('html', '</div>');

        $this->add_action_buttons();
        
        $mform->addElement('html','<a href = "'.$returnurl.'" style="text-decoration:none">');
        $mform->addElement('button', 'btn', 'View students'); 
        $mform->addElement('html','</a>');
        $mform->addElement('html', '</div>'); 
   
    }

//--------Validation for blood group--------//

//  public function validation($data, $files) {
//      global $DB;
//      $errors = parent::validation($data, $files);

//      if (!empty($data['bg'])) {
//         $validBloodGroups = array('A-','A+' ,'B+', 'AB+','AB-' ,'O+','O-');
//         $enteredBloodGroup = strtoupper($data['bg']);
//         if (!in_array($enteredBloodGroup, $validBloodGroups)) {
//         $errors['bg'] = "Invalid blood group. The blood groups are 'A-','A+' ,'B+', 'AB+','AB-' ,'O+','O-'";
//         }
//         }

//      return $errors;
//  }  

}
 


    


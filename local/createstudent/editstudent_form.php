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

class editstudent_form extends moodleform {
    function definition() {

        $urlto=$CFG->wwwroot.'/local/createstudent/editstudent.php';
        global $USER, $CFG, $COURSE, $DB;

        $id  = optional_param('id', 0, PARAM_INT);
        $editdata=$DB->get_record('student',array('id'=>$id));
        $sid=$editdata->user_id;
        $sid_data=$DB->get_record('student_assign',array('user_id'=>$sid));

        // print_r($sid);exit();
        // print_r($sid);exit();
        $mform = $this->_form;
        $mform->addElement('html', '<h2 class="text-center heading mb-5">Student creation</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');
        // $table = new html_table();
      
        // print_r($id);exit();

        $mform->addElement('hidden','id',$id);

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

        
        $mform->addElement('text', 'fstname', 'Student First Name'); 
        $mform->addRule('fstname', 'First name  missing', 'required', null);

        $mform->addElement('text', 'midlname', 'Student Middle  Name'); 
        $mform->addRule('midlname', ' Middle Name missing',  null);

        $mform->addElement('text', 'lsname', 'Student Last Name'); 
        $mform->addRule('lsname', 'Last Name missing', 'required', null);

        $mform->addElement('text', 'username', 'Username'); 
        $mform->addRule('username', 'Username missing', 'required', null);

        $mform->addElement('text', 'email', 'Email Address'); 
        $mform->addRule('email', 'email missing', 'required', null);

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

        if (empty($sid_data)){
            $classes  = $DB->get_records('class');
            $options1 = array();
            $options1=array(''=>'---- Select a class ----');
            foreach($classes as $class){
                $options1 [$class->id] = $class->class_name;
            }
    
           $mform->addElement('select', 'class','Select Class you applying',$options1);
    
        }
        // else{

        // }
   
    
        


        $editdata=$DB->get_record('student',array('id'=>$id));
        // print_r($editdata);exit();
 
        $academic=$DB->get_record('class',array('id'=>$editdata->s_class));

        $mform->setDefault('academicyear',$academic->academic_id);
        $mform->setDefault('fstname',$editdata->s_ftname);
        $mform->setDefault('midlname',$editdata->s_mlname);
        $mform->setDefault('lsname',$editdata->s_lsname );
        $mform->setDefault('username',$editdata->s_username);
        $mform->setDefault('email',$editdata->s_email);
        // $mform->setDefault('password',$editdata->s_name);
        $mform->setDefault('dob',$editdata->s_dob);
        $mform->setDefault('address',$editdata->s_address);
        $mform->setDefault('fname',$editdata->s_fname);
        $mform->setDefault('fno',$editdata->s_fno);
        $mform->setDefault('mname',$editdata->s_mname);
        $mform->setDefault('mno',$editdata->s_mno);
        $mform->setDefault('gname',$editdata->s_gname);
        $mform->setDefault('gno',$editdata->s_gno);
        $mform->setDefault('bg',$editdata->s_bg);
        $mform->setDefault('gender',$editdata->s_gender);
        $mform->setDefault('class',$editdata->s_class);
        
        $mform->addElement('html', '</div>');

        $this->add_action_buttons();
        // $mform->addElement('html','<a href = "div_view.php" style="text-decoration:none">');
        // $mform->addElement('button', 'btn', 'View divisions'); 
        // $mform->addElement('html','</a>');
        $mform->addElement('html', '</div>');
      
    }
    
  
}
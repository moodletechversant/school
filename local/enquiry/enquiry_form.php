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
 * Validate an email address
 *
 * @param string    $email         Email address to validate
 * @param boolean   $domainCheck   Check if the domain exists
 */
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


class enquiry_form extends moodleform {

    public function definition() {
        

        $mform = $this->_form;
      
   
        //enquiry date
        //$mform->addElement('date_selector', 'cdate','Date');
        //$mform->addRule('cdate', 'date missing', 'required', null);

        $mform->addElement('html', '<h2 class="text-center heading mb-5">Enquiry</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');


       
        //subject
        $mform->addElement('textarea', 'esubject','Subject','wrap="virtual" rows="4" cols="5"');
        $mform->addRule('esubject', 'sub description missing', 'required', null);
        
        //enquiry message
        $mform->addElement('textarea', 'emessage','enquiry','wrap="virtual" rows="6" cols="5"');
        $mform->addRule('emessage', 'sub description missing', 'required', null);

        $mform->addElement('html', '</div>');

        $this->add_action_buttons();
        $mform->addElement('html', '</div>');
        //$mform->addElement('html','<a href = "view_student.php" style="text-decoration:none">');
        //$mform->addElement('button', 'btn', 'View students'); 
       // $mform->addElement('html','</a>');
       
       //print_r($user_record);exit();
    
        //$addholiday = '<button style="float:right; margin-right: 20px;margin-bottom:20px; background-color: #0f6cbf; color: white; border: none; border-radius: 5px; padding: 10px 20px;"><a href="/school/local/holiday/addholiday.php" style="text-decoration:none; color:white;"><strong>Add Holiday</strong></a></button>';

    }

}

?>

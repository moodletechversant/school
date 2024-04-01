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

class schoolreg_form extends moodleform {

    public function definition() {
        global $DB, $USER, $CFG, $COURSE;
        $var123=$CFG->wwwroot.'/local/schoolreg/viewschools.php';

        $mform = $this->_form;

        $mform->addElement('html', '<h2 class="text-center heading mb-5">School Creation</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');
       

        $attributes = 'size="30"';

        

             $mform->addElement('text', 'schoolname','School Name',$attributes);
             $mform->addRule('schoolname', 'school name missing', 'required', null);

            $mform->addElement('text', 'shortname','School Short Name',$attributes);
            $mform->addRule('shortname', 'School short name missing', 'required', null);



             $mform->addElement('textarea', 'address','Address','wrap="virtual" rows="5" cols="5"');
             $mform->addRule('address', 'school address missing', 'required', null);

             $options = array(
                '' => 'Select a district', 
                'Thiruvanandapuram' => 'Thiruvanandapuram',
                'Kollam' => 'Kollam',
                'Pathanamthitta' => 'Pathanamthitta',
                'Alappuzha' => 'Alappuzha',
                'Kottayam' => 'Kottayam',
                'Idukki' => 'Idukki',
                'Ernakulam' => 'Ernakulam',
                'Thrissur' => 'Thrissur',
                'Palakkad' => 'Palakkad',
                'Malappuram' => 'Malappuram',
                'Kozhikode' => 'Kozhikode',
                'Wayanad' => 'Wayanad',
                'Kannur' => 'Kannur',
                'Kasargod' => 'Kasargod',
            );
            
            $mform->addElement('select', 'district', 'District', $options);
            $mform->addRule('district', 'District is required', 'required', null); 

            $mform->addElement('text', 'state','State',$attributes);
            $mform->addRule('state', 'state missing', 'required', null);

            $mform->addElement('text', 'pincode','Pincode',$attributes);
            $mform->addRule('pincode', 'pincode missing', 'required', null);

            $mform->addElement('text', 'phone','Phone number',$attributes);
            $mform->addRule('phone', 'Phone number missing', 'required', null);
            $mform->addElement('filepicker', 'logo', 'Add your logo');
            $mform->addRule('logo', 'Logo missing', 'required', null);
            $mform->addElement('html', '</div>');
             
             $this->add_action_buttons();

             $mform->addElement('html','<a href = "'.$var123.'" style="text-decoration:none">');
             $mform->addElement('button', 'btn', 'View schools'); 
             $mform->addElement('html','</a>');
  
             $mform->addElement('html', '</div>');
    }

  
}





?>

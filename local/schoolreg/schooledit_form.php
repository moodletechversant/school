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

class schooledit_form extends moodleform {
    function definition() {
        $urlto=$CFG->wwwroot.'/local/schoolreg/schooledit.php';

        global $USER, $CFG, $COURSE, $DB;

        $id  = optional_param('id', 0, PARAM_INT);
        

        $mform = $this->_form;

        $mform->addElement('html', '<h2 class="text-center heading mb-5">School Creation</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');
        $mform->addElement('hidden','id',$id);

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
        
            $acceptedtypes = (new \core_form\filetypes_util)->normalize_file_types($CFG->courseoverviewfilesext);
            if (in_array('*', $acceptedtypes) || empty($acceptedtypes)) {
                $acceptedtypes = '*';
            }
        
            $overviewfilesoptions = array(
                'maxbytes' => 0,                
                'maxfiles' => 2,  
             
                'accepted_types' => $acceptedtypes            );
            
            $mform->addElement('filemanager', 'logo', 'Add a logo', null, $overviewfilesoptions);
            $mform->addRule('logo', 'Logo is missing', 'required', null);
            
            $summaryfields .= ',logo';
        


        $editschooldata=$DB->get_record('school_reg',array('id'=>$id));
 
      
        $mform->setDefault('schoolname', $editschooldata->sch_name);
        $mform->setDefault('shortname', $editschooldata->sch_shortname );
        $mform->setDefault('address', $editschooldata->sch_address);
        $mform->setDefault('district', $editschooldata->sch_district);
        $mform->setDefault('state', $editschooldata->sch_state);
        $mform->setDefault('pincode', $editschooldata->sch_pincode);
        $mform->setDefault('phone', $editschooldata->sch_phone);
        $mform->setDefault('logo', $editschooldata->sch_logo);
        
        $mform->addElement('html', '</div>');
        

        $this->add_action_buttons();

        $mform->addElement('html', '</div>');
      
    }
  
      

    }
    

  

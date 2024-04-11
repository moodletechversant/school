

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

class academicyear_form extends moodleform {
    function definition() {

        $urlto=$CFG->wwwroot.'/local/academicyear/academicyear.php';
        $view_academic_yr=new moodle_url('/local/academicyear/viewacademicyear.php');

        global $USER, $CFG, $COURSE, $DB;
        $mform = $this->_form;

        $mform->addElement('html', '<h2 class="text-center heading mb-5">Academic Year Creation</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');
        
        // $table = new html_table();
        $school_id  = optional_param('id', 0, PARAM_INT);

        $mform->addElement('hidden','id',$school_id);
        // $mform->addElement('hidden', 'id'); 
        
        $mform->addElement('date_selector', 'timestart', 'Academic start',array(
            'startyear' => 2004, 
            'stopyear'  => 2050,
            'timezone'  => 99,
            'optional'  => false
        ));
        $mform->addElement('date_selector', 'timefinish', 'Academic end',array(
            'startyear' => 2005, 
            'stopyear'  => 2055,
            'timezone'  => 99,
            'optional'  => false
        ));
          
        $mform->addElement('date_selector', 'vacationstart', 'Vacation start',array(
            'startyear' => 2004, 
            'stopyear'  => 2050,
            'timezone'  => 99,
            'optional'  => false
        ));
        $mform->addElement('date_selector', 'vacationend', 'Vacation end',array(
            'startyear' => 2005, 
            'stopyear'  => 2055,
            'timezone'  => 99,
            'optional'  => false
        ));
        

        // $school  = $DB->get_records('school_reg');
        //     $options1 = array();
        //     $options1=array(''=>'---- Select School ----');
        //     foreach($school as $schools){
        //     $options1 [$schools->id] = $schools->sch_name;
        //     }

        //     $mform->addElement('select', 'schools','School',$options1);

      
        $mform->addElement('html', '</div>');

        $this->add_action_buttons();
        $mform->addElement('html','<a href = '.$view_academic_yr.' style="text-decoration:none">');
        $mform->addElement('button', 'btn', 'View Academic year  list'); 
        $mform->addElement('html','</a>');
        $mform->addElement('html', '</div>');
  
       
    }
    
  
}
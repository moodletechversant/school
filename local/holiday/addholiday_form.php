<!-- teacher_assign -->
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

class addholiday_form extends moodleform {

    public function definition() {
        global $DB, $USER, $CFG, $COURSE;

        $mform = $this->_form;

        $mform->addElement('html', '<h2 class="text-center heading mb-5">Add Holiday</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');
         //Academic Year 
         $academic  = $DB->get_records('academic_year');
         //    $classes  = $DB->get_records('class');
             $options1 = array();
             $options1=array(''=>'---- Select academic_year ----');
             foreach($academic as $academics){
                 $timestart = $academics->start_year;
                 $timeend = $academics->end_year;
             $timestart1 = date("d/m/Y", $timestart);
             $timeend1 = date("d/m/Y", $timeend);
             $options1 [$academics->id] =$timestart1.'-'.$timeend1;
             }
             $mform->addElement('select', 'academic','Academic Year',$options1);
        //From date
        $mform->addElement('date_selector', 'fromdate','From Date');
        $mform->addRule('fromdate', 'from date missing', 'required', null);
        
        //To date 
        $mform->addElement('date_selector', 'todate','To Date');
        $mform->addRule('todate', 'to date missing', 'required', null);

        //holiday name
        $mform->addElement('text', 'holidayname', 'Holiday Name'); 
        $mform->addRule('holidayname', 'Holiday name missing', 'required', null); 

        // $mform->addElement('button', 'btn', ' Submit', array(
        //     'style' => 'float:right; margin-right: 20px;margin-bottom:20px; background-color: #0f6cbf; color: white; border: none; border-radius: 5px; padding: 10px 20px;',
        //     'onclick' => "window.location.href='/school/local/holiday/view_holiday.php'",
        // ));
        $mform->addElement('html', '</div>');
        
        $this->add_action_buttons();

        $mform->addElement('html', '</div>');
        
    }
    }
    
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


class demo_form extends moodleform {

    public function definition() {
        global $DB, $USER, $CFG, $COURSE;

        $mform = $this->_form;
        // $editorclasslist = null;
        // $filemanagerclasslist = null;

        $attributes = 'size="30"';

        //$element = $mform->addElement('date_time_selector', 'assesstimestart', get_string('from'), array('optional' => true));
        
        $mform->addElement('html', '<div class="time-picker">');
        $mform->addElement('html', '<label>Time picker</label>');
        $mform->addElement('html', '<br>');
        $mform->addElement('html', '<input type="time" id="appt" name="appt" onchange="updateSelectedTime()">');
        $mform->addElement('html', '<select name="ampm" id="ampm" onchange="updateSelectedTime()">');
        $mform->addElement('html', '<option value="AM">AM</option>');
        $mform->addElement('html', '<option value="PM">PM</option>');
        $mform->addElement('html', '</select>');
        $mform->addElement('html', '</div>');
        $mform->addElement('html', '<br>');

       // $mform->addElement('html', '<input type="text" id="selectedTime" name="selectedTime">');
        $mform->addElement('text','time', 'Selected time', array('id' => 'selectedTime', 'name' => 'selectedTime', 'readonly' => 'readonly'));
        


$this->add_action_buttons();
}
}

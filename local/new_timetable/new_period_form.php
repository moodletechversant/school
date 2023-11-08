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


class new_period_form extends moodleform {

    public function definition() {
        global $DB, $USER, $CFG, $COURSE;

        $mform = $this->_form;
        // $editorclasslist = null;
        // $filemanagerclasslist = null;

        $attributes = 'size="30"';
        $id  = optional_param('id', 0, PARAM_INT);
        // print_r($id );exit();
        //----------Form creation---------//

        //Id
        $mform->addElement('hidden','id',$id);

        // From time
        $options = array();
        for ($h = 0; $h <= 23; $h++) {
            for ($m = 0; $m < 60; $m++) {
                $label = sprintf('%02d:%02d', $h, $m);
                $value = sprintf('%02d:%02d', $h, $m);
                $options[$value] = $label;
            }
        }
        $mform->addElement('select', 'fromtime', "From", $options);
        $mform->addElement('select', 'fromampm', '', array('AM' => 'AM', 'PM' => 'PM'));

        // To time
        $options = array();
        for ($h = 0; $h <= 23; $h++) {
            for ($m = 0; $m < 60; $m++) {
                $label = sprintf('%02d:%02d', $h, $m);
                $value = sprintf('%02d:%02d', $h, $m);
                $options[$value] = $label;
            }
        }
        $mform->addElement('select', 'totime', "To", $options);
        $mform->addElement('select', 'toampm', '', array('AM' => 'AM', 'PM' => 'PM'));

        // Subject
        $subjects = $DB->get_records('subject');
        $options = array(''=>'---- Select a subject ----');
        foreach($subjects as $subject) {
            $options[$subject->sub_name] = $subject->sub_name;
        }
        $mform->addElement('select', 'subject', "Subject", $options);
        $mform->addRule('subject', "subject missing", "required", null);

        // Teacher
        $teachers = $DB->get_records('teacher');
        $options = array(''=>'---- Select teacher ----');
        foreach($teachers as $teacher) {
            $options[$teacher->user_id] = $teacher->t_ftname;
        }
        $mform->addElement('select', 'teacher', "Teacher", $options);
        $mform->addRule('teacher', "teacher missing", "required", null);

        //Break
        // Create a unique ID for the container div using the loop index
        //$container_id = "container_$i";
        $mform->addElement('html', "<div id='id_container'>");
        $mform->addElement('button', 'showtextbutton', 'Add break', array('onclick' => "document.getElementById('id_text').style.display = 'block';"));
        $mform->addElement('html', '</div>');

        // Create a unique ID for the text box div using the loop index
        //$text_id = "text_$i";
        $mform->addElement('html', "<div id='id_text' style='display:none;'>");
        // $mform->addElement('text', "mytext_$i", 'Enter Text');

        //Break type
        $options = array(
            '' => 'Select a break type',
            'first break' => 'First break',
            'lunch break' => 'Lunch break',
            'second break' => 'Second break',
            'third break' => 'Third break'

            
        );
        $select = $mform->addElement('select', 'break', 'Break type', $options);
        // Break fromtime
        $options = array();
        for ($h = 0; $h <= 23; $h++) {
            for ($m = 0; $m < 60; $m++) {
                $label = sprintf('%02d:%02d', $h, $m);
                $value = sprintf('%02d:%02d', $h, $m);
                $options[$value] = $label;
            }
        }
        $mform->addElement('select', 'b_fromtime', "Break from-time", $options);
        $mform->addElement('select', 'b_fromampm', '', array('AM' => 'AM', 'PM' => 'PM'));

        // Break totime
        $options = array();
        for ($h = 0; $h <= 23; $h++) {
            for ($m = 0; $m < 60; $m++) {
                $label = sprintf('%02d:%02d', $h, $m);
                $value = sprintf('%02d:%02d', $h, $m);
                $options[$value] = $label;
            }
        }
        $mform->addElement('select', 'b_totime', "Break to-time", $options);
        $mform->addElement('select', 'b_toampm', '', array('AM' => 'AM', 'PM' => 'PM'));

        //Remove break button
        $mform->addElement('button', 'hidetextbutton', 'Remove break', array('onclick' => "resetBreak(); document.getElementById('id_text').style.display = 'none';"));        
        $mform->addElement('html', '</div>');

        $this->add_action_buttons();

    }
}
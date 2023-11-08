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


class timetable_form extends moodleform {

    public function definition() {
        global $DB, $USER, $CFG, $COURSE;

        $mform = $this->_form;
        // $editorclasslist = null;
        // $filemanagerclasslist = null;

        $attributes = 'size="30"';

        //-----------Form creation-----------

        $mform->addElement('html', '<h2 class="text-center heading mb-5">Time-table creation</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');

        $period = "SELECT t_periods FROM {new_timetable_periods} ORDER BY id DESC LIMIT 1";
        $rec = $DB->get_records_sql($period);
        $period1 = $DB->get_record_sql("SELECT t_division FROM {new_timetable_periods} ORDER BY id DESC LIMIT 1");
        $div=$period1->t_division;
        // print_r($period1->t_division);exit();
        $num_periods = reset($rec)->t_periods;
        // print_r($period1);exit();
        $mform->addElement('text', 'last_period', 'Number of periods', array('value' => $num_periods,'disabled' => 'disabled'));


        // loop to add elements for each period
        for ($i = 1; $i <= $num_periods; $i++) {

            // Period header
            $mform->addElement('html', '<h2>Period ' . $i . '</h2>');
            
            // From time
            $options = array();
            for ($h = 0; $h <= 23; $h++) {
                for ($m = 0; $m < 60; $m++) {
                    $label = sprintf('%02d:%02d', $h, $m);
                    $value = sprintf('%02d:%02d', $h, $m);
                    $options[$value] = $label;
                }
            }
            $mform->addElement('select', "fromtime_$i", "From", $options);
            $mform->addElement('select', "fromampm_$i", '', array('AM' => 'AM', 'PM' => 'PM'));
        
            // To time
            $options = array();
            for ($h = 0; $h <= 23; $h++) {
                for ($m = 0; $m < 60; $m++) {
                    $label = sprintf('%02d:%02d', $h, $m);
                    $value = sprintf('%02d:%02d', $h, $m);
                    $options[$value] = $label;
                }
            }
            $mform->addElement('select', "totime_$i", "To", $options);
            $mform->addElement('select', "toampm_$i", '', array('AM' => 'AM', 'PM' => 'PM'));

            // // Subject
            // $subjects = $DB->get_records('subject');
            // $options = array(''=>'---- Select a subject ----');
            // foreach($subjects as $subject) {
            //     $options[$subject->sub_name] = $subject->sub_name;
            // }
            // $mform->addElement('select', "subject_$i", "Subject", $options);
            // $mform->addRule("subject_$i", "subject missing", "required", null);

            $subjects=$DB->get_records_sql("SELECT * FROM mdl_subject WHERE sub_division='$div'");
            // print_r($subjects);exit();
            $options = array(''=>'---- Select a subject ----');
            foreach($subjects as $subject) {
                    $options[$subject->course_id] = $subject->sub_name;
                }
                // print_r($options);exit();
            $mform->addElement('select', "subject_$i", "Subject", $options);
            $mform->addRule("subject_$i", "subject missing", "required", null);
            // print_r($subjects);exit();

            // Teacher
            $teachers = $DB->get_records('teacher');
            $options = array(''=>'---- Select teacher ----');
            foreach($teachers as $teacher) {
                $options[$teacher->user_id] = $teacher->t_fname;
            }
            $mform->addElement('select', "teacher_$i", "Teacher", $options);
            $mform->addRule("teacher_$i", "teacher missing", "required", null);

            // Break
            // Create a unique ID for the container div using the loop index
            $container_id = "container_$i";
            $mform->addElement('html', "<div id='$container_id'>");
            $mform->addElement('button', "showtextbutton_$i", 'Add break', array('onclick' => "document.getElementById('text_$i').style.display = 'block';"));
            $mform->addElement('html', '</div>');

            // Create a unique ID for the text box div using the loop index
            $text_id = "text_$i";
            $mform->addElement('html', "<div id='$text_id' style='display:none;'>");
            // $mform->addElement('text', "mytext_$i", 'Enter Text');

            // Break type
            $options = array(
                '' => 'Select a break type',
                'first break' => 'First break',
                'lunch break' => 'Lunch break',
                'second break' => 'Second break',
                'third break' => 'Third break'                
            );
            $select = $mform->addElement('select', "break_$i", 'Break type', $options);

            // Break fromtime
            $options = array();
            for ($h = 0; $h <= 23; $h++) {
                for ($m = 0; $m < 60; $m++) {
                    $label = sprintf('%02d:%02d', $h, $m);
                    $value = sprintf('%02d:%02d', $h, $m);
                    $options[$value] = $label;
                }
            }
            $mform->addElement('select', "b_fromtime_$i", "Break from-time", $options);
            $mform->addElement('select', "b_fromampm_$i", '', array('AM' => 'AM', 'PM' => 'PM'));

            // Break totime
            $options = array();
            for ($h = 0; $h <= 23; $h++) {
                for ($m = 0; $m < 60; $m++) {
                    $label = sprintf('%02d:%02d', $h, $m);
                    $value = sprintf('%02d:%02d', $h, $m);
                    $options[$value] = $label;
                }
            }
            $mform->addElement('select', "b_totime_$i", "Break to-time", $options);
            $mform->addElement('select', "b_toampm_$i", '', array('AM' => 'AM', 'PM' => 'PM'));

            // Remove break button
            $mform->addElement('button', "hidetextbutton_$i", 'Remove break', array('onclick' => "resetBreak($i); document.getElementById('text_$i').style.display = 'none';"));        
            $mform->addElement('html', '</div>');
            }
             $mform->addElement('html', '</div>');
             
            $this->add_action_buttons();
            $mform->addElement('html', '</div>');

}

}

?>

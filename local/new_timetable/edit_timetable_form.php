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


class edit_timetable_form extends moodleform {

    public function definition() {
        global $DB, $USER, $CFG, $COURSE;


        $mform = $this->_form;
        // $editorclasslist = null;
        // $filemanagerclasslist = null;

        $attributes = 'size="30"';

        $id  = optional_param('id', 0, PARAM_INT);
        //print_r($id);exit();

        //-----------Form creation-----------

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
        $test=$mform->addElement('select', 'fromtime', "From", $options);
        // print_r($test);exit();
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

        $editdata=$DB->get_record('new_timetable',array('id'=>$id));
        //print_r($editdata->period_id);exit();
         $mform->addElement('hidden','period_id',$editdata->period_id);
         $mform->setDefault('fromtime', $editdata->from_time);
                  //print_r($demo);exit();
             $mform->setDefault('totime',$editdata->to_time);
             $mform->setDefault('subject',$editdata->t_subject);
             $mform->setDefault('teacher',$editdata->t_teacher);
             $mform->setDefault('break',$editdata->break_type);
             $mform->setDefault('b_fromtime',$editdata->break_ftime);
             //print_r($editdata->from_time);exit();
             $mform->setDefault('b_totime',$editdata->break_ttime);
            //  print_r($editdata->break_type);exit();

            //Break
        if (empty($editdata->break_type)) {
            $mform->addElement('button', "showtextbutton", 'Add break', array(
                'onclick' => "document.getElementById('text').style.display = 'block';"
            ));
                    
        

        // Create a unique ID for the text box div using the loop index
        //$text_id = "text_$i";
        $mform->addElement('html', "<div id='text' style='display:none;'>");
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
        $mform->addElement('button', "hidetextbutton", 'Remove break', array('onclick' => "document.getElementById('text').style.display = 'none'; resetBreak();"));        
        
        $mform->addElement('html', '</div>');
    }
    else{
        $mform->addElement('html', "<div id='text' style='display:block;'>");
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

        $mform->addElement('html', '</div>');

        //Remove break button
        $mform->addElement('button', "hidetextbutton", 'Remove break', array('id' => 'toggleButton', 'onclick' => "var textElement = document.getElementById('text'); 
        if (textElement.style.display === 'none') { 
            textElement.style.display = 'block';
            document.getElementById('toggleButton').innerHTML = 'Remove break';
            } 
            else { 
                textElement.style.display = 'none'; 
                document.getElementById('toggleButton').innerHTML = 'Add break'; 
            }
                resetBreak();"));
        // $mform->addElement('button', "hidetextbutton", 'Remove break', array('onclick' => "document.getElementById('text').style.display = 'none'; resetBreak();"));        

       
    }

        $this->add_action_buttons();

       // $mform->addElement('html','<a href = "delete_timetable.php?id=' . $id . '&period_id='.$editdata->period_id.'" onclick="return confirm(\'Are you sure you want to delete this period?\')" style="text-decoration:none">');
        $mform->addElement('html','<a href="delete_timetable.php?id=' . $id . '&period_id=' . $editdata->period_id . '" onclick="return confirm(\'Are you sure you want to delete this period?\')" style="text-decoration:none">');
        $mform->addElement('button', 'btn', 'Delete this period'); 
        $mform->addElement('html','</a>');

            //  $button1 = $mform->addElement('button', 'my_button1', '<i class="fa fa-plus" style="font-size:24px"></i>', array('class' => 'btn', 'onclick' => 'myFunction1()'));
            //  $button2 = $mform->addElement('button', 'my_button2', '<i class="fa fa-plus" style="font-size:24px"></i>', array('class' => 'btn', 'onclick' => 'myFunction2()'));
            

}

 
}

?>

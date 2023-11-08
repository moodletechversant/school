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

class periods_form extends moodleform {

    public function definition() {
        global $DB, $USER, $CFG, $COURSE;

        $mform = $this->_form;
        // $editorclasslist = null;
        // $filemanagerclasslist = null;

        $attributes = 'size="30"';

        $id  = optional_param('id', 0, PARAM_INT);
        // print_r($id);exit();

        //-----------Form creation-----------

            $mform->addElement('html', '<h2 class="text-center heading mb-5">Time-table creation</h2>');
            $mform->addElement('html', '<div class="container">');
            $mform->addElement('html', '<div class="form-class">');

            //Id
            $mform->addElement('hidden','id',$id);

            //Class 
            $classes  = $DB->get_records('class');
            $days1 = array();
            //$days1=array(''=>'---- Select a class ----');
            foreach($classes as $class){
            $days1 [$class->id] = $class->class_name;
            }
            $mform->addElement('select', 'class','Class',$days1);
            $mform->addRule('class', 'class missing', 'required', null);

            //Division
            $divisions  = $DB->get_records('division');
            $options2 = array();
            $options2=array(''=>'---- Select a division ----');
            foreach($divisions as $division){
            $options2 [$division->id] = $division->id;
            }
            $mform->addElement('select', 'division','Division',$options2);

            //Day
            $days = $DB->get_records('days');
            $days2 = array();
            foreach($days as $day){
                // $select = $DB->get_record('new_timetable_periods', array('t_day' => $day->id));
                // if(!$select){
                    $days2[$day->id] = $day->days;
                // }
            }
            $mform->addElement('select', 'day', 'Day', $days2);

            // if($selected_day = $mform->getElementValue('day')){
            //     $mform->disabledIf('day', "id=$selected_day");
            // }

            //Number of periods
            $mform->addElement('text', 'periods','Number of periods', array('style' => 'width: 120px;'));
            // $mform->getElement('periods')->setAttributes(array('style' => 'width: 130px;'));


            $mform->addElement('html', '</div>');


             $this->add_action_buttons();

             $mform->addElement('html','<a href = "/school/local/new_timetable/admin_view.php" style="text-decoration:none">');
             $mform->addElement('button', 'btn', 'View'); 
             $mform->addElement('html','</a>');

             $mform->addElement('html', '</div>');

  

            
  
  
    }

}





?>



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

class teacherdiary_form extends moodleform {

    public function definition() {
        global $DB, $USER, $CFG, $COURSE;
        $mform = $this->_form;
        $attributes = 'size="30"';
        $attributes1 = array('style' => 'width:500px; height:50px;');

        //-----------Form creation-----------

        // $id  = optional_param('id', 0, PARAM_INT);
        // $mform->addElement('hidden','id',$id);

        //Select a student
        $mform->addElement('html','<div class="journal-label">');
        $mform->addElement('html','<label class=stdselect>Select a student / students to notify</label>');
        $mform->addElement('html','</div>');
        
        //$mform->addElement('html','<br>');

            $student  = $DB->get_records('student');
            $stud = array('0' => 'Select All');
            foreach($student as $students){
            $stud [$students->user_id] = $students->s_ftname;
            
            }
            //$mform->addElement('select', 'student', '', $stud, array('id' => 'myList'));

            $size='size="30"';
            $options = array(                                                                                                           
                'multiple' => true,
                'id' => 'stud-select'                                                 
                //'noselectionstring' => 'select a student',                                                              
            );               
            $mform->addElement('autocomplete', 'student','' , $stud, $options);
            
        //Subject of diary
        $mform->addElement('html','<div class="journal-label">');
        $mform->addElement('text', 'subject','Subject',array('style' => 'width: 500px; height: 50px;'));
        $mform->addRule('subject', 'subject missing', 'required', null);
        $mform->addElement('html','</div>');
        
        //Content
        $mform->addElement('html','<div class="journal-label">');
        $mform->addElement('textarea', 'content', 'Content', array('style'=>'width: 500px; height: 300px;'));
        $mform->addRule('content', 'content missing', 'required', null);

        $mform->addElement('html','</div>');

        //Option
        $mform->addElement('html','<div class="journal-label">');
        $options = array(
            'leave' => 'Leave',
            'complaint' => 'Complaint',
            'events' => 'Events',
            'academics' => 'Academics',
            'others' => 'Others',
        );
        $select = $mform->addElement('select', 'option', 'Option', $options, array('style' => 'width: 200px; height: 50px;'));
        $select->setMultiple(false);



//date
$mform->addElement('html','<div class="journal-label">');
$mform->addElement('date_selector', 'sdate', 'Start date', array('style'=>'width: 500px; height: 300px;'));
$mform->addRule('sdate', 'Start date missing', 'required', null);

$mform->addElement('html','</div>');


$mform->addElement('html','<div class="journal-label">');
$mform->addElement('date_selector', 'edate', 'End date', array('style'=>'width: 500px; height: 300px;'));
$mform->addRule('edate', 'End date missing', 'required', null);

$mform->addElement('html','</div>');

        
        //Suboption
        $suboptions = array(
            'assignment' => 'Assignment',
            'project' => 'Project',
            'seminar' => 'Seminar',
            'exam' => 'Exam'
        );
        //$subselect = $mform->addElement('select', 'suboption', '', $suboptions);
        $subselect = $mform->addElement('select', 'suboption', '', $suboptions, array('id' => 'subselect','style' => 'width: 200px; height: 50px;'));
        $mform->addElement('html','</div>');

        $subselect->setMultiple(false);
        $subselect->updateAttributes(array('disabled' => 'disabled'));

        $select->updateAttributes(array('onchange' => 'showSubDropdown(this)'));
        
        $textinput = $mform->addElement('text', 'suboption_text', '', array('style' => 'display:none; width: 500px; height: 50px;'));

        // $mform->addElement('html','<div class="btn-main entry-submit-btn"">');
        $this->add_action_buttons(array('class' => 'btn-main'));
        // $mform->addElement('html','</div>');

        $mform->addElement('html','<a href = "view_diary.php" style="text-decoration:none">');
        $mform->addElement('button', 'btn', 'View Diary'); 
        $mform->addElement('html','</a>');
  
  
    }

}





?>

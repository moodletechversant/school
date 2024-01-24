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
 * Validate an email address
 *
 * @param string    $email         Email address to validate
 * @param boolean   $domainCheck   Check if the domain exists
 */
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
require_login();
global $DB,$class,$CFG,$USER;
$userid=$USER->id;
//print_r($userid);exit();

class parentschat_form extends moodleform {

    public function definition() {
        global $DB, $USER;
        $userid=$USER->id;

        $view_parentschat=new moodle_url('/local/parentschat/view_parentschat.php');
       
     
    
        $mform = $this->_form;
        $mform->addElement('html','<a href = "'.$view_parentschat.'" style="text-decoration:none">');
        $mform->addElement('button', 'btn', 'View parentschats'); 
       $mform->addElement('html','</a>');

    //    $parent = $DB->get_record_sql("SELECT * FROM {parent} WHERE user_id='$userid'");
    //    $sid = $parent->child_id;
    //    $student = $DB->get_record_sql("SELECT * FROM {student_assign} WHERE user_id='$sid'");
    //    $did = $student->s_division;

       $parent_join = $DB->get_record_sql("SELECT {student_assign}.* FROM {student_assign} JOIN {parent} ON {student_assign}.user_id={parent}.child_id WHERE {parent}.user_id='$userid'");
      
       $did = $parent_join->s_division;
       $teacher_assignments = $DB->get_records_sql("SELECT * FROM {teacher_assign} WHERE t_division = ?", array($did));
     
       $options1 = array('' => '---------------------------- Select Teacher ---------------------------- ');
       
       foreach ($teacher_assignments as $teacher_assignment) {
           $teacher1 = $teacher_assignment->user_id;
           $subid = $teacher_assignment->t_subject;
       
           $teacher_info = $DB->get_record_sql("SELECT * FROM {teacher} WHERE user_id = ?", array($teacher1));
           $teachername = $teacher_info->t_fname . ' ' . $teacher_info->t_mname . ' ' . $teacher_info->t_lname;
       
           $subject = $DB->get_record_sql("SELECT * FROM {subject} WHERE course_id = ?", array($subid));
       
           if ($subject) {
               $subject_name = $subject->sub_name;
               $options1[$teacher1] = $teachername . '-' . $subject_name;
           }
       }
       
       $mform->addElement('select', 'teachername', 'Teacher Name', $options1);
       $mform->addRule('teachername', 'Teacher name missing', 'required', null);
       



      
        //parentschat message
        $mform->addElement('textarea', 'cmessage','message','wrap="virtual" rows="6" cols="5"');
        $mform->addRule('cmessage', 'message missing', 'required', null);

        //$mform->addElement('html', '</div>');

        $this->add_action_buttons();
      
       // $mform->addElement('html', '</div>');
      
       
      
    }

}

?>

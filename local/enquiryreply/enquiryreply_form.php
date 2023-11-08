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

class enquiryreply_form extends moodleform {

    public function definition() {
        global $PAGE, $DB, $USER, $CFG, $COURSE;

        $mform = $this->_form;

        $mform->addElement('html', '<h2 class="text-center heading mb-5">Enquiry Reply</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');
        // $editoroptions = null;
        // $filemanageroptions = null;
        $id  = optional_param('id', 0, PARAM_INT);
        $mform->addElement('hidden','id',$id);

        $u_id  = optional_param('user_id', 0, PARAM_INT);
        $mform->addElement('hidden','user_id',$u_id);
        //print_r($u_id);exit();
       //replay message
       
       $mform->addElement('textarea', 'ereply','Reply message','wrap="virtual" rows="6" cols="5"');
       $mform->addRule('ereply', 'reply description missing', 'required', null);

       $mform->addElement('html', '</div>');
       $this->add_action_buttons();
       $mform->addElement('html','<a href = "/school/local/enquiry/view_enquiry.php" style="text-decoration:none">');
       $mform->addElement('button', 'btn', 'View Enquiry list'); 
       $mform->addElement('html','</a>');

       $mform->addElement('html', '</div>');
    }

}



?>

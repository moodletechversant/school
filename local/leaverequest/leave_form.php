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
class leave_form extends moodleform {
    function definition() {
        global $USER, $CFG, $DB;

        $mform = $this->_form;
        $mform->addElement('html', '<h2 class="text-center heading mb-5">Apply Leave</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');

        $id  = optional_param('id', 0, PARAM_INT);

        $mform->addElement('hidden','id',$id);


        $mform->addElement('html', '<div class="dbpicker">');
        $mform->addElement('date_selector', 'fdate','From Date', get_string('from'));
        $mform->addRule('fdate', 'From date missing', 'required', null);
        $mform->addElement('html', '</div>');

        $mform->addElement('html', '<div class="dbpicker">');
        $mform->addElement('date_selector', 'tdate','To Date', get_string('from'));
        $mform->addRule('tdate', 'To date missing', 'required', null);
        $mform->addElement('html', '</div>');
        $mform->addElement('text', 'nleave', 'Total no.of leaves applied', array('style' =>'width:300px')); 
        $mform->addRule('nleave', 'Subject missing', 'required', null);

        $mform->setDefault('nleave', 1);

        $options = array(
            '' => 'Select leave type', // Empty option added as the default/select option
            'sickleave' => 'Sick leave',
            'casual' => 'Casual leave',
            'duty' => 'Duty leave'
        );
        
        $mform->addElement('select', 'ltype', 'Leave type', $options);
        $mform->addRule('ltype', 'Leave type missing', 'required', null);
        
        $mform->addElement('textarea', 'subject', 'Subject', array('style' =>'width:300px')) ;

       // $mform->addElement('textarea', 'subject', 'Textarea Label', array('rows' => 3,'style' => 'font-size: 16px; padding: 1px; border: 1px solid #ccc; border-radius: 5px; box-shadow: inset 0 1px 1px rgba(0,0,0,0.075); '));

        $mform->addRule('subject', 'Subject missing', 'required', null);


        $mform->addElement('textarea', 'note', 'Note', array('rows' => 4,'style' =>'width:300px')); 
        $mform->addRule('note', 'Note missing', 'required', null);

        
    
        $mform->addElement('html', '</div>');

        $this->add_action_buttons(true,'Request leave');


        $mform->addElement('html', '</div>');

        // $mform->addElement('button', 'btn', 'Applied leaves', array(
        //     'style' => 'display: flex;justify-content:margin-bottom:1px;width:50%;background-color: #00ab3f; color: white; border: none; border-radius: 5px; padding: 10px 20px;',
        //     'onclick' => "window.location.href='/school/local/leaverequest/std_viewrequest.php?userid=$id'",
        // ));
        
    }

      

    }
    


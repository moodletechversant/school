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
class editleave_form extends moodleform {
    function definition() {
        global $USER, $CFG, $DB;
        $urlto=$CFG->wwwroot.'/local/leaverequest/editleave.php';
        $request_view=$CFG->wwwroot.'/local/leaverequest/request_view.php';
       
        $mform = $this->_form;

        $mform->addElement('html', '<h2 class="text-center heading mb-5">Apply Leave</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');

        $id  = optional_param('id', 0, PARAM_INT);

        $mform->addElement('hidden','id',$id);
       
        $mform->addElement('date_selector', 'fedate','From Date', get_string('from'));
        $mform->addRule('fedate', 'From date missing', 'required', null);
        // $mform->getElement('fdate')->addAttribute('class', 'fclass');

        $mform->addElement('date_selector', 'tedate','To Date', get_string('from'));
        $mform->addRule('tedate', 'To date missing', 'required', null);
        // $mform->getElement('tdate')->addAttribute('class', 'tclass');

        $mform->addElement('text', 'nleave', 'Total no.of leaves applied', array('style' =>'width:300px')); 
        $mform->addRule('nleave', 'no of leaves missing', 'required', null);

        $mform->addElement('textarea', 'reason', 'Reason for edit', array('rows' => 4,'style' =>'width:300px')); 
        $mform->addRule('reason', 'reason missing', 'required', null);

        $editdata=$DB->get_record('leave',array('id'=>$id));
 
//print_r($editdata);exit();
        $mform->setDefault('fedate',$editdata->f_date);
        $mform->setDefault('tedate',$editdata->t_date);
        $mform->setDefault('nleave',$editdata->n_leave);
       
        $mform->addElement('html', '</div>');

        $this->add_action_buttons();
        // $mform->addElement('html','<a href = "div_view.php" style="text-decoration:none">');
        // $mform->addElement('button', 'btn', 'View divisions'); 
        // $mform->addElement('html','</a>');
 
        $mform->addElement('html','<a href = "'.$request_view.'">');
        $mform->addElement('button', 'btn_btn', 'View Requests'); 
        $mform->addElement('html','</a>');

        $mform->addElement('html', '</div>');

    }

      

    }
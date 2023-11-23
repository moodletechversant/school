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
require_once($CFG->dirroot . '/lib/formslib.php'); 
require_login();
class attendance_form extends moodleform { 
    function definition() {
        global $USER, $CFG, $DB;

        $mform = $this->_form;
        $id  = optional_param('id', 0, PARAM_INT);

        $mform->addElement('hidden','id',$id);
        $rec=$DB->get_records_sql("SELECT * FROM {student}");     
} 
    }
            $rec=$DB->get_records_sql("SELECT * FROM {student}");
    
       echo "<table>";
    echo "<tr><th>Roll no</th>   <th>Full Name</th>   <th>present/absent</th>";
    echo "</tr>";
    foreach ($rec as $recs) {
        echo "<tr>";
        echo "<td>$recs->id</td><td>$recs->s_ftname</td><td><input type='radio' name='attendance[$user->id][$date]' value='present'> Present <input type='radio' name='attendance[$user->id][$date]' value='absent'> Absent</td>";
        
        echo "</tr>";
    }
    echo "</table>";
    
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
 * Form for submitting feedback
 *
 * @copyright 2023 Your Name
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Moodle page.
}
require_once($CFG->dirroot.'/lib/formslib.php');

class s_feedback_form extends moodleform {
    public function definition() {
        $mform = $this->_form;


        // $mform->addElement('html', '
        // <div>
        //     <div class="pic">
        //         <img src="images/pngwing.com.png" alt=""><br/>
        //         <input type="radio" name="quality" value="0"> Bad
        //     </div>
            

        //     <div class="pic">
        //         <img src="images/pngwing.com (1).png" alt=""><br/>
        //         <input type="radio" name="quality" value="1"> Okay
        //     </div>
        //     <div class="pic">
        //         <img src="images/pngwing.com (2).png" alt=""><br/>
        //         <input type="radio" name="quality" value="2"> Good
                
        //     </div>
        //     <br><br> <br><br>
        // </div>');
        // $mform->addRule('radio','quality', 'Please select the feedback quality', 'required', null, 'client');
        // echo '<style>';
        // echo '#id_submitbutton{margin-top:20px;margin-left:100px;background-color: #337ab7;
        //     border-color: #2e6da4;}';
        // echo '.pic{text-align:left;float:left;margin-right:20px;width:26%;}';
        // echo '.pic img {width: 18px;}';
        // echo '</style>';
        // Feedback message
        $mform->addElement('html', '
        <div>
        <p><b>Do you have any suggestion for us? </b></p>
        <br>
        </div>');
        $mform->addElement('textarea', 'message', 'Feedback', array('rows' => '6'));
        $mform->setType('message', PARAM_TEXT);
        $mform->addRule('message', 'Please enter the feedback message', 'required', null, 'client');
        
        $this->add_action_buttons(false, 'Submit');


      
    }
}
?>

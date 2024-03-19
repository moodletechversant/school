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

class survey_form extends moodleform {

    public function definition() {
        global $DB, $USER, $CFG, $COURSE;
        

        $mform = $this->_form;
        // $editorclasslist = null;
        // $filemanagerclasslist = null;

        $attributes = 'size="30"';

        //-----------Form creation-----------
                  
             //Survey name
             $academic  = $DB->get_records('academic_year');
             $options1 = array();
             $options1=array(''=>'---- Select academic year ----');
             foreach($academic  as $academic1 ){
                 $timestart = $academic1->start_year;
                 $timeend = $academic1->end_year;
             $timestart1 = date("d/m/Y", $timestart);
             $timeend1 = date("d/m/Y", $timeend);
             $options1 [$academic1->id] = $timestart1.'----'.$timeend1;
             }
     
             $mform->addElement('select', 'academicyear','Academic start',$options1);
             $mform->addRule('academicyear', 'academic year missing', 'required', null);



             
             $mform->addElement('text', 'surname','Survey name',$attributes);
             $mform->addRule('surname', 'survey name missing', 'required', null);

             $mform->addElement('date_selector', 'surveyfrom', get_string('from'));

             $mform->addElement('date_selector', 'surveyto', get_string('to'));
            //  $demo="<i class='icon fa fa-trash fa-fw pt-2 pl-2 ' title='delete this question' role='img' aria-label='Calendar'></i>";

            //  $icon1 = "<i class='icon fa fa-trash fa-fw' title='delete this question' role='img' aria-label='Calendar'></i>";
             $mform->addElement('text', 'question1','', array('placeholder' => 'Enter your question'));
             $mform->addRule('question1', 'question missing', 'required', null);

             //$demo = "<i class='icon fa fa-trash fa-fw pt-2 pl-2' title='delete this question' role='img' aria-label='Calendar'></i>";

             //$mform->addElement($demo . 'text', 'question1', 'Question 1');
                        
            
            //  $mform->addElement('text', 'demo','Demo',$attributes);

             
             $buttonattributes = array(
                'type' => 'button',
                'onclick' => 'showAlert();'
            );
            
            
            
            $attribute = array(
                'id' => 'id_question',
                'style' => 'display: none;',
            );
            // $icon2 = "<i class='icon fa fa-trash fa-fw' title='delete this question' role='img' aria-label='Calendar'></i>";
            $mform->addElement('text', 'question', '', $attribute);
            
             $mform->addElement('button', 'submitbutton', 'Add question', $buttonattributes);
            // print_r($buttonattributes);exit();
            $this->add_action_buttons();

            $mform->addElement('html','<a href = "survey_adminview.php" style="text-decoration:none">');
            $mform->addElement('button', 'btn', 'View survey'); 
            $mform->addElement('html','</a>');


    }
    

  
}


?>

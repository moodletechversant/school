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

class editsurvey_form extends moodleform {

    public function definition() {
        global $DB, $USER, $CFG, $COURSE;
        
        

        $mform = $this->_form;
        // $editorclasslist = null;
        // $filemanagerclasslist = null;

        $attributes = 'size="30"';

        $id  = optional_param('id', 0, PARAM_INT);
        // $id1  = optional_param('id', 0, PARAM_INT);
        // print_r($id1);exit();


             //-----------Form creation-----------

             //ID
             $mform->addElement('hidden','id',$id);
                  
             //Survey name

             $mform->addElement('text', 'surname','Survey name',$attributes);
             $mform->addRule('surname', 'survey name missing', 'required', null);

             $mform->addElement('date_selector', 'surveyfrom', get_string('from'));

             $mform->addElement('date_selector', 'surveyto', get_string('to'));
             
            

             $editdata = $DB->get_records_sql("SELECT * FROM {customsurvey_question} WHERE survey_id = ?", array($id));
             
              foreach ($editdata as $key => $value) {
                // print_r($value->id);exit();
              
              $id1=$value->id;
              }
            //  print_r($editdata);exit();
                $i = 1;
                $demo = "<a href='deletequestion.php?id=$id1'><i class='icon fa fa-trash fa-fw pt-2 pl-2 delete-icon' title='delete this question' role='img' aria-label='Calendar'></i></a>";
                foreach ($editdata as $index => $question) {
                    $field_name = 'question1' . ($index + 1);
                    $field_label = 'Question ' . ($i++);
                    $size = 52;
                
                    $mform->addGroup(array(
                        $mform->createElement('text', $field_name, $field_label, array('size' => $size)),
                        $mform->createElement('static', null, $field_label, $demo)
                    ));
                
                    $mform->setDefault($field_name, $question->survey_question);
                }
            
            // 
            //  $mform->addElement('text', 'question1','Question 1',$attributes);
           
            
             //  $mform->addElement('text', 'demo','Demo',$attributes);

             
             $buttonattributes = array(
                'type' => 'button',
                'onclick' => 'showAlert();'
             );
            
            
            
             $attribute = array(
                'id' => 'id_question',
                'style' => 'display: none;'
             );
            
             $mform->addElement('text', 'question', '', $attribute);
            
             $mform->addElement('button', 'submitbutton', 'Add question', $buttonattributes);
             // print_r($buttonattributes);exit();

             $editdata=$DB->get_record('customsurvey',array('id'=>$id));
            //  $editdata1=$DB->get_record_sql("SELECT * FROM {customsurvey_question} WHERE survey_id=$id");
             
                $mform->setDefault('surname', $editdata->survey_name);
                $mform->setDefault('surveyfrom', $editdata->survey_from);
                $mform->setDefault('surveyto', $editdata->survey_to);          


             $this->add_action_buttons();

    }
    

  
}


?>

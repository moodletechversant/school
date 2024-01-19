<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Division Creation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<link rel="stylesheet" href="/school/local/css/style.css" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</head>
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

class edit_form extends moodleform {
    function definition() {
       // $userid  = optional_param('userid', 0, PARAM_INT);

       
        $urlto=$CFG->wwwroot.'/local/division/div_creation.php';
        global $USER, $CFG, $DB;
        $table = new html_table();

        $mform = $this->_form;
        $mform->addElement('html', '<div class="form-wrap">
        <div class="cointainer">
            <div class="col-md-10 col-10 mx-auto col-lg-6">
                <div class="form-card card">
                    <h4>Division creation</h4> 
                    <div class="form-group">
                   
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Academic start</label>');
                                $id  = optional_param('id', 0, PARAM_INT);   

                                $mform->addElement('hidden','id',$id);
                                $academic  = $DB->get_records('academic_year');
    
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

    $mform->addElement('select', 'academicyear','',$options1);
    

    $js = <<<JS
    document.addEventListener("DOMContentLoaded", function() {
    var selectElement = document.getElementById("id_academicyear");
    selectElement.disabled = true;
    });
    JS;

    // Add the JavaScript to the form
    $mform->addElement('html', "<script>{$js}</script>");

                                $mform->addElement('html', ' </div>


                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>class</label>');
                                            $classes  = $DB->get_records('class');
                                            $options1 = array();
                                            $options1=array(''=>'---- Select a class ----');
                                            foreach($classes as $class){
                                            $options1 [$class->id] = $class->class_name;
                                            }
                                
                                        $mform->addElement('select', 'class','',$options1);
                                        
                                        $js = <<<JS
                                        document.addEventListener("DOMContentLoaded", function() {
                                        var selectElement = document.getElementById("id_class");
                                        selectElement.disabled = true;
                                        });
                                        JS;
                                    
                                        // Add the JavaScript to the form
                                        $mform->addElement('html', "<script>{$js}</script>");
                                           

                                    $mform->addElement('html', '</div>
                                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Division name</label>');
            
                                            $mform->addElement('text', 'dname', ''); 
                                            $mform->addRule('dname', 'div name missing', 'required', null);


                                            $mform->addElement('html', '</div>
                                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>No of boys</label>');
            
                                            $mform->addElement('text', 'bstrength', '');
        $mform->addRule('bstrength', 'No of boys missing', 'required', null);
        $mform->setDefault('bstrength',0);


                                            $mform->addElement('html', '</div>
                                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>No of girls</label>');
            
                                            $mform->addElement('text', 'gstrength', '');
        $mform->addRule('gstrength', 'No of girls missing', 'required', null);
        $mform->setDefault('gstrength',0);


                                            $mform->addElement('html', '</div>
                                            <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Total strength</label>');
                    
                                                    $mform->addElement('text', 'strength', '');
        $mform->addRule('strength', 'div strength missing', 'required', null);


                                                    $mform->addElement('html', '</div>
                                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description About division</label>');
            
                                            $mform->addElement('textarea', 'description', );

                                            $editdata=$DB->get_record('division',array('id'=>$id));
                                            $academic=$DB->get_record('class',array('id'=>$editdata->div_class));

                                            $mform->setDefault('academicyear',$academic->academic_id);

                                            $mform->setDefault('class',$editdata->div_class);
                                    
                                            $mform->setDefault('dname',$editdata->div_name);
                                            
                                            $mform->setDefault('bstrength',$editdata->div_bstrength);
                                    
                                            $mform->setDefault('gstrength',$editdata->div_gstrength);
                                            $mform->setDefault('strength',$editdata->div_strength);
                                    
                                            $mform->setDefault('description',$editdata->div_description);

                                            

                                    $mform->addElement('html', '</div>

                                    
                                    
                        </div>
                    </div>');
       
        
        $this->add_action_buttons(false, 'Submit', array('class' => 'btn btn-primary mt-3 mb-3'));

        $mform->addElement('html', '<br>');
        $this->add_action_buttons(false, 'cancel');

        $mform->addElement('html', '</div></div>
                </div>
                </div>
               <!-- <a href="#" class="btn btn-primary mt-3 mb-3">SUBMIT</a>-->
             

');
  

       
        
    }
    
  
}
?>

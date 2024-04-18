<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.'); // It must be included from a Moodle page.
}

require_once($CFG->dirroot.'/lib/formslib.php');
require_once($CFG->dirroot.'/user/lib.php');
class periods_form extends moodleform {

    public function definition() {
        global $DB, $USER, $CFG, $COURSE,$SESSION;

        $mform = $this->_form;
       
        $edit_periods=$CFG->wwwroot.'/local/edit_period.php?id';
        $attributes = 'size="30"';
        //-----------Form creation-----------

        $mform->addElement('html', '<h2 class="text-center heading mb-5">Time-table creation</h2>');
        $mform->addElement('html', '<div class="container">');
        $mform->addElement('html', '<div class="form-class">');
        $school_id  = $SESSION->schoolid;
        $mform->addElement('hidden','school_id',$school_id);

        $academic  = $DB->get_records('academic_year',array('school' => $school_id));
        $options1 = array();
        //$options1=array(''=>'---- Select academic_year ----');
        foreach($academic as $academics){
            $timestart = $academics->start_year;
            $timeend = $academics->end_year;
        $timestart1 = date("d/m/Y", $timestart);
        $timeend1 = date("d/m/Y", $timeend);
        $options1 [$academics->id] =$timestart1.'-'.$timeend1;
        }
        $mform->addElement('select', 'academic','Academic Year',$options1);

        $classes  = $DB->get_records('class');
        $days1 = array();
        foreach ($classes as $class) {
            $days1[$class->id] = $class->class_name;
        }
        $mform->addElement('select', 'class', 'class', $days1);
        $mform->addRule('class', 'Class missing', 'required', null);

        $divisions  = $DB->get_records('division');
        $options2 = array();
        $options2 = array('' => '---- Select a division ----');
        foreach ($divisions as $division) {
            $options2[$division->id] = $division->id;
        }

        $mform->addElement('select', 'division', 'division', $options2);
        $mform->addRule('division', 'Division missing', 'required', null);
        $days = $DB->get_records('days');
                $days2 = array();

                foreach ($days as $day) {
                    $days2[$day->id] = $day->days;
                }

        $mform->addElement('select', 'day', 'day', $days2);

        $mform->addElement('text', 'periods', 'periods', array('style' => 'width: 120px;', 'disabled' => 'disabled'));
        $mform->setType('periods', PARAM_INT);

        // Add validation rule to ensure the value is an integer between 1 and 15
        $mform->addRule('periods', null, 'numeric', null, 'client');
        $mform->addRule('periods', get_string('numericbetween', 'moodle', array(1, 15)), 'between', array(1, 15), 'client');

        $mform->addElement('html', '<div id="periods_details">'); 
        
        $mform->addElement('html', '</div>'); 

        $mform->addElement('html', '</div>');
             
            $this->add_action_buttons();
            $mform->addElement('html', '</div>');

            }
        }



?>
</body>
</html>
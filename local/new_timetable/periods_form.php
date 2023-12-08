<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Time-table creation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/school/local/css/style.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>
<body>
<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.'); // It must be included from a Moodle page.
}

require_once($CFG->dirroot.'/lib/formslib.php');
require_once($CFG->dirroot.'/user/lib.php');

class periods_form extends moodleform {

    public function definition() {
        global $DB, $USER, $CFG, $COURSE;

        $mform = $this->_form;

        $attributes = 'size="30"';

        $id  = optional_param('id', 0, PARAM_INT);

        // Form creation
        $mform->addElement('html', '
<div class="form-wrap">
    <div class="container">
        <div class="col-md-10 col-10 mx-auto col-lg-6">
            <div class="form-card card">
            <h4>Time-Table creation</h4>

            <div class="row">
                        <div class="form-group">
                        ');
            $academic  = $DB->get_records('academic_year');
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
            $mform->updateAttributes('academic', array('academic' => 'form-control'));


            $mform->addElement('html','
            </div>
            </div>
            <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Class</label>
                        ');

        $classes  = $DB->get_records('class');
        $days1 = array();

        foreach ($classes as $class) {
            $days1[$class->id] = $class->class_name;
        }

        $mform->addElement('select', 'class', '', $days1);
        $mform->addRule('class', 'Class missing', 'required', null);
        $mform->updateAttributes('class', array('class' => 'form-control'));

        $mform->addElement('html', '
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Division</label>
                        ');

        $divisions  = $DB->get_records('division');
        $options2 = array();
        $options2 = array('' => '---- Select a division ----');

        foreach ($divisions as $division) {
            $options2[$division->id] = $division->id;
        }

        $mform->addElement('select', 'division', '', $options2);
        $mform->addRule('division', 'Division missing', 'required', null);
        $mform->updateAttributes('division', array('class' => 'form-control'));

        $mform->addElement('html', '
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Day</label>
                        ');

        $days = $DB->get_records('days');
        $days2 = array();

        foreach ($days as $day) {
            $days2[$day->id] = $day->days;
        }

        $mform->addElement('select', 'day', '', $days2);
        $mform->updateAttributes('day', array('class' => 'form-control'));

        $mform->addElement('html', '
                        </div>
                    </div>
                    <div class="col-md-6">
                <div class="form-group">
                    <label>Number of Periods</label>
                ');

        $mform->addElement('text', 'periods', '', array('style' => 'width: 120px;'));
        $mform->setType('periods', PARAM_INT);
        $mform->updateAttributes('periods', array('class' => 'form-control'));

        $mform->addElement('html', '
                </div>
                </div>
        ');
        $this->add_action_buttons(false, 'Submit', array('class' => 'btn btn-primary mt-3 mb-3'));

        $mform->addElement('html', '<br>');
        $this->add_action_buttons(false, 'cancel');
        $mform->addElement('html', '<br>');
        $mform->addElement('html','<a href = "/school/local/new_timetable/admin_view_1.php" style="text-decoration:none">');
        $mform->addElement('button', 'btn','View',array('class' => 'btn btn-primary ms-5')); 
        $mform->addElement('html','</a>');
        $mform->addElement('html', '</div>
                     </div>
                    </div>
                </div>
            </div>
        </div>');

        // Additional form elements can be added here...

        //$this->add_action_buttons();
    }
}
?>
</body>
</html>
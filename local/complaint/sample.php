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
   require_login();
   
   class sampele extends moodleform {
    public function definition() {
    $mform->addElement('html', '<div>');
    $mform->addElement('button', 'minus_button', '-', array('onclick' => 'decrement(); return false;'));
    $mform->addElement('text', 'number', '', array('size' => 3, 'maxlength' => 3, 'style' => 'text-align: center;', 'readonly' => true));
    $mform->addElement('button', 'plus_button', '+', array('onclick' => 'increment(); return false;'));
    $mform->addElement('html', '</div>');

    $mform->addElement('hidden', 'current_value', '0');
   }
  }
?>
// Add this code to your Moodle JavaScript file, such as mod.js
<script>
M.mod_yourmodule = {};

M.mod_yourmodule.init = function(Y) {
  var currentValue = Y.one('#id_current_value').get('value');
  var numberInput = Y.one('#id_number');
  numberInput.set('value', currentValue);
  
  Y.one('#id_minus_button').on('click', function(e) {
    e.preventDefault();
    var currentValue = parseInt(numberInput.get('value'));
    if (currentValue > 0) {
      numberInput.set('value', currentValue - 1);
      Y.one('#id_current_value').set('value', currentValue - 1);
    }
  });
  
  Y.one('#id_plus_button').on('click', function(e) {
    e.preventDefault();
    var currentValue = parseInt(numberInput.get('value'));
    numberInput.set('value', currentValue + 1);
    Y.one('#id_current_value').set('value', currentValue + 1);
  });
};
</script>
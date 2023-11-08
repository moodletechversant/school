<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin upgrade steps are defined here.
 *
 * @package     local_school_feedback
 * @category    upgrade
 * @copyright   2023 Your Name <you@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__.'/upgradelib.php');

/**
 * Execute local_school_feedback upgrade from the given old version.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_local_school_feedback_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2023052403) {
        $table = new xmldb_table('school_feedback1');
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10',null, XMLDB_NOTNULL, XMLDB_SEQUENCE,null);
        $table->add_field('user_id', XMLDB_TYPE_INTEGER, '10',null, XMLDB_NOTNULL,null);
        //$table->add_field('quality_score', XMLDB_TYPE_INTEGER, '10',null, XMLDB_NOTNULL,null);
        //$table->add_field('subject', XMLDB_TYPE_CHAR, '400', null, XMLDB_NOTNULL, null, '');
        $table->add_field('feedback', XMLDB_TYPE_CHAR, '400', null, XMLDB_NOTNULL, null, '');
        $table->add_Key('primary', XMLDB_KEY_PRIMARY,array('id'));
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        }
       upgrade_plugin_savepoint(true,2023052403,'local','school_feedback');
       
    
    return true;
}

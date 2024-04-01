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
 * @package     local_schoolreg
 * @category    upgrade
 * @copyright   school
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__.'/upgradelib.php');

/**
 * Execute local_schoolreg upgrade from the given old version.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_local_schoolreg_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2024032509) {
        $table = new xmldb_table('school_reg');
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->add_field('sch_name', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, '');
        $table->add_field('sch_shortname', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, '');
        $table->add_field('sch_address', XMLDB_TYPE_CHAR, '200', null, XMLDB_NOTNULL, null, '');
        $table->add_field('sch_district', XMLDB_TYPE_CHAR, '200', null, XMLDB_NOTNULL, null, '');
        $table->add_field('sch_state', XMLDB_TYPE_CHAR, '200', null, XMLDB_NOTNULL, null, '');
        $table->add_field('sch_pincode', XMLDB_TYPE_CHAR, '200', null, XMLDB_NOTNULL, null, '');
        $table->add_field('sch_phone', XMLDB_TYPE_CHAR, '200', null, XMLDB_NOTNULL, null, '');
        $table->add_field('sch_logo', XMLDB_TYPE_CHAR, '200', null, null, null, '');
        $table->add_field('sch_status', XMLDB_TYPE_CHAR, '200', null, null, null, '');
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

       
        $divfield = new xmldb_field('sch_name', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, '');

		if (!$dbman->field_exists($table, $divfield)) {
		$dbman->add_field($table, $divfield);
		}
    }

   
    upgrade_plugin_savepoint(true, 2024032509, 'local', 'schoolreg');
    
    return true;
}

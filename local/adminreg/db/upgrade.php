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
 * @package     local_adminreg
 * @category    upgrade
 * @copyright   2022 Your Name <you@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__.'/upgradelib.php');

/**
 * Execute local_adminreg upgrade from the given old version.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_local_adminreg_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    // For further information please read {@link https://docs.moodle.org/dev/Upgrade_API}.
    //
    // You will also have to create the db/install.xml file by using the XMLDB Editor.
    // Documentation for the XMLDB Editor can be found at {@link https://docs.moodle.org/dev/XMLDB_editor}.
        if ($oldversion < 2024041506) {
            // Report_user_logins savepoint reached.
            $table = new xmldb_table('admin_registration');
            $table->add_field('id', XMLDB_TYPE_INTEGER, '10',null, XMLDB_NOTNULL, XMLDB_SEQUENCE,null);
            $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, '');
            $table->add_field('username', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, '');
            $table->add_field('email', XMLDB_TYPE_CHAR, '500', null, XMLDB_NOTNULL, null, '');
            $table->add_field('password', XMLDB_TYPE_CHAR, '500', null, XMLDB_NOTNULL, null, '');
            $table->add_field('number', XMLDB_TYPE_CHAR, '500', null, XMLDB_NOTNULL, null, '');
            $table->add_field('school', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, '');
            
            $table->add_Key('primary', XMLDB_KEY_PRIMARY,array('id'));
            if (!$dbman->table_exists($table)) {
                $dbman->create_table($table);
            }
            $divfield = new xmldb_field('userid', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, '');

            if (!$dbman->field_exists($table, $divfield)) {
            $dbman->add_field($table, $divfield);
            }

       }
       upgrade_plugin_savepoint(true, 2024041506, 'local', 'adminreg');
    return true;
}

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
 * @package     local_academicyear
 * @category    upgrade
 * @copyright   2022 Your Name <you@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__.'/upgradelib.php');

/**
 * Execute local_academicyear upgrade from the given old version.
 *
 * @param int $oldversion
 * @return bool  
 */
function xmldb_local_academicyear_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();
    if ($oldversion < 2023071902) {
        $table = new xmldb_table('academic_year');

        $fields = [
            'school' => new xmldb_field('school', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null),
            'vacation_s_year' => new xmldb_field('vacation_s_year', XMLDB_TYPE_CHAR, '255', null, null, null, null),
            'vacation_e_year' => new xmldb_field('vacation_e_year', XMLDB_TYPE_CHAR, '255', null, null, null, null)
        ];

        foreach ($fields as $fieldname => $field) {
            if (!$dbman->field_exists($table, $field)) {
                $dbman->add_field($table, $field);
            }
        }

        upgrade_plugin_savepoint(true, 2023071902, 'local', 'academicyear');
    }

    return true;
}

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
 * @package     local_survey
 * @category    upgrade
 * @copyright   2023 Your Name <you@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__.'/upgradelib.php');

/**
 * Execute local_survey upgrade from the given old version.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_local_survey_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2023070302) {
        $table = new xmldb_table('customsurvey');
        
    if (!$dbman->table_exists($table)) {
        $dbman->create_table($table);
    }
    }
    // $table5 = new xmldb_table('user');
    $divfield = new xmldb_field('academic_id', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
    
    if (!$dbman->field_exists($table, $divfield)) {
    $dbman->add_field($table, $divfield);
    }
    upgrade_plugin_savepoint(true,2023070302,'local','survey');
    
    
        return true;
}

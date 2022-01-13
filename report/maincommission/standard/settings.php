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
 * Settings and links
 *
 * @package    report
 * @subpackage questioninstances
 * @copyright  2008 Tim Hunt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

// Report

// Report Page settings
$name = new lang_string( 'datasettings', 'quizschedulemaincommission_standard' );
$description = new lang_string( 'datasettings_help', 'quizschedulemaincommission_standard' );
$settings->add(
    new admin_setting_heading(
        'datasettings', 
        $name, 
        $description
    )
);
// Theme List
$settings->add( new admin_setting_configtextarea(
    'quizschedulemaincommission_standard/datathemelist', // key
    get_string('datathemelist', 'quizschedulemaincommission_standard'),
    get_string('datathemelist_help', 'quizschedulemaincommission_standard'),
    '', // default settings
    PARAM_TEXT, 
    40,
    20
));

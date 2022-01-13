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
 * Quiz customresult report version information.
 *
 * @package   quiz_customresult
 * @copyright 2019 dit61
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// plugintype_pluginname ( full frankenstyle component name in the form of plugintype_pluginname )
$plugin->component = 'quizschedule_report';

// when the plugin was released, last XX incremental version within this year
$plugin->version  = 2020012300;

// the minimum version of Moodle that is required for this plugin
$plugin->requires = 2018051700;

// a minimal required gap in seconds between two calls of the plugin's cron function
//$plugin->cron = 900;

// how stable it is: MATURITY_ALPHA, MATURITY_BETA, MATURITY_RC or MATURITY_STABLE
$plugin->maturity = MATURITY_ALPHA;

// Human readable version name that should help to identify each release of the plugin
$plugin->release = 'v1.0-r1'; // This is our first revision for Moodle 3.5.x branch.

// explicit dependency on other plugin(s) for this plugin to work
//$plugin->dependencies = array(
//    'mod_foo' => ANY_VERSION,   // The Foo activity must be present (any version).
//    'enrol_bar' => 2014020300, // The Bar enrolment plugin version 2014020300 or higher must be present.
//);
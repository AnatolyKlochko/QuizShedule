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
 * Definition of sub-plugins
 *
 * @package   mod_quizschedule
 */

$subplugins = array(
    
    'quizschedule'=>'mod/quizschedule', // submodules: Synchronization
    
    'quizschedulesynchronization'=>'mod/quizschedule/synchronization', // submodules: ActiveDirectory
    
    'quizschedulemaincommission'=>'mod/quizschedule/report/maincommission', // submodules: Standard, Group
    'quizschedulecoursetraining'=>'mod/quizschedule/report/coursetraining', // submodules: Standard
);

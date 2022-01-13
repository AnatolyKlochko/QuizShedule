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
 * This script controls the display of the quiz reports.
 *
 * @package   mod_quiz
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('NO_OUTPUT_BUFFERING', true);

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');


$url = new moodle_url('/mod/quizschedule/index.php', []);
$PAGE->set_url($url);

require_login();
$PAGE->set_pagelayout('report');

echo $OUTPUT->header();

echo 'find';


// Print footer.
echo $OUTPUT->footer();

// Log that this report was viewed.
//$params = array(
//    'context' => $context,
//    'other' => array(
//        'quizid' => $quiz->id,
//        'reportname' => $mode
//    )
//);
//$event = \mod_quiz\event\report_viewed::create($params);
//$event->add_record_snapshot('course', $course);
//$event->add_record_snapshot('quiz', $quiz);
//$event->trigger();

function show_navigation_form(){
    include __DIR__ . '/view/navigation_form.php';
}
function show_search_form(){
    include __DIR__ . '/view/search_form.php';
}
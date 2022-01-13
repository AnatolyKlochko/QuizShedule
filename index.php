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
defined('MOODLE_INTERNAL') || define('MOODLE_INTERNAL', true);


require_login();

// View Data
$vd = [];
$h = new \mod_quizschedule\helper();
$ms = new \mod_quizschedule\model\schedule();

$vd['user_groups'] = $h->get_user_groups( $USER );
$vd['employee_schedule'] = $ms->get_schedule( $USER->id );

// Renderer
$ir = new \mod_quizschedule\output\index_renderer();

// Output Page
//echo $OUTPUT->header();
$ir->display( $vd );
echo $OUTPUT->footer(); // displays left sidebar

exit();





list( $is_admin, $is_lc, $is_employee ) = get_user_groups( $course, $USER );
if ($is_lc) {
    show_navigation_form();
    show_search_form();
}
if ($is_employee) {
    show_search_form();
}




if ( isset( $_POST['for_students'] ) ) {
    $schedule = get_schedule();
} else {
    $schedule = get_schedule($USER->id);
}

show_schedule();


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
function get_user_groups( ) {
    global $USER;
    //$roles = get_user_roles(context_course::instance($course->id), $user->id);
    //$x  = get_user_roles_sitewide_accessdata($user->id);
    if (is_siteadmin( $USER->id ) ) {
        return [ true, true, false ];
    } else {
        return [ false, false, true ];
    }
}
function show_navigation_form(){
    include __DIR__ . '/view/navigation_form.php';
}
function show_search_form(){
    include __DIR__ . '/view/search_form.php';
}
function show_schedule(){
    include __DIR__ . '/view/schedule_block.php';
}
function get_schedule( $userid = null ) {
    global $DB;
    
    $todaytimestamp = date('Y-m-d');
    
    $sql = "SELECT q.name, DATE_FORMAT(FROM_UNIXTIME(qs.nextattemptdate), '%d-%m-%Y') as quizdate FROM {quiz_schedule} qs INNER JOIN {quiz_attempts} qa ON qs.attemptid=qa.id INNER JOIN {quiz} q ON qa.quiz=q.id ";
    
    $where = " qs.nextattemptdate > UNIX_TIMESTAMP(DATE_SUB('$todaytimestamp', INTERVAL 1 MONTH)) AND qs.nextattemptdate < UNIX_TIMESTAMP(DATE_ADD('$todaytimestamp', INTERVAL 18 MONTH)) ";
    if ( isset($userid) ) {
        $where .= " AND qs.userid = :userid ";
        $params = [ 
            'userid' => $userid,
        ];
    }
    
    
    $sql .= "\nWHERE {$where}";
    
    $sql .= "\nORDER BY qs.nextattemptdate DESC";
    
    $userschedule = $DB->get_records_sql( $sql, $params );
    
    return $userschedule;
    
    /*
     SELECT q.name, DATE_FORMAT(FROM_UNIXTIME(qs.nextattemptdate), '%d-%m-%Y') as quizdate FROM {quiz_schedule} qs INNER JOIN {quiz_attempts} qa ON qs.attemptid=qa.id INNER JOIN {quiz} q ON qa.quiz=q.id 
WHERE  qs.userid = :userid AND qs.nextattemptdate > DATE_SUB(2019-05-31, INTERVAL 1 MONTH) AND qs.nextattemptdate < DATE_ADD(2019-05-31, INTERVAL 18 MONTH) 
ORDER BY qs.nextattemptdate DESC 
     */
}
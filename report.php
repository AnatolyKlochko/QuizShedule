<?php
use \mod_quizschedule\model\schedule;
use \mod_quizschedule\output\renderer;
use \mod_quizschedule\access_helper as ac_helper;

define('NO_OUTPUT_BUFFERING', true);
defined('MOODLE_INTERNAL') || define('MOODLE_INTERNAL', true);

// Moodle init
require_once(__DIR__ . '/../../config.php');


// Only for logged-in employees
require_login();

// Only for writers: MD, LC or RP
//if ( ! ac_helper::is_gr_viewer( $USER->id ) ) {
//    
//    // Redirect to module home
//    redirect( $CFG->wwwroot .'/mod/quizschedule/index.php' );
//    
//}

// Report Data
$report = ( new schedule() )->get_report();

// Display Report
( new renderer() )->display( $report );

// Output Footer (here displays left sidebar too)
echo $OUTPUT->footer();

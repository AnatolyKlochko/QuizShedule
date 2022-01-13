<?php
//$_POST['submit_quizname'] = 'submit_quizname';
//$_POST['quizname'] = 'ОП';

//$_POST['submit_link'] = 'submit_link';
//$_POST['quiz114'] = ["id"=>"114","quiz_status"=>"on"];
//$_POST['quiz121'] = ["id"=>"121","quiz_status"=>"off"];
//$_POST['quiz118'] = ["id"=>"118"];
//$_POST['quiz119'] = ["id"=>"119"];
//$_POST['grcolumnid'] = 7;


use \mod_quizschedule\output\link_quiz_to_grcolumn_renderer as renderer;
use \mod_quizschedule\access_helper as ac_helper;

define('NO_OUTPUT_BUFFERING', true);
defined('MOODLE_INTERNAL') || define('MOODLE_INTERNAL', true);

// Moodle init
require_once(__DIR__ . '/../../config.php');


// Only for logged-in employees
require_login();

// Only for writers: MD, LC or RP
if ( ! ( ac_helper::is_lc( $USER->id ) || ac_helper::is_moddev( $USER->id ) ) ) {
    
    // Redirect to module home
    redirect( $CFG->wwwroot .'/mod/quizschedule/index.php' );
    
}


// Display Form
include $CFG->dirroot . '/mod/quizschedule/classes/output/link_quiz_to_grcolumn_renderer.php';
( new renderer() )->display();

// Output Footer (here it displays left sidebar too)
echo $OUTPUT->footer();

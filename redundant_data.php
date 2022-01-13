<?php
//$_POST['qspoint2357'] = ["id"=>"2357"];
//$_POST['qspoint4790'] = ["id"=>"4790","checked"=>"on"];
//$_POST['submit_save'] = 'submit_save';

use \mod_quizschedule\output\redundant_data_renderer as renderer;
use \mod_quizschedule\access_helper as ac_helper;

define('NO_OUTPUT_BUFFERING', true);
defined('MOODLE_INTERNAL') || define('MOODLE_INTERNAL', true);

// Moodle init
require_once(__DIR__ . '/../../config.php');


// Only for logged-in employees
require_login();

// Only for: MD, LC
if ( ! ( ac_helper::is_lc( $USER->id ) || ac_helper::is_moddev( $USER->id ) ) ) {
    
    // Redirect to module home
    redirect( $CFG->wwwroot .'/mod/quizschedule/index.php' );
    
}


// Display Form
( new renderer() )->display();

// Output Footer (here it displays left sidebar too)
echo $OUTPUT->footer();

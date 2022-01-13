<?php
//$_POST['submit_affiliate_quiz'] = 'submit_affiliate_quiz';
//$_POST['affiliate_key'] = 'at_poltavaoblenergo';
//$_POST['quizid'] = '194';

//$_POST['managerid'] = 517;
//$_POST['quizdate'] = date( 'Y-m-d' );
//$_POST['commissiontypeid'] = 1;
//$_POST['quizid'] = 160;
//$_POST['employee845'] = ["id"=>"845","quiz_mark"=>"on","quiz_nextdate"=>"2020-07-30"];
////$_POST['employee847'] = ["id"=>"847","quiz_mark"=>"on","quiz_nextdate"=>"2020-05-31"];
//$_POST['submit_save'] = 'submit_save';

use \mod_quizschedule\output\edit_renderer as renderer;
use \mod_quizschedule\access_helper as ac_helper;

define('NO_OUTPUT_BUFFERING', true);
defined('MOODLE_INTERNAL') || define('MOODLE_INTERNAL', true);

// Moodle init
require_once(__DIR__ . '/../../config.php');


// Only for logged-in employees
require_login();

// Only for writers: MD, LC or RP
if ( ! ac_helper::is_writer( $USER->id ) ) {
    
    // Redirect to module home
    redirect( $CFG->wwwroot .'/mod/quizschedule/index.php' );
    
}


// Display Form
( new renderer() )->display();

// Output Footer (here it displays left sidebar too)
echo $OUTPUT->footer();

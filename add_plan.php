<?php
//$_POST['submit_affiliate'] = 'submit_affiliate';
//$_POST['affiliate_key'] = 'at_poltavaoblenergo';

//$_POST['managerid'] = 1216;
//$_POST['commissiontypeid'] = 2;
//$_POST['quizid'] = 160;
//$_POST['employee845'] = ["id"=>"845","quiz_nextdate"=>"2021-01-30"];
//$_POST['employee847'] = ["id"=>"847","quiz_nextdate"=>"2021-05-31"];
//$_POST['submit_save'] = 'submit_save';

//$_POST['managerid'] = 517;

//$_POST['quizdate'] = date( 'Y-m-d' );
//$nextdate = ( new DateTime() )->modify('+1 year')->format('Y-m-d');

//$_POST['commissiontypeid'] = 1;

//$_POST['quizid'] = 26; //151;//160;

//$_POST['employee1194'] = ["id"=>"1194",/*"quiz_mark"=>"on",*/"quiz_nextdate"=>$nextdate];

//$_POST['submit_save'] = 'submit_save';


use \mod_quizschedule\output\add_plan_renderer as renderer;
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

// Output Footer (here displays left sidebar too)
echo $OUTPUT->footer();
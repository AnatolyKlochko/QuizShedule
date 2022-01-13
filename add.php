<?php
//$_POST['submit_affiliate'] = 'submit_affiliate';
//$_POST['affiliate_key'] = 'at_poltavaoblenergo';

//$_POST['managerid'] = 517;

//$_POST['quizdate'] = date( 'Y-m-d' );
//$nextdate = ( new DateTime() )->modify('+1 year')->format('Y-m-d');

//$_POST['commissiontypeid'] = 1;

//$_POST['quizid'] = 338; //151;//160;

// my today quiz
//$_POST['quizid'] = 271;
//$_POST['employee517'] = ["id"=>"517","quiz_mark"=>"off",'attempt_id'=>"4155","quiz_nextdate"=>$nextdate]; // fake attempt id

// more than 1 attempt (10 attempts, Тестування):
//$_POST['quizid'] = 200;
//$_POST['employee3113'] = ["id"=>"3113","quiz_mark"=>"on",'attempt_id'=>"2925","quiz_nextdate"=>$nextdate]; // fake attempt id
//$_POST['employee3113'] = ["id"=>"3113","quiz_mark"=>"on",'attempt_id'=>"4145","quiz_nextdate"=>$nextdate]; // real attempt id

// more than 1 attempt (2 attempts, Екзамен):
//$_POST['quizid'] = 101;
//$_POST['employee901'] = ["id"=>"901","quiz_mark"=>"on",'attempt_id'=>"2925","quiz_nextdate"=>$nextdate]; // fake attempt id
//$_POST['employee2683'] = ["id"=>"2683","quiz_mark"=>"on",'attempt_id'=>"3644","quiz_nextdate"=>$nextdate]; // real attempt id


//$_POST['employee901'] = ["id"=>"901","quiz_mark"=>"on","quiz_nextdate"=>$nextdate];
//$_POST['employee1194'] = ["id"=>"1194","quiz_mark"=>"on","quiz_nextdate"=>$nextdate];
//$_POST['employee845'] = ["id"=>"845","quiz_mark"=>"on","quiz_nextdate"=>"2020-07-30"];
//$_POST['employee847'] = ["id"=>"847","quiz_mark"=>"on","quiz_nextdate"=>"2020-05-31"];

//$_POST['submit_save'] = 'submit_save';





use \mod_quizschedule\output\add_renderer as renderer;
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

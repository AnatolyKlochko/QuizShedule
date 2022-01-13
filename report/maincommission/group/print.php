<?php
/** TESTING */
//$_POST['quizdate'] = date( 'Y-m-d' ); //'2019-10-10';
//$_POST['employee1745'] = [
//    'id' => 1745,
//    'fullname' => 'Бакка Олександр Вячеславович',
//    'affiliate' => 'Кременчуцька філія',
//    'position' => 'Диспетчер району мереж 1 групи'
//]; 

/**
 * ...initially show only date box and button "Find"
 * # choose data and press "Find"
 *  # employee list is generated
 * # delete unusefull employees and press on button: "Print" or "PDF" or ...
 */
use \mod_quizschedule\access_helper as ac_helper;
use quizschedulemaincommission_group\formatprint\output\renderer;
use quizschedulemaincommission_group\report;

define('NO_OUTPUT_BUFFERING', true);

// This file path:
// C:\xampp\apps\moodle.oe.pl.ua.sandbox\htdocs\mod\quizschedule\report\maincommission\group\index.php
require_once( __DIR__ . '/../../../../../config.php');

defined('MOODLE_INTERNAL') || define('MOODLE_INTERNAL', true);

require_login();

// Only for LC
if ( ! ( ac_helper::is_lc( $USER->id ) || ac_helper::is_moddev( $USER->id ) ) ) {
    
    // Redirect to module home
    redirect( $CFG->wwwroot .'/mod/quizschedule/index.php' );
    
}

// Get report
$report = new report();

// Render
( new renderer() )->display( $report );

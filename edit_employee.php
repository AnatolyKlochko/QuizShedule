<?php
//$_POST['scheduleid'] = '732';
//$_POST['quizid'] = 350;//22; // original 275
//$_POST['datequiz'] = '2019-07-01';
//$_POST['datenextquiz'] = '2019-10-08';
//$_POST['commissiontypeid'] = '';

//$_GET['employeeid'] = 3393;
//$_GET['quizid'] = 350;//22; // original 275
//$_GET['scheduleid'] = 732;//732;
//$_POST['employee'] = 'Тягній Сергій Григорович';
//$_POST['quiz'] = 'Екзамен для ел. монтерів з ремонту та монтажу КЛ';

//$_POST['submit_edit_schedulepoint'] = 'submit_edit_employee';
//$_POST['submit_delete_schedulepoint'] = 'submit_delete_schedulepoint';


// BUG: Quiz ID is unchanged on next parameters:
//$_GET['employeeid'] = 3838;
//$_GET['quizid'] = 324;
//$_GET['scheduleid'] = 3658;
////-
//$_POST['quizid'] = 350;
//$_POST['datequiz'] = '';
//$_POST['datenextquiz'] = '2020-08-01';
//$_POST['commissiontypeid'] = '3';
//$_POST['scheduleid'] = 3658;
//$_POST['employee'] = 'Борщ Микола Григорович';
//$_POST['quiz'] = 'Екзамен з ОП для ел. монтерів СЗО'; // quizid 324
//$_POST['submit_edit_schedulepoint'] = 'Зберегти';
/*
 * BUG RESUME: 
 * the problem was at edit_employee_renderer.php:58 
 * "if ( ( ! isset( $_POST['submit_edit_employee'] ) ) && ( !..." 
 * which has to be replaced to
 * "if ( ( ! isset( $_POST['submit_edit_schedulepoint'] ) ) && ( !..."
 * --
 * Shortly exploring of algorithm gives clearly imagination about how it
 * causes the bug.
 */



use \mod_quizschedule\output\edit_employee_renderer as renderer;
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

<?php
// Copied from /mod/quiz/review.php:29-262 -> 4-...

/* TESTING-PARAMETERS */
//$_POST['id'] = 154;
//$_POST['userid'] = 649;
//$_POST['attempt'] = 1229;
//$_POST['quiz_student_table_reporttype'] = 'result';
//$_POST['quiz_student_table_reporttype'] = 'topiclist';
//$_POST['quiz_student_table_reportformat'] = 'html';
/* END TESTING-PARAMETERS */

require_once(__DIR__ . '/../../../../../../config.php');
require $CFG->libdir . '/gradelib.php';
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->dirroot . '/mod/quiz/report/reportlib.php');
//require_once($CFG->dirroot . '/mod/quiz/report/student/classes/quiz_attempt.php');
//require_once($CFG->dirroot . '/mod/quiz/report/student/classes/question_attempt.php');
require_once($CFG->dirroot . '/mod/quiz/report/student/report/result/classes/output/renderer.php');

$attemptid = required_param('attempt', PARAM_INT);
//$page      = optional_param('page', 0, PARAM_INT);
$showall   = optional_param('showall', true, PARAM_BOOL);
$cmid      = optional_param('cmid', null, PARAM_INT);


// Report Data
$rd = [];
$rd['page'] = $PAGE;

$url = new moodle_url('/mod/quiz/review.php', array('attempt'=>$attemptid));
if ($page !== 0) {
    $url->param('page', $page);
} else if ($showall) {
    $url->param('showall', $showall);
}
$PAGE->set_url($url);

$attemptobj = quiz_create_attempt_handling_errors($attemptid, $cmid);
$rd['course_fullname'] = $attemptobj->get_course()->fullname;
//$page = $attemptobj->force_page_number_into_range($page);

// Now we can validate the params better, re-genrate the page URL.
//if ($showall === null) {
//    $showall = $page == 0 && $attemptobj->get_default_show_all('review');
//}
//$PAGE->set_url($attemptobj->review_url(null, $page, $showall));
$PAGE->set_url($attemptobj->review_url(null, 1, $showall));

// Check login.
require_login($attemptobj->get_course(), false, $attemptobj->get_cm());
$attemptobj->check_review_capability();

// Create an object to manage all the other (non-roles) access rules.
$accessmanager = $attemptobj->get_access_manager(time());
$accessmanager->setup_attempt_page($PAGE);

$options = $attemptobj->get_display_options(true);

// Check permissions - warning there is similar code in reviewquestion.php and
// quiz_attempt::check_file_access. If you change on, change them all.
if ($attemptobj->is_own_attempt()) {
    if (!$attemptobj->is_finished()) {
        redirect($attemptobj->attempt_url(null, 1));

    } else if (!$options->attempt) {
        $accessmanager->back_to_view_page($PAGE->get_renderer('mod_quiz'),
                $attemptobj->cannot_review_message());
    }

} else if (!$attemptobj->is_review_allowed()) {
    throw new moodle_quiz_exception($attemptobj->get_quizobj(), 'noreviewattempt');
}

// Load the questions and states needed by this page.
if ($showall) {
    $questionids = $attemptobj->get_slots();
}
//else {
//    $questionids = $attemptobj->get_slots($page);
//}

// Save the flag states, if they are being changed.
//if ($options->flags == question_display_options::EDITABLE && optional_param('savingflags', false,
//        PARAM_BOOL)) {
//    require_sesskey();
//    $attemptobj->save_question_flags();
//    redirect($attemptobj->review_url(null, $page, $showall));
//}

// Work out appropriate title and whether blocks should be shown.
//if ($attemptobj->is_own_preview()) {
//    $strreviewtitle = get_string('reviewofpreview', 'quiz');
//    navigation_node::override_active_url($attemptobj->start_attempt_url());
//
//} else {
//    $strreviewtitle = get_string('reviewofattempt', 'quiz', $attemptobj->get_attempt_number());
//    if (empty($attemptobj->get_quiz()->showblocks) && !$attemptobj->is_preview_user()) {
//        $PAGE->blocks->show_only_fake_blocks();
//    }
//}

// Set up the page header.
//$headtags = $attemptobj->get_html_head_contributions($page, $showall);
//$PAGE->set_title($attemptobj->get_quiz_name());
//$PAGE->set_heading($attemptobj->get_course()->fullname);

// Summary table start. ============================================================================

// Work out some time-related things.
$attempt = $attemptobj->get_attempt();
$quiz = $attemptobj->get_quiz();

$rd['timefinish'] = $attempt->timefinish;

/*$overtime = 0;

if ($attempt->state == quiz_attempt::FINISHED) {
    if ($timetaken = ($attempt->timefinish - $attempt->timestart)) {
        if ($quiz->timelimit && $timetaken > ($quiz->timelimit + 60)) {
            $overtime = $timetaken - $quiz->timelimit;
            $overtime = format_time($overtime);
        }
        $timetaken = format_time($timetaken);
    } else {
        $timetaken = "-";
    }
} else {
    $timetaken = get_string('unfinished', 'quiz');
}*/

// Prepare summary informat about the whole attempt.
$summarydata = array();
//if (!$attemptobj->get_quiz()->showuserpicture && $attemptobj->get_userid() != $USER->id) {
    // If showuserpicture is true, the picture is shown elsewhere, so don't repeat it.
    $student = $DB->get_record('user', array('id' => $attemptobj->get_userid()));
    $rd['lastname'] = $student->lastname;
    $rd['firstname'] = $student->firstname;
    $rd['position'] = $student->address;
    $rd['company'] = $student->institution;
    $rd['department'] = $student->department;
    
//    $userpicture = new user_picture($student);
//    $userpicture->courseid = $attemptobj->get_courseid();
//    $summarydata['user'] = array(
//        'title'   => $userpicture,
//        'content' => new action_link(new moodle_url('/user/view.php', array(
//                                'id' => $student->id, 'course' => $attemptobj->get_courseid())),
//                          fullname($student, true)),
//    );
//}

//if ($attemptobj->has_capability('mod/quiz:viewreports')) {
//    $attemptlist = $attemptobj->links_to_other_attempts($attemptobj->review_url(null, $page,
//            $showall));
//    if ($attemptlist) {
//        $summarydata['attemptlist'] = array(
//            'title'   => get_string('attempts', 'quiz'),
//            'content' => $attemptlist,
//        );
//    }
//}

// Timing information.
//$summarydata['startedon'] = array(
//    'title'   => get_string('startedon', 'quiz'),
//    'content' => userdate($attempt->timestart),
//);
//
//$summarydata['state'] = array(
//    'title'   => get_string('attemptstate', 'quiz'),
//    'content' => quiz_attempt::state_name($attempt->state),
//);

//if ($attempt->state == quiz_attempt::FINISHED) {
//    $summarydata['completedon'] = array(
//        'title'   => get_string('completedon', 'quiz'),
//        'content' => userdate($attempt->timefinish),
//    );
//    $summarydata['timetaken'] = array(
//        'title'   => get_string('timetaken', 'quiz'),
//        'content' => $timetaken,
//    );
//}

//if (!empty($overtime)) {
//    $summarydata['overdue'] = array(
//        'title'   => get_string('overdue', 'quiz'),
//        'content' => $overtime,
//    );
//}

// Show marks (if the user is allowed to see marks at the moment).
$grade = quiz_rescale_grade($attempt->sumgrades, $quiz, false);
$rd['grade'] = $grade;



// Grade to pass

$cm = $attemptobj->get_cm();

$course = $attemptobj->get_course();

$rd['gradepass'] = ( function( $cm, $course ){
    global $DB;
    $gradepass;
    
    // Check module exists.
    $module = $DB->get_record('modules', array('id'=>$cm->module), '*', MUST_EXIST);
    
    if ( ! $module ) return null;
    
    if ( $items = grade_item::fetch_all( [
        'itemtype'=>'mod',
        'itemmodule'=>$module->name,
        'iteminstance'=>$cm->instance,
        'courseid'=>$course->id
    ] )) {
        
        // Add existing outcomes.
        foreach ( $items as $item ) {
            
            if ( isset( $item->gradepass ) ) {
                
                $decimalpoints = $item->get_decimals();
                
                $gradepass = format_float($item->gradepass, $decimalpoints);
                
            }
            
        }
        
    }
    
    
    
    return $gradepass;
    
} )( $cm, $course );

if ($options->marks >= question_display_options::MARK_AND_MAX && quiz_has_grades($quiz)) {

    if ($attempt->state != quiz_attempt::FINISHED) {
        // Cannot display grade.

    } else if (is_null($grade)) {
        $summarydata['grade'] = array(
            'title'   => get_string('grade', 'quiz'),
            'content' => quiz_format_grade($quiz, $grade),
        );

    } else {
        // Show raw marks only if they are different from the grade (like on the view page).
        if ($quiz->grade != $quiz->sumgrades) {
            $a = new stdClass();
            $a->grade = quiz_format_grade($quiz, $attempt->sumgrades);
            $a->maxgrade = quiz_format_grade($quiz, $quiz->sumgrades);
            $summarydata['marks'] = array(
                'title'   => get_string('marks', 'quiz'),
                'content' => get_string('outofshort', 'quiz', $a),
            );
        }

        // Now the scaled grade.
        $a = new stdClass();
        $a->grade = html_writer::tag('b', quiz_format_grade($quiz, $grade));
        $a->maxgrade = quiz_format_grade($quiz, $quiz->grade);
        if ($quiz->grade != 100) {
            $a->percent = html_writer::tag('b', format_float(
                    $attempt->sumgrades * 100 / $quiz->sumgrades, 0));
            $formattedgrade = get_string('outofpercent', 'quiz', $a);
        } else {
            $formattedgrade = get_string('outof', 'quiz', $a);
        }
        $summarydata['grade'] = array(
            'title'   => get_string('grade', 'quiz'),
            'content' => $formattedgrade,
        );
    }
}

// Any additional summary data from the behaviour.
//$summarydata = array_merge($summarydata, $attemptobj->get_additional_summary_data($options));
//
//// Feedback if there is any, and the user is allowed to see it now.
//$feedback = $attemptobj->get_overall_feedback($grade);
//if ($options->overallfeedback && $feedback) {
//    $summarydata['feedback'] = array(
//        'title'   => get_string('feedback', 'quiz'),
//        'content' => $feedback,
//    );
//}

// Summary table end. ==============================================================================

//if ($showall) {
//    $slots = $attemptobj->get_slots();
//    $lastpage = true;
//} else {
//    $slots = $attemptobj->get_slots($page);
//    $lastpage = $attemptobj->is_last_page($page);
//}

//$output = $PAGE->get_renderer('mod_quiz');
//$output->header();
//echo '1';
//$output->footer();


// Arrange for the navigation to be displayed.
//$navbc = $attemptobj->get_navigation_panel($output, 'quiz_review_nav_panel', $page, $showall);
//$regions = $PAGE->blocks->get_regions();
//$PAGE->blocks->add_fake_block($navbc, reset($regions)); $page = 1;
//echo $output->review_page($attemptobj, $slots, $page, $showall, $lastpage, $options, $summarydata);

// Trigger an event for this review.
//$attemptobj->fire_attempt_reviewed_event();

$student_attemptobj = new quiz_student\quiz_attempt($attemptobj);
$rd['question_count'] = $student_attemptobj->get_question_count();
$rd['incorrectanswer_count'] = $student_attemptobj->get_incorrectanswer_count();
$rd['topiclist'] = ( function() {
    global $CFG;
    
    // Get Theme List
    //$themelist_str = file_get_contents( __DIR__ . '/themelist.txt' ); // prev version
    $themelist_str = $CFG->qs_report_standard_themelist;
    
    // Explode to Lines
    $name_arr = explode( "\n", $themelist_str );
    
    // Result
    return $name_arr;
} )();

$renderer = new quiz_student_result\renderer;
$renderer->display($rd);


exit;











?>
<style>
    .title {
        font-weight: 800;
    }
    .data {
        color: blue;
        margin-bottom: 1rem;
    }
</style>
<div class="title">Протокол перевірки знань № ____</div>
<br/>
<br/>
<br/>

1. Результат перевірки знань в програмному комплексі "Moodle":<br/><br/>

<div class="title">Назва контрольного набору</div>
<div class="data">
    <?= $attemptobj->get_course()->fullname ?>
</div>

<div class="title">Кількість запитань</div>
<div class="data">
    <?= $student_attemptobj->get_question_count() ?>
</div>

<div class="title">Кількість помилок</div>
<div class="data">
    <?= $student_attemptobj->get_incorrectanswer_count() ?>
</div>

<div class="title">Оцінка</div>
<div class="data">
    <?= $grade >= 0.85 ? 'знає' : 'не знає' ?>
</div>
<br/>
<br/>
<br/>

2. Результати опитування:<br/><br/>
<div class="title">№ п/п</div>
<div class="data">
    <?= '{number}' ?>
</div>

<div class="title">Прізвище, ім'я, по-батькові, посада</div>
<div class="data">
    <?= $student->lastname ?><br/>
    <?= $student->firstname ?><br/>
    <?= '{position}' ?><br/>
    <?= '{location}' ?>
</div>

<div class="title">Дата попередньої перевірки, група з електробезпеки</div>
<div class="data">
    <?= '{date}' ?>
</div>

<div class="title">Дата перевірки, причина, група з електробезпеки</div>
<div class="data">
    <?= date('Y.m.d', $attempt->timefinish) . '<br>' . date('H:i', $attempt->timefinish) ?>
</div>

<div class="title">Тема перевірки (охорона праці, правила пожежної безпеки, вимоги Держгірпромнагляду, технологія робіт)</div>
<div class="data">
    <?= implode('<br/>', $student_attemptobj->get_topiclist_names()) ?>
</div>

<div class="title">Рішення комісії (знає, не знає)</div>
<div class="data">
    <?= '[handmade]' ?>
</div>

<div class="title">Дата наступної перевірки</div>
<div class="data">
    <?= '[handmade]' ?>
</div>

<div class="title">Підпис особи, яка перевіряється</div>
<div class="data">
    <?= '[handmade]' ?>
</div>
<br/>
<br/>
<br/>

<div class="title">Рішення комісії</div>
<div class="title">Спец.роботи:</div>
<br/>
<br/>
<br/>

<div class="title">Голова комісії:</div>
___ ___ ___ <i>(підпис)</i><br/>
<br/>
<br/>
<br/>

<div class="title">Члени комісії:</div>
___ ___ ___ <i>(підпис)</i><br/>
___ ___ ___ <i>(підпис)</i><br/>
___ ___ ___ <i>(підпис)</i><br/>
___ ___ ___ <i>(підпис)</i><br/>

<?php
//echo $attemptobj->get_course()->fullname . '<br /><br />';
//
//echo 'Оцінка '.$grade.' з '.$a->maxgrade . '<br /><br />';
//
//echo 'Прізвище, ім\'я, по-батькові, посада: ';
//echo $student->lastname . ' ' . $student->firstname . ', ' . 'NEED position:{н-д, диспетчер району мереж 2 групи} ' . 'NEED: office location:{н-д, Диканська філія}' . '<br /><br />';
//
//echo 'Дата перевірки: ';
//echo date('Y.m.d H:i', $attempt->timefinish) . '<br /><br />';

//$q = new question;

//return;


//exit;
//foreach ($slots as $slot) {
//    $qa = $attemptobj->get_question_attempt($slot);
//    $m = $qa->has_marks();
//    $m = $qa->get_min_fraction();
//    $m = $qa->get_max_fraction();
//    $m = $qa->get_fraction();
//    $m = $qa->fraction_to_mark($m);
//    $m = $qa->get_mark();
//    $m = $qa->get_max_mark();
//    $m = $qa->get_state();
//    $m = $qa->get_state_string(false);
//}


/**#@+
 * Options determining how the grades from individual attempts are combined to give
 * the overall grade for a user
 */
//define('QUIZ_GRADEHIGHEST', '1');
//define('QUIZ_GRADEAVERAGE', '2');
//define('QUIZ_ATTEMPTFIRST', '3');
//define('QUIZ_ATTEMPTLAST',  '4');
/**#@-*/
//quiz_get_grading_option_name($quiz->grademethod);
//function quiz_get_grading_options() {
//    return array(
//        QUIZ_GRADEHIGHEST => get_string('gradehighest', 'quiz'),
//        QUIZ_GRADEAVERAGE => get_string('gradeaverage', 'quiz'),
//        QUIZ_ATTEMPTFIRST => get_string('attemptfirst', 'quiz'),
//        QUIZ_ATTEMPTLAST  => get_string('attemptlast', 'quiz')
//    );
//}
/**
 * @param int $option one of the values QUIZ_GRADEHIGHEST, QUIZ_GRADEAVERAGE,
 *      QUIZ_ATTEMPTFIRST or QUIZ_ATTEMPTLAST.
 * @return the lang string for that option.
 */
//function quiz_get_grading_option_name($option) {
//    $strings = quiz_get_grading_options();
//    return $strings[$option];
//}
//
//if ($state->is_finished() && $state != question_state::$needsgrading) {
//    question_state::graded_state_for_fraction($fraction)->get_feedback_class();
//    $feedbackimg = $this->icon_for_fraction($this->slot_fraction($attempt, $slot));
//}
//
//if ($question->maxmark == 0) {
//    $grade = '-';
//} else if (is_null($stepdata->fraction)) {
//    if ($state == question_state::$needsgrading) {
//        $grade = get_string('requiresgrading', 'question');
//    } else {
//        $grade = '-';
//    }
//} else {
//    $grade = quiz_rescale_grade(
//            $stepdata->fraction * $question->maxmark, $this->quiz, 'question');
//}

//
//$a->mark = $qa->format_mark($options->markdp);      // 0.80
//$a->max = $qa->format_max_mark($options->markdp);   // 1.00
//
//$qa->get_question()->qtype->name();
//$qa->get_behaviour_name();
//$qa->has_marks();


//quiz_attempt $attemptobj
//$slots = $attemptobj->get_slots();

//foreach ($slots as $slot) {
//    $output .= $attemptobj->render_question($slot, $reviewing, $this,
//            $attemptobj->review_url($slot, $page, $showall));
//}
//// question_attempt
//public function get_fraction() {
//    return $this->get_last_step()->get_fraction();
//}
//
//public function get_last_step() {
//    if (count($this->steps) == 0) {
//        return new question_null_step();
//    }
//    return end($this->steps);
//}
//public function fraction_to_mark($fraction) {
//    if (is_null($fraction)) {
//        return null;
//    }
//    return $fraction * $this->maxmark; // 0.8 * 1, how many user took (from maximum mark)
//}
//public function format_max_mark($dp) {
//    return format_float($this->maxmark, $dp); // 1
//}
//// question_attempt_step
//public function get_fraction() {
//    return $this->fraction; // 0.8
//}
//
//$qa->format_mark($options->markdp); // 

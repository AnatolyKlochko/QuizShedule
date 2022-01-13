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
 * This file defines the quiz grades table.
 *
 * @package   quiz_overview
 * @copyright 2008 Jamie Pratt
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/quiz/report/student/config.php');
require_once($CFG->dirroot . '/mod/quiz/report/attemptsreport_table.php');


/**
 * This is a table subclass for displaying the quiz grades report.
 *
 * @copyright 2008 Jamie Pratt
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class quiz_student_table extends quiz_attempts_report_table {

    private $reporttype = [];
    private $reportformat = [];
    
    protected $regradedqs = array();

    /**
     * Constructor
     * @param object $quiz
     * @param context $context
     * @param string $qmsubselect
     * @param quiz_overview_options $options
     * @param \core\dml\sql_join $groupstudentsjoins
     * @param \core\dml\sql_join $studentsjoins
     * @param array $questions
     * @param moodle_url $reporturl
     */
    public function __construct($quiz, $context, $qmsubselect,
            quiz_student_options $options, \core\dml\sql_join $groupstudentsjoins,
            \core\dml\sql_join $studentsjoins, $questions, $reporturl) {
        parent::__construct('mod-quiz-report-student-report', $quiz , $context,
                $qmsubselect, $options, $groupstudentsjoins, $studentsjoins, $questions, $reporturl);
    }

    public function build_table() {
        global $DB;

        if (!$this->rawdata) {
            return;
        }

        $this->strtimeformat = str_replace(',', ' ', get_string('strftimedatetime'));
        
        $this->prepare_reporttype();
        $this->prepare_reportformat();
        
        parent::build_table();
        
        // End of adding the data from attempts. Now add averages at bottom.
//        $this->add_separator();
//
//        if (!empty($this->groupstudentsjoins->joins)) {
//            $sql = "SELECT DISTINCT u.id
//                      FROM {user} u
//                    {$this->groupstudentsjoins->joins}
//                     WHERE {$this->groupstudentsjoins->wheres}";
//            $groupstudents = $DB->get_records_sql($sql, $this->groupstudentsjoins->params);
//            if ($groupstudents) {
//                $this->add_average_row(get_string('groupavg', 'grades'), $this->groupstudentsjoins);
//            }
//        }
//
//        if (!empty($this->studentsjoins->joins)) {
//            $sql = "SELECT DISTINCT u.id
//                      FROM {user} u
//                    {$this->studentsjoins->joins}
//                     WHERE {$this->studentsjoins->wheres}";
//            $students = $DB->get_records_sql($sql, $this->studentsjoins->params);
//            if ($students) {
//                $this->add_average_row(get_string('overallaverage', 'grades'), $this->studentsjoins);
//            }
//        }
    }

    public function get_sql_sort() {
        return 'quiza.timefinish DESC';
    }
    
    /**
     * Calculate the average overall and question scores for a set of attempts at the quiz.
     *
     * @param string $label the title ot use for this row.
     * @param \core\dml\sql_join $usersjoins to indicate a set of users.
     * @return array of table cells that make up the average row.
     */
    public function compute_average_row($label, \core\dml\sql_join $usersjoins) {
        global $DB;

        list($fields, $from, $where, $params) = $this->base_sql($usersjoins);
        $record = $DB->get_record_sql("
                SELECT AVG(quizaouter.sumgrades) AS grade, COUNT(quizaouter.sumgrades) AS numaveraged
                  FROM {quiz_attempts} quizaouter
                  JOIN (
                       SELECT DISTINCT quiza.id
                         FROM $from
                        WHERE $where
                       ) relevant_attempt_ids ON quizaouter.id = relevant_attempt_ids.id
                ", $params);
        $record->grade = quiz_rescale_grade($record->grade, $this->quiz, false);
        if ($this->is_downloading()) {
            $namekey = 'lastname';
        } else {
            $namekey = 'fullname';
        }
        $averagerow = array(
            $namekey       => $label,
            'sumgrades'    => $this->format_average($record),
            'feedbacktext' => strip_tags(quiz_report_feedback_for_grade(
                                         $record->grade, $this->quiz->id, $this->context))
        );

        if ($this->options->slotmarks) {
            $dm = new question_engine_data_mapper();
            $qubaids = new qubaid_join("{quiz_attempts} quizaouter
                  JOIN (
                       SELECT DISTINCT quiza.id
                         FROM $from
                        WHERE $where
                       ) relevant_attempt_ids ON quizaouter.id = relevant_attempt_ids.id",
                    'quizaouter.uniqueid', '1 = 1', $params);
            $avggradebyq = $dm->load_average_marks($qubaids, array_keys($this->questions));

            $averagerow += $this->format_average_grade_for_questions($avggradebyq);
        }

        return $averagerow;
    }

    /**
     * Add an average grade row for a set of users.
     *
     * @param string $label the title ot use for this row.
     * @param \core\dml\sql_join $usersjoins (joins, wheres, params) for the users to average over.
     */
    protected function add_average_row($label, \core\dml\sql_join $usersjoins) {
        $averagerow = $this->compute_average_row($label, $usersjoins);
        $this->add_data_keyed($averagerow);
    }

    /**
     * Helper userd by {@link add_average_row()}.
     * @param array $gradeaverages the raw grades.
     * @return array the (partial) row of data.
     */
    protected function format_average_grade_for_questions($gradeaverages) {
        $row = array();

        if (!$gradeaverages) {
            $gradeaverages = array();
        }

        foreach ($this->questions as $question) {
            if (isset($gradeaverages[$question->slot]) && $question->maxmark > 0) {
                $record = $gradeaverages[$question->slot];
                $record->grade = quiz_rescale_grade(
                        $record->averagefraction * $question->maxmark, $this->quiz, false);

            } else {
                $record = new stdClass();
                $record->grade = null;
                $record->numaveraged = 0;
            }

            $row['qsgrade' . $question->slot] = $this->format_average($record, true);
        }

        return $row;
    }

    /**
     * Format an entry in an average row.
     * @param object $record with fields grade and numaveraged.
     * @param bool $question true if this is a question score, false if it is an overall score.
     * @return string HTML fragment for an average score (with number of things included in the average).
     */
    protected function format_average($record, $question = false) {
        if (is_null($record->grade)) {
            $average = '-';
        } else if ($question) {
            $average = quiz_format_question_grade($this->quiz, $record->grade);
        } else {
            $average = quiz_format_grade($this->quiz, $record->grade);
        }

        if ($this->download) {
            return $average;
        } else if (is_null($record->numaveraged) || $record->numaveraged == 0) {
            return html_writer::tag('span', html_writer::tag('span',
                    $average, array('class' => 'average')), array('class' => 'avgcell'));
        } else {
            return html_writer::tag('span', html_writer::tag('span',
                    $average, array('class' => 'average')) . ' ' . html_writer::tag('span',
                    '(' . $record->numaveraged . ')', array('class' => 'count')),
                    array('class' => 'avgcell'));
        }
    }

    protected function submit_buttons() {
        if (has_capability('mod/quiz:regrade', $this->context)) {
            echo '<input type="submit" class="btn btn-secondary m-r-1" name="regrade" value="' .
                    get_string('regradeselected', 'quiz_overview') . '"/>';
        }
        parent::submit_buttons();
    }

    public function col_sumgrades($attempt) {
        if ($attempt->state != quiz_attempt::FINISHED) {
            return '-';
        }

        $grade = quiz_rescale_grade($attempt->sumgrades, $this->quiz);
        if ($this->is_downloading()) {
            return $grade;
        }

        if (isset($this->regradedqs[$attempt->usageid])) {
            $newsumgrade = 0;
            $oldsumgrade = 0;
            foreach ($this->questions as $question) {
                if (isset($this->regradedqs[$attempt->usageid][$question->slot])) {
                    $newsumgrade += $this->regradedqs[$attempt->usageid]
                            [$question->slot]->newfraction * $question->maxmark;
                    $oldsumgrade += $this->regradedqs[$attempt->usageid]
                            [$question->slot]->oldfraction * $question->maxmark;
                } else {
                    $newsumgrade += $this->lateststeps[$attempt->usageid]
                            [$question->slot]->fraction * $question->maxmark;
                    $oldsumgrade += $this->lateststeps[$attempt->usageid]
                            [$question->slot]->fraction * $question->maxmark;
                }
            }
            $newsumgrade = quiz_rescale_grade($newsumgrade, $this->quiz);
            $oldsumgrade = quiz_rescale_grade($oldsumgrade, $this->quiz);
            $grade = html_writer::tag('del', $oldsumgrade) . '/' .
                    html_writer::empty_tag('br') . $newsumgrade;
        }
        return html_writer::link(new moodle_url('/mod/quiz/review.php',
                array('attempt' => $attempt->attempt)), $grade,
                array('title' => get_string('reviewattempt', 'quiz')));
    }

    /**
     * @param string $colname the name of the column.
     * @param object $attempt the row of data - see the SQL in display() in
     * mod/quiz/report/overview/report.php to see what fields are present,
     * and what they are called.
     * @return string the contents of the cell.
     */
    public function other_cols($colname, $attempt) {
        if (!preg_match('/^qsgrade(\d+)$/', $colname, $matches)) {
            return null;
        }
        $slot = $matches[1];

        $question = $this->questions[$slot];
        if (!isset($this->lateststeps[$attempt->usageid][$slot])) {
            return '-';
        }

        $stepdata = $this->lateststeps[$attempt->usageid][$slot];
        $state = question_state::get($stepdata->state);

        if ($question->maxmark == 0) {
            $grade = '-';
        } else if (is_null($stepdata->fraction)) {
            if ($state == question_state::$needsgrading) {
                $grade = get_string('requiresgrading', 'question');
            } else {
                $grade = '-';
            }
        } else {
            $grade = quiz_rescale_grade(
                    $stepdata->fraction * $question->maxmark, $this->quiz, 'question');
        }

        if ($this->is_downloading()) {
            return $grade;
        }

        if (isset($this->regradedqs[$attempt->usageid][$slot])) {
            $gradefromdb = $grade;
            $newgrade = quiz_rescale_grade(
                    $this->regradedqs[$attempt->usageid][$slot]->newfraction * $question->maxmark,
                    $this->quiz, 'question');
            $oldgrade = quiz_rescale_grade(
                    $this->regradedqs[$attempt->usageid][$slot]->oldfraction * $question->maxmark,
                    $this->quiz, 'question');

            $grade = html_writer::tag('del', $oldgrade) . '/' .
                    html_writer::empty_tag('br') . $newgrade;
        }

        return $this->make_review_link($grade, $attempt, $slot);
    }

    public function col_regraded($attempt) {
        if ($attempt->regraded == '') {
            return '';
        } else if ($attempt->regraded == 0) {
            return get_string('needed', 'quiz_overview');
        } else if ($attempt->regraded == 1) {
            return get_string('done', 'quiz_overview');
        }
    }

    protected function update_sql_after_count($fields, $from, $where, $params) {
        $fields .= ", COALESCE((
                                SELECT MAX(qqr.regraded)
                                  FROM {quiz_overview_regrades} qqr
                                 WHERE qqr.questionusageid = quiza.uniqueid
                          ), -1) AS regraded";
        if ($this->options->onlyregraded) {
            $where .= " AND COALESCE((
                                    SELECT MAX(qqr.regraded)
                                      FROM {quiz_overview_regrades} qqr
                                     WHERE qqr.questionusageid = quiza.uniqueid
                                ), -1) <> -1";
        }
        return [$fields, $from, $where, $params];
    }

    protected function requires_latest_steps_loaded() {
        return $this->options->slotmarks;
    }

    protected function is_latest_step_column($column) {
        if (preg_match('/^qsgrade([0-9]+)/', $column, $matches)) {
            return $matches[1];
        }
        return false;
    }

    protected function get_required_latest_state_fields($slot, $alias) {
        return "$alias.fraction * $alias.maxmark AS qsgrade$slot";
    }

    public function query_db($pagesize, $useinitialsbar = true) {
        parent::query_db($pagesize, $useinitialsbar);

        if ($this->options->slotmarks && has_capability('mod/quiz:regrade', $this->context)) {
            $this->regradedqs = $this->get_regraded_questions();
        }
    }

    /**
     * Get all the questions in all the attempts being displayed that need regrading.
     * @return array A two dimensional array $questionusageid => $slot => $regradeinfo.
     */
    protected function get_regraded_questions() {
        global $DB;

        $qubaids = $this->get_qubaids_condition();
        $regradedqs = $DB->get_records_select('quiz_overview_regrades',
                'questionusageid ' . $qubaids->usage_id_in(), $qubaids->usage_id_in_params());
        return quiz_report_index_by_keys($regradedqs, array('questionusageid', 'slot'));
    }
    
    private function get_reporttype_array() {
        //$ar = ... // from DB
        global $QRS_CFG;
        
        $ar = [];
        
        foreach ($QRS_CFG->reporttype as $type) {
            $item = new stdClass;
            $item->name = $type['name'];
            $item->report_url = $type['report_url'];
            $ar[] = $item;
        }
        
        
        return $ar;
    }
    
    private function get_reportformat_array() {
        //$ar = ... // from DB
        global $QRS_CFG;
        
        $ar = $QRS_CFG->reportformat;
        
        
        return $ar;
    }
    
    private function prepare_reporttype() {
        $cntr = '<select name="quiz_student_table_reporttype">';
        foreach ($this->get_reporttype_array() as $type) {
            $cntr .= '<option value="' . $type->name . '" data-url="' . $type->report_url . '">' . get_string('reporttype_' . $type->name, 'quiz_student') . '</option>';
        }
        $cntr .= '</select>';
        $this->reporttype = $cntr;
    }
    
    private function prepare_reportformat() {
        $cntr = '<select name="quiz_student_table_reportformat">';
        foreach ($this->get_reportformat_array() as $format) {
            $cntr .= '<option value="' . $format . '">' . $format . '</option>';
        }
        $cntr .= '</select>';
        $this->reportformat = $cntr;
    }
    
    protected function col_reporttype() {
        return $this->reporttype;
    }
    protected function col_reportformat() {
        return $this->reportformat;
    }
    protected function col_actionbutton() {
        return '<input type="submit" value="' . get_string('actionbutton_text', 'quiz_student') . '">';
    }
    
    // O V E R R I D I N G S
    
    /**
     * This function is not part of the public api.
     */
    public function start_html() {
        global $OUTPUT;

        // Render button to allow user to reset table preferences.
        //echo $this->render_reset_button();

        // Do we need to print initial bars?
        //$this->print_initials_bar();

        // Paging bar
        if ($this->use_pages) {
//            $pagingbar = new paging_bar($this->totalrows, $this->currpage, $this->pagesize, $this->baseurl);
//            $pagingbar->pagevar = $this->request[TABLE_VAR_PAGE];
//            echo $OUTPUT->render($pagingbar);
        }

        if (in_array(TABLE_P_TOP, $this->showdownloadbuttonsat)) {
            //echo $this->download_buttons();
        }

        //$this->wrap_html_start();
        // Start of main data table

        echo html_writer::start_tag('div', array('class' => 'no-overflow'));
        echo html_writer::start_tag('table', $this->attributes);

    }
    
    /**
     * This function is not part of the public api.
     */
    function finish_html() {
        global $OUTPUT;
        if (!$this->started_output) {
            //no data has been added to the table.
            $this->print_nothing_to_display();

        } else {
            // Print empty rows to fill the table to the current pagesize.
            // This is done so the header aria-controls attributes do not point to
            // non existant elements.
            $emptyrow = array_fill(0, count($this->columns), '');
            while ($this->currentrow < $this->pagesize) {
                $this->print_row($emptyrow, 'emptyrow');
            }

            echo html_writer::end_tag('tbody');
            echo html_writer::end_tag('table');
            echo html_writer::end_tag('div');
            //$this->wrap_html_finish();

            // Paging bar
//            if(in_array(TABLE_P_BOTTOM, $this->showdownloadbuttonsat)) {
//                echo $this->download_buttons();
//            }
//
//            if($this->use_pages) {
//                $pagingbar = new paging_bar($this->totalrows, $this->currpage, $this->pagesize, $this->baseurl);
//                $pagingbar->pagevar = $this->request[TABLE_VAR_PAGE];
//                echo $OUTPUT->render($pagingbar);
//            }
        }
    }
    
    /**
     * Generate the display of the user's full name column.
     * @param object $attempt the table row being output.
     * @return string HTML content to go inside the td.
     */
    public function col_fullname($attempt) {
        $html = flexible_table::col_fullname($attempt);
        
        // Add few params - 'attempt' and 'userid'
        $html .= html_writer::empty_tag('input', array('type'=>'hidden', 'name'=>'userid', 'value'=>$attempt->userid));
        $html .= html_writer::empty_tag('input', array('type'=>'hidden', 'name'=>'attempt', 'value'=>$attempt->attempt));
         
        return $html;
    }

    /**
     * Generate the display of the attempt state column.
     * @param object $attempt the table row being output.
     * @return string HTML content to go inside the td.
     */
    public function col_state($attempt) {
        if (!is_null($attempt->attempt)) {
            return quiz_attempt::state_name($attempt->state);
        } else {
            return  '-';
        }
    }

    /**
     * Generate the display of the start time column.
     * @param object $attempt the table row being output.
     * @return string HTML content to go inside the td.
     */
    public function col_timestart($attempt) {
        if ($attempt->attempt) {
            return userdate($attempt->timestart, $this->strtimeformat);
        } else {
            return  '-';
        }
    }

    /**
     * Generate the display of the finish time column.
     * @param object $attempt the table row being output.
     * @return string HTML content to go inside the td.
     */
    public function col_timefinish($attempt) {
        if ($attempt->attempt && $attempt->timefinish) {
            return date('Y.m.d H:i', $attempt->timefinish);
        } else {
            return  '-';
        }
    }

    /**
     * Generate the display of the time taken column.
     * @param object $attempt the table row being output.
     * @return string HTML content to go inside the td.
     */
    public function col_duration($attempt) {
        if ($attempt->timefinish) {
            return format_time($attempt->timefinish - $attempt->timestart);
        } else {
            return '-';
        }
    }
    
    /**
     * Generate html code for the passed row.
     * 
     * flexible_table
     *
     * @param array $row Row data.
     * @param string $classname classes to add.
     *
     * @return string $html html code for the row passed.
     */
    public function get_row_html($row, $classname = '') {
        global $QRS_CFG;
        
        static $suppress_lastrow = NULL;
        $rowclasses = array();

        if ($classname) {
            $rowclasses[] = $classname;
        }

        $rowid = $this->uniqueid . '_r' . $this->currentrow;
        
        
        $html = '';

        // Form
        $html .= html_writer::start_tag('form', [
            'class' => '', 'id' => '', 'target' => '_blank',
            'method' => 'post', 
            'action' => $QRS_CFG->reporttype_defaulturl
        ]);
        
        // Add a param - 'quiz id'
        $html .= html_writer::empty_tag('input', array('type'=>'hidden', 'name'=>'id', 'value'=>$this->quiz->id));
        
        // Table Row
        $html .= html_writer::start_tag('tr', array('class' => implode(' ', $rowclasses), 'id' => $rowid));

        // If we have a separator, print it
        if ($row === NULL) {
            $colcount = count($this->columns);
            $html .= html_writer::tag('td', html_writer::tag('div', '',
                    array('class' => 'tabledivider')), array('colspan' => $colcount));

        } else {
            $colbyindex = array_flip($this->columns);
            foreach ($row as $index => $data) {
                $column = $colbyindex[$index];

                if (empty($this->prefs['collapse'][$column])) {
                    if ($this->column_suppress[$column] && $suppress_lastrow !== NULL && $suppress_lastrow[$index] === $data) {
                        $content = '&nbsp;';
                    } else {
                        $content = $data;
                    }
                } else {
                    $content = '&nbsp;';
                }

                $html .= html_writer::tag('td', $content, array(
                        'class' => 'cell c' . $index . $this->column_class[$column],
                        'id' => $rowid . '_c' . $index,
                        'style' => $this->make_styles_string($this->column_style[$column])));
            }
        }

        // End Table Row
        $html .= html_writer::end_tag('tr');
        
        // End Form
        $html .= html_writer::end_tag('form');

        
        $suppress_enabled = array_sum($this->column_suppress);
        if ($suppress_enabled) {
            $suppress_lastrow = $row;
        }
        $this->currentrow++;
        return $html;
    }
    
}

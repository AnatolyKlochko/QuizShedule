<?php

namespace mod_quizschedule\output;

defined('MOODLE_INTERNAL') || die();

use \mod_quizschedule\helper;
use \mod_quizschedule\view\helper as vhelper;
use \mod_quizschedule\model\schedule;

class edit_employee_renderer {
          
    public function display() {
        global $PAGE, $OUTPUT;
        
        $url = new \moodle_url('/mod/quizschedule/edit_employee.php', []);
        $PAGE->set_url($url);
        $PAGE->set_pagelayout('report');
        
        
        // CSS
        //   
        // Libraries
        //
        // Bootstrap
        $PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/styles/bootstrap/4.0.0/css/bootstrap.min.css' ) );
        // Iconic
        $PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/styles/iconic/1.1.0/font/css/open-iconic-bootstrap.min.css' ) );
        // Custom CSS
        $PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/styles/edit_employee/editemployee_result.css' ) );
        
        // Title, Heading
        $PAGE->set_title( get_string( 'edit_plan_title', 'quizschedule' ) );
        $PAGE->set_heading( get_string( 'edit_plan_title', 'quizschedule' ) );
        
        echo $OUTPUT->header();
        
        
        $this->display_edit_employee();
        
    }
    
    /**
     * Note: this method is runned:
     * - when it is open firstly for edit (for instance, from Shared Schedule)
     * - when it has been edited and new data is sent
     */
    private function display_edit_employee() {
        global $USER;
        
        // View Data
        $managerid = $USER->id;
        $ms = new schedule;
        $vh = new vhelper;
   
        // Get LAST employee schedule point
        $es = new \stdClass;
        if ( ( ! isset( $_POST['submit_edit_schedulepoint'] ) ) && ( ! isset( $_POST['submit_delete_schedulepoint'] ) ) ) {
            // - when it is open firstly for edit (for instance, from Shared Schedule)
            
            
            if ( isset( $_GET['scheduleid'] ) && isset( $_GET['quizid'] ) ) {
                $scheduleid = $_GET['scheduleid'];
                $quizid = $_GET['quizid'];
                $es = $ms->get_schedulepoint( null, null, $scheduleid );
            } elseif ( isset( $_GET['employeeid'] ) && isset( $_GET['quizid'] ) ) {
                $employeeid = $_GET['employeeid'];
                $quizid = $_GET['quizid'];
                $es = $ms->get_schedulepoint( $employeeid, $quizid );
            }
            
            // Set quiz id, if is present
            if ( isset( $quizid ) ) {
                // this line trowed hidden logical error (when it was out of the 'submit' condition), because changing of quiz was imposible
                $_POST['quizid'] = $quizid;

            }
            
            // Set commission type id, if is present
            if ( isset( $es->ctid ) ) {

                $_POST['ctid'] = $es->ctid;

            }
        
        }
        
        
        // Display View
        include helper::modroot() . '/view/edit_employee.php';
    }
    
}

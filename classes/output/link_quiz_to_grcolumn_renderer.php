<?php

namespace mod_quizschedule\output;

defined('MOODLE_INTERNAL') || die();

use \mod_quizschedule\helper;
use \mod_quizschedule\view\helper as vhelper;
use \mod_quizschedule\model\schedule;

class link_quiz_to_grcolumn_renderer {
        
    public function display() {
        
        global $PAGE, $OUTPUT, $CFG, $USER;
        
        
        // Page settings
        $url = new \moodle_url('/mod/quizschedule/link_quiz_to_grcolumn.php', []);
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
        // basictable
        $PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/basictable/1.0.9/basictable.css' ) );
        // dataTables
        //$PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/datatables/1.10.19/css/jquery.dataTables.min.css' ) );
        //$PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/datatables/1.10.19/datatables.min.css' ) ); // NOT WORK. work
        $PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/datatables/1.10.19/dataTables.bootstrap4.min.css' ) ); // NO EFFECT
        //     
        // Custom CSS
        $PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/styles/linkquiztogrcolumn/linkquiztogrcolumn.css' ) );
        
        
        
        // JS
        // 
        // Libraries
        // 
        // jQuery
        //$PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/3.4.1/jquery-3.4.1.min.js' ), true );
        $PAGE->requires->jquery();
        // Bootstrap
        //$PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/styles/bootstrap/4.0.0/js/bootstrap.min.js' ) );
        $PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/styles/bootstrap/4.0.0/js/bootstrap.bundle.min.js' ), true );
        // dataTables
        $PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/datatables/1.10.19/datatables.min.js' ), true ); // NOT WORK. work
        //$PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/datatables/1.10.19/js/jquery.dataTables.min.js' ), true );
        //$PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/datatables/1.10.19/dataTables.bootstrap4.min.js' ), true ); // NO EFFECT
        // jQuery UI
        //$PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/ui/1.12.1/themes/base/jquery-ui.min.css' ) );
        //$PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/ui/1.12.1/jquery-ui.min.js' ), true );
        // 
        // basictable
        $PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/basictable/1.0.9/jquery.basictable.min.js' ), true );
        // Custom scripts
        $PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/datatable.options.js' ), true );
        $PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/link_quiz_to_grcolumn.js' ) );
        
        
        
        
        // Page
        $PAGE->set_title( get_string( 'linkquiztogrcolumn_title', 'quizschedule' ) );
        $PAGE->set_heading( get_string( 'linkquiztogrcolumn_heading', 'quizschedule' ) );

        echo $OUTPUT->header();
        
        $this->display_view();
        
//        $aco = ( new helper )->get_user_groups( $USER );//        var_dump($aco);
//        
//        if ( $aco->is_lc || $aco->is_moddev ) {
//            
//            
//            
//        } elseif ( $aco->is_employee ) {
//            
//            echo 'You have no permissions to view the page.';
//            
//        }
        
    }
    
    private function display_view() {
        global $USER;
        
        // View Data
        $managerid = $USER->id;
        $ms = new schedule;
        $vh = new vhelper;
                
        // Display View
        include helper::modroot() . '/view/link_quiz_to_grcolumn.php';
    }
    
}

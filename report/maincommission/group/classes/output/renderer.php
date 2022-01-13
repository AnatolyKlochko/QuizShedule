<?php
namespace quizschedulemaincommission_group\output;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\report;



class renderer {
    
    /**
     * Report Data Object
     */
    protected $report;
    
    /**
     * Page URL
     */
    protected $url;
    
    /**
     * Page Title
     */
    protected $title;
    
    /**
     * Page Heading
     */
    protected $heading;
    
      
    
    public function __construct( ) {
       
       $this->url = '/mod/quizschedule/report/maincommission/group/index.php';
       
       $this->title = get_string( 'pageindextitle', 'quizschedulemaincommission_group' );
       
       $this->heading = get_string( 'pageindexheading', 'quizschedulemaincommission_group' );
       
    }

    public function display( report $report, bool $display_parents = true ) {
        global $OUTPUT;
        
        $this->report = $report;
      
        
        // Page Settings
        $this->set_settings();
        
        // Page Styles
        $this->add_styles();
        
        // Page Scripts
        $this->add_scripts();
        
        // Content
        echo $OUTPUT->header();
        
        // Main Container
        echo '<div class="container pt-3 cntr-maincommission-group">';
        
        // display parent parts
        if ( $display_parents ) {
            
            $this->display_parent_parts();
            
        } else {
            
            // display breadcrumbs
            
        }
        
        // display parts
        $this->display_parts();

        // Main Container:Close
        echo '</div>';
        
        // Output Footer (here it displays left sidebar too)
        echo $OUTPUT->footer();
        
    }
    
    protected function set_settings() {
        global $PAGE;
                
        // Page settings
        $url = new \moodle_url( $this->url, [] );
        $PAGE->set_url($url);
        $PAGE->set_pagelayout('report');
        
        // Page
        $PAGE->set_title( $this->title );
        $PAGE->set_heading( $this->heading );
    }
    
    protected function add_styles() {
        global $PAGE;
        
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
        $PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/report/maincommission/group/styles/index.css' ) );
    }
    
    protected function add_scripts() {
        global $PAGE;
        
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
        $PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/report/maincommission/group/jquery/index.js' ) );
    }
    
    protected function display_parent_parts() {
                    
        if ( get_parent_class( ) !== false ) { // NOTE: with $this return itself

            parent::display_parent_parts();
            
            parent::display_parts();

        }

    }
    
    protected function display_parts() {
        global $CFG;
        
        $header = $this->report->header;
        
        $action = new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/report/maincommission/group/stage/filtering.php' );
        
        include mod_quizschedule_root( 'report' ) . '/maincommission/group/part/header.php';
        
    }
    
}

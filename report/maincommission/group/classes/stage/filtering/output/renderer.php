<?php
namespace quizschedulemaincommission_group\stage\filtering\output;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\output\renderer as base_renderer;



class renderer extends base_renderer {

    public function __construct( ) {
       
       $this->url = '/mod/quizschedule/report/maincommission/group/stage/filtering.php';
       
       $this->title = get_string( 'pagefilteringtitle', 'quizschedulemaincommission_group' ) . ' - ' . get_string( 'pageindextitle', 'quizschedulemaincommission_group' );
       
       $this->heading = get_string( 'pagefilteringheading', 'quizschedulemaincommission_group' );
       
    }
    
    protected function display_parent_parts() {
                    
        if ( get_parent_class( ) !== false ) { // NOTE: with $this returns name itself

            parent::display_parent_parts();
            
            parent::display_parts();

        }

    }
        
    public function display_parts() {
        global $CFG;
        
        $datatable = $this->report->body->datatable;
        
        $dci = -1; // data-column index
        $nbo = 1; // number by order
        
        
        include mod_quizschedule_root( 'report' ) . '/maincommission/group/part/stage/filtering/datatable.php';
        
        if ( count( $datatable->source ) > 0 ) {
            
            $printinglink = new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/report/maincommission/group/format/printing.php' );
            $pdflink = new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/maincommission/group/format/pdf.php' );
            $docxlink = new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/maincommission/group/format/docx.php' );
            
            include mod_quizschedule_root( 'report' ) . '/maincommission/group/part/stage/filtering/format.php';
            
        }
        
    }
    
}

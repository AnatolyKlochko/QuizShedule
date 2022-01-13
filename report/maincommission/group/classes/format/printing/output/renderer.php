<?php
namespace quizschedulemaincommission_group\format\printing\output;

defined('MOODLE_INTERNAL') || die();

use mod_quizschedule\admin_helper;



class renderer {
    
    public function display( $report ) {
        global $CFG, $PAGE, $OUTPUT;
        
        $htmlpage = $PAGE;
        $output = $OUTPUT;
        
        $htmlpage->set_title( '' ); // doesn't work
        //$page->bodyid = '';
        
        $bodyclasses = array();
        $bodyclasses[] = 'report';
        
        
        // Module Helpers
        $admin_helper = new admin_helper;
        
        
        
        // Report Components
        
        // Page
        $page = $report->page;
                
        // Header
        $header = $report->header;
        
        // Body           
        $body = $report->body;
        
        $datatable = $body->datatable;
        $numbering = $datatable->numbering;
        $employeeinfo = $datatable->employeeinfo;
        $sharetype = $datatable->sharetype;
                
        // Footer
        $footer = $report->footer;

        include mod_quizschedule_root( 'report' ) . '/maincommission/group/part/format/printing.php';
        
    }
    
}

<?php

namespace quizschedulemaincommission_group\formatprint\output;

defined('MOODLE_INTERNAL') || die();

use mod_quizschedule\helper as helper;
use quizschedulemaincommission_group\schedule;

class renderer {
    
    public function display( $report ) {
        global $CFG, $PAGE, $OUTPUT;
        
        $page = $PAGE;
        $output = $OUTPUT;
        
        $page->set_title( get_string( 'pluginname', 'quizschedulemaincommission_group' ) . ' - ' . $report->date );
        //$page->bodyid = '';
        
        $bodyclasses = array();
        $bodyclasses[] = 'report';
        
        // Module
        $helper = new helper;
        
        // Report
        $rpage = $report->page;
        
        $header = $report->header;
        
        $body = $report->body;
        
        $datatable = $body->datatable;
        $col_numbering = $datatable->column['numbering'];
        $col_employeeinfo = $datatable->column['employeeinfo'];
        $col_sharetype = $datatable->column['sharetype'];
        
        $footer = $report->footer;
        
        
        // Filtering
        $schedule = new schedule;
        
        include $CFG->dirroot . '/mod/quizschedule/report/maincommission/group/view/format/print.php';
        
    }
    
}

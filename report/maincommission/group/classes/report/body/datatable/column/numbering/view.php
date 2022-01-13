<?php
namespace quizschedulemaincommission_group\report\body\datatable\column\numbering;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\view as base_view;



/**
 * Numbering View
 */
class view extends base_view {
    
    /**
     * Content of property 'class'
     */
    public $headerclass;
    
    
    
    public function __construct( ) {
                
        // Header Class
        $this->init_headerclass( );
             
    }
    
    private function init_headerclass( ) {
        
        // Class, whole CSS
        $this->headerclass = 'text-center'; //get_config( 'quizschedulemaincommission_group', "datatablecol{$key}font" );
        
    }
        
}

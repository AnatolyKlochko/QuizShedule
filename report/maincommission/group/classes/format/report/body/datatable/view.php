<?php
namespace quizschedulemaincommission_group\format\report\body\datatable;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\format\view as base_view;



/**
 * Datatable View
 */
class view extends base_view {
    
    /**
     * Header Height, with units
     */
    public $headerheight;
    
    /**
     * Header Font, whole CSS
     */
    public $headerfont;
    
    /**
     * Font
     */
    public $font;
    
    
    
    public function __construct( ) {
        
        $this->init_headerheight();
           
        $this->init_headerfont();
        
        $this->init_font();
             
    }
    
    private function init_headerheight() {
        
        // Header Height, with units
        $this->headerheight = get_config( 'quizschedulemaincommission_group', 'datatableheaderheight' );
        
    }
    
    private function init_headerfont() {
        
        // Header Font, whole CSS
        $this->headerfont = get_config( 'quizschedulemaincommission_group', 'datatableheaderfont' );
        
    }
    
    private function init_font() {
        
        // Font, whole CSS
        $this->font = get_config( 'quizschedulemaincommission_group', 'datatablebodyfont' );
        
    }
        
}

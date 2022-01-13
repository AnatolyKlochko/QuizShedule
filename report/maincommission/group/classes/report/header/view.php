<?php
namespace quizschedulemaincommission_group\report\header;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\view as base_view;



/**
 * Header View
 */
class view extends base_view {
        
    /**
     * Margin
     */
    public $margin;
    
    /**
     * Font
     */
    public $font;


    
    public function __construct( ) {
        
        // Margin
        $this->init_margin();
        
        // Font
        $this->init_font();
                
    }
       
    private function init_margin() {
        
        $this->margin = get_config( 'quizschedulemaincommission_group', 'headermargin' );
        
    }
    
    private function init_font() {
        
        $this->font = get_config( 'quizschedulemaincommission_group', 'headerfont' );
        
    }
        
}

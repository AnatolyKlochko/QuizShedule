<?php
namespace quizschedulemaincommission_group\format\report\page;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\format\view as base_view;



/**
 * Page View
 */
class view extends base_view {
    
    /**
     * Page Margin
     */
    public $margin;
    
    /**
     * Is used only for @screen section only
     */
    public $width;

    
    public function __construct( ) {
        
        // Margin
        $this->init_margin();
        
        // Width
        $this->init_width();
        
    }
    
    private function init_margin() {
        
        $margin = get_config( 'quizschedulemaincommission_group', 'pagemargin' );
        
        if ( ! $margin ) {
            
            $margin = get_config( 'quizschedule_report', 'margin' );
            
        }
        
        $this->margin = $margin;
        
    }
    
    private function init_width() {
        
        $width = get_config( 'quizschedulemaincommission_group', 'pagewidth' );
                
        $this->width = $width;
        
    }
        
}

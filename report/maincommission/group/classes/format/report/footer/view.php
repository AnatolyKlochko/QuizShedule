<?php
namespace quizschedulemaincommission_group\format\report\footer;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\format\view as base_view;



/**
 * Footer View
 */
class view extends base_view {
        
    /**
     * Margin
     */
    public $margin;
    
    /**
     * Lines padding
     */
    public $linepadding;
    
    /**
     * Column 'Title' Width
     * 
     * Imagine all Footer Presentation is divided on two columns, column with
     * texts, it's left column, and column with underlines, it's right column.
     * 
     * Left column is called 'Title'.
     * 
     */
    public $coltitlewidth;
    
    /**
     * Column 'Underline' Width
     * 
     * ...
     * 
     * Right column is called 'Underline'.
     */
    public $colunderlinewidth;
        
    /**
     * Font
     */
    public $font;



    public function __construct( ) {
        
        // Margin
        $this->init_margin();
        
        // Lines padding
        $this->init_linepadding();
        
        // Column 'Title' Width
        $this->init_coltitlewidth();
        
        // Column 'Underline' Width
        $this->init_colunderlinewidth();
        
        // Font
        $this->init_font();
                
    }
       
    private function init_margin() {
        
        $this->margin = get_config( 'quizschedulemaincommission_group', 'footermargin' );
        
    }
    
    private function init_linepadding() {
        
        $this->linepadding = get_config( 'quizschedulemaincommission_group', 'footerlinepadding' );
        
    }
    
    private function init_coltitlewidth() {
        
        $this->coltitlewidth = get_config( 'quizschedulemaincommission_group', 'footercolumntitlewidth' );
        
    }
    
    private function init_colunderlinewidth() {
        
        $this->colunderlinewidth = get_config( 'quizschedulemaincommission_group', 'footercolumnunderlinewidth' );
        
    }
    
    private function init_font() {
        
        $this->font = get_config( 'quizschedulemaincommission_group', 'footerfont' );
        
    }
        
}

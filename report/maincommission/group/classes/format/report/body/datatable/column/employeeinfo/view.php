<?php
namespace quizschedulemaincommission_group\format\report\body\datatable\column\employeeinfo;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\format\view as base_view;



/**
 * EmployeeInfo View
 */
class view extends base_view {
        
    /**
     * In pixels
     */
    public $width;
    
    /**
     * Whole CSS expression, short tag
     */
    public $font;
    
    
    
    public function __construct( ) {
             
        // Header Font, whole CSS
        $this->init_width( );
        
        // Font
        $this->init_font( );
             
    }
        
    private function init_width( ) {
        
        // Header Font, whole CSS
        $this->width = get_config( 'quizschedulemaincommission_group', 'datatablecol' . ( new model )->key . 'width' );
        
    }
    
    private function init_font( ) {
        
        // Font, whole CSS
        $this->font = get_config( 'quizschedulemaincommission_group', 'datatablecol' . ( new model )->key . 'font' );
        
    }
        
}

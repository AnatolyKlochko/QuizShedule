<?php
namespace quizschedulemaincommission_group\report\body\datatable\column\attempt;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\model as base_model;



/**
 * Attempt Model
 */
class model extends base_model {
    
    /**
     * Short name
     */
    public $key;
    
    /**
     * Displayed name
     */
    public $title;
    
    
    
    public function __construct( ) {
        
        // Key
        $this->init_key( );
                        
        // Header Height, with units
        $this->init_title( );  
                
    }
    
    private function init_key( ) {
        
        $this->key = 'attemptinfo';
        
    }
    
    private function init_title( ) {
        
        // Header Height, with units
        $this->title = get_string( "pagefilteringdtcol{$this->key}", 'quizschedulemaincommission_group' );
        
    }
    
}

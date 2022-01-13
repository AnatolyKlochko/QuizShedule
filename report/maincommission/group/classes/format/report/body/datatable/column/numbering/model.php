<?php
namespace quizschedulemaincommission_group\format\report\body\datatable\column\numbering;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\format\model as base_model;



/**
 * Numbering Model
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
        
        $this->key = 'numb';
        
    }
    
    private function init_title( ) {
        
        // Header Height, with units
        $this->title = get_config( 'quizschedulemaincommission_group', "datatablecol{$this->key}title" );
        
    }
    
}

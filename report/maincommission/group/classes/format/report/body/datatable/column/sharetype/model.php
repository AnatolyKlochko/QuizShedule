<?php
namespace quizschedulemaincommission_group\format\report\body\datatable\column\sharetype;

defined('MOODLE_INTERNAL') || die();

use mod_quizschedule\admin_helper;
use quizschedulemaincommission_group\base\format\model as base_model;



/**
 * ShareType Model
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
    
    /**
     * Subcolumns array
     */
    public $column;
    
    
    public function __construct( ) {
        
        // Key
        $this->init_key( );
                        
        // Header Height, with units
        $this->init_title( );
        
        // Subcolumns
        $this->init_column();
                
    }
    
    private function init_key( ) {
        
        $this->key = 'shrtype';
        
    }
    
    private function init_title( ) {
        
        // Header Height, with units
        $this->title = get_config( 'quizschedulemaincommission_group', "datatablecol{$this->key}title" );
        
    }
    
    private function init_column( ) {
        
        // Columns List, as string
        $raw_cfg = get_config( 'quizschedulemaincommission_group', 'datatablecolshrtypesubcols' );
        
        if ( $raw_cfg ) {
            
            // Parse to assoc array
            $this->column = ( new admin_helper )->get_settingarrayassoc( $raw_cfg );
            
        }
        
    }
    
}

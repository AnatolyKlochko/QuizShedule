<?php
namespace quizschedulemaincommission_group\format\report\header;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\format\model as base_model;



/**
 * Header Model
 */
class model extends base_model {
    
    /**
     * Date
     */
    public $date;
    
    /**
     * Format:
     * date {
     *   'result' = bool,
     *   'message' = ''
     * }
     * 
     * @var array Verifying result object
     */
    private $verifying;



    public function __construct( ) {
        
        // Date
        $this->init_date();
        
    }
        
    private function get_date() {
        
        $data = date( 'd.m.Y', strtotime( $_POST['quizdate'] ) );
        
        
        return $data;
        
    }
    
    private function verifying_date( &$date ) : bool {
        
        $result = false;
        
        // Verifying
        //...
        $result = true;
        
        
        return $result; // 
        
    }
    
    private function init_date( ) {
        
        // Get Raw Date
        $date = $this->get_date();
        
        // Verifying Date
        $vresult = $this->verifying_date( $date );
        
        if ( $vresult ) {
            
            // Init
            $this->date = $date;
            
        }
                
    }
        
}

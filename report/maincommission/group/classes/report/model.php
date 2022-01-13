<?php
namespace quizschedulemaincommission_group\report;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\model as base_model;



/**
 * Report Model
 */
class model extends base_model {
    
    public function __construct( ) {
        
        // Init params
        $this->init_params();
        
    }
    
    protected function init_params() {
        
        $param = [];
        
        // Date
        if ( $this->exists_param( 'quizdate' ) ) {
            
            $param['quizdate'] = $this->get_param( 'quizdate', 'string' );
            
        }
                
        // Schedule
        if ( $this->exists_param( 'schedule' ) ) {
            
            $param['schedule'] = $this->get_param( 'schedule', 'string' );
            
        }
        
        // Attempt
        if ( $this->exists_param( 'moodleattempt' ) ) {
            
            $param['moodleattempt'] = $this->get_param( 'moodleattempt', 'string' );
            
        }
        
        
        self::$param = $param;
        
    }
    
    public function filter_replacecomatobrtaginquiz( &$val ) {
        
        $val = str_replace( ', ', '<br />', $val );
        
    }
    
}

<?php
namespace quizschedulemaincommission_group\report\header;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\model as base_model;



/**
 * Header Model
 */
class model extends base_model {
    
    /**
     * Quiz Date
     */
    public $date;
    
    /**
     * Moodle Attempt
     */
    /**
     * Control Value
     */
    public $attemptstate;
    /**
     * Control Label
     */
    public $attempttitle;


    /**
     * Planned Quiz
     */
    /**
     * Control Value
     */
    public $schedulestate;
    /**
     * Control Label
     */
    public $scheduletitle;
    
    /**
     * Submit
     */
    public $submittitle;


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
        
        // Moodle Attempt
        $this->init_attemptstate();
        $this->init_attempttitle();
        
        // Planned Quiz
        $this->init_schedulestate();
        $this->init_scheduletitle();
        
        // Submit
        $this->init_submittitle();
        
    }
    

    // Date
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
        
    private function get_date() {
        
        $data = isset( self::$param['quizdate'] ) ? date( 'Y-m-d', strtotime( self::$param['quizdate'] ) ) : date( 'Y-m-d' );
        
        
        return $data;
        
    }
    
    private function verifying_date( &$date ) : bool {
        
        $result = false;
        
        // Verifying
        //...
        $result = true;
        
        
        return $result; // 
        
    }
    
    
    // Quiz Attempt
    private function init_attemptstate( ) {
        
        // Get Raw Date
        $attemptstate = $this->get_attemptstate();
        
        // Verifying Date
        $vresult = $this->verifying_attemptstate( $attemptstate );
        
        if ( $vresult ) {
            
            // Init
            $this->attemptstate = $attemptstate;
            
        }
        
    }
        
    private function get_attemptstate() {
        
        $attemptstate = isset( self::$param['moodleattempt'] ) && self::$param['moodleattempt'] === 'on' ? 'checked' : '';
        
        
        return $attemptstate;
        
    }
    
    private function verifying_attemptstate( &$attemptstate ) : bool {
        
        $result = false;
        
        // Verifying
        //...
        $result = true;
        
        
        return $result; // 
        
    }
    
    private function init_attempttitle( ) {
        
        // Get Raw Date
        $attempttitle = $this->get_attempttitle();
        
        // Verifying Date
        $vresult = $this->verifying_attempttitle( $attempttitle );
        
        if ( $vresult ) {
            
            // Init
            $this->attempttitle = $attempttitle;
            
        }
        
    }
        
    private function get_attempttitle() {
        
        $attempttitle = get_string( 'searchmoodle', 'quizschedulemaincommission_group' );
        
        
        return $attempttitle;
        
    }
    
    private function verifying_attempttitle( &$attempttitle ) : bool {
        
        $result = false;
        
        // Verifying
        //...
        $result = true;
        
        
        return $result; // 
        
    }
    
    
    // Schedule
    private function init_schedulestate( ) {
        
        // Get Raw Date
        $schedulestate = $this->get_schedulestate();
        
        // Verifying Date
        $vresult = $this->verifying_schedulestate( $schedulestate );
        
        if ( $vresult ) {
            
            // Init
            $this->schedulestate = $schedulestate;
            
        }
        
    }
        
    private function get_schedulestate() {
        
        $schedulestate = isset( self::$param['schedule'] ) && self::$param['schedule'] === 'on' ? 'checked' : '';
        
        
        return $schedulestate;
        
    }
    
    private function verifying_schedulestate( &$schedulestate ) : bool {
        
        $result = false;
        
        // Verifying
        //...
        $result = true;
        
        
        return $result; // 
        
    }
    
    private function init_scheduletitle( ) {
        
        // Get Raw Date
        $scheduletitle = $this->get_scheduletitle();
        
        // Verifying Date
        $vresult = $this->verifying_scheduletitle( $scheduletitle );
        
        if ( $vresult ) {
            
            // Init
            $this->scheduletitle = $scheduletitle;
            
        }
        
    }
        
    private function get_scheduletitle() {
        
        $scheduletitle = get_string( 'searchschedule', 'quizschedulemaincommission_group' );
        
        
        return $scheduletitle;
        
    }
    
    private function verifying_scheduletitle( &$scheduletitle ) : bool {
        
        $result = false;
        
        // Verifying
        //...
        $result = true;
        
        
        return $result; // 
        
    }
    
    
    private function init_submittitle( ) {
        
        // Get Raw Date
        $submittitle = $this->get_submittitle();
        
        // Verifying Date
        $vresult = $this->verifying_submittitle( $submittitle );
        
        if ( $vresult ) {
            
            // Init
            $this->submittitle = $submittitle;
            
        }
        
    }
        
    private function get_submittitle() {
        
        $submittitle = get_string( 'searchquizdate', 'quizschedulemaincommission_group' );
        
        
        return $submittitle;
        
    }
    
    private function verifying_submittitle( &$submittitle ) : bool {
        
        $result = false;
        
        // Verifying
        //...
        $result = true;
        
        
        return $result; // 
        
    }
        
}

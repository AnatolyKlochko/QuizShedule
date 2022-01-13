<?php

namespace mod_quizschedule\Synchronization\Employee;

defined('MOODLE_INTERNAL') || die();


class Position extends \mod_quizschedule\Synchronization\Employee {
    
    private $sync_employee;
    
    private $ad_employee;


    public function __construct( $sync_employee, $ad_employee ) {
        
        $this->sync_employee = $sync_employee;
        
        $this->ad_employee = $ad_employee;
        
    }
    
    public function synchronize( ) {
        
	$ad_position = $this->ad_employee->get_position();
        
        $moodle_position = $this->sync_employee->get_position();
        
        if ( $ad_position !== $moodle_position ) {
                // add to position log/array
                // change in mdl_user
        }
    
    }
     
}

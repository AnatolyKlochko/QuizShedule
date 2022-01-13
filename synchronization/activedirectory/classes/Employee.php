<?php

namespace mod_quizschedule\Synchronization;

defined('MOODLE_INTERNAL') || die();

use \mod_quizschedule\ActiveDirectory\Employee as ADEmployee;
use mod_quizschedule\Synchronization\Employee\Position;
use mod_quizschedule\Synchronization\Employee\Staff;


class Employee extends \mod_quizschedule\Employee {
       
    public static function synchronize_all() {
        
        $employees = self::get_by_attr();
        
        if ( $employees ) {
            
            foreach( $employees as $employee ) {
                
                $employee->synchronize();
                
            }
            
        }

    }
    
    
    
    public function synchronize() {
        
        $ad_employee = $this->get_ad_employee();

	/**
         * Position
         * 
         * Note, order is important, the “Staff” part is last all time.
         * 
         */
        ( new Position( $this, $ad_employee ) )->synchronize();

	/**
         * Staff
         */
        ( new Staff( $this, $ad_employee ) )->synchronize();

    }
   
    public function get_ad_employee() {
        
        $ad_employee = ADEmployee::get_by_attr( 'employee_number', $this->number );
        
        return $ad_employee;
    }
    
    
}

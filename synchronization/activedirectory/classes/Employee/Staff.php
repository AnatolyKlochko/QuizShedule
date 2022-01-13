<?php

namespace mod_quizschedule\Synchronization\Employee;

defined('MOODLE_INTERNAL') || die();


class Staff extends \mod_quizschedule\Synchronization\Employee {
    
    private $sync_employee;
    
    private $ad_employee;


    public function __construct( $sync_employee, $ad_employee ) {
        
        $this->sync_employee = $sync_employee;
        
        $this->ad_employee = $ad_employee;
        
    }
    
    public function synchronize() {
        
        if ($this->ad_employee->is_fired( ) ) {
            
            $this->delete();
            
        }
        
    }

    public function delete() {
            // add to mdl_quizschedule_archive_user
            // delete from mdl_user
    }
     
}

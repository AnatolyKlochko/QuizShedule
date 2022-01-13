<?php

namespace mod_quizschedule\task;
 
/**
 * An example of a scheduled task.
 */
class synchronize_employees extends \core\task\scheduled_task {
 
    /**
     * Return the task's name as shown in admin screens.
     *
     * @return string
     */
    public function get_name() {
        return get_string( 'synchronize_employees', 'mod_quizschedule' );
    }
 
    /**
     * Execute the task.
     */
    public function execute() {
        
        echo 'Hello, Dolly@';
    }
}

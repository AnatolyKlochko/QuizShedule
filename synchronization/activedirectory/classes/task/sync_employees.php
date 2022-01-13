<?php

namespace quizschedulesynchronization_activedirectory\task;
 
/**
 * An example of a scheduled task.
 */
class sync_employees extends \core\task\scheduled_task {
 
    /**
     * Return the task's name as shown in admin screens.
     *
     * @return string
     */
    public function get_name() {
        return get_string( 'sync_employees', 'quizschedulesynchronization_activedirectory' );
    }
 
    /**
     * Execute the task.
     */
    public function execute() {
        
        echo 'test message at ' . __FILE__;
    }
}

<?php
namespace quizschedulemaincommission_group\report\body\datatable;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\model as base_model;
use quizschedulemaincommission_group\report\body\datatable\model\employee;



/**
 * Datatable Model
 */
class model extends base_model {
    
    public $employee;
    
    
    
    public function __construct( ) {
                       
        // Employees
        $this->init_employee();
                        
    }
    
    private function init_employee( ) {
        
        $this->employee = ( new employee(  ) )->get_all();
        
    }
        
}

<?php
namespace quizschedulemaincommission_group\format\report\body\datatable;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\format\model as base_model;
use quizschedulemaincommission_group\format\report\body\datatable\model\employee;



/**
 * Datatable Model
 */
class model extends base_model {
    
    public $employee;
    
    
    
    public function __construct( ) {
                       
        $this->init_employee();
                        
    }
    
    private function init_employee( ) {
        
        $this->employee = ( new employee( [] ) )->get_all();
        
    }
        
}

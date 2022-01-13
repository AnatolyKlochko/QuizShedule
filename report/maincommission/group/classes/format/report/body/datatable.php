<?php
namespace quizschedulemaincommission_group\format\report\body;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\format\component;
use quizschedulemaincommission_group\format\report\body\datatable\{model, view};
use quizschedulemaincommission_group\format\report\body\datatable\column\{numbering, employeeinfo, sharetype};



/**
 * Datatable Component
 */
class datatable extends component {
    
    /**
     * Data processing
     */
    public $model;
    
    /**
     * View options
     */
    public $view;
    
    /**
     * Components
     */
    public $component;
    

    
    public function __construct( ) {
        
        // Model
        $this->model = new model();
        
        // View
        $this->view = new view();
        
        // Components
        $this->component = [];
        
        // Column
        $this->component[] = new numbering();
        $this->component[] = new employeeinfo();
        $this->component[] = new sharetype();
                
    }
    
    public function __get( $param ) {
        
        if ( 'employees' === $param ) {
            
            return $this->employee;
            
        }
        
        return parent::__get( $param );
        
    }
    
}

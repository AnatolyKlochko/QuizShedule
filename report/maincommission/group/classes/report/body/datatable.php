<?php
namespace quizschedulemaincommission_group\report\body;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\component;
use quizschedulemaincommission_group\report\body\datatable\{model, view};
use quizschedulemaincommission_group\report\body\datatable\column\{numbering, employee, quiz, attempt, action};



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
        $this->component[] = new employee();
        $this->component[] = new quiz();
        $this->component[] = new attempt();
        $this->component[] = new action();
                
    }
    
    public function __get( $param ) {
        
        if ( 'columns' === $param ) {
            
            return $this->component;
            
        }
        
        if ( 'employees' === $param || 'source' === $param ) {
            
            return $this->model->employee;
            
        }
        
        return parent::__get( $param );
        
    }
    
}

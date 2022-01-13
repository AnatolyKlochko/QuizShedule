<?php
namespace quizschedulemaincommission_group\report;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\component;
use quizschedulemaincommission_group\report\body\{model, view};
use quizschedulemaincommission_group\report\body\{datatable};



/**
 * Body Component
 */
class body extends component {
    
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
        
        // Datatable
        $this->component[] = new datatable();
        
    }
            
}

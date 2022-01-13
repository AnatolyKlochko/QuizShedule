<?php
namespace quizschedulemaincommission_group\report\body\datatable\column;

use quizschedulemaincommission_group\base\component;
use quizschedulemaincommission_group\report\body\datatable\column\attempt\{model, view};



/**
 * Attempt Column
 */
class attempt extends component {
    
    /**
     * Data processing
     */
    public $model;
    
    /**
     * View options
     */
    public $view;
    
    
    
    public function __construct( ) {
        
        // Model
        $this->model = new model( );
        
        // View
        $this->view = new view( );
        
    }
    
}

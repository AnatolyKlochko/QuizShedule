<?php
namespace quizschedulemaincommission_group\format\report\body\datatable\column;

use quizschedulemaincommission_group\base\format\component;
use quizschedulemaincommission_group\format\report\body\datatable\column\sharetype\{model, view};



/**
 * ShareType Column
 */
class sharetype extends component {
    
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

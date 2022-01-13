<?php
namespace quizschedulemaincommission_group\report;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\component;
use quizschedulemaincommission_group\report\header\{model, view};



/**
 * Header Component
 */
class header extends component {
    
    public function __construct( ) {
        
        // Model
        $this->model = new model();
        
        // View
        $this->view = new view();
        
    }

}

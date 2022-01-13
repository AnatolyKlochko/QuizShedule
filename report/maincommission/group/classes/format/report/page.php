<?php
namespace quizschedulemaincommission_group\format\report;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\format\component;
use quizschedulemaincommission_group\format\report\page\{model, view};



/**
 * Page Component
 */
class page extends component {
    
    public function __construct( ) {
        
        // Model
        $this->molel = new model;
        
        // View
        $this->view = new view;
    
    }
            
}

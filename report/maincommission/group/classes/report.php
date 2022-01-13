<?php
namespace quizschedulemaincommission_group;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\component;
use quizschedulemaincommission_group\report\{model, view};
use quizschedulemaincommission_group\report\{header, body, footer};



/**
 * Report Component
 * 
 * Pre Formation Stage
 */
class report extends component {
    
    public function __construct() {
        
        // Model
        $this->molel = new model;
        
        // View
        $this->view = new view;
        
        
        // Components
        $this->component = [];
               
        // Header
        $this->component[] = new header();
        
        
        if ( $this->stage() === 'filtering' ) :
            
        // Body
        $this->component[] = new body();
                
        // Footer
        $this->component[] = new footer();
        
        endif;
        
    }
    
}

<?php
namespace quizschedulemaincommission_group\base\format;

use quizschedule_report\format\component as format_component;



/**
 * Base Report Component
 * 
 * Formation Stage
 */
abstract class component extends format_component {
    
    /**
     * Data processing
     */
    public $model;
    
    /**
     * View options
     */
    public $view;
        
    /**
     * Sub Components
     */
    public $component;
    
}

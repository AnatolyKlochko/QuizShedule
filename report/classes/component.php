<?php
namespace quizschedule_report;



/**
 * Displayed Base Component
 * 
 * Pre formation stage
 *
 */
abstract class component /*extends \stdClass*/ {
    
    /**
     * Data processing.
     */
    public $model;
    
    /**
     * View options.
     */
    public $view;
        
    /**
     * Subcomponents
     */
    public $component;

    
    public function __get( $prop ) {
        
        // Subcomponent
        foreach ( $this->component as $c ) {
            
            if ( $prop === ( new \ReflectionClass( $c ) )->getShortName( ) ) {
                
                return $c;
                
            }
            
        }
        
        // Component has NO sub components ( or requested property has been not found ), seek among 'model' properties, and then 'view' properties
        if ( isset( $this->model ) && isset( $this->model->{$prop} ) ) {
            
            return $this->model->{$prop};
            
        } elseif ( isset( $this->view ) && isset( $this->view->{$prop} ) ) {
            
            return $this->view->{$prop};
            
        }
        
    }
    
    public function stage( ) {
        
        return defined( 'MODQUIZSCHEDULE_STAGE' ) ? MODQUIZSCHEDULE_STAGE : '';
        
    }
    
}

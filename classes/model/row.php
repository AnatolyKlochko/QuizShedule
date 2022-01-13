<?php

namespace mod_quizschedule\model;
defined('MOODLE_INTERNAL') || die();

/**
 * General Report Row Class.
 *
 * @author dit61
 */
class row {
   
    public $columns = [];
    
    
    
    /**
     * 
     * @param mixed $so Source object
     */
    public function init( $column, $employee = null, $schedule = null ) {
        
        $handler = "init_{$column->key}";
        
        $this->$handler( $column, ( $column->has_quiz ) ? $schedule : $employee );
        
    }
    
    /**
     * Column 'Numbering'.
     */
    private function init_numbering( $column, $employee ) {
        
        $this->columns[ $column->key ] = ++report::$numbering;
        
    }
    
    /**
     * Column 'Affiliate'.
     */
    private function init_affiliate( $column, $employee ) {
        
        $this->columns[ $column->key ] = $employee->affiliate;
        
    }
    
    /**
     * Column 'Department'.
     */
    private function init_department( $column, $employee ) {
        
        $this->columns[ $column->key ] = $employee->department;
        
    }
    
    /**
     * Column 'Employee Number'.
     */
    private function init_employee_number( $column, $employee ) {
        
        $this->columns[ $column->key ] = $employee->employee_number;
        
    }
    
    /**
     * Column 'Full Name'.
     */
    private function init_fullname( $column, $employee ) {
        
        $this->columns[ $column->key ] = $employee->fullname;
        
    }
    
    /**
     * Column 'Position'.
     */
    private function init_position( $column, $employee ) {
        
        $this->columns[ $column->key ] = $employee->position;
        
    }
    
    /**
     * Column 'Group of Electrical Safety'.
     */
    private function init_group_of_electrical_safety( $column, $employee ) {
        
        $this->columns[ $column->key ] = $employee->group_of_electrical_safety;
        
    }
        
    /**
     * Column 'Occupational Health'.
     */
    private function init_occupational_health( $column, $schedulelist ) {
        
        $data = [];
        
        if ( $schedulelist ) {
            
            $nearestschedule = array_shift( $schedulelist );
        
            $data = column_quiz::get_data( $nearestschedule );

            // Usefull data is: ->commissiontypeid, ->is_active, ->quizname
            $data[ 'object' ] = $nearestschedule;

            // and end of list
            if ( count( $schedulelist ) > 0 ) {
                $data[ 'list' ] = $schedulelist;
            }
                        
        }
                
        $this->columns[ $column->key ] = $data;
        
    }
    
    /**
     * Column 'Technology Works'.
     */
    private function init_technology_works( $column, $schedulelist ) {
        
        $data = [];
        
        if ( $schedulelist ) {
            
            $nearestschedule = array_shift( $schedulelist );
        
            $data = column_quiz::get_data( $nearestschedule );

            // Usefull data is: ->commissiontypeid, ->is_active, ->quizname
            $data[ 'object' ] = $nearestschedule;

            // and end of list
            if ( count( $schedulelist ) > 0 ) {
                $data[ 'list' ] = $schedulelist;
            }
            
        }
                
        $this->columns[ $column->key ] = $data;
        
    }
    
    /**
     * Column 'Fire Safety Rules'.
     */
    private function init_fire_safety_rules( $column, $schedulelist ) {
        
        $data = [];
        
        if ( $schedulelist ) {
            
            $nearestschedule = array_shift( $schedulelist );
        
            $data = column_quiz::get_data( $nearestschedule );

            // Usefull data is: ->commissiontypeid, ->is_active, ->quizname
            $data[ 'object' ] = $nearestschedule;

            // and end of list
            if ( count( $schedulelist ) > 0 ) {
                $data[ 'list' ] = $schedulelist;
            }
            
        }
                
        $this->columns[ $column->key ] = $data;
        
    }
    
    /**
     * Column 'Safe Operation of Lifts'.
     */
    private function init_safe_operation_of_lifts( $column, $schedulelist ) {
        
        $data = [];
        
        if ( $schedulelist ) {
            
            $nearestschedule = array_shift( $schedulelist );
        
            $data = column_quiz::get_data( $nearestschedule );

            // Usefull data is: ->commissiontypeid, ->is_active, ->quizname
            $data[ 'object' ] = $nearestschedule;

            // and end of list
            if ( count( $schedulelist ) > 0 ) {
                $data[ 'list' ] = $schedulelist;
            }
            
        }
                
        $this->columns[ $column->key ] = $data;
        
    }
    
    /**
     * Column 'Safe Operation of Cranes'.
     */
    private function init_safe_operation_of_cranes( $column, $schedulelist ) {
        
        $data = [];
        
        if ( $schedulelist ) {
            
            $nearestschedule = array_shift( $schedulelist );
        
            $data = column_quiz::get_data( $nearestschedule );

            // Usefull data is: ->commissiontypeid, ->is_active, ->quizname
            $data[ 'object' ] = $nearestschedule;

            // and end of list
            if ( count( $schedulelist ) > 0 ) {
                $data[ 'list' ] = $schedulelist;
            }
            
        }
                
        $this->columns[ $column->key ] = $data;
        
    }
    
    /**
     * Column 'Pressure Vessels'.
     */
    private function init_pressure_vessels( $column, $schedulelist ) {
        
        $data = [];
        
        if ( $schedulelist ) {
            
            $nearestschedule = array_shift( $schedulelist );
        
            $data = column_quiz::get_data( $nearestschedule );

            // Usefull data is: ->commissiontypeid, ->is_active, ->quizname
            $data[ 'object' ] = $nearestschedule;

            // and end of list
            if ( count( $schedulelist ) > 0 ) {
                $data[ 'list' ] = $schedulelist;
            }
            
        }
                
        $this->columns[ $column->key ] = $data;
        
    }
    
    /**
     * Column 'Physical Examination'.
     */
    private function init_physical_examination( $column, $schedulelist ) {
        
        $data = [];
        
        if ( $schedulelist ) {
            
            $nearestschedule = array_shift( $schedulelist );
        
            $data = column_quiz::get_data( $nearestschedule );

            // Usefull data is: ->commissiontypeid, ->is_active, ->quizname
            $data[ 'object' ] = $nearestschedule;

            // and end of list
            if ( count( $schedulelist ) > 0 ) {
                $data[ 'list' ] = $schedulelist;
            }
            
        }
                
        $this->columns[ $column->key ] = $data;
        
    }
        
    /**
     * Column 'Commission Type'.
     */
    private function init_commission_type( $column, $employee ) {
        global $DB;        
        
        $commissiontype = '';
        
        foreach ( $this->columns as $xcolumn ) {
            
            // first || last || all
            // first
            if ( $xcolumn['object'] && isset( $xcolumn['object']->commissiontypeid )) {
                
                $key = $DB->get_field( 'quizschedule_commissiontype', '`key`', [ 'id' => $xcolumn['object']->commissiontypeid ] );
                
                $commissiontype = get_string( "add_commissiontype_val_$key", 'quizschedule' );
                
                break;
                
            }
            
        }
        
        $this->columns[ $column->key ] = $commissiontype;
        
    }
    
    /**
     * Column 'Notes'.
     */
    private function init_notes( $column, $employee ) {
        
        $this->columns[ $column->key ] = NULL;
        
    }
        
}

<?php
namespace quizschedulemaincommission_group\format\report\body\datatable\model;

use quizschedulemaincommission_group\base\format\model as base_model;



/**
 * Employee Model
 */
class employee extends base_model {
  
    public function __construct( array $employee ) {
        
        $this->id = $employee['id'];
                
        $this->fullname = $employee['fullname'];

        $this->affiliate = $employee['affiliate'];

        $this->position = $employee['position'];
        
    }
    
    public function get_info() {
        
        return $this->fullname . '<br />' . $this->position . '<br />' . $this->affiliate;
        
    }
    
    private function load_data( ) {
        
        $raw_data = $_POST;
        
        
        return $raw_data;
        
    }
    
    private function verifying_data( $raw_data ) {
        
        $result = false;
        
        // ...
        
        $result = true;
        
        
        return $result;
        
    }
    
    public function get_all( ) {
        
        $raw_data = $this->load_data();
        
        $vresult = $this->verifying_data( $raw_data );
        
        if ( $vresult ) {
            
            $employee = [];
            
            foreach ( $raw_data as $key => $value ) {
            
                if ( mb_stripos( $key, 'employee', 0, 'UTF-8' ) !== false ) {

                    if ( isset( $value['fullname'] ) && mb_strlen( $value['fullname'], 'UTF-8' ) >= 10 ) {

                        $employee[] = new employee( $value );

                    }

                }

            }
            
            
            // Filters
            
            $this->filter_arr_replacedoublequoteshashtosymbol( $employee, [ 'affiliate' ] );
            
            $this->filter_arr_replaceaffiliatenumbertoname( $employee, [ 'affiliate' ] );
                    
        }
        
        
        return $employee;
                
    }

}

<?php

namespace mod_quizschedule;

defined('MOODLE_INTERNAL') || die();


class Employee {
    
    /**
     * 
     */
    private $attr;
    
    
    
    public function __get( $name ) {
        
        if ( method_exists( $this, "get_$name" ) ) {
            
            return $this->{"get_$name"}();
            
        } elseif ( isset( $this->attr->{$name} ) ) {
            
            return $this->attr->{$name};
            
        } else {
            
            return null;
            
        }
                
    }
    
//    public function get_number() {
//
//        
//    }
//    
//    public function get_position() {
//
//        
//        
//    }
//    
//    public function get_affiliate() {
//
//        
//        
//    }
//    
//    public function get_department() {
//
//        
//        
//    }
        
    private static function attr_get_field( string $name ) {
        global $CFG;
        
        return $CFG->{"qs_synchronization_ad_mapping_$name"};
    }
    
    private static function attr_get_selectfields() : array {
        
        $selectfields = [];
        
        $selectfields['id'] = 'id';
        
        $selectfields['lastname'] = 'lastname'; // 
        
        $selectfields['firstname'] = 'firstname'; // 
        
        $selectfields['number'] = self::attr_get_field( 'number' ); // username
        
        $selectfields['position'] = self::attr_get_field( 'position' ); // address
        
        $selectfields['affiliate'] = self::attr_get_field( 'affiliate' ); // institution
        
        $selectfields['department'] = self::attr_get_field( 'department' ); // department
        
        
        return $selectfields;
        
    }
    
    /**
     * 
     */
    private static function attr_get_wherecondition( string $attr = null, $val = null ) {
        
        $where_cond = '';
        
        switch ( $attr ) {
            case 'fullname':
                $where_cond = "CONCAT_WS( ' ', lastname, firstname ) LIKE %:fullname%";
                break;

            default:
                $where_cond = "$attr=:$attr";
                break;
        }
        
        
        return $where_cond;
        
    }
    
    /**
     * 
     */
    private static function attr_get_employees( string $attr = null, $val = null ) {
        global $DB;
        
        $fields = ( function( array $fields ) {
            
            $selectexpr = [];
            
            foreach ( $fields as $alias => $column ) {
               
                $selectexpr[] = $column . ' ' . $alias;
               
            }
           
           return implode( ',', $selectexpr );
           
        } )( self::attr_get_selectfields() );
        
        $sql = "SELECT $fields FROM {user}";
        
        if ( ! is_null( $attr )  ) {
            
            $where = ' WHERE ' . self::attr_get_wherecondition( $attr );
            
        }
        
        // Params
        if ( isset( $where ) ) {
            
            $params = [
                
                $attr => $val
                    
            ];
            
            $sql .= $where;
            
        }
        

        // Result: array stdClass
        $employees = $DB->get_records_sql( $sql, $params );
        
        
        return $employees;
        
    }
    
    /**
     * 
     */
    public function init( $attrObj ) {
        
        $this->attr = $attrObj;
        
    }
    
    /**
     * 
     */
    private static function attr_get_employeeobjects( array &$employees ) {
        
        // Employee Array
        $objects = [];
        
        // Employee Object Array
        foreach ( $employees as $employee ) {
            
            $object = new static();
            
            $object->init( $employee );
            
            $objects[] = $object;
            
        }
        
        
        return $objects;
        
    }
    
    // ( ‘attr’, ‘value’ ) id, fullname, affiliate : array Employee, inside use “new static”
    public static function get_by_attr( string $attr = null, $val = null ) {
        
        // Employees Array
        $employees = self::attr_get_employees($attr, $val);
        
        // Employee Array
        $objects = self::attr_get_employeeobjects( $employees );
        
               
        return $objects;
        
    }

    // ‘affiliate’
    public function get_attr(  ) {
        
        
        
    }
    
    // ‘firstname’, ‘lastname’, ‘affiliate’
    public function get_attrs(  ) {
        
        
        
    }

     
}

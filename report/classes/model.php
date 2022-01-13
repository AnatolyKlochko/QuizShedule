<?php
namespace quizschedule_report;

use mod_quizschedule\admin_helper;



/**
 * Displayed Base Model
 * 
 * Pre formation stage
 *
 */
abstract class model extends \stdClass {
    
    protected static $param;


    protected function exists_param( string $name ) {
        
        $result = false;
        
        
        if ( isset( $_POST[$name] ) || isset( $_GET[$name] ) ) {
            
            $result = true;
            
        }
        
        
        return $result;
        
    }
            
    protected function get_param( string $name, string $type ) {
        
        $value = null;
        
        
        if ( isset( $_POST[$name] ) ) {
            
            $value = $_POST[$name];
            
        } elseif ( isset( $_GET[$name] ) ) {
            
            $value = $_GET[$name];
            
        }
        
        
        return $this->in_type( $type, $value );
    
    }
    
    protected function in_type( $name, $value ) {
        
        switch ( $name ) {
            
            case 'bool':
                return (bool)$value;
                
            case 'int':
                return (int)$value;
                
            case 'date':
                return date( 'Y-m-d', strtotime( $value ) );
                
            case 'string':
                return $value;

            default:
                $value;
            
        }
        
        
    }
    
    
    protected function filter_replacebreaklinehashtobrtag( string &$val ) {
        
        // Returns %BR% or similar
        $brhash = get_config( 'quizschedulemaincommission_group', 'datafilterbreakline' );
        
        $brtag = '<br />';
        
        $val = str_replace( $brhash, $brtag, $val ); // find replace where
        
    }
    
    /**
     * Filter 'Commission Type'. For single values.
     * 
     * Replaces every commission type key to commission type name:
     * '' -> ''
     */
    protected function filter_replacecommissiontypekeytoname( & $commissionkey ) {
        
        $commission = get_string( 'add_commissiontype_val_' . $commissionkey, 'mod_quizschedule' );
        
        if ( $commission === '[[add_commissiontype_val_]]' ) {

            $commission = '';

        }
        
        $commissionkey = $commission;
        
    }
    
    /**
     * Filter 'Affiliate Number'. For single values.
     * 
     * Replaces every affiliate code to affiliate name:
     * '0100' -> 'АТ "ПОЛТАВАОБЛЕНЕРГО"'
     */
    protected function filter_replaceaffiliatenumbertoname( &$val ) {
        
        $raw_cfg = get_config( 'quizschedule_report', 'datalistaffiliatenumber' );
        
        if ( $raw_cfg ) {
            
            $affiliatenumber = ( new admin_helper )->get_settingarrayassoc( $raw_cfg, ',' );
            
            if ( array_key_exists( $val, $affiliatenumber ) ) {

                $val = $affiliatenumber[ $val ];

            }
            
        }
        
    }
    
    /**
     * Filter 'Double Quotes' Symbol. For single values.
     * 
     * Replaces every double quote symbol '"' to double quotes hash %DOUBLEQUOTE%:
     * АТ %DOUBLEQUOTE%ПОЛТАВАОБЛЕНЕРГО%DOUBLEQUOTE% -> АТ "ПОЛТАВАОБЛЕНЕРГО"
     */
    protected function filter_replacedoublequotessymboltohash( &$val, string $hash = '' ) {
        
        if ( empty( $hash ) ) {
            
            $hash = get_config( 'quizschedule_report', 'datahashdoublequotes' ); // by default '%DOUBLEQUOTE%'
            
        }
        
        $val = str_replace( '"', $hash, $val );
        
    }
    
    /**
     * Filter 'Affiliate Number'. For arrays.
     * 
     * Replaces every affiliate code to affiliate name:
     * '0100' -> 'АТ "ПОЛТАВАОБЛЕНЕРГО"'
     */
    protected function filter_arr_replaceaffiliatenumbertoname( array &$source, array $props ) {
        
        $raw_cfg = get_config( 'quizschedule_report', 'datalistaffiliatenumber' );
        
        if ( $raw_cfg ) {
            
            $affiliatenumber = ( new admin_helper )->get_settingarrayassoc( $raw_cfg );
            
            foreach ( $source as $item ) {
            
                foreach ( $props as $prop ) {

                    if ( isset( $item->{$prop} ) ) {

                        if ( array_key_exists( $item->{$prop}, $affiliatenumber ) ) {

                            $item->{$prop} = $affiliatenumber[ $item->{$prop} ];

                        }

                    }

                }

            }                    
            
        }
        
    }
    
    /**
     * Filter 'Double Quotes' Symbol. For arrays.
     * 
     * Replaces every double quote symbol '"' to double quotes hash %DOUBLEQUOTE%:
     * АТ "ПОЛТАВАОБЛЕНЕРГО" -> АТ %DOUBLEQUOTE%ПОЛТАВАОБЛЕНЕРГО%DOUBLEQUOTE%
     */
    protected function filter_arr_replacedoublequotessymboltohash( array &$source, array $props, string $hash = '' ) {
        
        if ( empty( $hash ) ) {
            
            $hash = get_config( 'quizschedule_report', 'datahashdoublequotes' ); // by default '%DOUBLEQUOTE%'
            
        }
        
        
        foreach ( $source as $item ) {
            
            foreach ( $props as $prop ) {
                
                if ( isset( $item->{$prop} ) ) {
                    
                    $item->{$prop} = str_replace( '"', $hash, $item->{$prop} );
                    
                }
                
            }
            
        }
        
    }
    
    /**
     * Filter 'Double Quotes' Hash. For arrays.
     * 
     * Replaces every double quote hash %DOUBLEQUOTE% to double quotes symbol '"':
     * АТ %DOUBLEQUOTE%ПОЛТАВАОБЛЕНЕРГО%DOUBLEQUOTE% -> АТ "ПОЛТАВАОБЛЕНЕРГО"
     */
    protected function filter_arr_replacedoublequoteshashtosymbol( array &$source, array $props, string $hash = '' ) {
        
        if ( empty( $hash ) ) {
            
            $hash = get_config( 'quizschedule_report', 'datahashdoublequotes' ); // by default '%DOUBLEQUOTE%'
            
        }
        
        
        foreach ( $source as $item ) {
            
            foreach ( $props as $prop ) {
                
                if ( isset( $item->{$prop} ) ) {
                    
                    $item->{$prop} = str_replace( $hash, '"', $item->{$prop} );
                    
                }
                
            }
            
        }
        
    }
    
}

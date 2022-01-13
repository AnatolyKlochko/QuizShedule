<?php
namespace mod_quizschedule;

defined('MOODLE_INTERNAL') || die(); // throws ERROR or constant 'MOODLE_INTERNAL' is not defined



/**
 * Helper to work with admin settings.
 */
class admin_helper {
        
    public function get_settingarray( $suffix = '' ) {
        
        
        
    }
    
    public function get_settingarrayassoc( string $value, string $splitter = ',' ) {
        
        $arrassoc = [];
        
        $line = preg_split( '/\r\n|\r|\n/', $value );
        
        array_walk(
                
            $line,
                
            function ( $item, $key ) use ( &$arrassoc, &$splitter ) {
            
                $arrline = explode( $splitter, $item );
                
                if ( ! empty( $arrline[1] ) ) {
                    
                    $arrassoc[ trim( $arrline[0] ) ] = trim( $arrline[1] );
                    
                }
                
            }
            
        );
        
        
        return $arrassoc;
        
    }
    
    public function getint( $rawint ) {
        
        $int = (int) filter_var( $rawint, FILTER_SANITIZE_NUMBER_INT );
        
        
        return $int;
        
    }
    
    public function getunit( $rawcss ) {
        
        $pattern = '/([a-z]+)$/';
        
        preg_match( $pattern, $rawcss, $matches );
        
        
        return $matches[1];
        
    }
}

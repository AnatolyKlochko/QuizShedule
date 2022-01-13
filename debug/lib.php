<?php

function debug_log( $info, $zone = 'function', $ext = '' ) {
    static $c = 0;
    
    $path = __DIR__ . '/log/' . date( 'Ymd\THis' ) . '_' . $zone . $ext;
       
    if ( file_exists( $path ) ) {
        
        $path = __DIR__ . '/log/' . date( 'Ymd\THis' ) . '_' . $zone . '_' . ++$c . $ext;
        
    } 
    
    file_put_contents( $path, $info );
    
}
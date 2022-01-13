<?php

namespace mod_quizschedule\view;

class report_helper {
    
    /**
     * General Report 
     */
    public static function get_columns( ) {
        global $DB;
        
        $sql = " 
            SELECT id, `key`, settings
            FROM {quizschedule_columns} 
            ORDER BY `order`
            ";

        $columnlist = $DB->get_records_sql( $sql );

        return $columnlist;
    }
    
}

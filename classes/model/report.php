<?php

namespace mod_quizschedule\model;
defined('MOODLE_INTERNAL') || die();

/**
 * General Report Class.
 *
 * @author dit61
 */
class report {
    
    public static $numbering = 0;


    /**
     * Returns General Report Array.
     */
    public function get() {
        
        $report = [];
        
        // Report row (Emloyee information object)
        $rrow;
        
        $employee_list = $this->get_users();
        
        $columns = $this->get_columns();
        
        // Report records
        foreach ( $employee_list as $employee ) {
            
            $rrow = new row();
            
            // Report columns
            foreach ( $columns as $column ) {
                
                if ( $column->has_quiz ) {
                    
                    $column_quizzes = $this->get_column_quizzes( $column->id );
                    
                    if ( $column_quizzes ) {
                        
                        // Employee Schedule (nearest and missed Quizzes (for employee))
                        $employee_schedule = $this->get_employee_schedule( $employee, $column_quizzes );
                        
                        if ( $employee_schedule ) {
                         
                            $rrow->init( $column, null, $employee_schedule );
                            
                        }
                        
                    }
                                    
                } else {
                    
                    $rrow->init( $column, $employee );
                    
                }
                
            }
            
            $report[] = $rrow;
            
        }
        

        return $report;
    }
    
    /**
     * General Report Users
     */
    private function get_users( ) {
        global $DB;
        
        $sql = " 
            SELECT 
                u.id, 
                u.institution AS affiliate, 
                u.department,
                u.username AS employee_number, 
                CONCAT_WS(' ', u.lastname, u.firstname) AS fullname, 
                u.address AS position
            FROM 
                {user} u 
                INNER JOIN ( 
                    SELECT 
                        employeeid 
                    FROM 
                        {quizschedule} 
                #    WHERE
                #        employeeid IN ( 517 )
                    GROUP BY 
                        employeeid 
                ) qs ON u.id = qs.employeeid 
            ORDER BY 
                affiliate, department, position, fullname
            ";

        $employeelist = $DB->get_records_sql( $sql/*, $params*/ );

        return $employeelist;
    }
    
    /**
     * General Report Users
     */
    private function get_columns( ) {
        global $DB;
        
        $sql = " 
            SELECT id, `key`, has_quiz
            FROM {quizschedule_columns} 
            ORDER BY `order`
            ";

        $columnlist = $DB->get_records_sql( $sql );

        return $columnlist;
    }
    
    /**
     * General Report Column Quizzes.
     * 
     * Returns Quiz ID's that relates to the column.
     */
    private function get_column_quizzes( $columnid ) {
        global $DB;
        
        $sql = " 
            SELECT quizid 
            FROM {quizschedule_columns_quizzes} ";

        $where = " columnid =:columnid ";

        $params = [ 
            'columnid' => $columnid
        ];

        $sql .= "\nWHERE {$where}";

        //$sql .= "\nORDER BY institution ASC";

        $quizlist = $DB->get_records_sql( $sql, $params );

        return $quizlist;
    }
    
    /**
     * General Report. Returns the Nearest and every Missed Quiz.
     * 
     * @param stdClass $employee Class with employee information.
     * @param array $quizzes Quiz IDs.
     */
    private function get_employee_schedule( $employee, $quizzes ) {
        global $CFG, $DB;
        
        $todaydate = date( 'Y-m-d' );
        $daysbefore = get_config( 'mod_quizschedule', 'generalscheduletabledaysbefore' );
        $daysafter = get_config( 'mod_quizschedule', 'generalscheduletabledaysafter' );
        
        $quizzes = implode( ',', array_keys( $quizzes ) ); // '183,196,105'
        
        $sql = " 
            SELECT 
                qs.id, 
                qs.employeeid, 
                qs.quizid,
                qs.commissiontypeid, 
                qs.datequiz, 
                qs.datenextquiz, 
                IF( datenextquiz < CURDATE(), 0, 1 ) AS is_active, 
                q.name AS quizname
            FROM 
                {quizschedule} qs 
                LEFT JOIN {quiz} q ON qs.quizid = q.id
            WHERE
                qs.employeeid = $employee->id 
                AND 
                qs.datenextquiz >= DATE_SUB( '$todaydate', INTERVAL $daysbefore DAY ) 
                AND 
                qs.datenextquiz <= DATE_ADD( '$todaydate', INTERVAL $daysafter DAY ) 
                AND
                qs.quizid IN ($quizzes)
            ORDER BY 
               # datenextquiz DESC, 
               # is_active ASC
                qs.quizid ASC,
                qs.timecreated DESC
            "; // MySQL add the query to cache for all day long ( if cache is enabled )
        
        $schedulelist = $DB->get_records_sql( $sql );
        
        
        // Get actual Schedule list
        $actuallist = [];
        
        // Collect nearest values for each quiz
        foreach ( $schedulelist as $point ) {
            
            if ( isset( $actuallist[ $point->quizid ] ) ) {
                
                continue;
                
            } else {
                
                // снимаем сливки: remember the last added results
                $actuallist[ $point->quizid ] = $point;
                
            }
            
        }
        
        // Sort list by 'nextquizdate' ASC, first row - the nearest quiz
        $datelist = [];
        
        foreach ( $actuallist as $key => $point ) {
            
            $key = $point->datenextquiz . '_' . $point->id; // point ID never intersect
            
            $datelist[ $key ] = $point;
                        
        }
        ksort( $datelist );
        
        // Build again actuallist array
        $actuallist = [];
        
        foreach ( $datelist as $point ) {
                        
            $actuallist[ $point->id ] = $point;
            
        }
        

        return $actuallist;

    }
    
}

<?php

namespace mod_quizschedule\model;

/**
 * 
 *
 * @author 
 */
class column_quiz {
    
    /**
     * Returns prepared array for multicolumns.
     */
    public static function get_data( \stdClass $schedule ) {
        
        $plandata = self::get_plandata( $schedule );
        
        $data = [
            'plan' => $plandata[ 'plan' ],
            'fact' => $schedule->datequiz,
            'next' => $schedule->datenextquiz
        ];
        
        if ( $plandata[ 'changes' ] ) {
            
            $data['changes'] = $plandata['changes'];
            
        }
        
        return $data;
        
    }
    
    /**
     * Returns info about who changed next quiz date (list of changes: datetime, 
     * responsible person, old quiz date) or just next quiz date, if were no 
     * changes.
     * 
     * The data table is {quizschedule_changes}.
     * 
     * The key thing is "Plan" - date when Quiz should be happend // когда он 
     * должен был бы быть (FIRST primary planned date of quiz in day of quiz).
     * 
     * Notes: usually Quiz date is chanded very seldom, for few, maximum for 10-40 
     * employees. Thus perform few requests is more preferable than get whole table 
     * and then compute particular dates. In other hand result table will be very 
     * little. Can just start test...
     * 
     * Note: at the ending of a Quiz the Responsible Person sets the date of next Quiz, and it 
     * is NEW RECORD in {quizschedule} table. Therefore is right perform SELECT only 
     * for schedule ID.
     * 
     * @param stdObject $schedule Schedule object (SELECT result).
     * 
     * @return array Array struct: [ planData, changesList[timestamp, person, oldnextdate] ]
     */
    public static function get_plandata( $schedule ) : array {
        
        global $DB;
        
        // Now list is ordered by ASC (natural order, adding order), so FIRST planned date is located in first record.
        $sql = " 
            SELECT qsc.timecreated, CONCAT_WS(' ', u.lastname, u.firstname) AS employeename, qsc.datenextquiz AS prevdate
            FROM {quizschedule_changes} qsc INNER JOIN {user} u ON qsc.managerid=u.id
            WHERE
                qsc.quizscheduleid = $schedule->id
            /*ORDER BY timecreated DESC*/
            "; // MySQL add the query to cache for all day long ( if cache is enabled )
        
        if ( $changeslistraw = $DB->get_records_sql( $sql ) ) {
            
            $firstchange = array_shift( $changeslistraw );
            
            $plan = $firstchange->datenextquiz;
            
            $changes = [];
            
            $changes[] = [
                'timecreated' => $firstchange->timecreated,
                'person' => $firstchange->employeename,
                'prevdate' => $firstchange->prevdate
            ];
            
            if ( $changeslistraw ) {
                
                foreach ( $changeslistraw as $change ) {
                    
                    $changes[] = [
                        'timecreated' => $change->timecreated,
                        'person' => $change->employeename,
                        'prevdate' => $change->prevdate
                    ];
                    
                }
                
            }
            
        } else {
            // not found
            $plan = $schedule->datenextquiz;
            
            $changes = [];
            
        }
        
        return [
            'plan' => $plan,
            'changes' => $changes
        ];
        
    }
    
}

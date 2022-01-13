<?php
namespace mod_quizschedule;

defined('MOODLE_INTERNAL') || die(); // throws ERROR or constant 'MOODLE_INTERNAL' is not defined



/**
 * Module Helper
 */
class helper {
    
    public static function modroot() {
        global $CFG;
        return $CFG->dirroot . '/mod/quizschedule';
    }
    
    public static function moddatadir( ) {
        return self::modroot( ) . '/data';
    }
    
    
    public function __construct( ) {
        
    }
    
    /**
     * @param type $user Global $USER object
     */
    public function get_user_groups( $user ) : access_helper {
        
        //$roles = get_user_roles(context_course::instance($course->id), $user->id);
        //$x  = get_user_roles_sitewide_accessdata($user->id);
        
        $aco = new access_helper( $user->id );
        
        return $aco;
                
        if (is_siteadmin( $user->id ) ) {
            
            $group->is_admin = true;
            
            $group->is_lc = true;
            
            $group->is_rp = true;
            
            return [ true, true, false ]; // is_admin, is_lc, is_employee
            
        } else {
            
            return [ false, false, true ];
            
        }
    }
    
    /**
     * 
     */
    public function get_schedule( $employeeid = null ) {
        global $DB;

        $todaytimestamp = date( 'Y-m-d' );

        $sql = " 
            SELECT q.name, DATE_FORMAT( qs.datenextquiz, '%d-%m-%Y' ) as quizdate 
            FROM {quizschedule} qs INNER JOIN {quiz_attempts} qa ON qs.attemptid=qa.id INNER JOIN {quiz} q ON qa.quiz=q.id ";

        $where = " 
            qs.datenextquiz >= DATE_SUB( '$todaytimestamp', INTERVAL 1 MONTH ) AND 
            qs.datenextquiz <= DATE_ADD( '$todaytimestamp', INTERVAL 18 MONTH ) ";
        
        if ( isset( $employeeid ) ) {
            $where .= " AND qs.employeeid = :employeeid ";
            $params = [ 
                'employeeid' => $employeeid,
            ];
        }


        $sql .= "\nWHERE {$where}";

        $sql .= "\nORDER BY qs.datenextquiz DESC";

        $employee_schedule = $DB->get_records_sql( $sql, $params );

        return $employee_schedule;
        
        // date to timestamp:
        // qs.datenextquiz > UNIX_TIMESTAMP( DATE_SUB( '$todaytimestamp', INTERVAL 1 MONTH ) ) AND 
        // qs.nextattemptdate < UNIX_TIMESTAMP(DATE_ADD('$todaytimestamp', INTERVAL 18 MONTH)) ";
        
        // date from timestamp:
        // SELECT q.name, DATE_FORMAT(FROM_UNIXTIME(qs.nextattemptdate), '%d-%m-%Y') as quizdate FROM {quiz_schedule} qs INNER JOIN {quiz_attempts} qa ON qs.attemptid=qa.id INNER JOIN {quiz} q ON qa.quiz=q.id     WHERE  qs.userid = :userid AND qs.nextattemptdate > DATE_SUB(2019-05-31, INTERVAL 1 MONTH) AND qs.nextattemptdate < DATE_ADD(2019-05-31, INTERVAL 18 MONTH)     ORDER BY qs.nextattemptdate DESC 
    }
    
    
    public function admin_get_settingarray( $suffix = '' ) {
        
        
        
    }
    
    public function admin_get_settingarrayassoc( string $value, string $splitter = ',' ) {
        
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
    
    public function admin_getint( $rawint ) {
        
        $int = (int) filter_var( $rawint, FILTER_SANITIZE_NUMBER_INT );
        
        
        return $int;
        
    }
    
    public function admin_getunit( $rawcss ) {
        
        $pattern = '/([a-z]+)$/';
        
        preg_match( $pattern, $rawcss, $matches );
        
        
        return $matches[1];
        
    }
}

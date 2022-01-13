<?php

namespace quizschedulemaincommission_group;

defined('MOODLE_INTERNAL') || die();

use mod_quizschedule\helper as helper;


class schedule {
    
    /**
     * 
     */
    public function get_employees( string $quizdate, $ismoodleattempt, $isschedule ) {
        
        $employeelist = [];
        
        if ( $ismoodleattempt ) {
            
            $attemts = $this->get_moodleattempts( $quizdate );
            
            $employeelist = array_merge( $employeelist, $attemts );
            
        }
        
        if ( $isschedule ) {
            
            $schedules = $this->get_schedules( $quizdate );
            
            $employeelist = array_merge( $employeelist, $schedules );
            
        }
        
        
        return $employeelist;        
        
    }
    
    /**
     * 
     */
    public function get_moodleattempts( string $quizdate ) {
        global $DB;
                
        // Anti words
        $antiwords = explode( ' ', get_config( 'mod_quizschedule', 'quizlistidentifyingantiwords' ) );
        $likeexprantiwords = $this->get_sqllikeexpr( 'q.name', $antiwords, true );
        if ( ! empty( $likeexprantiwords ) /*&& count( $likeexprantiwords ) > 1*/ ) {
            $likeexprantiwords = implode( ' OR ', $likeexprantiwords );
        }
        // Words
        $words = explode( ' ', get_config( 'mod_quizschedule', 'quizlistidentifyingwords' ) );
        $likeexprwords = $this->get_sqllikeexpr( 'q.name', $words );
        if ( ! empty( $likeexprwords ) /*&& count( $likeexprantiwords ) > 1*/ ) {
            $likeexprwords = implode( ' OR ', $likeexprwords );
        }
        $likeexpr = ' ( ' . $likeexprantiwords . ' ) AND ( ' . $likeexprwords . ' ) ';
        
        // datetime state fullname grade
        $sql = " 
            SELECT 
                u.id employee_id,
                CONCAT_WS( ' ', u.lastname, u.firstname ) AS employee_fullname,
                u.address employee_position,
                u.institution employee_affiliate,
                GROUP_CONCAT( 
                    CONCAT_WS( ', ', 
                        q.name, 
                        CONCAT( 'номер в Moodle: ', qa.id ), 
                        CONCAT( 'період спроби: ', FROM_UNIXTIME( qa.timestart, '%d.%m.%Y %H:%i:%s' ), '-', FROM_UNIXTIME( qa.timefinish, '%d.%m.%Y %H:%i:%s' ) ), 
                        CONCAT( 'стан: ', qa.state ) 
                    ) 
                    SEPARATOR '%BR%' 
                ) quizattempt_info
            FROM
                {quiz_attempts} qa 
                LEFT JOIN 
                {quiz} q ON q.id = qa.quiz 
                LEFT JOIN 
                {user} u ON u.id = qa.userid 
            WHERE
                qa.timefinish >= UNIX_TIMESTAMP( '$quizdate' ) 
                AND 
                qa.timefinish <= UNIX_TIMESTAMP( '$quizdate' + INTERVAL 1 day ) 
                AND 
                $likeexpr
            GROUP BY 
                employee_id                    
            ORDER BY 
                employee_fullname ASC
        ";
 
        // Result List
        $employeelist = $DB->get_records_sql( $sql, $params );

        
        return $employeelist;
        
    }
    
    /**
     * 
     */
    public function get_sqllikeexpr( string $col, array $word, bool $negative = false ) : array {
        
        $like = [];
        
        $negative = $negative ? 'NOT' : '';
        
        foreach ( $word as $prm ) {
            
            $like[] = "$col $negative LIKE '%$prm%'";
            
        }
        
        //if
        
        
        return $like;
        
    }
    
    /**
     * 
     */
    public function get_schedules( string $quizdate ) {
        global $DB;
        
        $maincommissionid = 1;
        
        $sql = " 
            SELECT 
                GROUP_CONCAT( DISTINCT qs.id ORDER BY qs.id ASC SEPARATOR '.' ) quizschedule_id, 
                qs.commissionkey quizschedule_commissionkey,
                qs.employeeid employee_id,
                GROUP_CONCAT( DISTINCT q.name ORDER BY q.name ASC SEPARATOR ', ' ) quiz_name,
            #    u.id employee_id,
                CONCAT_WS( ' ', u.lastname, u.firstname ) AS employee_fullname,
                u.address employee_position,
                u.institution employee_affiliate
            FROM
                (
                    SELECT
                        qs.id,
                        qs.employeeid,
                        qs.quizid,
                        qsct.`key` commissionkey
                    FROM
                        {quizschedule} qs
                        LEFT JOIN
                        {quizschedule_commissiontype} qsct ON qs.commissiontypeid = qsct.id
                    WHERE
                        datenextquiz = :quizdate 
                        AND 
                        ( commissiontypeid = :commissiontypeid OR commissiontypeid IS NULL )
                ) qs 
                INNER JOIN 
                {quiz} q ON q.id = qs.quizid 
                INNER JOIN 
                {user} u ON u.id = qs.employeeid 
            GROUP BY 
                employee_id
            ORDER BY 
                employee_fullname ASC
        ";
        
        // Params
        $params = [ 
            'quizdate' => $quizdate,
            'commissiontypeid' => $maincommissionid
        ];

        // Result List
        $employeelist = $DB->get_records_sql( $sql, $params );

        
        return $employeelist;
        
    }
    
    /**
     * 
     */
    public function joinSchedules( $attempts, $schedules ) {
        
        
        
    }
    
    /**
     * Filters 
     */
    
    /**
     * 
     */
    public function filter_replacedoublequotes( $val ) {
        
        $word = get_config( 'quizschedulemaincommission_group', 'datafilterdoublequotes' );
        
        return str_replace( '"', $word, $val );
        
    }
    
    /**
     * 
     */
    public function filter_replacebreackline( $val ) {
        
        $word = get_config( 'quizschedulemaincommission_group', 'datafilterbreakline' );
        
        return str_replace( '<br />', $word, $val );
        
    }
    
    /**
     * 
     */
    public function filter_backreplacebreakline( $val ) {
        
        // Returns %BR% or similar
        $find = get_config( 'quizschedulemaincommission_group', 'datafilterbreakline' );
        
        $replace = '<br />';
        
        return str_replace( $find, $replace, $val ); // find replace where
        
    }
    
    /**
     * 
     */
    public function filter_affiliatenumber( $val ) {
        
        $raw_cfg = get_config( 'quizschedulemaincommission_group', 'dataaffiliatenumber' );
        
        if ( $raw_cfg ) {
            
            $affiliatenumber = ( new helper )->admin_get_settingarrayassoc( $raw_cfg, ',' );
            
            if ( array_key_exists( $val, $affiliatenumber ) ) {

                return $affiliatenumber[ $val ];

            }
            
        }
                
        
        return $val;
        
    }
    
    /**
     * 
     */
    public function filter_quizgroupbylines( $val ) {
        
        //$raw_cfg = get_config( 'quizschedulemaincommission_group', 'dataaffiliatenumber' );
        
        $val = str_replace( ', ', '<br />', $val );
                
        
        return $val;
        
    }
    
    /**
     * 
     */
    public function filter_commissiontype( $commissionkey ) {
        
        $commission = get_string( 'add_commissiontype_val_' . $commissionkey, 'mod_quizschedule' );
        
        if ( $commission === '[[add_commissiontype_val_]]' ) {

            return '';

        }
        
        return $commission;
        
    }
    
}

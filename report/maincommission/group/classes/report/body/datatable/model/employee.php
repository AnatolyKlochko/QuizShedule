<?php
namespace quizschedulemaincommission_group\report\body\datatable\model;

use quizschedulemaincommission_group\report\model as report_model;



/**
 * Employee Model
 *
 */
class employee extends report_model {
  
    public function __construct( \stdClass $employee = null ) {
        
        if ( empty( $employee ) ) {
            return;
        }
        
        foreach ( $employee as $prop => $value ) {
            
            $this->{$prop} = $value;
            
        }
        
        
        // Hidden Fields
        
        if ( $this->employee_position ) {
            
            $this->hidden_employee_position = $this->employee_position;
            
        }
        
        if ( $this->employee_affiliate ) {
            
            $this->hidden_employee_affiliate = $this->employee_affiliate;
            
        }
        
        
    }
    
    public function get_info() {
        
        return $this->employee_fullname . '<br />' . $this->employee_position . '<br />' . $this->employee_affiliate;
        
    }
    
    private function load_data( ) {
        
        list( $quizdate, $ismoodleattempt, $isschedule ) = $this->get_params();
        
        $employeelist = [];
        
        if ( $ismoodleattempt ) {
            
            $attemts = $this->get_moodleattempts( $quizdate );
            
            $employeelist = array_merge( $employeelist, $attemts );
            
        }
        
        if ( $isschedule ) {
            
            $schedules = $this->get_schedules( $quizdate );
            
            $employeelist = array_merge( $employeelist, $schedules );
            
        }
                
        $raw_data = $employeelist;
        
        
        return $raw_data;
        
    }
    
    private function get_params() {
        
        $prm = [];
        
        
        // Quiz Date
        $prm[] = isset( self::$param['quizdate'] ) ? date( 'Y-m-d', strtotime( self::$param['quizdate'] ) ) : date( 'Y-m-d' );
        
        // Attempt CheckBox State
        $prm[] = isset( self::$param['moodleattempt'] ) && self::$param['moodleattempt'] === 'on' ? true : false;
        
        // Schedule CheckBox State
        $prm[] = isset( self::$param['schedule'] ) && self::$param['schedule'] === 'on' ? true : false;
        
        
        return $prm;
        
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
            
            foreach ( $raw_data as $raw_employee ) {
                
                $emp = new self( $raw_employee );
                
                // filters
                
                $this->filter_replaceaffiliatenumbertoname( $emp->employee_affiliate );
                
                $this->filter_replacedoublequotessymboltohash( $emp->hidden_employee_affiliate );
                
                $this->filter_replacedoublequotessymboltohash( $emp->hidden_employee_position );
                
                $this->filter_replacecomatobrtaginquiz( $emp->quiz_name );
                
                $this->filter_replacecommissiontypekeytoname( $emp->commissionkey );
                
                if ( $emp->quizattempt_info ) {
                    
                    $this->filter_replacebreaklinehashtobrtag( $emp->quizattempt_info );
                    
                }
                
                
                $employee[] = $emp;

            }
                   
        }
        
        
        return $employee;
                
    }
    
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
                        CONCAT( 'період: ', FROM_UNIXTIME( qa.timestart, '%d.%m.%Y %H:%i:%s' ), ' - ', FROM_UNIXTIME( qa.timefinish, '%d.%m.%Y %H:%i:%s' ) ), 
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
    
    public function get_sqllikeexpr( string $col, array $word, bool $negative = false ) : array {
        
        $like = [];
        
        $negative = $negative ? 'NOT' : '';
        
        foreach ( $word as $prm ) {
            
            $like[] = "$col $negative LIKE '%$prm%'";
            
        }
        
        //if
        
        
        return $like;
        
    }

}

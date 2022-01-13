<?php
namespace mod_quizschedule\model;

defined('MOODLE_INTERNAL') || die();

use mod_quizschedule\access_helper as ac_helper;

// UNUSED ACCORDING: \lib\coursecatlib.php:28
//require_once($CFG->libdir . '/coursecatlib.php');

class schedule {
    
    /**
     * Returns General Report Array.
     */
    public function get_report( $employeeid = null ) {
        
        return ( new report() )->get();
        
    }
    
    /**
     * 
     */
    public function get_schedule( $employeeid = null ) {
        global $DB, $CFG;

        $todaydate = date( 'Y-m-d' );
        $daysbefore = get_config( 'mod_quizschedule', 'scheduletabledaysbefore' );
        $daysafter = get_config( 'mod_quizschedule', 'scheduletabledaysafter' );
        
        $sql = " 
            SELECT q.name, DATE_FORMAT( qs.datenextquiz, '%d-%m-%Y' ) as quizdate 
            FROM {quizschedule} qs INNER JOIN {quiz_attempts} qa ON qs.attemptid=qa.id INNER JOIN {quiz} q ON qa.quiz=q.id ";

        $where = " 
            qs.datenextquiz >= DATE_SUB( '$todaydate', INTERVAL $daysbefore DAY ) AND 
            qs.datenextquiz <= DATE_ADD( '$todaydate', INTERVAL $daysafter DAY ) ";
        
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
    
    /**
     * key moment is DESC in 'ORDER BY qs.timecreated DESC', because no sence 
     * edit any previous schedule points.
     */
    public function get_prev_schedulepoint( $employeeid, $quizid ) {
        global $DB;

        $sql = " 
            SELECT 
                qs.id AS quizscheduleid,
                qs.managerid, 
                qs.employeeid, 
                CONCAT_WS(' ', u.lastname, u.firstname) AS employeename, 
                u.institution, 
                u.department, 
                q.name AS quizname, 
                ct.id AS ctid, 
                ct.`key` AS ctkey, 
                qs.grade,
                qs.datequiz, 
                qs.datenextquiz, 
                qs.timecreated
            FROM 
                {user} u 
                INNER JOIN 
                {quizschedule} qs ON u.id=qs.employeeid
                LEFT JOIN 
                {quiz} q ON qs.quizid=q.id
                LEFT JOIN 
                {quizschedule_commissiontype} ct ON qs.commissiontypeid=ct.id
            WHERE
                qs.employeeid = :employeeid
                AND 
                qs.quizid = :quizid
            ORDER BY 
                qs.timecreated DESC
            LIMIT 2
        ";
        
        $params = [ 
            'employeeid' => $employeeid,
            'quizid' => $quizid
        ];

        $employee_schedule = $DB->get_records_sql( $sql, $params );//echo '<pre>1';var_dump($employee_schedule);
        
        // if result is more than 1 record
        if ( count( $employee_schedule ) > 1 ) {
            
            // return second row, it is prev schedule point
            $prev_schedulepoint = current( array_slice( $employee_schedule, 1, 1 ) );
            
            return $prev_schedulepoint;
            
        }
        
        return false;
        
    }
    
    /**
     * key moment is DESC in 'ORDER BY qs.timecreated DESC', because no sence 
     * edit any previous schedule points.
     */
    public function get_schedulepoint( $employeeid, $quizid, $scheduleid = null ) {
        global $DB;
        
        $whereexpr = ( is_null( $scheduleid ) ) ? 'qs.employeeid = :employeeid AND qs.quizid = :quizid' : 'qs.id = :scheduleid';

        $sql = " 
            SELECT 
                qs.id AS quizscheduleid,
                qs.managerid, 
                qs.employeeid, 
                CONCAT_WS(' ', u.lastname, u.firstname) AS employeename, 
                u.institution, 
                u.department, 
                q.name AS quizname, 
                ct.id AS ctid, 
                ct.`key` AS ctkey, 
                qs.grade,
                qs.datequiz, 
                qs.datenextquiz, 
                qs.timecreated
            FROM 
                {user} u 
                INNER JOIN 
                {quizschedule} qs ON u.id=qs.employeeid
                LEFT JOIN 
                {quiz} q ON qs.quizid=q.id
                LEFT JOIN 
                {quizschedule_commissiontype} ct ON qs.commissiontypeid=ct.id
            WHERE
                $whereexpr
            ORDER BY 
                qs.timecreated DESC
        ";
        
        $params = [ 
            'employeeid' => $employeeid,
            'quizid' => $quizid,
            'scheduleid' => $scheduleid
        ];

        $employee_schedule = $DB->get_record_sql( $sql, $params );//echo '<pre>1';var_dump($employee_schedule);
        //$employee_schedule->commissiontypeid = $DB->get_field( 'quizschedule_commissiontype', '`key`', [ 'id' => $employee_schedule->commissiontypeid ] );
        
        
        return $employee_schedule;
        
    }
    
    /**
     * 
     * ToDo: add condition 'schedule points for last 10 years'
     */
    public function get_schedulepoints( $employeeid, $quizid ) {
        global $DB;

        $sql = " 
            SELECT 
                qs.id AS id, qs.managerid, qs.employeeid, CONCAT_WS(' ', u.lastname, u.firstname) AS employeename, 
                u.institution, u.department, q.name AS quizname, ct.`key` AS ctkey, qs.datequiz, qs.datenextquiz, qs.timecreated
            FROM 
                {quizschedule} qs 
                LEFT JOIN {user} u ON u.id=qs.employeeid
                LEFT JOIN {quiz} q ON qs.quizid=q.id
                LEFT JOIN {quizschedule_commissiontype} ct ON qs.commissiontypeid=ct.id
            WHERE
                qs.employeeid = :employeeid AND qs.quizid = :quizid
            ORDER BY 
                qs.timecreated DESC
        "; // this thing gets down request
        
        $params = [ 
            'employeeid' => $employeeid,
            'quizid' => $quizid
        ];

        $employee_schedule = $DB->get_records_sql( $sql, $params );//echo '<pre>1';var_dump($employee_schedule);
        //$employee_schedule->commissiontypeid = $DB->get_field( 'quizschedule_commissiontype', '`key`', [ 'id' => $employee_schedule->commissiontypeid ] );

        
        return $employee_schedule;
        
    }
    
    /*
     * 
     */
    public function get_grcolumn_list( $onlywithquizzes = true ) {
        
        global $DB;
        
        $sql = " 
            SELECT id, name_uk, desc_uk
            FROM {quizschedule_columns} 
            ".
            ( $onlywithquizzes ? 'WHERE has_quiz=1 ' : '' )
            ."
            ORDER BY `order`
            ";

        $columnlist = $DB->get_records_sql( $sql );

        return $columnlist;
        
    }
    
    /**
     * 
     */
    public function get_affiliate_list() {
        static $affiliate_list;
        global $DB;

        if ( ! isset( $affiliate_list ) ) {
            $sql = " 
                SELECT `key`, name_uk 
                FROM {quizschedule_affiliatelist}";

            //$sql .= "\nORDER BY qs.datenextquiz DESC";

            $raw_affiliate_list = $DB->get_records_sql( $sql );
            
            foreach ($raw_affiliate_list as &$affiliate) {
                $affiliate = $affiliate->name_uk;
            }
            
            $affiliate_list = &$raw_affiliate_list;
        }

        return $affiliate_list;
    }
    
    /**
     * 
     */
    public function get_affiliate_employees( string $affiliate_key = '' ) {
        global $DB;

        $sql = "SELECT id, CONCAT_WS(' ', lastname, firstname) AS name, institution, department FROM {user} ";
        $params = [];

        if ( ! empty( $affiliate_key ) ) {
            $where = " institution = :institution ";

            $affiliate_name = $this->get_affiliate_by_key( $affiliate_key );
            $params = [ 'institution' => $affiliate_name ];

            $sql .= "\nWHERE {$where}";
        }

        $employees = $DB->get_records_sql( $sql, $params );

        return $employees;
    }
    
    /**
     * 
     */
    public function get_affiliate_by_key( $affiliate_key ) {
        $affiliate_list = $this->get_affiliate_list( );
        $affiliate_name = $affiliate_list[ $affiliate_key ];
        return $affiliate_name;
    }
    
    /**
     * 
     */
    public function get_employees_by_affiliate_quiz( string $affiliate_key, string $quiz_id ) {
        global $DB;
        
//        $sql = " 
//            SELECT 
//                qs.employeeid AS id, 
//                CONCAT_WS(' ', u.lastname, u.firstname) AS name, 
//                u.institution, 
//                u.department, 
//                qs.quizid, 
//                qs.datenextquiz
//            FROM 
//                {user} u 
//                INNER JOIN {quizschedule} qs ON u.id = qs.employeeid 
//                INNER JOIN {quiz} q ON qs.quizid = q.id
//            WHERE
//                u.institution = :institution
//                AND 
//                qs.quizid = :quizid
//            ORDER BY 
//                name ASC
//        ";

        $sql = " 
            SELECT 
                qs.employeeid AS id, 
                u.name, 
                u.institution, 
                u.department, 
                qs.quizid, 
                qs.datenextquiz
            FROM
                (
                    SELECT
                        id,
                        CONCAT_WS( ' ', lastname, firstname ) AS name, 
                        institution,
                        department
                    FROM
                        {user}
                    WHERE
                        institution = :institution
                ) u 
                INNER JOIN {quizschedule} qs 
                    ON u.id = qs.employeeid 
                INNER JOIN {quiz} q 
                    ON qs.quizid = q.id
            WHERE
                qs.quizid = :quizid
            ORDER BY 
                u.name ASC
        ";
        
        // Params
        // 
        // Affiliate Name (string)
        $affiliate_name = $this->get_affiliate_by_key( $affiliate_key );
        
        $params = [ 
            'institution' => $affiliate_name,
            'quizid' => $quiz_id
        ];

        // Result List
        $employeelist = $DB->get_records_sql( $sql, $params );

        
        return $employeelist;
        
    }
    
    /**
     * Returns TOP categories.
     * 
     * @return array Array of all root categories, names.
     */
    public function quiz_get_top_categories(  ) : ? array {
        
        // coursecat is now alias to autoloaded class core_course_category
        // course_in_list is an alias to core_course_list_element
        // coursecat_sortable_records is deprecated
        
        // Get root category (an imagine abstract category that is parent of real top categories)
        $root = \coursecat::get( 0, IGNORE_MISSING );
        
        if( ! is_null( $root ) ) {
            
            $top_level_categories = $root->get_children();
            
            if ( count( $top_level_categories ) < 1 ) {
                return null;
            }
            
            // Names of Top Categories
            $top = [];
            
            // Fill $top array
            foreach ( $top_level_categories as $top_category ) {
                
                $top[] = $top_category->name;
                
            }
            
        }
        
        
        return $top;
        // TODO: create at admin settings with checkboxes list of root categories and use selected as allowed
        
//        return [
//            'Перевірка знань в комісіях', //'Перевірка знань Головною комісією',//,
//            'Перевірка знань Головною комісією',
//            'Розвиток компетенцій',
//            //'Курсове навчання УЦ',
//        ];
        
    }
        
    /**
     * Returns filtered and ordered array of root categories.
     * 
     * @return array Array of root categories names.
     */
    public function quiz_get_allowed_top_categories(  ) : array {
        
        $top = $this->quiz_get_top_categories();
        
        $allowed_cfg = get_config( 'mod_quizschedule', 'quizlistallowedcategories' );
        
        $allowed_top = [];
        
        foreach ( explode( ',', $allowed_cfg ) as $i ) {
            
            $allowed_top[] = $top[ intval($i) ];
            
        }
        
        
        return $allowed_top;
        
//        return [
//            'Перевірка знань в комісіях', //'Перевірка знань Головною комісією',//,
//            'Перевірка знань Головною комісією',
//            'Розвиток компетенцій',
//            //'Курсове навчання УЦ',
//        ];
        
    }
    
    /**
     * 
     */
    public function get_quiz_list() {
        static $quizarr;
        global $CFG, $DB;

        if ( ! isset( $quizarr ) ) {
            $quizarr = [];
            $searchtextarr = explode( ' ', get_config( 'mod_quizschedule', 'quizlistidentifyingwords' ) );
            $searchtextarrcount = count( $searchtextarr );
            $cattag = $CFG->qs_quiz_cat_tag || 'span';
            $catclass = $CFG->qs_quiz_cat_class || 'quiz-cat';
            $catdelimiter = $CFG->qs_quiz_cat_delimiter || '>';
            
            
            // NOTE: it returns data from 'mdl_course' table.
            $sql = ' 
                SELECT q.id AS quizid, q.name AS quizname, cc.id AS catid, cc.path 
                FROM {quiz} q INNER JOIN {course} c ON q.course=c.id INNER JOIN {course_categories} cc ON c.category=cc.id
            ';
            $allquizzes = $DB->get_records_sql( $sql, $params );
            
            foreach ( $allquizzes as $quiz ) { // course_in_list
                
                // Filter: by if the course is a quiz (if quiz name contains word 'кзамен')
                for ( $i = 0; $i < $searchtextarrcount; $i++ ) {
                    
                     $searchtext = $searchtextarr[$i];
                    
                    if ( mb_stripos( $quiz->quizname, $searchtext, 0, 'UTF-8') === false ) {//echo '-1--'; echo '<pre>not quiz:'; var_dump( $searchtext ); var_dump( $quiz->quizname ); echo '</pre>';
                        // Nothing found at all, is the $i last
                        if ( $i == ( $searchtextarrcount - 1 ) ) { 
                            // Leave the for() and current loop of foreach()
                            continue 2;
                        }
                    } else {
                        // Quiz is found, leave the for()
                        break;
                    }
                    
                }
                
                
                // Filter: by root category kind, allowed only 'Перевірка знань', 'Розвиток компетенцій'
                $cat = \coursecat::get( $quiz->catid, IGNORE_MISSING, true ); //->get_parents() id name path(/4/123/{self}
                
                $rootcat_name = ( function( string $path ) { // "/4/123/{self}"

                    $parents = explode( '/', $path );

                    foreach ( $parents as $parentid ) {
                        
                        if ( empty( $parentid ) ) continue;
                        
                        $rootname .= \coursecat::get( $parentid, IGNORE_MISSING, true )->name;
                        
                        break;
                        
                    }

                    return $rootname;

                })( $cat->path );
                
                $allowed_topcat = $this->quiz_get_allowed_top_categories();
                
                if ( ! in_array( $rootcat_name, $allowed_topcat, true ) ) {
                    
                    continue;
                    
                }
                                
                
                
                // Quiz list
                $quizarr[ ] = [
                    'id' => $quiz->quizid,
                    'fullname' => $quiz->quizname,
                    'rootcat_name' => $rootcat_name,
                    'category_breadcrumb' => ( function( string $path ) { // "/4/123/{self}"

                        $parents = explode( '/', $path );

                        foreach ( $parents as $parentid ) {
                            if ( empty( $parentid ) ) continue;
                            $namepath .= \coursecat::get( $parentid, IGNORE_MISSING, true )->name . ' > ';
                        }

                        $namepath = mb_ereg_replace( '\s>\s$', '', $namepath, 'im');

                        return $namepath;

                    })( $cat->path )
                ];

            }
            
            // Sort quiz array
            $rootcat_name  = array_column( $quizarr, 'rootcat_name' );
            $fullname = array_column( $quizarr, 'fullname' );
            array_multisort( $rootcat_name, SORT_ASC, $fullname, SORT_ASC, $quizarr );
            
        }

        return $quizarr;

    }
    
    /**
     * 
     */
    public function get_quiz_list_by_partname( string $quizpartname ) {
        static $quizarr;
        global $CFG, $DB;

        if ( ! isset( $quizarr ) ) {
            $quizarr = [];
//            $searchtext = $CFG->qs_adddata_words_for_identiting_quiz_objects;
//            $cattag = $CFG->qs_quiz_cat_tag || 'span';
//            $catclass = $CFG->qs_quiz_cat_class || 'quiz-cat';
//            $catdelimiter = $CFG->qs_quiz_cat_delimiter || '>';
            
            
            // NOTE: it returns data from 'mdl_course' table.
            $sql = ' 
                SELECT q.id AS quizid, q.name AS quizname, q.timemodified as modified, cc.id AS catid, cc.path 
                FROM {quiz} q INNER JOIN {course} c ON q.course=c.id INNER JOIN {course_categories} cc ON c.category=cc.id
            ';
            $allquizzes = $DB->get_records_sql( $sql, $params );
            
            foreach ( $allquizzes as $quiz ) { // course_in_list

                // Filter: by if the course is a quiz (if quiz name contains word 'кзамен')
                if ( mb_stripos( $quiz->quizname, $quizpartname, 0, 'UTF-8') === false ) {//echo '-1--'; echo '<pre>not quiz:'; var_dump( $searchtext ); var_dump( $quiz->quizname ); echo '</pre>';
                    // Nothing found
                    continue;
                }//echo '-1--'; echo '<pre>QUIZ:'; var_dump( $searchtext ); var_dump( $quiz->quizname ); echo '</pre>';

                
                // Filter: by root category kind, allowed only 'Перевірка знань', 'Розвиток компетенцій'
                $cat = \coursecat::get( $quiz->catid, IGNORE_MISSING, true ); //->get_parents() id name path(/4/123/{self}
                
                $rootcat_name = ( function( string $path ) { // "/4/123/{self}"

                    $parents = explode( '/', $path );

                    foreach ( $parents as $parentid ) {
                        
                        if ( empty( $parentid ) ) continue;
                        
                        $rootname .= \coursecat::get( $parentid, IGNORE_MISSING, true )->name;
                        
                        break;
                        
                    }

                    return $rootname;

                })( $cat->path );
                
                $allowed_topcat = $this->quiz_get_allowed_top_categories();
                
                if ( ! in_array( $rootcat_name, $allowed_topcat, true ) ) {
                    
                    continue;
                    
                }
                                
                
                
                // Quiz list
                $quizarr[ ] = [
                    'id' => $quiz->quizid,
                    'fullname' => $quiz->quizname,
                    'rootcat_name' => $rootcat_name,
                    'category_breadcrumb' => ( function( string $path ) { // "/4/123/{self}"

                        $parents = explode( '/', $path );

                        foreach ( $parents as $parentid ) {
                            if ( empty( $parentid ) ) continue;
                            $namepath .= \coursecat::get( $parentid, IGNORE_MISSING, true )->name . ' > ';
                        }

                        $namepath = mb_ereg_replace( '\s>\s$', '', $namepath, 'im');

                        return $namepath;

                    })( $cat->path ),
                    'modified' => $quiz->modified
                ];

            }
            
            // Sort quiz array
            $rootcat_name  = array_column( $quizarr, 'rootcat_name' );
            $fullname = array_column( $quizarr, 'fullname' );
            array_multisort( $rootcat_name, SORT_ASC, $fullname, SORT_ASC, $quizarr );
            
        }

        return $quizarr;

    }
    
    /**
     * 
     */
    function get_commissiontype_list() {
        static $commissiontype_list;
        global $DB;

        if ( ! isset( $commissiontype_list ) ) {
            $sql = " 
                SELECT id, `key`
                FROM {quizschedule_commissiontype}";

            //$sql .= "\nORDER BY qs.datenextquiz DESC";

            $raw_commissiontype_list = $DB->get_records_sql( $sql );
            
            
            foreach ( $raw_commissiontype_list as &$commissiontype ) {
                $commissiontype = $commissiontype->key;
            }
            
            $commissiontype_list = &$raw_commissiontype_list;
        }

        return $commissiontype_list;
    }
    
    /**
     * 
     */
    public function get_employee_name( int $id ) {
        global $DB;

        $sql = "SELECT CONCAT_WS(' ', lastname, firstname) FROM {user} ";
        $where = " id = :id ";
        $params = [
            'id' => $id
        ];
        $sql .= "\nWHERE {$where}";
        $employeename = $DB->get_field_sql( $sql, $params );

        return $employeename;
    }
    
    public function get_employee_affiliatename( int $id ) {
        global $DB;
        
        // If Employee is absent in DB, continue
//        if ( $DB->get_field( 'user', 'id', [ 'id' => $employee['id'] ] ) === FALSE ) {
//            return 'Not found.';
//        }

        return $DB->get_field( 'user', 'institution', [ 'id' => $id ] );
    }
    
    
    // Redundant Data.
    
    /**
     * NOTE: the Moodle get_sql_records func treats first column as ID and uses it
     * as key of assoc array, therefore it is NECESSARY to add as firs column an
     * unique identifier.
     */
    public function get_redundant_data( array $params = [] ) {
        global $DB;
        
        $sql = " 
-- SET @id = 0;
SELECT 
        @id := @id + 1 id,
	CONCAT( u.lastname, ' ', u.firstname ) employeename, 
	u.institution employeeaffiliatename,
	q.name quizname, 
	qs.employeeid, 
	qs.quizid,
	qs.`planresultstatistics`,
	qs.`schedulepointcount`, 
	qs.`column_id`,
	qs.`column_datequiz`,
	qs.`column_datenextquiz`,
	qs.`column_timecreated`
FROM 
	(
		SELECT 
			employeeid,
			quizid,
			GROUP_CONCAT( IF( ISNULL( `datequiz` ) OR LENGTH( `datequiz` ) = 0, '0', '1' ) SEPARATOR '' ) AS `planresultstatistics`,
			COUNT(*) AS `schedulepointcount`,
			GROUP_CONCAT( `id` SEPARATOR ',' ) AS `column_id`,
			GROUP_CONCAT( IF( ISNULL( `datequiz` ) OR LENGTH( `datequiz` ) = 0, '0', `datequiz` ) SEPARATOR ',' ) AS `column_datequiz`,
			GROUP_CONCAT( IF( ISNULL( `datenextquiz` ) OR LENGTH( `datenextquiz` ) = 0, '0', `datenextquiz` ) SEPARATOR ',' ) AS `column_datenextquiz`,
			GROUP_CONCAT( `timecreated` SEPARATOR ',' ) AS `column_timecreated`
		FROM 
			{quizschedule}
		GROUP BY 
			employeeid, 
			quizid
		HAVING
--	we need select only redundant data:		
			INSTR( `planresultstatistics`, '0' ) AND
			`schedulepointcount` > 1
                LIMIT 10
	) qs
	INNER JOIN 
	{user} u ON qs.employeeid = u.id 
	INNER JOIN
	{quiz} q ON qs.quizid = q.id,
        (SELECT @id := 0) r
        ";
        
        //$where = " u.institution = :institution AND qs.quizid = :quizid ";

//        $affiliate_name = $this->get_affiliate_by_key( $affiliate_key );
//        $params = [ 
//            'institution' => $affiliate_name,
//            'quizid' => $quiz_id
//        ];
//
//        $sql .= "\nWHERE {$where}";
//
//        $sql .= "\nORDER BY name ASC";

        $redundantdatalist = $DB->get_records_sql( $sql/*, $params*/ );
        
        
        return $redundantdatalist;
        
    }
    
    /**
     * 
     */
    public function get_redundant_data_children( array &$rd ) {
        
        foreach ( $rd as &$empoyeequiz ) { // redundant data, quizschedule point
            
            $column_id_arr = explode( ',', $empoyeequiz->column_id );
            
            $column_datequiz_arr = explode( ',', $empoyeequiz->column_datequiz );
            
            $column_datenextquiz_arr = explode( ',', $empoyeequiz->column_datenextquiz );
            
            $column_timecreated_arr = explode( ',', $empoyeequiz->column_timecreated );
            
            $rows_count = count( $column_id_arr );
            
            $empoyeequiz->children = [];
            
            for( $i = 0; $i < $rows_count; $i++ ) {
                
                $point = [];
                
                $point['id'] = $column_id_arr[$i];
                
                $point['datequiz'] = $column_datequiz_arr[$i];
                
                $point['datenextquiz'] = $column_datenextquiz_arr[$i];
                
                $point['timecreated'] = $column_timecreated_arr[$i];
                
                $empoyeequiz->children[] = $point;
                
            }
            
        }
        
    }
    
    /**
     * 
     */
    public function mark_redundant_data_children( array &$rd ) {

            foreach( $rd as &$empoyeequiz ) { // redundant data, quizschedule point

                    $maxplandate = 0;
                    //$maxquizdate = 0;
                    $pointid_withmaxplandate = 0;

                    // find max plan date
        foreach ( $empoyeequiz->children as $point ) {

                            $nextdate = strtotime( $point['datenextquiz'] );

                            if ( $nextdate > $maxplandate ) {

                                    $maxplandate = $nextdate;

                                    $pointid_withmaxplandate = $point['id'];

                            }

                    }

                    // mark points
        foreach ( $empoyeequiz->children as &$point ) {

                            $point['checked'] = ( $point['id'] == $pointid_withmaxplandate ? 'off' : 'on' );
                            $m = 2 + 3;

                    }
        unset( $point );

    }

    }

    /**
     * 
     */
    function delete_redundant_data( array &$rd_to_delete ) {
            global $DB;
            $deletedcount = 0;
            
            // it is accepted in foreach loop
            unset( $rd_to_delete['submit_save'] );

            foreach ( $rd_to_delete as $point ) {

                    if ( $point['checked'] ) {

                            $DB->delete_records( 'quizschedule', array( 'id' => $point['id'] ) );

                            $deletedcount++;

                    }

            }

            return $deletedcount;

    }
    
    /**
     * 
     */
    function get_redundant_data_count( ) : int {
        global $DB;
        
        $sql = " 
SELECT 
    @id := @id + 1 id,
-- it's error, : 
--        COUNT(*) AS count
-- because count always will be equal 10. Realy count is in 
-- `planresultstatistics` field and it is ( count of symbols ) - 1 symbol, for ONE row:
    `schedulepointcount`
FROM 
	(
		SELECT 
			employeeid,
			quizid,
			GROUP_CONCAT( IF( ISNULL( `datequiz` ) OR LENGTH( `datequiz` ) = 0, '0', '1' ) SEPARATOR '' ) AS `planresultstatistics`,
			COUNT(*) AS `schedulepointcount`,
			GROUP_CONCAT( `id` SEPARATOR ',' ) AS `column_id`,
			GROUP_CONCAT( IF( ISNULL( `datequiz` ) OR LENGTH( `datequiz` ) = 0, '0', `datequiz` ) SEPARATOR ',' ) AS `column_datequiz`,
			GROUP_CONCAT( IF( ISNULL( `datenextquiz` ) OR LENGTH( `datenextquiz` ) = 0, '0', `datenextquiz` ) SEPARATOR ',' ) AS `column_datenextquiz`,
			GROUP_CONCAT( `timecreated` SEPARATOR ',' ) AS `column_timecreated`
		FROM 
			{quizschedule}
		GROUP BY 
			employeeid, 
			quizid
		HAVING
--	we need select only redundant data:		
			INSTR( `planresultstatistics`, '0' ) AND
			`schedulepointcount` > 1
--              LIMIT 10
	) qs,
        (SELECT @id := 0) r
";
        
 
        $redundantdata = $DB->get_records_sql( $sql );
        
        $rdtotal = 0;
        
        foreach ( $redundantdata as $row_ugly ) {
            
            $rdtotal += ( $row_ugly->schedulepointcount - 1 );
            
        }
        
        
        return $rdtotal;
        
    }
    
    
    // General Report. Relation Columns<->Quizzes
    
    /**
     * 
     */
    function save_link_quizzes_to_grcolumn( $quizzes_grcolumm ) {
        
        global $DB, $USER;

        if ( isset( $quizzes_grcolumm['grcolumnid'] ) ) {
            
            $grcolumnid = $quizzes_grcolumm['grcolumnid'];
            
            unset( $quizzes_grcolumm['grcolumnid'] );
            
        }
                
        unset( $quizzes_grcolumm['submit_link'] );
        
        
        // Report info
        $result = [
            'grcolumnname' => $DB->get_field( 'quizschedule_columns', 'name_uk', [ 'id' => $grcolumnid ] ),
            'quizzes' => [],
            'quizzescount' => 0,
            'message' => '',
            'messagetype' => '' // info, warning
        ];
        
        
        // Collect Empoyees to one array, student by student
        foreach ( $quizzes_grcolumm as $quiz ) {
            
            // Verifying 'Employee Scope'
            
            // - if no: employee ID, or employee grade, or next date quiz - continue
            if ( empty( $quiz['id'] ) ) continue;
            if ( empty( $quiz['quiz_status'] ) || $quiz['quiz_status'] != 'on' ) continue;
                        
            
            $quizid = $quiz['id'];
            
            // - if 
            if ( $DB->record_exists( 'quizschedule_columns_quizzes', [ 
                    'columnid' => $grcolumnid,    // LC or RP
                    'quizid' => $quizid,            // and the Quiz
                ] ) ) {
                
                // has added information, then it can be edited or deleted only
                continue;
                
            }
            
            
            
            
            // Collect
            $link_result = [
                'columnid' => $grcolumnid,
                'quizid' => $quizid,
            ];
            
            $linkresult_prepared[] = $link_result;
            
            
            // Report info
            $result[ 'quizzes' ][] = [
                'id' => $quizid,
                'fullname' => $DB->get_field( 'quiz', 'name', [ 'id' => $quizid ] ),
            ];
            $result[ 'quizzescount' ]++;
    
        }
        
        // Adding, within transaction
        // Note: if the transaction WILL NOT lock 'quiz_attempts' table - can be problems with correct $uniqueid value and/or $quizattemptcount. 
        // To avoid this the value of $uniqueid var will increment for +5 step. The $quizattemptcount still as is.
        
        if ( count( $linkresult_prepared ) ) {
            
            try {

                try {

                    // Open TRANSACTION
                    $transaction = $DB->start_delegated_transaction();

                    // Insert Quiz Result
                    $DB->insert_records( 'quizschedule_columns_quizzes', $linkresult_prepared );

                    // Apply TRANSACTION
                    $transaction->allow_commit();

                } catch (Exception $e) {

                    // Make sure transaction is valid.
                    if ( !empty( $transaction ) && !$transaction->is_disposed()) {

                        $transaction->rollback($e);

                        $result[ 'quizzescount' ] = 0;

                    }

                }

            } catch (Exception $e) {
                // Silence the rollback exception or do something else.
                // May be later: Verify if rows were inserted. Delete permanently.
            }
            
        }
        
        
        return $result;       
                
    }
    
    
    // Quiz Result
    
    /**
     * 
     */
    function save_quiz_result( array &$quizresult ) { //echo '<pre>1';var_dump($quizresult);
        global $DB, $USER;

        $managerid = $quizresult['managerid'];
        unset( $quizresult['managerid'] );
        $manager = $this->get_employee_name( $managerid );
        
        $quizdate = $quizresult['quizdate'];
        $quizdate_ts = strtotime( $quizdate ); // convert date to timestamp
        unset( $quizresult['quizdate'] );
        
        $commissiontypeid = $quizresult['commissiontypeid'];
        unset( $quizresult['commissiontypeid'] );
        $commission = get_string('add_commissiontype_val_'. $DB->get_field( 'quizschedule_commissiontype', '`key`', [ 'id' => $commissiontypeid ] ), 'quizschedule');
        
        $quizid = $quizresult['quizid'];
        unset( $quizresult['quizid'] );
        $quiz = $DB->get_field( 'quiz', 'name', [ 'id' => $quizid ] );
        
        // Delete last element "submit_save"
        unset( $quizresult['submit_save'] );
        //array_pop( $quizresult );
        
        
        // Verify array for only employees are presented: has prop 'id', 'quiz_mark', 'quiz_nextdate'
               
        
        $employeeid;
        $quizattempt;
        $quizattemptcount;
        $quizgrades;
        $quizschedule;
        
        $aco = new ac_helper( $USER->id );
        
        // Report info
        $result = [
            'date' => $quizdate,
            'quiz' => $quiz,
            'commission' => $commission,
            'manager' => $manager,
            'students' => [],
            'total' => 0,
            'message' => '',
            'messagetype' => '', // info, warning
            'status' => 'success' // fail
        ]; //echo '<pre>1';var_dump($result);

        
        
        // Verifying 'Quiz Scope'
                       
        // - if an Employee is not related to RP affiliate -> cancel adding
        if ( 0 /*$aco->is_rp*/ ) { // if manager is RP
            
            // RP Affiliate Name
            $rp_affiliatename = $this->get_employee_affiliatename( $managerid );
            
            foreach ( $quizresult as $employee ) {
                
                // If Employee is absent in DB, continue
//                if ( $DB->get_field( 'user', 'id', [ 'id' => $employee['id'] ] ) === FALSE ) {
//                    continue;
//                }
                
                // Employee Affiliate Name
                $em_affiliatename = $this->get_employee_affiliatename( intval( $employee['id'] ) );
                
                if ( $em_affiliatename === FALSE ) {
                    
                    $message = 'Філію співробітника з ID '.intval( $employee['id'] ).' не знайдено.';//'Ты шо так гнать, '.$rp_fullname.'. А откуда у Вас ID товарища из другого филиала ( ID-'.$employee['id'].' Fullname-\''.$em_fullname.'\' Affiliate-\''.$em_affiliatename.'\' )?';
                    
                    $this->quiz_result_report( $result, $employee, __METHOD__, __LINE__, $message, 'error', 'fail' );
                    

                    // Stop adding at all
                    return $result;
                    
                }
            
                if ( $rp_affiliatename != $em_affiliatename ) {
                    
                    $rp_fullname = $this->get_employee_name( $managerid );
                    
                    $em_fullname = $this->get_employee_name( $employee['id'] );

                    $message = 'Список містить співробітників з інших філіалів: ' . $em_fullname;;//'Ты шо так гнать, '.$rp_fullname.'. А откуда у Вас ID товарища из другого филиала ( ID-'.$employee['id'].' Fullname-\''.$em_fullname.'\' Affiliate-\''.$em_affiliatename.'\' )?';
                    
                    $this->quiz_result_report( $result, $employee, __METHOD__, __LINE__, $message, 'error', 'fail' );


                    // Stop adding at all
                    return $result;

                }
                
            }
            
            // Set array pointer on the beginning of array (if manager is RP)
            // in PHP 5 it is not need, it makes automatically
            
        }
        
        
        // Array of Verified Employees
        //$quizresult_prepared = [];
        $quizresult_update_prepared = [];
        $quizresult_insert_prepared = [];
        
        // Collect Empoyees to arrays, student by student
        foreach ( $quizresult as $employee ) {
            
            // Verifying
                        
            // - 'Empty row', by default brauser sends everything displayed on 
            // the screen. In most cases it's rows with only Employee ID's.
            if ( empty( $employee['id'] ) || empty( $employee['quiz_mark'] ) || empty( $employee['quiz_nextdate'] ) || empty( $employee['attempt_id'] )  ) { 
                
                // $result['message'] .= 'Відсутнє поле ID Співробітника' . "\n " . __METHOD__.':'.__LINE__;
                    
                // $result['messagetype'] .= ' warning';
                
                continue;
                
            }
            // WRONG CONSTRAINTS:
            // - if no: employee ID, or employee grade, or next date quiz - continue
//            if ( empty( $employee['id'] ) ) { 
//                
////                $result['message'] .= 'Відсутнє поле ID Співробітника' . "\n " . __METHOD__.':'.__LINE__;
////                    
////                $result['messagetype'] .= ' warning';
//                
//                continue;
//                
//            }
//            if ( empty( $employee['quiz_mark'] ) ) {
//                
////                $result['message'] .= 'Відсутнє поле quiz_mark Співробітника' . "\n " . __METHOD__.':'.__LINE__;
////                    
////                $result['messagetype'] .= ' warning';
//                
//                continue;
//                
//            }
//            if ( empty( $employee['quiz_nextdate'] ) ) {
//                
//                $message = 'Відсутнє поле quiz_nextdate Співробітника';
//
//                $this->quiz_result_report( $result, $employee, __METHOD__, __LINE__, $message, 'warning' );
//                
//                
//                continue;
//                
//            }
            
            
            $employeeid = $employee['id'];
            $employeefullname = $this->get_employee_name( $employeeid );
            $attemptid = intval( $employee['attempt_id'] );
            $grade = $employee['quiz_mark'] === 'on' ? 1 : 0;
            
            // - does given attempt exist & belong to "employee and quiz" (or RP gave a fake attempt id, or some previous successful attemptid)
            if ( ! $this->attempt_check_to( $employeeid, $quizid, $attemptid ) ) {
                
                $existed_attemptid = $this->attempt_get( $employeeid, $quizid );
                $existed_attemptid = ( $existed_attemptid ? $existed_attemptid : '(не існує)' );
                $message = "Вказаний \"Номер в Moodle\" - $attemptid не відповідає наявному в Базі Даних - $existed_attemptid". 
                    ', для екзамену - ' . $quiz . ' (ID ' . $quizid . '), по співробітнику - ' . $employeefullname . ' (ID ' . $employeeid . '). Внесення результату до Бази Даних відмінено.';
                $this->quiz_result_report( $result, $employee, __METHOD__, __LINE__, $message, 'warning' );
                
                // has added information, then it can be edited or deleted only
                continue;
                
            }
            
            /**
             * Teacher can:
             * - set negative grade (in any situation)
             * - set positive grade only if Moodle test is passed
             * 
             * So, if grade is positive, check Moodle attempt on passing:
             */
            if ( $grade == 1 && ( ! $this->attempt_is_passed( $attemptid ) )  ) {
                
                $message = "Співробітник $employeefullname (ID $employeeid) не пройшов успішно тест в Moodle. Успішне проходження тесту є необхідною умовою для доступу на усний Екзамен. Внесення результату до Бази Даних відмінено.";
                $this->quiz_result_report( $result, $employee, __METHOD__, __LINE__, $message, 'warning' );
                
                // fail Moodle quiz attempt
                continue;
                
            }

            // - if 
            if ( $DB->record_exists( 'quizschedule', [ 
                    'datequiz' => $quizdate,        // for Quiz day
                    'quizid' => $quizid,            // and the Quiz
                    'employeeid' => $employeeid,    // and the Employee
                ] ) ) { // exists record...
                
                $message = 'Дані вже внесено до БД (відповідальна особа: '. $DB->get_field( 'quizschedule', 'managerid', [ 
                            'datequiz' => $quizdate,        // for Quiz day
                            'quizid' => $quizid,            // and the Quiz
                            'employeeid' => $employeeid,    // and the Employee
                        ] ) .', екзамен: ' . $quizid . ', співробітник: ' . $employeeid . ')';
                    
                $this->quiz_result_report( $result, $employee, __METHOD__, __LINE__, $message, 'warning' );
                
                // has added information, then it can be edited or deleted only
                continue;
                
            }
            
            
            // Verifying on 'data redundancy' + 'logical correctness':
            // - can't be for EmployeeID-QuizID plan record and result record ( because
            // plan MUST transform to result )
            // - ???:current quiz date MUST be (bigger than previous quiz date and less than quiz next date)
            $employee_schedule = $this->get_schedulepoints( $employeeid, $quizid );
            $es_count = count( $employee_schedule );
            $exists_plan = ( function( $employee_schedule ) {
                foreach ( $employee_schedule as $schedule_point ) {
                    if ( $schedule_point->datequiz ) {
                    } else {
                        return true;
                    }
                }
                return false;
            } )( $employee_schedule );
			
            // Verify Data Redundancy:
            if ( $exists_plan && $es_count > 1 ) { // one plan or only results
                // for this employee exists redundant data
                
                // Warning
                     
                $message = 'База Данних містить збиткові дані для: QuizID ' . $quizid . ', EmployeeID ' . $employeeid . '. Внесення результату екзамену відмінено.';

                $this->quiz_result_report( $result, $employee, __METHOD__, __LINE__, $message, 'warning' );
                
                continue;
            }

            
//            if ( $scount > 0 ) {
//                
//                $quizdate_prev = 0; $quizdate_curr; $quizdate_curr_next;
//            
//                $quiz_plan_count = $quiz_result_count = 0;
//                
//                foreach ( $employeeschedules as $employeeschedule ) {
//                    
//                    // Count plans and results
//                    
//                    if ( $employeeschedule->datequiz ) {
//                        
//                        $quiz_result_count++;
//                        
//                    } else {
//                        
//                        $quiz_plan_count++;
//                        
//                    }
//                    
//                    
//                    // Logical Correctness
//                    
//                    if ( $employeeschedule->datequiz ) {
//                        
//                        if ( strtotime( $employeeschedule->datequiz ) > strtotime( $quizdate_prev ) && 
//                                ( strtotime( $employeeschedule->datequiz ) < strtotime( $employeeschedule->datenextquiz ) || empty( $employeeschedule->datenextquiz ) ) 
//                            ) {
//                            // All right
//                        } else {
//                            
//                            // Error
//                            
//                            $message = 'База Данних містить некоректні дані: QuizScheduleID ' . $employeeschedule->id . ', EmployeeID ' . $employeeid . '.';
//                    
//                            $this->quiz_result_report( $result, $employee, __METHOD__, __LINE__, $message, 'warning' );
//
//                            continue;
//                                                        
//                        }
//                                        
//                    }
//                    
//                    // Save current quiz date
//                    
//                    $quizdate_prev = $employeeschedule->datequiz;
//                    
//                }
//                // Data Redundancy:
//                // - 
//                //if (  )
//                
//                
//            }
            
            
            
            // - last quiz date must not be existed or be less (<) than $quizdate
//            $lastquizdate = $DB->get_field_sql( 'SELECT datequiz FROM {quizschedule} ORDER BY datequiz DESC', [ 'employeeid' => $employeeid, 'quizid' => $quizid ], IGNORE_MULTIPLE );
//            if ( $lastquizdate === FALSE || strtotime( $lastquizdate ) < strtotime( $quizdate ) ) {
//                
//            } else {
//                
//                $message = "Дата Екзамену '$quizdate' є меншою ніж існуюча в БД '$lastquizdate'";
//                    
//                $this->quiz_result_report( $result, $employee, __METHOD__, __LINE__, $message, 'warning' );
//                
//
//                continue;
//                
//            }
            
            
            
            
            // Collect
            
            // ACTIONS
                    
            // Optional Data

            // Add records to 'mdl_quiz_attempts' and 'mdl_quiz_grades' + Get quiz attempt id
            //$quizattemptcount = $DB->get_field( 'quiz_attempts', 'attempt', [ 'quiz' => $quizid, 'userid' => $employeeid ] );
            //$uniqueid = $DB->get_record_sql("SELECT MAX(uniqueid) AS max_uniqueid FROM {quiz_attempts}")->max_uniqueid;
            
//            try {
//            
//                $quizattempt = [
//                    'quiz' => $quizid,
//                    'userid' => $employeeid,
//                    'attempt' => ( $quizattemptcount === false ) ? 1 : ++$quizattemptcount, // attempt number, has been paritcipate in index (сквозная нумерация попыток)
//                    'uniqueid' => ( $uniqueid === false ) ? 1 : ($uniqueid += 10), // throws error without
//                    'layout' => '(by quizschedule module)',
//                    'state' => 'finished',
//                    'sumgrades' => $grade,
//                    'timefinish' => $quizdate_ts // convert date to timestamp
//                ];
//                
//                $attemptid = $DB->insert_record( 'quiz_attempts', $quizattempt, true );
//
//            } catch (Exception $e) {
//                
//                $attemptid = NULL;
//                
//            }
            
            // Add records to 'mdl_quiz_grades'
//            try {
//            
//                $quizgrades = [
//                    'quiz' => $quizid,
//                    'userid' => $employeeid,
//                    'grade' => $grade,
//                    'timemodified' => $quizdate_ts
//                ];
//                
//                $DB->insert_record( 'quiz_grades', $quizgrades, false );
//
//            } catch (Exception $e) {
//                
//            }
            
            
            // QuizSchedule Row (Employee Schedule)
            $em_result = [
                'managerid' => $managerid,
                'employeeid' => $employeeid,
                'quizid' => $quizid,
                'grade' => $grade,
                'commissiontypeid' => $commissiontypeid,
                'attemptid' => $attemptid,
                'datequiz' => $quizdate,
                'datenextquiz' => $employee['quiz_nextdate']
            ];
            if ( $exists_plan ) {
                $id = ( current( $employee_schedule ) )->id;
                $em_result[ 'id' ] = $id;
                unset( $em_result['employeeid'] );
                unset( $em_result['quizid'] );
            }
            
            
            // Collect
            if ( $exists_plan ) {
                $quizresult_update_prepared[] = $em_result;
            } else {
                $quizresult_insert_prepared[] = $em_result;
            }
            //$quizresult_prepared[] = $em_result;
            
            
            // Report info
            $result['students'][] = [
                'name' => $this->get_employee_name( $employeeid ),
                'gradekey' => $employee['quiz_mark'],
                'datenextquiz' => $employee['quiz_nextdate']
            ];
            $result[ 'total' ]++;
    
        }
        
        // Adding, within transaction
        // Note: if the transaction WILL NOT lock 'quiz_attempts' table - can be problems with correct $uniqueid value and/or $quizattemptcount. 
        // To avoid this the value of $uniqueid var will increment for +5 step. The $quizattemptcount still as is.
        try {

            try {

                // Open TRANSACTION
                $transaction = $DB->start_delegated_transaction();
                
                // Update Quiz Plan->Result
                foreach( $quizresult_update_prepared as $em_result ) {
                    $upd_result = $DB->update_record( 'quizschedule', $em_result, true );
//                    if ( $upd_result ) {
//                        $this->autochange_plandate( $em_result['id'], $em_result['datequiz'] );
//                    }
                }

                // Insert Quiz Result
                foreach( $quizresult_insert_prepared as $em_result ) {
                    $id = $DB->insert_record( 'quizschedule', $em_result, true, true );
//                    if ( $id ) {
//                        $this->autochange_plandate( $id, $em_result['datequiz'] );
//                    }
                }
                //$DB->insert_records( 'quizschedule', $quizresult_insert_prepared );

                // Apply TRANSACTION
                $transaction->allow_commit();

            } catch (Exception $e) {

                // Make sure transaction is valid.
                if ( !empty( $transaction ) && !$transaction->is_disposed()) {

                    $transaction->rollback($e);
                    

                    $message = "Помилка транзакції. Опис: " . $e->getMessage();

                    $this->quiz_result_report( $result, $employee, __METHOD__, __LINE__, $message, 'error' );
                                    
                    $result[ 'total' ] = 0;

                }

            }

        } catch (Exception $e) {
            // Silence the rollback exception or do something else.
            // May be later: Verify if rows were inserted. Delete permanently.
        }
        
        
        
        return $result;

    }
    
    /**
     * 
     */
    function quiz_result_report( array &$r, $e, $m, $l, string $message, $type = 'warning', $status = 'success' ) {
        
        static $n = 1;
        
                
        $r['status'] = $status;
        
        $r['messagetype'] .= $n . '. <span class="' . $type . '">' . $type . '</span>';
        
        if( is_array( $e ) ) {
            
            $employee = 'ID:' . $e['id'] . ', ПІБ:' . $this->get_employee_name( $e['id'] ) . ', Оцінка:' . $e['quiz_mark'] . ', Наступний Екзамен: ' . $e['quiz_nextdate'];
            
        } else {
            
            $employee = $e;
            
        }
        
        $r['message'] .= 
                PHP_EOL . PHP_EOL . 
                $n . '. <span class="' . $type . '">' . $message . '</span>' . PHP_EOL . 
                'Співробітник: ' . $employee . PHP_EOL .
                $m . ':' . $l;
                
        
        $n++;
        
    }
    
    
    /** Quiz Attempt */
    
    /**
     * Selects only last nearest by date from today QUIZ attempt ID (excluding 
     * Trainee attempts) by relation "Employee-Quiz", and compare it to given 
     * attempt ID.
     * 
     * Previous wrong alhorithm:
     * Select last 20 attempts (for "employee & quiz") and seeks given attemp ID among them.
     */
    function attempt_check_to( int $employeeid, int $quizid, int $attemptid ) : bool {
        global $CFG, $DB;
        
        $quizsearchtextarr = explode( ' ', get_config( 'mod_quizschedule', 'quizlistidentifyingwords' ) );
        
        $likeexpr = [];
        foreach ( $quizsearchtextarr as $searchtext ) {
            $likeexpr[] = "q.name LIKE '%$searchtext%'";
        }
        $likeexpr = '( ' . implode( ' OR ', $likeexpr ) . ' )';

        $sql = " 
            SELECT 
                qa.id
            FROM 
                {quiz_attempts} qa
                INNER JOIN
                    {quiz} q
                        ON qa.quiz = q.id
            WHERE
                qa.quiz = :quizid
                AND
                $likeexpr
                AND 
                qa.userid = :employeeid
                AND
                qa.`state` = 'finished'
#                AND
#               qa.`timefinish` >= UNIX_TIMESTAMP( NOW() - INTERVAL 4 WEEK )
            ORDER BY 
                qa.timefinish DESC
            LIMIT
                1
        ";
        
        $params = [ 
            'quizid' => $quizid,
            'employeeid' => $employeeid,
        ];

        $employee_attempt = $DB->get_record_sql( $sql, $params );
        
        if ( $employee_attempt ) {
            if ( intval( $employee_attempt->id ) == $attemptid ) {
                return true;
            }
        }
        
        
        return false;
    }
    
    /**
     * Key thing is "finished", not necessary "passed".
     * 
     * Returns ID of first finished attempt for "employeeid & quizid" (not 
     * necessary passed), nearest in time (from now()).
     */
    function attempt_get( $employeeid, $quizid ) {
        global $DB;

        $sql = " 
            SELECT 
                id
            FROM 
                {quiz_attempts}
            WHERE
                quiz = :quizid
                AND 
                userid = :employeeid
                AND
                `state` = 'finished'
                AND
                `timefinish` >= UNIX_TIMESTAMP( NOW() - INTERVAL 4 WEEK )
            ORDER BY 
                timefinish DESC
            LIMIT
                1
        ";
        
        $params = [ 
            'quizid' => $quizid,
            'employeeid' => $employeeid
        ];

        $attempt = $DB->get_record_sql( $sql, $params );
        
        if ( $attempt ) {
            return $attempt->id;
        } else {
            return false;
        }
        
    }
    
    /**
     * Returns TRUE if attempt is finished and passed (passed grade)
     */
    function attempt_is_passed( $attemptid ) : bool {
        global $CFG;
        
        require_once($CFG->libdir . '/gradelib.php');
        require_once($CFG->dirroot . '/mod/quiz/locallib.php');
        
        $attemptobj = \quiz_create_attempt_handling_errors( $attemptid, null );
        
        
        // Quiz Grade to pass

        $cm = $attemptobj->get_cm();

        $course = $attemptobj->get_course();

        $quiz_gradepass = ( function( $cm, $course ){
            global $DB;
            $gradepass;

            // Check module exists.
            $module = $DB->get_record('modules', array('id'=>$cm->module), '*', MUST_EXIST);

            if ( ! $module ) return null;

            if ( $items = \grade_item::fetch_all( [
                'itemtype'=>'mod',
                'itemmodule'=>$module->name,
                'iteminstance'=>$cm->instance,
                'courseid'=>$course->id
            ] )) {

                // Add existing outcomes.
                foreach ( $items as $item ) {

                    if ( isset( $item->gradepass ) ) {

                        $decimalpoints = $item->get_decimals();

                        $gradepass = \format_float($item->gradepass, $decimalpoints);

                    }

                }

            }



            return $gradepass;

        } )( $cm, $course );
        
        
        // Employee Quiz 
        $attempt = $attemptobj->get_attempt();
        $quiz = $attemptobj->get_quiz();
        $employee_grade = \quiz_rescale_grade($attempt->sumgrades, $quiz, false); // come here with Debugger and find field with grade or better go to last tab and look...
        
        
        return $employee_grade >= $quiz_gradepass;
        
    }
    
    
    
    /**
     * In case successful updating or inserting of quiz result changes the 'datenextquiz' field of
     * previous schedule point to current quiz date and adds info to {quizschedule_changes} table
     * as new record with extra field 'autochanged'=true. This will give ability for RPs
     * to add quiz results early than plan date is (but only one quiz per day).
     */
    function autochange_plandate( $id, $quizdate ) {
        
        
        
    }
    
    
    // Quiz Plan
    
    /**
     * 
     */
    function save_quiz_plan( array &$quizplan ) { //echo '<pre>1';var_dump($quizplan);
        global $DB, $USER;

        $managerid = $quizplan['managerid'];
        unset( $quizplan['managerid'] );
        
//        $quizdate = $quizplan['quizdate'];
//        $quizdate_ts = strtotime( $quizdate ); // convert date to timestamp
//        unset( $quizplan['quizdate'] );
        
        $commissiontypeid = $quizplan['commissiontypeid'];
        unset( $quizplan['commissiontypeid'] );
        
        $quizid = $quizplan['quizid'];
        unset( $quizplan['quizid'] );
        
        // Delete last element "submit_save"
        unset( $quizplan['submit_save'] );
        //array_pop( $quizplan );
        
        // Verify array for only employees are presented: has prop 'id', 'quiz_mark', 'quiz_nextdate'
               
        
        $employeeid;
        //$quizattempt;
        //$quizattemptcount;
        //$quizgrades;
        $quizschedule;
        
        $aco = new ac_helper( $USER->id );
        
        // Report info
        $result = [
            //'date' => $quizdate,
            'quiz' => $DB->get_field( 'quiz', 'name', [ 'id' => $quizid ] ),
            'commission' => get_string('add_commissiontype_val_'. $DB->get_field( 'quizschedule_commissiontype', '`key`', [ 'id' => $commissiontypeid ] ), 'quizschedule'),
            'manager' => $this->get_employee_name( $managerid ),
            'students' => [],
            'total' => 0,
            'message' => '',
            'messagetype' => '', // info, warning
            'status'
        ]; //echo '<pre>1';var_dump($result);

        
        
        // Verifying 'Quiz Scope'
                       
        // - if an Employee is not related to RP affiliate -> cancel adding
        if ( 0 /*$aco->is_rp*/ ) { // if manager is RP
            
            // RP Affiliate Name
            $rp_affiliatename = $this->get_employee_affiliatename( $managerid );
            
            foreach ( $quizplan as $employee ) {
                
                // If Employee is absent in DB, continue
//                if ( $DB->get_field( 'user', 'id', [ 'id' => $employee['id'] ] ) === FALSE ) {
//                    continue;
//                }
                
                // Employee Affiliate Name
                $em_affiliatename = $this->get_employee_affiliatename( intval( $employee['id'] ) );
                
                if ( $em_affiliatename === FALSE ) {
                    
                    $message = 'Співробітника з ID '.intval( $employee['id'] ).' не знайдено.';//'Ты шо так гнать, '.$rp_fullname.'. А откуда у Вас ID товарища из другого филиала ( ID-'.$employee['id'].' Fullname-\''.$em_fullname.'\' Affiliate-\''.$em_affiliatename.'\' )?';
                    
                    $this->quiz_plan_report( $result, $employee, __METHOD__, __LINE__, $message, 'error', 'fail' );

                    // Stop adding at all
                    return $result;
                    
                }
            
                if ( $rp_affiliatename != $em_affiliatename ) {
                    
                    $rp_fullname = $this->get_employee_name( $managerid );
                    
                    $em_fullname = $this->get_employee_name( $employee['id'] );

                    $message = 'Список містить співробітників з інших філіалів: ' . $em_fullname;//'Ты шо так гнать, '.$rp_fullname.'. А откуда у Вас ID товарища из другого филиала ( ID-'.$employee['id'].' Fullname-\''.$em_fullname.'\' Affiliate-\''.$em_affiliatename.'\' )?';
                    
                    $this->quiz_plan_report( $result, $employee, __METHOD__, __LINE__, $message, 'error', 'fail' );

                    // Stop adding at all
                    return $result;

                }
                
            }
            
            // Set array pointer on the beginning of array (if manager is RP)
            // in PHP 5 it is not need, it makes automatically
            
        }
        
        
        // Array of Verified Employees
        $quizplan_prepared = [];
        
        // Collect Empoyees to one array, student by student
        foreach ( $quizplan as $employee ) {
            
            // Verifying 'Employee Scope'
            
            if ( empty( $employee['id'] ) || empty( $employee['quiz_nextdate'] ) ) { 
                
                // $result['message'] .= 'Відсутнє поле ID Співробітника' . "\n " . __METHOD__.':'.__LINE__;
                    
                // $result['messagetype'] .= ' warning';
                
                continue;
                
            }
            
            // WRONG CONSTRAINTS:
            // - if no: employee ID, or employee grade, or next date quiz - continue
//            if ( empty( $employee['id'] ) && empty( $employee['quiz_nextdate'] ) ) { 
//                
//                // $result['message'] .= 'Відсутнє поле ID Співробітника' . "\n " . __METHOD__.':'.__LINE__;
//                    
//                // $result['messagetype'] .= ' warning';
//                
//                continue;
//                
//            }
//            if ( empty( $employee['id'] ) ) { 
//                
//                // $result['message'] .= 'Відсутнє поле ID Співробітника' . "\n " . __METHOD__.':'.__LINE__;
//                    
//                // $result['messagetype'] .= ' warning';
//                
//                continue;
//                
//            }
            //if ( empty( $employee['quiz_mark'] ) ) continue;
//            if ( empty( $employee['quiz_nextdate'] ) ) {
//                
//                $message = 'Відсутнє поле quiz_nextdate Співробітника';
//                    
//                //$result['messagetype'] .= ' warning';
//
//                $this->quiz_plan_report( $result, $employee, __METHOD__, __LINE__, $message );
//                
//                continue;
//                
//            }
            
            
            $employeeid = $employee['id'];
            
            
            // - on redundant data
            $employee_schedule = $this->get_schedulepoints( $employeeid, $quizid );
            $es_count = count( $employee_schedule );
            if ( $es_count > 0 ) {
                // for this employee exists redundant data
                
                // Warning
                     
                $message = 'База Данних вже містить дані (плану або результату) для: QuizID ' . $quizid . ', EmployeeID ' . $employeeid . '. Внесення данних призведе до збитковості (порушення цілісності даних).  Внесення плану відмінено.';

                $this->quiz_result_report( $result, $employee, __METHOD__, __LINE__, $message, 'warning' );
                
                continue;
            }
            
            
            
            
            // Collect
            $em_plan = [
                'managerid' => $managerid,
                'employeeid' => $employeeid,
                'quizid' => $quizid,
                'commissiontypeid' => $commissiontypeid,
                //'datequiz' => $quizdate,
                'datenextquiz' => $employee['quiz_nextdate']
            ];
//            if ( ! is_null( $attemptid ) ) {
//                $em_plan[ 'attemptid' ] = $attemptid;
//            }
            $quizplan_prepared[] = $em_plan;
            
            
            // Report info
            $result[ 'students' ][] = [
                'name' => $this->get_employee_name( $employeeid ),
                //'gradekey' => $employee['quiz_mark'],
                'datenextquiz' => $employee['quiz_nextdate']
            ];
            $result[ 'total' ]++;
    
        }
        
        // Adding, within transaction
        // Note: if the transaction WILL NOT lock 'quiz_attempts' table - can be problems with correct $uniqueid value and/or $quizattemptcount. 
        // To avoid this the value of $uniqueid var will increment for +5 step. The $quizattemptcount still as is.
        try {

            try {

                // Open TRANSACTION
                $transaction = $DB->start_delegated_transaction();

                // Insert Quiz Result
                $DB->insert_records( 'quizschedule', $quizplan_prepared );

                // Apply TRANSACTION
                $transaction->allow_commit();

            } catch (Exception $e) {

                // Make sure transaction is valid.
                if ( !empty( $transaction ) && !$transaction->is_disposed()) {

                    $transaction->rollback($e);
                    
                    $message = "Помилка транзакції. Опис: " . $e->getMessage();

                    $this->quiz_plan_report( $result, $employee, __METHOD__, __LINE__, $message, 'error', 'fail' );
                    
                    $result[ 'total' ] = 0;

                }

            }

        } catch (Exception $e) {
            // Silence the rollback exception or do something else.
            // May be later: Verify if rows were inserted. Delete permanently.
        }
        
        
        
        return $result;

    }
    
    /**
     * 
     */
    function quiz_plan_report( array &$r, $e, $m, $l, string $message, $type = 'warning', $status = 'success' ) {
        
        static $n = 1;
        
                
        $r['status'] = $status;
        
        $r['messagetype'] .= $n . '. <span class="' . $type . '">' . $type . '</span>';
        
        if( is_array( $e ) ) {
            
            $employee = 'ID:' . $e['id'] . ', ПІБ:' . $this->get_employee_name( $e['id'] ) . ', Оцінка:' . $e['quiz_mark'] . ', Наступний Екзамен: ' . $e['quiz_nextdate'];
            
        } else {
            
            $employee = $e;
            
        }
        
        $r['message'] .= 
                PHP_EOL . PHP_EOL . 
                $n . '. <span class="' . $type . '">' . $message . '</span>' . PHP_EOL . 
                'Співробітник: ' . $employee . PHP_EOL .
                $m . ':' . $l;
                
        
        $n++;
        
    }
       
    
    // Edit Data
    
    /**
     * Edit a quizschedule point.
     */
    function edit_data( array &$data ) {
        global $DB, $USER;
        
        // New row
        $new_row = [];
        $new_row['id'] = intval( $data['scheduleid'] );
        $new_row['managerid'] = $USER->id;
        $new_row['quizid'] = intval( $data['quizid'] );
        if ( isset( $data['grade'] ) ) { 
            $new_row['grade'] = intval( $data['grade'] == 0 ? 0 : 1 );
        }
        $new_row['datequiz'] = ( $data['datequiz'] ? date( 'Y-m-d', strtotime( $data['datequiz'] ) ) : null );
        $new_row['datenextquiz'] = date( 'Y-m-d', strtotime( $data['datenextquiz'] ) );
        $new_row['commissiontypeid'] = intval( $data['commissiontypeid'] );
        
        // Current row
        $current_row = $DB->get_record( 'quizschedule', ['id' => $data['scheduleid']] );
        
        
        
        // Verifying
         
        $verifyingmsg = ''; 
        
        // Schedulepoint exists
        if ( ! $DB->record_exists( 'quizschedule', [ 'id' => $new_row['id'] ] ) ) {

            $verifyingmsg = 'Запис відсутній в Базі Даних (план екзамену з ID ' . $new_row['id'] . ' не існує). Редагування неможливе';

            return [
                'message' => $verifyingmsg,
                'status' => false
            ];
            
        }
        
        // - REQUIREMENT FOR OLD ALGORITHM VERSION. if at given date exists quizid and employeeid, disable adding (result for employee was added, continue)
//        if ( strtotime($quiznextdate) == strtotime($quiznextdate_old) )
//            return $result;
        
        // if exists previous schedule point, then curr.date > prev.date, curr.plandate > prev.plandate
        if ( ( $prevpoint = $this->get_prev_schedulepoint( $current_row->employeeid, $current_row->quizid ) ) ) {
            
            if ( strtotime( $prevpoint->datequiz ) >= strtotime( $new_row['datequiz'] ) ) {
                
                $verifyingmsg = 'Дата Екзамену повинна бути більшою від дати попереднього Екзамену. Редагування відмінено';
                
                return [
                    'message' => $verifyingmsg,
                    'status' => false
                ];
                
            }
            
            if ( strtotime( $prevpoint->datenextquiz ) >= strtotime( $new_row['datenextquiz'] ) ) {
                
                $verifyingmsg = 'Планова дата Екзамену повинна бути більшою від планової дати попереднього Екзамену. Редагування відмінено';
                
                return [
                    'message' => $verifyingmsg,
                    'status' => false
                ];
                
            }
            
        } //else {
            // no problem, nothing to compare (because no prev schedule point - current editable point is single for the employeeid & quizid)
        //}
        
        // Quiz exists
        if ( ! $DB->record_exists( 'quiz', [ 'id' => $new_row['quizid'] ] ) ) {

            $verifyingmsg = 'Екзамен з ID ' . $new_row['quizid'] . ' не існує. Редагування відмінено';

            return [
                'message' => $verifyingmsg,
                'status' => false
            ];
            
        }
        
        // Commission type exists
        if ( ! is_null( $new_row['datequiz'] ) ) {
            
            if ( ! $DB->record_exists( 'quizschedule_commissiontype', [ 'id' => $new_row['commissiontypeid'] ] ) ) {

                $verifyingmsg = 'Комісія з ID ' . $new_row['commissiontypeid'] . ' не існує. Редагування відмінено';

                return [
                    'message' => $verifyingmsg,
                    'status' => false
                ];

            }
            
        }
                
        
        
        // Stringify current row
        $current_row_json = json_encode( $current_row );
        //$quiznextdate_old = $DB->get_field( 'quizschedule', 'datenextquiz', [ 'id' => $quizscheduleid ] );
        
        
        // Report Info
        $result = [
            'prev_row' => $current_row,
            'curr_row' => null,
            'total_changed' => 0,
            'total_added' => 0,
            'status' => true
        ];

        
        // Updating
        try {
            try {
                // Open TRANSACTION
                //$transaction = $DB->start_delegated_transaction();


                // ACTIONS
                
                // Update 'quizshedule'
                //$DB->set_field( 'quizschedule', 'datenextquiz', $data['datenextquiz'], [ 'id' => $data['scheduleid'] ] );
                $upd_result = $DB->update_record( 'quizschedule', $new_row );
                if ( ! $upd_result ) {
                    throw new Exception( 'Update error' );
                }
                
                // Report Info
                $result['total_changed'] = 1;
                
                
                // Get New Updated Row
                $new_row = $DB->get_record( 'quizschedule', ['id' => $data['scheduleid']] );
                $new_row_json = json_encode( $new_row );
                
                
                // Add record to 'quizschedule_changes'
                $quizschedule_changes = [
                    'managerid' => $USER->id,
                    'quizscheduleid' => $data['scheduleid'],
                    'datenextquiz' => $data['datenextquiz'],
                    'prev_row' => $current_row_json,
                    'curr_row' => $new_row_json
                ];
                $ins_result = $DB->insert_record( 'quizschedule_changes', $quizschedule_changes, false );
                // Report Info
                if ( ! $ins_result ) {
                    // it's strange...
                } else {
                    $result['total_added'] = 1;
                }

                // Apply TRANSACTION
                //$transaction->allow_commit();
                
            } catch (Exception $e) {
                // Make sure transaction is valid.
//                if (!empty($transaction) && !$transaction->is_disposed()) {
//                    $transaction->rollback($e);
//                }
                
                return $result;
            }
        } catch (Exception $e) {
            // Silence the rollback exception or do something else.
            // May be later: Verify if rows were inserted. Delete permanently.
        }
        
        
        // Report info
        $current_row->quiz = $DB->get_field( 'quiz', 'name', [ 'id' => $current_row->quizid ] );
        $current_row->commissiontype = $DB->get_field( 'quizschedule_commissiontype', '`key`', [ 'id' => $current_row->commissiontypeid ] );
        $current_row->employee = $this->get_employee_name( $current_row->employeeid );
        $current_row->manager = $this->get_employee_name( $current_row->managerid );
        //-
        $new_row->quiz = $DB->get_field( 'quiz', 'name', [ 'id' => $new_row->quizid ] );
        $new_row->commissiontype = $DB->get_field( 'quizschedule_commissiontype', '`key`', [ 'id' => $new_row->commissiontypeid ] );
        $new_row->employee = $this->get_employee_name( $new_row->employeeid );
        $new_row->manager = $this->get_employee_name( $new_row->managerid );
        $result['curr_row'] = $new_row;
        
        
        
        return $result;

    }
    
    
    /** Delete Data */
    
    function delete_data( $editdata ) {
        
        global $DB;
        
        
        $scheduleid = intval( $editdata['scheduleid'] );
        
        $result = [];
        $result['status'] = $DB->delete_records( 'quizschedule', ['id'=>$scheduleid]);
        $result['data'] = $editdata;
        
        return $result;
        
    }
    
}

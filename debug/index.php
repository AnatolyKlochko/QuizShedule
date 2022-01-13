<?php
//phpinfo();exit;

require_once( './../../../config.php' );


//include $CFG->dirroot . '/mod/quizschedule/debug/lib.php';
//debug_log( 'Test message at ' . __FILE__, 'global' );





/** Synchronization */
//use mod_quizschedule\Synchronization\Employee;
//Employee::synchronize_all();




//
///** LDAP */
//$ldapconnstr = "ldap://ad-dc2.oe.pl.ua/;ldap://ad-dc1.oe.pl.ua/";
//$ldaprdn  = 'CN=moodle,OU=TechUsers,OU=baza,DC=oe,DC=pl,DC=ua';     // ldap rdn или dn
//$ldappass = '12345678';  // ассоциированный пароль
//// Tables
//$context = 'dc=oe,dc=pl,dc=ua';
//$tbl_baza = 'ou=baza,dc=oe,dc=pl,dc=ua';
//$tbl_techusers = 'ou=TechUsers,dc=oe,dc=pl,dc=ua';
//$tbl_filiali = 'ou=filials,dc=oe,dc=pl,dc=ua';
//
//// соединение с сервером
//$ldapconn = ldap_connect( $ldapconnstr );
//    //or die("Не могу соединиться с сервером LDAP.");
//
//if ($ldapconn) {
//    
//    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
//    //ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
//    ldap_set_option($ldapconn, LDAP_OPT_X_TLS_REQUIRE_CERT, LDAP_OPT_X_TLS_NEVER);
//    //ldap_set_option($ldapconn, LDAP_OPT_SIZELIMIT, 10000 );
//    //ldap_set_option($ldapconn, LDAP_OPT_, LDAP_OPT_X_TLS_NEVER);
//
//    // привязка к ldap-серверу
//    $ldapbind = @ldap_bind( $ldapconn, $ldaprdn, $ldappass );
//
//    // проверка привязки
//    if ($ldapbind) {
//        
//        // Table 'Baza'
////        $filter="(employeeid=*)"; // + // 600 entries
////        $filter="(employeeid=53931)"; // + // 1 entry
//        $filter="(employeeid=49236)"; // + // 0 entry, 
////        $filter="(displayname=Клочко*)"; // + // 1 entry // Клочко Анатолій Сергійович
////        $filter="(displayname=К*)"; // + // 80 entries
////        $result = ldap_search( $ldapconn, $tbl_baza, $filter );
////        $info = ldap_get_entries( $ldapconn, $result );
////        $pageSize = 50;
////        $cookie = '';
////        do {
////            ldap_control_paged_result($ldapconn, $pageSize, true, $cookie);
////
////            $result  = ldap_search($ldapconn, $tbl_baza, $filter/*, $justthese*/);
////            $entries = ldap_get_entries($ldapconn, $result);
////
////            foreach ($entries as $e) {
////                echo $e['employeeid'] . PHP_EOL;
////            }
////
////            ldap_control_paged_result_response($ldapconn, $result, $cookie);
////
////        } while($cookie !== null && $cookie != '');
//        
//        // Table 'Filiali'
////        $filter="(employeeid=*)"; // + // 600 entries
////        $filter="(employeeid=52711)"; // + // 1 entry
////        $filter="(employeeid=49236)"; // + // 0 entry, 
////        $filter="(displayname=Клочко*)"; // + // 1 entry // Клочко Анатолій Сергійович
////        $filter="(displayname=К*)"; // + // 80 entries
////        $result = ldap_search( $ldapconn, $tbl_filiali, $filter );
////        $info = ldap_get_entries( $ldapconn, $result );
//        
//        
//        // Table '$context', keys the same like in 'Baza'
////        $filter="(employeeid=*)"; // + // 1000 entries
////        $filter="(employeeid=4630)"; // 53931 - no entries, 4630 - no entries
////        $filter="(displayname=Клочко*)"; // -
////        $filter="(displayname=К*)"; // -
////        $filter = '(&(objectClass=user)(objectCategory=person)(!(userAccountControl:1.2.840.113556.1.4.803:=2)))'; // 1000 entries
////        $filter = '(&(objectClass=user)(objectCategory=person)(!(userAccountControl:1.2.840.113556.1.4.803:=2))(&(employeeid=*)))';  // 1000 entries
////        $filter = '(&(objectClass=user)(objectCategory=person)(!(userAccountControl:1.2.840.113556.1.4.803:=2))(&(employeeid=53931)))'; // false (error)
////        $filter = '(&(objectClass=user)(objectCategory=person)(!(userAccountControl:1.2.840.113556.1.4.803:=2))(employeeid=53931*))'; // 1 entry
////        $filter = '(&(objectClass=user)(objectCategory=person)(!(userAccountControl:1.2.840.113556.1.4.803:=2))(employeeid=50203))'; // Гадяцька філія // 1 entry
////        $filter = Net_LDAP_Filter::create('givenName', 'equals', 'Benedikt');
////        $filter = '(&(objectClass=user)(objectCategory=person)(EmployeeID=53931)(!(userAccountControl:1.2.840.113556.1.4.803:=2)))'; // false (error)
////        $filter = '(&(EmployeeID=*)(EmployeeID=53931))'; // false (error)
////        $filtertest = '
////                ( 
////                  (&(objectClass=user)(objectCategory=person))
////                  (|(mail=*)(telephonenumber=*))
////                  (employeeid=53931)
////                  (!(userAccountControl:1.2.840.113556.1.4.803:=2))
////                )
////                  
////                  
////                  ';
//          //(|(mail=*)(telephonenumber=*)) (!(userAccountControl:1.2.840.113556.1.4.803:=2)))
////        $pageSize = 1000;
////        $cookie = '';
////        do {
////            ldap_control_paged_result($ldapconn, $pageSize, true, $cookie);
////
////            $result  = ldap_search($ldapconn, $context, $filter/*, $justthese*/);
////            $entries = ldap_get_entries($ldapconn, $result);
////
////            foreach ($entries as $e) {
////                echo $e['employeeid'] . PHP_EOL;
////            }
////
////            ldap_control_paged_result_response($ds, $result, $cookie);
////
////        } while($cookie !== null && $cookie != '');
//        $result = ldap_search( $ldapconn, $context, $filter ); // false
//        //ldap_sort($ldap,$result,"sn");
//        $info = ldap_get_entries( $ldapconn, $result );
//        $result = ldap_search( $ldapconn, $context, $filter ); // false
//        $info = ldap_get_entries( $ldapconn, $result );
////        var_dump($info);
//        
//        // Table 'TechUsers'
////        $filter2="(employeeid=*)";
////        $result2 = ldap_search( $ldapconn, $tbl_techusers, $filter );
//        //ldap_sort($ldap,$result,"sn");
////        $info2 = ldap_get_entries( $ldapconn, $result2 );
//        
//        
//        for ($i=0; $i<$info["count"]; $i++)
//        {
//            if($info['count'] > 1)
//                break;
//            echo "<p>You are accessing <strong> ". $info[$i]["sn"][0] .", " . $info[$i]["givenname"][0] ."</strong><br /> (" . $info[$i]["samaccountname"][0] .")</p>\n";
//            echo '<pre>';
//            var_dump($info);
//            echo '</pre>';
//            $userDn = $info[$i]["distinguishedname"][0]; 
//        }
//        @ldap_close($ldap);
//    } else {
//        echo "LDAP-привязка не удалась...";
//    }
//
//}





// Model "/classes/schedule.php"
include $CFG->dirroot . '/mod/quizschedule/classes/model/schedule.php';

// Top Categories
$schedule = new \mod_quizschedule\model\schedule;
$top = $schedule->quiz_get_top_categories();
$allowed = $schedule->quiz_get_allowed_top_categories();

//$x = ( new \mod_quizschedule\model\schedule )->get_schedulepoints( 1076, 105); // 5
//$x = ( new \mod_quizschedule\model\schedule )->get_schedulepoints( 1076, 107); // 3
//$xy = 5;
//$x = 0;





/**
 * Change being key of associative array
 * Result: now it isn't possible.
 */
//$a = ['one'=>1, 'two'=>2];
//foreach ($a as &$key => $value) {
//    $key = $key . '_' . time(); // ( ! ) Fatal error: Key element cannot be a reference in C:\xampp\apps\moodle.oe.pl.ua.sandbox\htdocs\mod\quizschedule\debug\index.php on line
//}
//$b = $a;





/**
 * Cyrilic & Latin in 'mdl_user':'institution'
 */
//
//$sql = ' 
//    SELECT institution AS affiliate
//    FROM {user}
//';
//$uaffiliates = $DB->get_records_sql( $sql );
//
//$len = '';
//
//foreach ( $uaffiliates as $affiliate_obj ) {
//    
//    try {
//        
//        $affiliate = $affiliate_obj->affiliate;
//        
//        $encoding = mb_detect_encoding( $affiliate );
//        
//        $len = mb_strlen( $affiliate, $encoding );
//        
//    } catch (Exception $exc) {
//        //echo $exc->getTraceAsString();
//    }
//
//    
//    for ( $i = 0; $i < $len; $i++ ) {
//        $char = $affiliate[$i];
//        $char_code = ord( $char );
//    }
//}





//$sql = ' 
//    SELECT q.id AS quizid, q.name AS quizname, cc.id AS catid, cc.path 
//    FROM {quiz} q INNER JOIN {course} c ON q.course=c.id INNER JOIN {course_categories} cc ON c.category=cc.id
//';
//$allquizzes = $DB->get_records_sql( $sql, $params );
//
//foreach ( $allquizzes as $quiz ) { // course_in_list
//
//    // Filter: by if the course is a quiz (if quiz name contains word 'кзамен')
//    //if ( mb_stripos( $quiz->quizname, $searchtext, 0, 'UTF-8') === false ) {//echo '-1--'; echo '<pre>not quiz:'; var_dump( $searchtext ); var_dump( $quiz->quizname ); echo '</pre>';
//        // Nothing found
//        //continue;
//    //}//echo '-1--'; echo '<pre>QUIZ:'; var_dump( $searchtext ); var_dump( $quiz->quizname ); echo '</pre>';
//
//}

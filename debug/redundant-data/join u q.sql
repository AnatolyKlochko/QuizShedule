SELECT 
	CONCAT( u.lastname, ' ', u.firstname ) employeename, 
	u.institution employeeaffiliatename,
--	q.name quizname, 
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
			mdl_quizschedule
		GROUP BY 
			employeeid, 
			quizid
		HAVING
--	we need select only redundant data:		
			INSTR( `planresultstatistics`, '0' ) AND
			`schedulepointcount` > 1
                LIMIT 10
	) qs
--	INNER JOIN 
--	mdl_user u ON qs.employeeid = u.id
--        INNER JOIN
--	mdl_quiz q ON qs.quizid = q.id
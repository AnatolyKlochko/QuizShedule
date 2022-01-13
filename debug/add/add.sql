
# Just get all records "Epmployee-Quiz" with their IDs. The purpose is delete rows, which have been added by mod quizschedule.
# Returns both Quizzes and Trainies
SELECT
    userid, quiz, GROUP_CONCAT( ', ', id ) AS attemptid_col
FROM
    mdl_quiz_attempts
GROUP BY
    userid,
    quiz


# ...get only Quzzes, plus few other params
SELECT
    qa.userid, qa.quiz, q.name AS quizname, GROUP_CONCAT( ', ', qa.id ) AS attemptid_col, COUNT(*) AS attempttotal
FROM
    mdl_quiz_attempts qa
    INNER JOIN
        mdl_quiz q ON qa.quiz = q.id
WHERE
#    qa.userid > 300
#    AND
    q.name LIKE '%кзамен%'
GROUP BY
    qa.userid,
    qa.quiz
HAVING
    attempttotal > 1


# Show only rows which have been added by quizschedule mod
SELECT 
    qa.`id`, qa.`sumgrades`, qs.id as scheduleid, qs.grade as schedulegrade
FROM 
    `mdl_quiz_attempts` qa LEFT JOIN mdl_quizschedule qs on qa.id=qs.attemptid
WHERE 
    qa.`sumgrades` IN (0, 1) AND qa.`layout` = '(by quizschedule module)';


# Run procedure to move actual grades from 'mdl_quiz_attempts' to 'mdl_quizschedule'
SET @test = 0;
SET @selected = 0;
SET @updated = 0;
SET @notFound = 0;
call deletebug_move_grade_from_quizattempts_to_quizschedule(@selected, @updated, @notFound);
SELECT @selected, @updated, @notFound;


# After actual grades have been moved from 'mdl_quiz_attempts', delete accedent rows
DELETE FROM mdl_quiz_attempts WHERE `sumgrades` IN (0, 1) AND `layout` = '(by quizschedule module)'


# Moves actual grades from 'mdl_quiz_attempts' to 'mdl_quizschedule'
DELIMITER $$
 
CREATE DEFINER=`root`@`localhost` PROCEDURE `deletebug_move_grade_from_quizattempts_to_quizschedule`(INOUT selected BIGINT, INOUT updated BIGINT, INOUT notFound BIGINT /* inout test bigint */)
BEGIN
		DECLARE varQuizAttempts_DataIsOver TINYINT DEFAULT 0;
		DECLARE varQuizSchedule_emptySet TINYINT DEFAULT 0;
		DECLARE varQuizAttemptID BIGINT;
        DECLARE varQuizAttemptGrade DECIMAL(10,5);
        DECLARE varQuizScheduleID BIGINT;
			 
		DECLARE csrQuizAttempts CURSOR FOR
			SELECT 
				`id`, `sumgrades`
			FROM 
				`mdl_quiz_attempts` 
			WHERE 
				`sumgrades` IN (0, 1) AND `layout` = '(by quizschedule module)';
			
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET varQuizAttempts_DataIsOver = 1, varQuizSchedule_emptySet = 1;

		SET selected = 0, updated = 0, notFound = 0;
	 
		OPEN csrQuizAttempts;
		FETCH csrQuizAttempts INTO varQuizAttemptID, varQuizAttemptGrade;

		# set test = varQuizAttemptID;
		# set test = varQuizAttemptGrade;

		WHILE varQuizAttempts_DataIsOver = 0 DO

        # set test = 1777777777;

			# get QuizSchedule ID
			SELECT id INTO varQuizScheduleID FROM `mdl_quizschedule` WHERE `attemptid` = varQuizAttemptID;

			# set test = varQuizScheduleID;

			IF varQuizSchedule_emptySet = 1 THEN
				SET varQuizSchedule_emptySet = 0, varQuizAttempts_DataIsOver = 0;
				SET notFound = notFound + 1;
				SET varQuizScheduleID = 0;
			END IF;

            # Update QuizSchedule with Grade from QuizAttempts table
			IF varQuizScheduleID > 0 THEN
				# set test = 1177777777;

				UPDATE `mdl_quizschedule` SET `grade` = varQuizAttemptGrade WHERE `id` = varQuizScheduleID;

				SET updated = updated + 1;

			END IF;
			
			SET selected = selected + 1;

			# Get next record from QuizAttempt table
			FETCH csrQuizAttempts INTO varQuizAttemptID, varQuizAttemptGrade;
			
		 END WHILE;
	 
		CLOSE csrQuizAttempts;
     
 END $$
 
DELIMITER ;









Publish moodle to remote
- load directory (open putty, sudo mc+Enter, move catalog from 10.107.1.135 to /var/www/html/moodle/mod/)
- delete 'sql' directory
- open admin page and click Обновити
- it will open 'https://moodle.oe.pl.ua/moodle/admin/upgradesettings.php?', where set settings ("кзамен", not "'кзамен'")
- open phpmyadmin and execute '/sql/create_tables.sql' and 'fill_columns_quizzes.sql'


Migrate module DB to remote

Module DB Tables:
`mdl_quizschedule_columns`
`mdl_quizschedule_columns_quizzes`
`mdl_quizschedule_affiliatelist`
`mdl_quizschedule_commissiontype`
`mdl_quizschedule`
`mdl_quizschedule_changes`

At this time exists 2 versions of Moodle DB. First is https://moodle.oe.pl.ua/moodle, 
second - https://moodle.oe.pl.ua/moodle. Second variant is a sandbox for production version (first varriant).
LC employees enter data to first version (to DB of first version).
For migrate module DB to second:
[- make DB dump of second: save data of {quizschedule} and {quizschedule_changes}]
- apply dump of first to second
[- run script 'create_tables.sql', if DB is overwritten]
- overwrite {quizschedule} and {quizschedule_changes} on second (from dump)
- by hand fill {quizschedule_columns_quizzes}. Open 'fill_table_columns_quizzes.slq' and follow instructions.


{quizschedule_columns_quizzes}
WARNING: if `quizid` in remote is different to local query will contain inexistent quizzes. SOLUTION: fill this table live/by hand on remote.


<?php
// Index Page settings
$name = new lang_string('indexpagesettings', 'mod_quizschedule');
$description = new lang_string('indexpagesettings_help', 'mod_quizschedule');
$settings->add( new admin_setting_heading( 
    'indexpagesettings', 
    $name, 
    $description
));
// Period Start of select of employee's schedules
$visiblename = new lang_string( 'scheduletabledaysbefore', 'mod_quizschedule' );
$description = new lang_string('scheduletabledaysbefore_help', 'mod_quizschedule');
$settings->add( new admin_setting_configtext(
    'mod_quizschedule/scheduletabledaysbefore', // name  // old name: qs_indexpage_userschedulestable_months_interval_before
    $visiblename,
    $description,
    35, // default settings
    PARAM_INT
    //$size // size
));
// Period Finish of select of employee's schedules
$visiblename = new lang_string( 'scheduletabledaysafter', 'mod_quizschedule' );
$description = new lang_string('scheduletabledaysafter_help', 'mod_quizschedule');
$settings->add( new admin_setting_configtext(
    'mod_quizschedule/scheduletabledaysafter', // name  // old name: qs_indexpage_userschedulestable_months_interval_after
    $visiblename,
    $description,
    35, // default settings
    PARAM_INT
    //$size // size
));

// General Schedule settings
$name = new lang_string('generalschedulesettings', 'mod_quizschedule');
$description = new lang_string('generalschedulesettings_help', 'mod_quizschedule');
$settings->add( new admin_setting_heading( 
    'generalschedulesettings', 
    $name, 
    $description
));
// Period Start of select of General Schedule
$visiblename = new lang_string( 'generalscheduletabledaysbefore', 'mod_quizschedule' );
$description = new lang_string('generalscheduletabledaysbefore_help', 'mod_quizschedule');
$settings->add( new admin_setting_configtext(
    'mod_quizschedule/generalscheduletabledaysbefore', // name  // old name: qs_indexpage_userschedulestable_months_interval_before
    $visiblename,
    $description,
    3650, // default settings, 365x10=3650 days, 10 years
    PARAM_INT
    //$size // size
));
// Period Finish of select of General Schedule
$visiblename = new lang_string( 'generalscheduletabledaysafter', 'mod_quizschedule' );
$description = new lang_string('generalscheduletabledaysafter_help', 'mod_quizschedule');
$settings->add( new admin_setting_configtext(
    'mod_quizschedule/generalscheduletabledaysafter', // name  // old name: qs_indexpage_userschedulestable_months_interval_after
    $visiblename,
    $description,
    3650, // default settings
    PARAM_INT
    //$size // size
));

// Adding Data settings
$name = new lang_string('addingdatasettings', 'mod_quizschedule');
$description = new lang_string('addingdatasettings_help', 'mod_quizschedule');
$settings->add( new admin_setting_heading( 
    'addingdatasettings', 
    $name, 
    $description
));
// Words for Identiting Quizzes
$visiblename = new lang_string( 'wordsforidentitingquizzes', 'mod_quizschedule' );
$description = new lang_string('wordsforidentitingquizzes_help', 'mod_quizschedule');
$settings->add( new admin_setting_configtext(
    'mod_quizschedule/wordsforidentitingquizzes', // name  // old name: qs_adddata_words_for_identiting_quiz_objects
    $visiblename,
    $description,
    '\'кзамен\' \'спит\'', // default settings
    PARAM_TEXT
    //$size // size
));
// Hours between Moodle Attempt and Oral Quiz
$visiblename = new lang_string( 'hoursbetweenmoodleattemptandoralquiz', 'mod_quizschedule' );
$description = new lang_string('hoursbetweenmoodleattemptandoralquiz_help', 'mod_quizschedule');
$settings->add( new admin_setting_configtext(
    'mod_quizschedule/hoursbetweenmoodleattemptandoralquiz', // name  // old name: qs_adddata_hours_between_moodle_and_oralquiz
    $visiblename,
    $description,
    12, // default settings
    PARAM_INT
    //$size // size
));

/** Загалний Графік */
//$settings->add(new admin_setting_heading('qs_gr_search', 'Загальний Графік', ''));
//$settings->add(new admin_setting_configtext(
//        'qs_gr_search_day_interval_before', 
//        'Період відображення екзаменів - Початкова дата', 
//        'Кількість днів до сьогоднішньої дати.', 
//        30, 
//        PARAM_INT));
//$settings->add(new admin_setting_configtext(
//        'qs_gr_search_day_interval_after', 
//        'Період відображення екзаменів - Кінцева дата', 
//        'Кількість днів після сьогоднішньої дати.', 
//        30, 
//        PARAM_INT));
//
//
///** Внесення результату Екзамену */
//$settings->add(new admin_setting_heading('qs_quiz', 'Внесення даних', 'Налаштування, які відносяться до інтерфейсу та алгоритмів внесення результатів та плану'));
//$settings->add(new admin_setting_configtext('qs_adddata_words_for_identiting_quiz_objects', 
//        'Ідентифікуючі слова', 
//        'Визначення обєкту Екзамен (quiz) серед набору всіх курсів. Текст для пошуку в полі <code>fullname</code> обєкту <code>course</code>.', 
//        '\'кзамен\'', PARAM_TEXT));
//$settings->add(new admin_setting_configtext('qs_adddata_hours_between_moodle_and_oralquiz', 
//        'Інтервал між спробою в Moodle і усним Екзаменом', 
//        'Максимально допустима кількість годин між закінченням тесту в Moodle та початком усного Екзамену.', 
//        24, 
//        PARAM_INT));



/** Звіти */
$settings->add(new admin_setting_heading('qs_reports', 'Звіти', 'Налаштування для звітів'));
// Протокол Стандартний
$settings->add(new admin_setting_heading('qs_report_standard', 'Протокол \'Стандартний\'', ''));
$settings->add(new admin_setting_configtextarea('qs_report_standard_themelist', 'Теми перевірки', 'Список тем, які виводяться у протоколі', '', PARAM_TEXT, 40, 20));


/** Синхронізація */
$settings->add(new admin_setting_heading('qs_synchronization', 'Синхронізація', 'Налаштування для синхронізації сховища Moodle з іншими джерелами'));
// Active Directory
$settings->add(new admin_setting_heading('qs_synchronization_ad', 'Active Directory', 'Налаштування для синхронізації з Active Directory компанії'));
// Mapping
$settings->add(new admin_setting_heading('qs_synchronization_ad_mapping', 'Зв\'язування', 'Налаштування звязків між стовпцями таблиці mdl_user та Active Directory. Початково встановлюється в Керування сайтом > Модулі > Аутентифікація > Сервер LDAP, розділ \'Відображення даних\''));
$settings->add(new admin_setting_configtext('qs_synchronization_ad_mapping_number', 'Ідентифікатор співробітника', 'Назва стовпчику в mdl_user в якому буде збережене значення ідентифікатору співробітника з Active Directory.', 'username', PARAM_TEXT ) );
$settings->add(new admin_setting_configtext('qs_synchronization_ad_mapping_position', 'Посада', 'Назва стовпчику в mdl_user в якому буде збережене значення посади співробітника з Active Directory.', 'address', PARAM_TEXT ) );
$settings->add(new admin_setting_configtext('qs_synchronization_ad_mapping_affiliate', 'Філія', 'Назва стовпчику в mdl_user в якому буде збережене значення філії співробітника з Active Directory.', 'institution', PARAM_TEXT ) );
$settings->add(new admin_setting_configtext('qs_synchronization_ad_mapping_department', 'Відділ', 'Назва стовпчику в mdl_user в якому буде збережене значення відділу співробітника з Active Directory.', 'department', PARAM_TEXT ) );
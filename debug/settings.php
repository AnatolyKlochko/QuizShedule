<?php

// get_string('replytouser', 'forum')
/** Пошук */
$settings->add( new admin_setting_heading( 'qs_search', 'Пошук', 'Налаштування пошуку' ) );
$settings->add( new admin_setting_configtext( 'qs_search_date_interval_before', 'Місяців', 'Кількість місяців до сьогоднішньої дати.', 1, PARAM_INT ) );
$settings->add( new admin_setting_configtext( 'qs_search_date_interval_after', 'Місяців', 'Кількість місяців після сьогоднішньої дати.', 18, PARAM_INT ) );
//+
$settings->add( new admin_setting_heading( 'qs_quiz', 'Екзамен', 'Налаштування для визначення обєкту Екзамен (quiz) серед набору всіх курсів' ) );
$settings->add( new admin_setting_configtext( 'qs_quiz_search_text', 'Текст', 'Текст для пошуку в полі <code>fullname</code> обєкту <code>course</code>.', '\'кзамен\'', PARAM_TEXT) );
// $name, $visiblename, $description, $defaultsetting, $paramtype=PARAM_RAW, $size=null

/** Загалний Графік */
$settings->add( new admin_setting_heading( 'qs_gr_search', 'Пошук', 'Загальний Графік' ) );
$settings->add( new admin_setting_configtext( 'qs_gr_search_date_interval_before', 'Днів', 'Кількість днів до сьогоднішньої дати.', 30, PARAM_INT ) );
$settings->add( new admin_setting_configtext( 'qs_gr_search_date_interval_after', 'Днів', 'Кількість днів після сьогоднішньої дати.', 30, PARAM_INT ) );

/** Звіти */
$settings->add( new admin_setting_heading( 'qs_reports', 'Звіти', 'Налаштування для Звітів' ) );
$settings->add( new admin_setting_configtextarea( 'qs_reports_themelist', 'Тема перевірки', 'Список тем для протоколу \'Стандартний\'', '', PARAM_TEXT, 40, 20) );

/** + Внесення результату Екзамену */
$settings->add( new admin_setting_heading( 'qs_add_result', 'Внесення результатів Екзаменів', 'Налаштування для алгоритму внесення результатів Екзаменів' ) );
$settings->add( new admin_setting_configtext( 'qs_add_result_hour_interval_between_moodle_attempt_and_quiz', 'Годин', 'Максимально допустима кількість годин між закінченням тесту в Moodle та початком усного Екзамену.', 24, PARAM_INT ) );

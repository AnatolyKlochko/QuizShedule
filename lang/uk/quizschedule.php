<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings for component 'quiz_overview', language 'en', branch 'MOODLE_20_STABLE'
 *
 * @package   quiz_overview
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
$string['pluginname'] = 'Графік екзаменів';

// Admin Menu Tree, Folders (Admin Categories)
$string['synchronizationplugins'] = 'Синхронізація';
$string['reportplugins'] = 'Звіти';
$string['maincommissionplugins'] = 'Головна Комісія';
$string['coursetrainingplugins'] = 'Курсове Навчання';

$string['managemaincommissionplugins'] = 'Керування модулями';
$string['managecoursetrainingplugins'] = 'Керування модулями';

// Admin settings page, module settings
$string['settings'] = 'Параметри модуля';
// Admin settings 
$string['indexpagesettings'] = 'Індексна сторінка';
$string['indexpagesettings_help'] = 'Налаштування для Індексної сторінки Модуля /mod/quizschedule або /mod/quizschedule/index.php';
$string['indexpagescheduletabledaysbefore'] = 'Початок періоду';
$string['indexpagescheduletabledaysbefore_help'] = 'Кількість днів перед сьогоднішньою датою, як початкова дата вибірки запланованих Екзаменів співробітника';
$string['indexpagescheduletabledaysafter'] = 'Кінець періоду';
$string['indexpagescheduletabledaysafter_help'] = 'Кількість днів після сьогоднішньої дати, як кінцева дата вибірки запланованих Екзаменів співробітника';
// General Schedule
$string['generalschedulesettings'] = 'Загальний Графік';
$string['generalschedulesettings_help'] = 'Налаштування для Загального Графіку';
$string['generalscheduletabledaysbefore'] = 'Початок періоду';
$string['generalscheduletabledaysbefore_help'] = 'Кількість днів перед сьогоднішньою датою, як початкова дата вибірки запланованих Екзаменів співробітників';
$string['generalscheduletabledaysafter'] = 'Кінець періоду';
$string['generalscheduletabledaysafter_help'] = 'Кількість днів після сьогоднішньої дати, як кінцева дата вибірки запланованих Екзаменів співробітників';
// Adding Data
$string['addingdatasettings'] = 'Внесення Даних';
$string['addingdatasettings_help'] = 'Налаштування для Внесення Даних, які включають внесення Результатів і Планових Даних відповідно.';
$string['addingdatahoursafteroralquiz'] = 'Період внесення';
$string['addingdatahoursafteroralquiz_help'] = 'Кількість годин після Усного Екзамену впродовж яких ще можна занести Результат Екзамену до Бази Даних';
// Quiz List
$string['quizlistsettings'] = 'Список Екзаменів';
$string['quizlistsettings_help'] = 'Налаштування для Списку Екзаменів';
$string['quizlistidentifyingwords'] = 'Ідентифікація Екзамену';
$string['quizlistidentifyingwords_help'] = 'Список слів (або частин слів) для ідентифікації Екзаменів (серед інших типів перевірок знань таких як Тренування, або подібні)';
$string['quizlistidentifyingantiwords'] = 'Ідентифікація Екзамену, антислова';
$string['quizlistidentifyingantiwords_help'] = 'Список слів (або частин слів), які ідентифікують НЕ Екзамени (і таким чином обмежують непідходящі обєкти)';
$string['quizlistallowedcategories'] = 'Дозволені категорії';
$string['quizlistallowedcategories_help'] = 'Список дозволених для показу категорій Екзаменів у Списках Екзаменів у межах модуля';

// Sub Plugins
$string['subplugintype_quizschedule'] = 'Плагін';
$string['subplugintype_quizschedule_plural'] = 'Плагіни';
$string['subplugintype_quizschedulesynchronization'] = 'Синхронізація > Плагін';
$string['subplugintype_quizschedulesynchronization_plural'] = 'Синхронізація > Плагіни';
$string['subplugintype_quizschedulemaincommission'] = 'Головна Комісія > Протокол';
$string['subplugintype_quizschedulemaincommission_plural'] = 'Головна Комісія > Протоколи';
$string['subplugintype_quizschedulecoursetraining'] = 'Курсове Навчання > Протокол';
$string['subplugintype_quizschedulecoursetraining_plural'] = 'Курсове Навчання > Протоколи';


$string['quiz_mark_on'] = 'Здав';
$string['quiz_mark_off'] = 'Не&nbspздав';
$string['quiz_nextdate'] = 'Дата наступного екзамену';
$string['quiz_editlink'] = 'Редагувати';
$string['quiz_nav_quizresults'] = 'Занести результати екзамену';
$string['quiz_nav_quizedit'] = 'Редагувати результати екзамену';
$string['quiz_nav_quizsearch'] = 'Пошук';

$string['quiz_search_datefrom'] = 'Дата від';
$string['quiz_search_dateto'] = 'Дата по';
$string['quiz_search_button'] = 'Шукати';

$string['quiz_name'] = 'Назва екзамену';
$string['quiz_date'] = 'Дата екзамену';

$string['quiz_saveresults'] = 'Занести до Бази Даних';

// Add View
$string['add_title'] = 'Результати екзамену';
$string['add_heading'] = 'Внесення результатів екзамену';

$string['add_affiliatelist_heading'] = 'Філія';
$string['add_affiliatelist_find'] = 'Пошук';

$string['add_exam_heading'] = 'Екзамен';

$string['add_quizlist_title'] = 'Назва екзамену';

$string['add_commissiontype_title'] = 'Тип комісії';
//-
$string['add_commissiontype_val_general_commission'] = 'Головна Комісія';
$string['add_commissiontype_val_production_structural_subdivisions_commission'] = 'Комісія виробничого структурного підрозділу';
$string['add_commissiontype_val_affiliate_commission'] = 'Комісія філії';

$string['add_quizdate_title'] = 'Дата екзамену';

$string['add_results_heading'] = 'Результати';

$string['add_quiz_result'] = 'Результат';

$string['edit_employee_title'] = 'Редагування даних';



// Add Plan View
$string['add_plan_title'] = 'Внесення плану';
$string['add_plan_heading'] = 'Введення планових даних';
$string['add_plan_data_heading'] = 'План';



// Edit Plan View
$string['edit_plan_title'] = 'Редагування плану';
$string['edit_plan_find'] = 'Пошук';
$string['edit_results_heading'] = 'Співробітники';



// Link Quiz to GRColumn View
$string['linkquiztogrcolumn_title'] = 'Зв\'язки між Екзаменами і стовпцями Загального Звіту';
$string['linkquiztogrcolumn_heading'] = 'Зв\'язки між Екзаменами і стовпцями Загального Звіту';

$string['linkquiztogrcolumn_searchtitle'] = 'Умови Пошуку';
$string['linkquiztogrcolumn_quizname'] = 'Частина назви Екзамену, н-д, ОП';
$string['linkquiztogrcolumn_search'] = 'Пошук';

$string['linkquiztogrcolumn_quizlisttitle'] = 'Екзамени';

$string['linkquiztogrcolumn_grcolumntitle'] = 'Стовпець Загального Звіту';

$string['linkquiztogrcolumn_searchempty'] = 'Нічого не знайдено';
$string['linkquiztogrcolumn_link'] = 'Прив\'язати Екзамени до Стовпця';




// General Report
$string['report_title'] = 'Загальний графік';
// Header columns
$string['report_hcol_numbering'] = '№ п/п';
$string['report_hcol_affiliate'] = 'Філія';
$string['report_hcol_department'] = 'Підрозділ';
$string['report_hcol_employee_number'] = 'Таб. Номер';
$string['report_hcol_fullname'] = 'ПІБ';
$string['report_hcol_position'] = 'Посада';
$string['report_hcol_group_of_electrical_safety'] = 'Група з ЕБ';
// quiz columns
$string['report_hcol_occupational_health'] = 'Перевірка знань з охорони праці (правила безпеки, Інструкції з ОП і техніки безпеки)';
$string['report_hcol_short_occupational_health'] = 'ОП';
//-
$string['report_hcol_technology_works'] = 'Перевірка знань з технології робіт (правила експлуатації, виробничі інструкції)';
$string['report_hcol_short_technology_works'] = 'ТР';
//-
$string['report_hcol_fire_safety_rules'] = 'Перевірка знань правил пожежної безпеки';
$string['report_hcol_short_fire_safety_rules'] = 'ППБ';
//-
$string['report_hcol_safe_operation_of_lifts'] = 'Безпечне проведення робіт підйомниками';
$string['report_hcol_short_safe_operation_of_lifts'] = 'БПРП';
//-
$string['report_hcol_safe_operation_of_cranes'] = 'Безпечне проведення робіт кранами';
$string['report_hcol_short_safe_operation_of_cranes'] = 'БПРК';
//-
$string['report_hcol_pressure_vessels'] = 'Посудини під тиском';
$string['report_hcol_short_pressure_vessels'] = 'ППТ';
//-
$string['report_hcol_physical_examination'] = 'Проходження медичного огляду';
$string['report_hcol_short_physical_examination'] = 'МО';
$string['report_hcol_subcol_C_physical_examination'] = 'дата наступного огляду';
// quiz columns.
$string['report_hcol_commission_type'] = 'Вид комісії';
$string['report_hcol_notes'] = 'Примітки';
$string['report_hcol_subcol_A'] = 'план';
$string['report_hcol_subcol_B'] = 'факт';
$string['report_hcol_subcol_C'] = 'дата наступної перевірки';

$string['report_daysword'] = 'день(ів)';
$string['report_daysbeforeword'] = 'день(ів)';
$string['report_todayquizword'] = 'Сьогодні екзамен';
$string['report_quizword'] = 'Екзамен';


// Redundant Data View
$string['redundant_data_title'] = 'Збиткові Дані';
$string['redundant_data_heading'] = 'Перевірка на збиткові дані';
$string['redundant_data_delete_result'] = 'записів видалено';
$string['redundant_data_delete_btn_title'] = 'Видалити Збиткові Дані';

// Synchronization
$string['synchronize_employees'] = 'Синхронізація працівників модуля "Графік екзаменів"';
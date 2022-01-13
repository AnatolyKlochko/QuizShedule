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
 
$string['pluginname'] = 'Протокол "Груповий"';

// Page settings, mod\quizschedule\report\maincommission\group\classes\output\renderer.php
$string['pageindextitle'] = 'Протокол "Груповий", Головна Комісія';
$string['pageindexheading'] = 'Протокол "Груповий"';

// view/search.php
$string['searchquizdate'] = 'Пошук';
$string['searchmoodle'] = 'Спроба в Moodle';
$string['searchschedule'] = 'Графік';

// stage 'Filtering'
$string['pagefilteringtitle'] = 'Фільтрація';
$string['pagefilteringheading'] = 'Фільтрація';
// datatable
$string['pagefilteringdtcolnumbering'] = '№';
$string['pagefilteringdtcolemployeeinfo'] = 'Співробітник';
$string['pagefilteringdtcolquizinfo'] = 'Екзамен';
$string['pagefilteringdtcolattemptinfo'] = 'Спроба';
$string['pagefilteringdtcolaction'] = 'Дія';

// view/formatbuttons.php
$string['formatbuttonsbtnprint'] = 'Друкувати';
$string['formatbuttonsbtnpdf'] = 'PDF';
$string['formatbuttonsbtndocx'] = 'MS Word';



// Admin Settings

// Page
$string['pagesettings'] = 'Сторінка';
$string['pagesettings_help'] = 'Налаштування для Сторінки Звіту';
$string['pagemargin'] = 'Поля';
$string['pagemargin_help'] = 'Відступи між краєм паперу та областю друку. Вираз виду "1cm 2cm 3cm 4cm" означає відступ в 1см зверху, в 2см зправа, в 3см знизу, в 4см зліва. Вираз виду "2cm" означає відступ в 2см з усіх боків паперу';
$string['pagewidth'] = 'Ширина';
$string['pagewidth_help'] = 'Ширина області відображення. Використовується лише для секції @screen';

// Header
$string['headersettings'] = 'Шапка';
$string['headersettings_help'] = 'Налаштування для Шапки Звіту';
$string['headermargin'] = 'Поля';
$string['headermargin_help'] = 'Зовнішні відступи Блоку Шапки';
$string['headerfont'] = 'Шрифт';
$string['headerfont_help'] = 'Шрифт Блоку Шапки';

// Data Table
$string['datatablesettings'] = 'Таблиця Даних';
$string['datatablesettings_help'] = 'Налаштування для Таблиці Даних Звіту';
$string['datatableheaderheight'] = 'Висота, Висота Шапки';
$string['datatableheaderheight_help'] = 'Висота Шапки для Таблиці Даних, з одиницями виміру';
$string['datatableheaderfont'] = 'Шрифт, Шапка Таблиці';
$string['datatableheaderfont_help'] = 'Шрифт Шапки Таблиці Даних, повний CSS вираз';
$string['datatablebodyfont'] = 'Шрифт, Тіло Таблиці';
$string['datatablebodyfont_help'] = 'Шрифт для змісту Таблиці Даних, повний CSS вираз';
// Columns
$string['datatablecolumnsettings'] = 'Стовпці Таблиці Даних';
$string['datatablecolumnsettings_help'] = 'Налаштування для Стовпців Таблиці Даних';
// Column 'Numbering'
$string['datatablecolnumbsettings'] = 'Стовпець \'Нумерація\'';
$string['datatablecolnumbsettings_help'] = 'Налаштування для стовпця \'Нумерація\' Таблиці Даних';
$string['datatablecolnumbtitle'] = 'Заголовок';
$string['datatablecolnumbtitle_help'] = 'Заголовок Стовпця у Шапці Таблиці';
$string['datatablecolnumbwidth'] = 'Ширина';
$string['datatablecolnumbwidth_help'] = 'Ширина Стовпця, з одиницями виміру';
$string['datatablecolnumbfont'] = 'Шрифт';
$string['datatablecolnumbfont_help'] = 'Шрифт змісту Стовпця, повний CSS вираз';
// Column 'Employee Info'
$string['datatablecolemplinfosettings'] = 'Стовпець \'Дані Працівника\'';
$string['datatablecolemplinfosettings_help'] = 'Налаштування для стовпця \'Дані Працівника\' Таблиці Даних';
$string['datatablecolemplinfotitle'] = 'Заголовок';
$string['datatablecolemplinfotitle_help'] = 'Заголовок Стовпця у Шапці Таблиці. Для вставлення символу переносу рядка використовуйте \'%BR%\'';
$string['datatablecolemplinfowidth'] = 'Ширина';
$string['datatablecolemplinfowidth_help'] = 'Ширина Стовпця, з одиницями виміру';
$string['datatablecolemplinfofont'] = 'Шрифт';
$string['datatablecolemplinfofont_help'] = 'Шрифт змісту Стовпця, повний CSS вираз';
// Column 'Share Type'
$string['datatablecolshrtypesettings'] = 'Стовпець \'Загальний Тип\'';
$string['datatablecolshrtypesettings_help'] = 'Налаштування для стовпця \'Загальний Тип\' Таблиці Даних';
$string['datatablecolshrtypetitle'] = 'Заголовок';
$string['datatablecolshrtypetitle_help'] = 'Заголовок Стовпця у Шапці Таблиці';
$string['datatablecolshrtypewidth'] = 'Ширина';
$string['datatablecolshrtypewidth_help'] = 'Ширина Стовпця, з одиницями виміру';
$string['datatablecolshrtypefont'] = 'Шрифт';
$string['datatablecolshrtypefont_help'] = 'Шрифт змісту Стовпця, повний CSS вираз';
$string['datatablecolshrtypesubcols'] = 'Підлеглі Стовпці';
$string['datatablecolshrtypesubcols_help'] = 'Підлеглі Стовпці, список виду: \'key\', \'title\'';


// Footer
$string['footersettings'] = 'Підвал';
$string['footersettings_help'] = 'Налаштування для Підвалу Звіту';
$string['footermargin'] = 'Поля';
$string['footermargin_help'] = 'Зовнішні відступи Блоку Підвалу';
$string['footerlinepadding'] = 'Внутрішні відступи Лінії';
$string['footerlinepadding_help'] = 'Внутрішні відступи Блоку Лінії Підвалу';
$string['footercolumntitlewidth'] = 'Стовпець \'Заголовок\', Ширина';
$string['footercolumntitlewidth_help'] = 'Ширина стовпця \'Заголовок\', з одиницями виміру';
$string['footercolumnunderlinewidth'] = 'Стовпець \'Нижня лінія\', Ширина';
$string['footercolumnunderlinewidth_help'] = 'Ширина Стовпця \'Нижня лінія\', з одиницями виміру';
$string['footerfont'] = 'Шрифт';
$string['footerfont_help'] = 'Шрифт Підвалу, повний CSS вираз';


// Data
$string['datasettings'] = 'Дані';
$string['datasettings_help'] = 'Налаштування для Даних Звіту';
$string['datafilterdoublequotes'] = 'Фільтр, \'Подвійні Лапки\'';
$string['datafilterdoublequotes_help'] = 'Будь-яке ключове слово для заміни символа подвійних лапок для можливості запису у HTML властивість';
$string['datafilterbreakline'] = 'Фільтр, \'Розрив рядку\'';
$string['datafilterbreakline_help'] = 'Будь-яке слово для позначення розриву рядку, кожне таке слово в подальшому буде замінене на HTML тег <br />';
$string['datafilteraffiliatenumber'] = 'Фільтр, \'Код Філії\'';
$string['datafilteraffiliatenumber_help'] = 'Список пар виду: affiliatekey, affiliatename для заміни Коду Філії на Назву Філії';

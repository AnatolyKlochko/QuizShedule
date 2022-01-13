<?php
// Access
$name = new lang_string('accesssettings', 'quizschedule_report');
$description = new lang_string('accesssettings_help', 'quizschedule_report');
$settings->add( new admin_setting_heading(
    'accesssettings', 
    $name, 
    $description
));

// Main Commission, Standard Protocol
$name = new lang_string('maincommissionstandardaccess', 'quizschedule_report');
$description = new lang_string('maincommissionstandardaccess_help', 'quizschedule_report');
$setting = new admin_setting_configcheckbox( 'quizschedule_report/maincommissionstandardaccess', $name, $description, 1 );
//$setting->set_advanced_flag_options(admin_setting_flag::ENABLED, false);
//$setting->set_locked_flag_options(admin_setting_flag::ENABLED, false);
$settings->add($setting);
// Main Commission, Group Protocol
$name = new lang_string('maincommissiongroupaccess', 'quizschedule_report');
$description = new lang_string('maincommissiongroupaccess_help', 'quizschedule_report');
$setting = new admin_setting_configcheckbox( 'quizschedule_report/maincommissiongroupaccess', $name, $description, 1 );
$settings->add($setting);
// Course Training, Standard Protocol
$name = new lang_string('coursetrainingstandardaccess', 'quizschedule_report');
$description = new lang_string('coursetrainingstandardaccess_help', 'quizschedule_report');
$setting = new admin_setting_configcheckbox( 'quizschedule_report/coursetrainingstandardaccess', $name, $description, 1 );
$settings->add($setting);

// Data
$name = new lang_string('datasettings', 'quizschedule_report');
$description = new lang_string('datasettings_help', 'quizschedule_report');
$settings->add( new admin_setting_heading(
    'datasettings', 
    $name, 
    $description
));
// Hash, Double Quotes
$visiblename = new lang_string( 'datahashdoublequotes', 'quizschedule_report' );
$description = new lang_string( 'datahashdoublequotes_help', 'quizschedule_report' );
$settings->add( new admin_setting_configtext(
    'quizschedule_report/datahashdoublequotes', // key
    $visiblename,
    $description,
    '%DOUBLEQUOTE%', // default settings
    PARAM_TEXT
    //$size // size
));
// Hash, Break Line
$visiblename = new lang_string( 'datahashbreakline', 'quizschedule_report' );
$description = new lang_string( 'datahashbreakline_help', 'quizschedule_report' );
$settings->add( new admin_setting_configtext(
    'quizschedule_report/datahashbreakline', // key
    $visiblename,
    $description,
    '%BR%', // default settings
    PARAM_TEXT
    //$size // size
));
// List, Affiliate Number
$visiblename = new lang_string( 'datalistaffiliatenumber', 'quizschedule_report' );
$description = new lang_string( 'datalistaffiliatenumber_help', 'quizschedule_report' );
$settings->add( new admin_setting_configtextarea(
    'quizschedule_report/datalistaffiliatenumber', // key
    $visiblename,
    $description,
    '0100, АТ "ПОЛТАВАОБЛЕНЕРГО"
', // default settings
    PARAM_TEXT
    //$size // size
));

// View
$name = new lang_string('viewsettings', 'quizschedule_report');
$description = new lang_string('viewsettings_help', 'quizschedule_report');
$settings->add( new admin_setting_heading(
    'viewsettings', 
    $name, 
    $description
));
// Margin
$visiblename = new lang_string( 'margin', 'quizschedule_report' );
$description = new lang_string( 'margin_help', 'quizschedule_report' );
$settings->add( new admin_setting_configtext(
    'quizschedule_report/margin', // key
    $visiblename,
    $description,
    '1.5cm 1.5cm 1.5cm 1.5cm', // default settings
    PARAM_TEXT
    //$size // size
));
// Font
$visiblename = new lang_string( 'font', 'quizschedule_report' );
$description = new lang_string( 'font_help', 'quizschedule_report' );
$settings->add( new admin_setting_configtext(
    'quizschedule_report/font', // key
    $visiblename,
    $description,
    'normal normal 13pt/14pt "Times New Roman", Times, serif', // default settings
    PARAM_TEXT
    //$size // size
));
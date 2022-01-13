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
 * This file adds the settings pages to the navigation menu
 *
 * @package   mod_assign
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/mod/quizschedule/adminlib.php');

$ADMIN->add(
    'modsettings', 
    new admin_category(
        'modquizschedulefolder', 
        new lang_string('pluginname', 'mod_quizschedule'), 
        $module->is_enabled() === false
    )
);

$settings = new admin_settingpage(
        $section, 
        get_string('settings', 'mod_quizschedule'), 
        'moodle/site:config', 
        $module->is_enabled() === false
);

if ($ADMIN->fulltree) {
    
    // Index Page settings
    $name = new lang_string('indexpagesettings', 'mod_quizschedule');
    $description = new lang_string('indexpagesettings_help', 'mod_quizschedule');
    $settings->add( new admin_setting_heading( 
        'indexpagesettings', 
        $name, 
        $description
    ));
    // Period Start of select of employee's schedules
    $visiblename = new lang_string( 'indexpagescheduletabledaysbefore', 'mod_quizschedule' );
    $description = new lang_string( 'indexpagescheduletabledaysbefore_help', 'mod_quizschedule');
    $settings->add( new admin_setting_configtext(
        'mod_quizschedule/indexpagescheduletabledaysbefore', // name  // old name: qs_indexpage_userschedulestable_months_interval_before
        $visiblename,
        $description,
        35, // default settings
        PARAM_INT
        //$size // size
    ));
    // Period Finish of select of employee's schedules
    $visiblename = new lang_string( 'indexpagescheduletabledaysafter', 'mod_quizschedule' );
    $description = new lang_string('indexpagescheduletabledaysafter_help', 'mod_quizschedule');
    $settings->add( new admin_setting_configtext(
        'mod_quizschedule/indexpagescheduletabledaysafter', // name  // old name: qs_indexpage_userschedulestable_months_interval_after
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
    // Hours between Moodle Attempt and Oral Quiz
    $visiblename = new lang_string( 'addingdatahoursafteroralquiz', 'mod_quizschedule' );
    $description = new lang_string('addingdatahoursafteroralquiz_help', 'mod_quizschedule');
    $settings->add( new admin_setting_configtext(
        'mod_quizschedule/addingdatahoursafteroralquiz', // name  // old name: qs_adddata_hours_between_moodle_and_oralquiz
        $visiblename,
        $description,
        12, // default settings
        PARAM_INT
        //$size // size
    ));
    
    // Quiz List settings
    $name = new lang_string('quizlistsettings', 'mod_quizschedule');
    $description = new lang_string('quizlistsettings_help', 'mod_quizschedule');
    $settings->add( new admin_setting_heading( 
        'quizlistsettings', 
        $name, 
        $description
    ));
    // Identifying words, Quiz List
    $visiblename = new lang_string( 'quizlistidentifyingwords', 'mod_quizschedule' );
    $description = new lang_string('quizlistidentifyingwords_help', 'mod_quizschedule');
    $settings->add( new admin_setting_configtext(
        'mod_quizschedule/quizlistidentifyingwords', // name  // old name: qs_adddata_words_for_identiting_quiz_objects
        $visiblename,
        $description,
        'кзамен спит', // default settings
        PARAM_TEXT
        //$size // size
    ));
    // Identifying antiwords, Quiz List
    $visiblename = new lang_string( 'quizlistidentifyingantiwords', 'mod_quizschedule' );
    $description = new lang_string('quizlistidentifyingantiwords_help', 'mod_quizschedule');
    $settings->add( new admin_setting_configtext(
        'mod_quizschedule/quizlistidentifyingantiwords', // name  // old name: qs_adddata_words_for_identiting_quiz_objects
        $visiblename,
        $description,
        'ренування', // default settings
        PARAM_TEXT
        //$size // size
    ));
    // Allowed Top Categories
    $quizlist_allowedcategories = is_null( $top = ( new mod_quizschedule\model\schedule )->quiz_get_top_categories() ) ? [] : $top;
//    if (is_null( $quizlist_allowedcategories ) ) {
//        $quizlist_allowedcategories = [];
//    }
    $name = new lang_string('quizlistallowedcategories', 'mod_quizschedule');
    $description = new lang_string('quizlistallowedcategories_help', 'mod_quizschedule');
    $settings->add(
        new admin_setting_configmultiselect(
            'mod_quizschedule/quizlistallowedcategories',
            $name,
            $description,
            [],
            $quizlist_allowedcategories
        )
    );
    
//
//    // Here (next 18 lines) the mod "Assign" just gets all subplugins of 
//    // 'assignfeedback'=>'mod/assign/feedback' alias, to display it in combobox 
//    // (and select one of them as default plugin), variabe $menu is that combobox
//    $menu = array();
//    foreach (core_component::get_plugin_list('assignfeedback') as $type => $notused) {
//        $visible = !get_config('assignfeedback_' . $type, 'disabled');
//        if ($visible) {
//            $menu['assignfeedback_' . $type] = new lang_string('pluginname', 'assignfeedback_' . $type);
//        }
//    }
//
//    // The default here is feedback_comments (if it exists).
//    $name = new lang_string('feedbackplugin', 'mod_assign');
//    $description = new lang_string('feedbackpluginforgradebook', 'mod_assign');
//    $settings->add(new admin_setting_configselect('assign/feedback_plugin_for_gradebook',
//                                                  $name,
//                                                  $description,
//                                                  'assignfeedback_comments',
//                                                  $menu));
//
//    $name = new lang_string('showrecentsubmissions', 'mod_assign');
//    $description = new lang_string('configshowrecentsubmissions', 'mod_assign');
//    $settings->add(new admin_setting_configcheckbox('assign/showrecentsubmissions',
//                                                    $name,
//                                                    $description,
//                                                    0));
}

$ADMIN->add('modquizschedulefolder', $settings);
// Tell core we already added the settings structure.
$settings = null;

//$ADMIN->add('modassignfolder', new admin_category('assignsubmissionplugins',
//    new lang_string('submissionplugins', 'assign'), !$module->is_enabled()));
//$ADMIN->add('assignsubmissionplugins', new assign_admin_page_manage_assign_plugins('assignsubmission'));
//$ADMIN->add('modassignfolder', new admin_category('assignfeedbackplugins',
//    new lang_string('feedbackplugins', 'assign'), !$module->is_enabled()));
//$ADMIN->add('assignfeedbackplugins', new assign_admin_page_manage_assign_plugins('assignfeedback'));

// Adding 'Reports' Node
$ADMIN->add(
    'modquizschedulefolder',
    new admin_category(
        'quizschedulereportplugins',
        new lang_string('reportplugins', 'quizschedule'),
        !$module->is_enabled()
    )
);
// Settings Page for 'Reports' Node
$settings = new \admin_settingpage( // $syncsettings is wrong name, because inside /mod/quizschedule/synchronization/settings.php is used $settings variable
    'modsettingreport', 
    get_string('settings', 'mod_quizschedule'), 
    'moodle/site:config', 
    $this->is_enabled() === false
);
if ($ADMIN->fulltree) {
    include( $CFG->dirroot . '/mod/quizschedule/report/settings.php' );
}
$ADMIN->add('quizschedulereportplugins', $settings);
// Tell core we already added the settings structure.
$settings = null; // it removes node 'Параметри модуля' (which was appeared after include) from 'Модулі діяльності' node

// Report submodules:

// Adding 'Main Commission' Node to 'Reports' Node
$ADMIN->add(
    'quizschedulereportplugins',
    new admin_category(
        'quizschedulemaincommissionplugins',
        new lang_string('maincommissionplugins', 'quizschedule'),
        !$module->is_enabled()
    )
);
$ADMIN->add('quizschedulemaincommissionplugins', new quizschedule_admin_page_manage_quizschedule_plugins( 'maincommission' ));
//TODO: add sorting in admin tree(at node 'Manage Plugins' plugins can be visually sorted and it is saved to db... #1.implement it managing, #2.use it value)
foreach (core_plugin_manager::instance()->get_plugins_of_type('quizschedulemaincommission') as $plugin) {
    /** @var \mod_assign\plugininfo\assignfeedback $plugin */
    $plugin->load_settings(
        $ADMIN, 
        'quizschedulemaincommissionplugins', // the menu key defined above at "// Adding 'Main Commission' Node to 'Reports' Node"
                                             // Note, if this key length is bigger than ? 38 symbols, then Tree Node is not adding to Menu Tree, 
                                             // therefore subword 'report' has been removed from key: 
                                             // 'quizschedulereportmaincommissionplugins' -> 'quizschedulemaincommissionplugins'
        $hassiteconfig
    );
}

// Adding 'Course Training' Node to 'Reports' Node
$ADMIN->add(
    'quizschedulereportplugins',
    new admin_category(
        'quizschedulecoursetrainingplugins',
        new lang_string('coursetrainingplugins', 'quizschedule'),
        !$module->is_enabled()
    )
);
$ADMIN->add('quizschedulecoursetrainingplugins', new quizschedule_admin_page_manage_quizschedule_plugins( 'coursetraining' ));
foreach (core_plugin_manager::instance()->get_plugins_of_type('quizschedulecoursetraining') as $plugin) {
    /** @var \mod_assign\plugininfo\assignfeedback $plugin */
    $plugin->load_settings(
        $ADMIN, 
        'quizschedulecoursetrainingplugins',
        $hassiteconfig
    );
}



// Adding 'Synchronization' Node
$ADMIN->add(
    'modquizschedulefolder',
    new admin_category(
        'quizschedulesynchronizationplugins',
        new lang_string('synchronizationplugins', 'quizschedule'),
        !$module->is_enabled()
    )
);
// Settings Page for 'Synchronization' Node
$settings = new \admin_settingpage( // $syncsettings is wrong name, because inside /mod/quizschedule/synchronization/settings.php is used $settings variable
    'modsettingsynchronization', 
    get_string('settings', 'mod_quizschedule'), 
    'moodle/site:config', 
    $this->is_enabled() === false
);
if ($ADMIN->fulltree) {
    include( $CFG->dirroot . '/mod/quizschedule/synchronization/settings.php' );
}
$ADMIN->add('quizschedulesynchronizationplugins', $settings);
// Tell core we already added the settings structure.
$settings = null; // it removes node 'Параметри модуля' (which was appeared after include) from 'Модулі діяльності' node

// Synchronization submodules
foreach (core_plugin_manager::instance()->get_plugins_of_type('quizschedulesynchronization') as $plugin) {
    /** @var \mod_quizschedule\plugininfo\assignsubmission $plugin */
    $plugin->load_settings($ADMIN, 'quizschedulesynchronizationplugins', $hassiteconfig);
}


// NOTE, the following code is unnecessary (does nothing), because new menu tree node is added by node itself:
//foreach (core_plugin_manager::instance()->get_plugins_of_type('quizschedule') as $plugin) {
//    /** @var \mod_quizschedule\plugininfo\assignsubmission $plugin */
//    $plugin->load_settings($ADMIN, 'modquizschedulefolder', $hassiteconfig); // DEBUG: THIS LINE ENFORCE SUBFOLDER BUILDING
//}
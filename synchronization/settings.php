<?php
// Active Directory
$name = new lang_string('activedirectorysettings', 'quizschedule_synchronization');
$description = new lang_string('activedirectorysettings_help', 'quizschedule_synchronization');
$settings->add( new admin_setting_heading(
    'syncactivedirectory', 
    $name, 
    $description
));


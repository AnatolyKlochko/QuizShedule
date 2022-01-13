<?php

// Report

// Report Page settings
$name = new lang_string( 'pagesettings', 'quizschedulemaincommission_group' );
$description = new lang_string( 'pagesettings_help', 'quizschedulemaincommission_group' );
$settings->add(
    new admin_setting_heading(
        'pagesettings', 
        $name, 
        $description
    )
);
// Page: margin
$visiblename = new lang_string( 'pagemargin', 'quizschedulemaincommission_group' );
$description = new lang_string( 'pagemargin_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/pagemargin', // key
    $visiblename,
    $description,
    '1.5cm', // default settings
    PARAM_TEXT
    //$size // size
));
// Page: width
$visiblename = new lang_string( 'pagewidth', 'quizschedulemaincommission_group' );
$description = new lang_string( 'pagewidth_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/pagewidth', // key
    $visiblename,
    $description,
    '992px', // default settings
    PARAM_TEXT
    //$size // size
));

// Report Header settings
$name = new lang_string( 'headersettings', 'quizschedulemaincommission_group' );
$description = new lang_string( 'headersettings_help', 'quizschedulemaincommission_group' );
$settings->add(
    new admin_setting_heading(
        'headersettings', 
        $name, 
        $description
    )
);
// Margin
$visiblename = new lang_string( 'headermargin', 'quizschedulemaincommission_group' );
$description = new lang_string( 'headermargin_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/headermargin', // key
    $visiblename,
    $description,
    '20px 0', // default settings
    PARAM_TEXT
    //$size // size
));
// Font
$visiblename = new lang_string( 'headerfont', 'quizschedulemaincommission_group' );
$description = new lang_string( 'headerfont_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/headerfont', // key
    $visiblename,
    $description,
    'normal normal 13pt/14pt "Times New Roman", Times, serif', // default settings
    PARAM_TEXT
    //$size // size
));


// Data Table

// Data Table Settings
$name = new lang_string( 'datatablesettings', 'quizschedulemaincommission_group' );
$description = new lang_string( 'datatablesettings_help', 'quizschedulemaincommission_group' );
$settings->add(
    new admin_setting_heading(
        'datatablesettings', 
        $name, 
        $description
    )
);

// Header, Height
$visiblename = new lang_string( 'datatableheaderheight', 'quizschedulemaincommission_group' );
$description = new lang_string( 'datatableheaderheight_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/datatableheaderheight', // name
    $visiblename,
    $description,
    '50px', // default settings
    PARAM_TEXT
    //$size // size
));

// Header, Font
$visiblename = new lang_string( 'datatableheaderfont', 'quizschedulemaincommission_group' );
$description = new lang_string( 'datatableheaderfont_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/datatableheaderfont', // key
    $visiblename,
    $description,
    'bold normal 13pt/14pt "Times New Roman", Times, serif', // default settings
    PARAM_TEXT
    //$size // size
));

// Body, Font
$visiblename = new lang_string( 'datatablebodyfont', 'quizschedulemaincommission_group' );
$description = new lang_string( 'datatablebodyfont_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/datatablebodyfont', // key
    $visiblename,
    $description,
    'normal normal 13pt/14pt "Times New Roman", Times, serif', // default settings
    PARAM_TEXT
    //$size // size
));

// Data Table Columns
//$name = new lang_string( 'datatablecolumnsettings', 'quizschedulemaincommission_group' );
//$description = new lang_string( 'datatablecolumnsettings_help', 'quizschedulemaincommission_group' );
//$settings->add(
//    new admin_setting_heading(
//        'datatablecolumnsettings', 
//        $name, 
//        $description
//    )
//);

// Column 'Numbering'

// Column 'Numbering' Heading, no setting
$name = new lang_string( 'datatablecolnumbsettings', 'quizschedulemaincommission_group');
$description = new lang_string( 'datatablecolnumbsettings_help', 'quizschedulemaincommission_group');
$settings->add(
    new admin_setting_heading(
        'datatablecolnumbsettings', 
        $name, 
        $description
    )
);
// Column 'Numbering': Title
$visiblename = new lang_string( 'datatablecolnumbtitle', 'quizschedulemaincommission_group' );
$description = new lang_string( 'datatablecolnumbtitle_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/datatablecolnumbtitle', // key
    $visiblename,
    $description,
    '№', // default settings
    PARAM_TEXT
    //$size // size
));
// Column 'Numbering': Width
$visiblename = new lang_string( 'datatablecolnumbwidth', 'quizschedulemaincommission_group' );
$description = new lang_string( 'datatablecolnumbwidth_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/datatablecolnumbwidth', // key
    $visiblename,
    $description,
    '40px', // default settings
    PARAM_TEXT
    //$size // size
));
// Column 'Numbering': Font
$visiblename = new lang_string( 'datatablecolnumbfont', 'quizschedulemaincommission_group' );
$description = new lang_string( 'datatablecolnumbfont_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/datatablecolnumbfont', // key
    $visiblename,
    $description,
    'normal normal 13pt/14pt "Times New Roman", Times, serif', // default settings
    PARAM_TEXT
    //$size // size
));

// Column 'Employee Info'

// Column 'Employee Info' Heading, no setting
$name = new lang_string( 'datatablecolemplinfosettings', 'quizschedulemaincommission_group');
$description = new lang_string( 'datatablecolemplinfosettings_help', 'quizschedulemaincommission_group');
$settings->add(
    new admin_setting_heading(
        'datatablecolemplinfosettings', 
        $name, 
        $description
    )
);
// Column 'Employee Info': Title
$visiblename = new lang_string( 'datatablecolemplinfotitle', 'quizschedulemaincommission_group' );
$description = new lang_string( 'datatablecolemplinfotitle_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/datatablecolemplinfotitle', // key
    $visiblename,
    $description,
    'Прізвище, ім\'я, по-батькові,<br />посада, підрозділ', // default settings
    PARAM_TEXT
    //$size // size
));
// Column 'Employee Info': Width
$visiblename = new lang_string( 'datatablecolemplinfowidth', 'quizschedulemaincommission_group' );
$description = new lang_string( 'datatablecolemplinfowidth_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/datatablecolemplinfowidth', // key
    $visiblename,
    $description,
    '400px', // default settings
    PARAM_TEXT
    //$size // size
));
// Column 'Employee Info': Font
$visiblename = new lang_string( 'datatablecolemplinfofont', 'quizschedulemaincommission_group' );
$description = new lang_string( 'datatablecolemplinfofont_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/datatablecolemplinfofont', // key
    $visiblename,
    $description,
    'normal normal 13pt/14pt "Times New Roman", Times, serif', // default settings
    PARAM_TEXT
    //$size // size
));

// Column 'Share Type'

// Column 'Share Type' Heading, no setting
$name = new lang_string( 'datatablecolshrtypesettings', 'quizschedulemaincommission_group');
$description = new lang_string( 'datatablecolshrtypesettings_help', 'quizschedulemaincommission_group');
$settings->add(
    new admin_setting_heading(
        'datatablecolshrtypesettings', 
        $name, 
        $description
    )
);
// Column 'Share Type': Title
$visiblename = new lang_string( 'datatablecolshrtypetitle', 'quizschedulemaincommission_group' );
$description = new lang_string( 'datatablecolshrtypetitle_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/datatablecolshrtypetitle', // key
    $visiblename,
    $description,
    'Рішення комісії та дата наступної перевірки знань', // default settings
    PARAM_TEXT
    //$size // size
));
// Column 'Share Type': Width
$visiblename = new lang_string( 'datatablecolshrtypewidth', 'quizschedulemaincommission_group' );
$description = new lang_string( 'datatablecolshrtypewidth_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/datatablecolshrtypewidth', // key
    $visiblename,
    $description,
    '600px', // default settings
    PARAM_TEXT
    //$size // size
));
// Column 'Share Type': Font
$visiblename = new lang_string( 'datatablecolshrtypefont', 'quizschedulemaincommission_group' );
$description = new lang_string( 'datatablecolshrtypefont_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/datatablecolshrtypefont', // key
    $visiblename,
    $description,
    'normal normal 13pt/14pt "Times New Roman", Times, serif', // default settings
    PARAM_TEXT
    //$size // size
));
// Column 'Share Type', subcolumns
$visiblename = new lang_string( 'datatablecolshrtypesubcols', 'quizschedulemaincommission_group' );
$description = new lang_string( 'datatablecolshrtypesubcols_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtextarea(
    'quizschedulemaincommission_group/datatablecolshrtypesubcols', // key
    $visiblename,
    $description,
    'occupational_health, ОП
technology_works, ТР
fire_safety_rules, ППБ
special_types_of_work, Спец.роботи', // default settings
    PARAM_TEXT
    //$size // size
));


// Body
//$name = new lang_string( 'tablebodysettings', 'quizschedulemaincommission_group');
//$description = new lang_string( 'tablebodysettings_help', 'quizschedulemaincommission_group');
//$settings->add(
//    new admin_setting_heading(
//        'tablebodysettings', 
//        $name, 
//        $description
//    )
//);





// Report Footer
$name = new lang_string( 'footersettings', 'quizschedulemaincommission_group');
$description = new lang_string( 'footersettings_help', 'quizschedulemaincommission_group');
$settings->add(
    new admin_setting_heading(
        'footersettings', 
        $name, 
        $description
    )
);
// Footer: margin
$visiblename = new lang_string( 'footermargin', 'quizschedulemaincommission_group' );
$description = new lang_string( 'footermargin_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/footermargin', // key
    $visiblename,
    $description,
    '20px 0', // default settings
    PARAM_TEXT
    //$size // size
));
// Line: padding
$visiblename = new lang_string( 'footerlinepadding', 'quizschedulemaincommission_group' ); // внутрішній відступ лінії
$description = new lang_string( 'footerlinepadding_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/footerlinepadding', // key
    $visiblename,
    $description,
    '20px 0 0 0', // default settings
    PARAM_TEXT
    //$size // size
));
// Line: Title Column: width
$visiblename = new lang_string( 'footercolumntitlewidth', 'quizschedulemaincommission_group' );
$description = new lang_string( 'footercolumntitlewidth_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/footercolumntitlewidth', // key
    $visiblename,
    $description,
    '150px', // default settings
    PARAM_TEXT
    //$size // size
));
// Line: Underline Columns: widht
$visiblename = new lang_string( 'footercolumnunderlinewidth', 'quizschedulemaincommission_group' );
$description = new lang_string( 'footercolumnunderlinewidth_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/footercolumnunderlinewidth', // key
    $visiblename,
    $description,
    '300px', // default settings
    PARAM_TEXT
    //$size // size
));
// Font
$visiblename = new lang_string( 'footerfont', 'quizschedulemaincommission_group' );
$description = new lang_string( 'footerfont_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/footerfont', // key
    $visiblename,
    $description,
    'normal normal 13pt/14pt "Times New Roman", Times, serif', // default settings
    PARAM_TEXT
    //$size // size
));





// Data settings
$name = new lang_string( 'datasettings', 'quizschedulemaincommission_group'); // налаштування даних звіту
$description = new lang_string( 'datasettings_help', 'quizschedulemaincommission_group'); // включають налаштування фільтрації
$settings->add(
    new admin_setting_heading(
        'datasettings', 
        $name, 
        $description
    )
);
// Filter, Double Quotes
$visiblename = new lang_string( 'datafilterdoublequotes', 'quizschedulemaincommission_group' );
$description = new lang_string( 'datafilterdoublequotes_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/datafilterdoublequotes', // key
    $visiblename,
    $description,
    '%DOUBLEQUOTE%', // default settings
    PARAM_TEXT
    //$size // size
));
// Filter, Break Line
$visiblename = new lang_string( 'datafilterbreakline', 'quizschedulemaincommission_group' );
$description = new lang_string( 'datafilterbreakline_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtext(
    'quizschedulemaincommission_group/datafilterbreakline', // key
    $visiblename,
    $description,
    '%BR%', // default settings
    PARAM_TEXT
    //$size // size
));
// Filter, Affiliate Number
$visiblename = new lang_string( 'datafilteraffiliatenumber', 'quizschedulemaincommission_group' );
$description = new lang_string( 'datafilteraffiliatenumber_help', 'quizschedulemaincommission_group' );
$settings->add( new admin_setting_configtextarea(
    'quizschedulemaincommission_group/datafilteraffiliatenumber', // key
    $visiblename,
    $description,
    '0100, АТ "ПОЛТАВАОБЛЕНЕРГО"
', // default settings
    PARAM_TEXT
    //$size // size
));
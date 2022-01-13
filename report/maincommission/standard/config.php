<?php  // QRS - Quiz Report Student configuration file

unset($QRS_CFG);
global $QRS_CFG;
$QRS_CFG = new stdClass();

$QRS_CFG->dataurl = '/moodle'; // original
//$QRS_CFG->dataurl = ''; // local

$QRS_CFG->reporttype = [
    [
        'name' => 'result',
        'report_url' => $QRS_CFG->dataurl . '/mod/quiz/report/student/report/result/report.php'
    ],
    [
        'name' => 'topiclist',
        'report_url' => $QRS_CFG->dataurl . '/mod/quiz/report/student/report/topiclist/report.php'
    ],
    [
        'name' => 'commission',
        'report_url' => $QRS_CFG->dataurl . '/mod/quiz/report/student/report/commission/report.php'
    ]
];


$QRS_CFG->reporttype_defaulturl = $QRS_CFG->dataurl . '/mod/quiz/report/student/report/result/report.php';


$QRS_CFG->reportformat = [
    'html',
    'pdf',
    'docx'
];
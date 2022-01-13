<?php
$tasks = [
    [
        'classname' => 'quizschedulesynchronization_activedirectory\task\sync_employees',
        'blocking' => 0, // if this is set to 1, no other scheduled task will run at the same time as this task. Do not set this to 1 unless you really need it as it will impact the performance of the task queue.
        'minute' => '0',
        'hour' => '0',
        'day' => '*',
        'month' => '*',
        'dayofweek' => '*',
    ],
];
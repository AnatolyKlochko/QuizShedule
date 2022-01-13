<?php

defined('MOODLE_INTERNAL') || die();

$r = $params[0]; // array

$totalcount = $params[1];

?>
<div id="cntr-delete-result" class="">
    <span id="delete-result">
        <span class="rowscount text-danger"><?php echo $r ?></span>
        <span class="message"><?php echo ' ' . get_string( 'redundant_data_delete_result', 'quizschedule' ) ?></span> / 
        з <span class="totalcount text-danger"><?php echo $totalcount ?></span> записів
    </span>
</div>
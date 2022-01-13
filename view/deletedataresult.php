<?php

defined('MOODLE_INTERNAL') || die();

$r = $params[0]; // array

?>
<div class="text-success">Запис <?php echo $r['status'] ? 'видалено' : 'не видалено' ?>.</div>

<div class="mt-5 mb-5 text-center">
    <a href="<?php echo new \moodle_url('/mod/quizschedule/edit.php', []) ?>" class="btn btn-success">Редагувати Дані</a>
</div>

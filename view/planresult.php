<?php defined('MOODLE_INTERNAL') || die(); ?>
<?php 
$r = $params[0]; // array
?>
<div class="bold"><?php echo get_string( 'add_quiz_result', 'quizschedule' ) ?></div>
<div class="addresult">
    <table class="table">
        <tbody>
            <tr>
                <td>Екзамен</td>
                <td><?php echo $r['quiz'] ?></td>
            </tr>
            <tr>
                <td>Відповідальна особа</td>
                <td><?php echo $r['manager'] ?></td>
            </tr>
            <tr>
                <td>Доданих планових записів (загально)</td>
                <td><?php echo $r['total'] ?></td>
            </tr>
            <tr>
                <td>Статус операції</td>
                <td><?php echo $r['status'] ?></td>
            </tr>
            <tr>
                <td>Повідомлення операції</td>
                <td><?php echo $r['message'] ?></td>
            </tr>
            <tr>
                <td>Тип повідомлення операції</td>
                <td><?php echo $r['messagetype'] ?></td>
            </tr>
        </tbody>
    </table>
<?php if ( $r['total'] > 0 ) : ?>
    <div class="bold">Студенти</div>
    <table class="table">
        <tbody><?php
            foreach ($r['students'] as $student) { ?>
            <tr>
                <td><?php echo $student['name'] ?></td>
                <td><?php echo $student['datenextquiz'] ?></td>
            </tr><?php
            }?>
        </tbody>
    </table>
</div>
<?php endif; ?>
<div class="mt-5 text-center">
    <a href="<?php echo new \moodle_url('/mod/quizschedule/add_plan.php', []) ?>" class="btn btn-success">Додати План</a>
</div>

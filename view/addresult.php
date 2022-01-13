<?php defined('MOODLE_INTERNAL') || die(); ?>
<?php 
$r = $params[0]; // array
?>
<div class="bold"><?php echo get_string( 'add_quiz_result', 'quizschedule' ) ?></div>
<div class="addresult">
    <table class="table">
        <tbody>
            <tr>
                <td>Дата Екзамену</td>
                <td><?php echo $r['date'] ?></td>
            </tr>
            <tr>
                <td>Екзамен</td>
                <td><?php echo $r['quiz'] ?></td>
            </tr>
            <tr>
                <td>Тип комісії</td>
                <td><?php echo $r['commission'] ?></td>
            </tr>
            <tr>
                <td>Відповідальна особа</td>
                <td><?php echo $r['manager'] ?></td>
            </tr>
            <tr>
                <td>Доданих результатів (загально)</td>
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
    
    <div class="bold">Студенти</div>
    <table class="table">
        <tbody><?php
            foreach ($r['students'] as $student) { ?>
            <tr>
                <td><?php echo $student['name'] ?></td>
                <td><?php echo get_string('quiz_mark_'.$student['gradekey'], 'quizschedule') ?></td>
            </tr><?php
            }?>
        </tbody>
    </table>
</div>
<div class="mt-5 text-center">
    <a href="<?php echo new \moodle_url('/mod/quizschedule/add.php', []) ?>" class="btn btn-success">Додати результати Екзамену</a>
</div>

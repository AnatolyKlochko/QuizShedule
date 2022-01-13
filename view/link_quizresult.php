<?php defined('MOODLE_INTERNAL') || die();

$r = $params[0]; // array

?>
<div class="bold"><?php echo get_string( 'add_quiz_result', 'quizschedule' ) ?></div>
<div class="addresult">
    <table class="table">
        <tbody>
            <tr>
                <td>Стовпець Загального Звіту</td>
                <td><?php echo $r['grcolumnname'] ?></td>
            </tr>
            <tr>
                <td>Додано Екзаменів</td>
                <td><?php echo $r['quizzescount'] ?></td>
            </tr>
        </tbody>
    </table>
<?php if ( $r['quizzescount'] > 0 ) : ?>
    <div class="bold">Екзамени</div>
    <table class="table">
        <tbody><?php
            foreach ( $r['quizzes'] as $quiz ) { ?>
            <tr>
                <td><?php echo $quiz['id'] ?></td>
                <td><?php echo $quiz['fullname'] ?></td>
            </tr><?php
            }?>
        </tbody>
    </table>
<?php endif; ?>
</div>
<div class="mt-5 text-center">
    <a href="/mod/quizschedule/link_quiz_to_grcolumn.php" class="btn btn-success">Додати Екзамени до Стовпця</a>
</div>
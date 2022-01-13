<?php

defined('MOODLE_INTERNAL') || die();

$r = $params[0]; // array
$prev = $r['prev_row'];
$curr = $r['curr_row'];
$changed = $r['total_changed'];
$added = $r['total_added'];

?>
<div class="bold">Результат зміни даних</div>
<?php if ( $r['status'] ) : ?>
<div id="cntr-addresult" class="mt-5">
    <table id="tbl-result" class="table">
        <thead>
            <tr>
                <th>Стовпець</th>
                <th>Попередні дані</th>
                <th>Поточні дані</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="column-name">Запис, ID</td>
                <td><?php echo $prev->id ?></td>
                <td class="<?php echo ( $curr->id !== $prev->id ? 'new' : '' ) ?>">
                    <span class="<?php echo ( $curr->id !== $prev->id ? 'new' : '' ) ?>">
                        <?php echo $curr->id ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="column-name">Запис, Створено</td>
                <td><?php echo date( 'd.m.Y H:i:s', strtotime( $prev->timecreated ) ) ?></td>
                <td class="<?php echo ( $curr->timecreated !== $prev->timecreated ? 'new' : '' ) ?>">
                    <span class="<?php echo ( $curr->timecreated !== $prev->timecreated ? 'new' : '' ) ?>">
                        <?php echo date( 'd.m.Y H:i:s', strtotime( $curr->timecreated ) ) ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="column-name">Запис, Змінено</td>
                <td><?php echo date( 'd.m.Y H:i:s', strtotime( $prev->timemodified ) ) ?></td>
                <td class="<?php echo ( $curr->timemodified !== $prev->timemodified ? 'new' : '' ) ?>">
                    <span class="<?php echo ( $curr->timemodified !== $prev->timemodified ? 'new' : '' ) ?>">
                        <?php echo date( 'd.m.Y H:i:s', strtotime( $curr->timemodified ) ) ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="column-name">Відповідальна особа, ID</td>
                <td><?php echo $prev->managerid ?></td>
                <td class="<?php echo ( $curr->managerid !== $prev->managerid ? 'new' : '' ) ?>">
                    <span class="<?php echo ( $curr->managerid !== $prev->managerid ? 'new' : '' ) ?>">
                        <?php echo $curr->managerid ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="column-name">Відповідальна особа, ПІБ</td>
                <td><?php echo $prev->manager ?></td>
                <td class="<?php echo ( $curr->manager !== $prev->manager ? 'new' : '' ) ?>">
                    <span class="<?php echo ( $curr->manager !== $prev->manager ? 'new' : '' ) ?>">
                        <?php echo $curr->manager ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="column-name">Співробітник, ID</td>
                <td><?php echo $prev->employeeid ?></td>
                <td class="<?php echo ( $curr->employeeid !== $prev->employeeid ? 'new' : '' ) ?>">
                    <span class="<?php echo ( $curr->employeeid !== $prev->employeeid ? 'new' : '' ) ?>">
                        <?php echo $curr->employeeid ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="column-name">Співробітник, ПІБ</td>
                <td><?php echo $prev->employee ?></td>
                <td class="<?php echo ( $curr->employee !== $prev->employee ? 'new' : '' ) ?>">
                    <span class="<?php echo ( $curr->employee !== $prev->employee ? 'new' : '' ) ?>">
                        <?php echo $curr->employee ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="column-name">Екзамен, ID</td>
                <td><?php echo $prev->quizid ?></td>
                <td class="<?php echo ( $curr->quizid !== $prev->quizid ? 'new' : '' ) ?>">
                    <span class="<?php echo ( $curr->quizid !== $prev->quizid ? 'new' : '' ) ?>">
                        <?php echo $curr->quizid ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="column-name">Екзамен, Назва</td>
                <td><?php echo $prev->quiz ?></td>
                <td class="<?php echo ( $curr->quiz !== $prev->quiz ? 'new' : '' ) ?>">
                    <span class="<?php echo ( $curr->quiz !== $prev->quiz ? 'new' : '' ) ?>">
                        <?php echo $curr->quiz ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="column-name">Екзамен, Оцінка</td>
                <td>
                <?php
                    if ( $prev->datequiz ) {
                        echo get_string('quiz_mark_' . ( $prev->grade == 0 ? 'off' : 'on' ), 'quizschedule');
                    }
                ?>
                </td>
                <td class="<?php echo ( $curr->grade !== $prev->grade ? 'new' : '' ) ?>">
                    <span class="<?php echo ( $curr->grade !== $prev->grade ? 'new' : '' ) ?>">
                    <?php
                        if ( $curr->datequiz ) {
                            echo get_string('quiz_mark_' . ( $curr->grade == 0 ? 'off' : 'on' ), 'quizschedule');
                        }
                    ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="column-name">Екзамен, Дата</td>
                <td>
                <?php
                    if ( $prev->datequiz ) {
                        echo date( 'd.m.Y', strtotime( $prev->datequiz ) );
                    }
                ?>
                </td>
                <td class="<?php echo ( $curr->datequiz !== $prev->datequiz ? 'new' : '' ) ?>">
                    <span class="<?php echo ( $curr->datequiz !== $prev->datequiz ? 'new' : '' ) ?>">
                    <?php
                        if ( $curr->datequiz ) {
                            echo date( 'd.m.Y', strtotime( $curr->datequiz ) );
                        }
                    ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="column-name">Екзамен, План</td>
                <td><?php echo date( 'd.m.Y', strtotime( $prev->datenextquiz ) ) ?></td>
                <td class="<?php echo ( $curr->datenextquiz !== $prev->datenextquiz ? 'new' : '' ) ?>">
                    <span class="<?php echo ( $curr->datenextquiz !== $prev->datenextquiz ? 'new' : '' ) ?>">
                        <?php echo date( 'd.m.Y', strtotime( $curr->datenextquiz ) ) ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="column-name">Екзамен, Комісія</td>
                <td>
                <?php
                    if ( $prev->commissiontype ) {
                        echo get_string('add_commissiontype_val_' . $prev->commissiontype, 'quizschedule');
                    }
                ?>
                </td>
                <td class="<?php echo ( $curr->commissiontype !== $prev->commissiontype ? 'new' : '' ) ?>">
                    <span class="<?php echo ( $curr->commissiontype !== $prev->commissiontype ? 'new' : '' ) ?>">
                    <?php
                        if ( $curr->commissiontype ) {
                            echo get_string('add_commissiontype_val_' . $curr->commissiontype, 'quizschedule');
                        }
                    ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="column-name bg-secondary" colspan="3"></td>
            </tr>
            <tr>
                <td>Змінено записів</td>
                <td><?php echo $changed ?></td>
                <td></td>
            </tr>
            <tr>
                <td>Додано записів</td>
                <td><?php echo $added ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
<?php 
    else :
        echo $r['message'];
    endif;
?>

<div class="mt-5 mb-5 text-center">
    <a href="<?php echo new \moodle_url('/mod/quizschedule/edit.php', []) ?>" class="btn btn-success">Редагувати Дані</a>
</div>

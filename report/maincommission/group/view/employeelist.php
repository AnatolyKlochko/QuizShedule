<?php

// $employees, is passed to render method

$dci = -1; // data-column index
$nbo = 1; // number by order

?>
<div id="employeelist-column-visibility">
    <a href="#" data-column="<?php echo ++$dci; ?>" data-name="numbering">№</a><span class="splitter"></span>
    <a href="#" data-column="<?php echo ++$dci; ?>" data-name="employeeinfo">Співробітник</a><span class="splitter"></span>
    <a href="#" data-column="<?php echo ++$dci; ?>" data-name="quizinfo">Екзамен</a><span class="splitter"></span>
    <a href="#" data-column="<?php echo ++$dci; ?>" data-name="attemptinfo">Спроба</a><span class="splitter"></span>
    <a href="#" data-column="<?php echo ++$dci; ?>">Дія</a>
</div>

<form id="frm-employeelist">
    
    <table id="employeelist" class="display dataTable table table-striped mb-5">
        <thead>
            <tr>
                <th class="text-center">№</th>
                <th>Співробітник</th>
                <th>Екзамен</th>
                <th>Спроба</th>
                <th class="text-center">Дія</th>
            </tr>
        </thead>
        <tbody>

    <?php

    foreach ($employees as $employee) {

        $id = $employee->employee_id;

    ?>

            <tr>

                <td class="col-nbo text-center" data-th="№">
                    <span class=""><?php echo $nbo++ ?></span>
                </td>

                <td>
                    <?php echo $employee->employee_fullname . '<br />' . $employee->employee_position . '<br />' . $schedule->filter_affiliatenumber( $employee->employee_affiliate ) ?>
                    <input name="employee<?php echo $id ?>[id]" value="<?php echo $employee->employee_id ?>" placeholder="" type="hidden" tabindex="">
                    <input name="employee<?php echo $id ?>[fullname]" value="<?php echo $employee->employee_fullname ?>" placeholder="" type="hidden" tabindex="">
                    <input name="employee<?php echo $id ?>[position]" value="<?php echo $schedule->filter_replacedoublequotes( $employee->employee_position ) ?>" placeholder="" type="hidden" tabindex="">
                    <input name="employee<?php echo $id ?>[affiliate]" value="<?php echo $schedule->filter_replacedoublequotes( $employee->employee_affiliate ) ?>" placeholder="" type="hidden" tabindex="">
                </td>

                <td>
                    <?php echo $schedule->filter_quizgroupbylines( $employee->quiz_name ) . '<br />' . $schedule->filter_commissiontype( $employee->commissionkey ) ?>
                </td>

                <td>
                    <?php 
                        if ( $employee->quizattempt_info ) {
                            echo $schedule->filter_backreplacebreakline( $employee->quizattempt_info ) /*$employee->quizattempt_id . '<br />' . date( 'H:m:i d-m-Y', $employee->quizattempt_timestart ) . ' - ' . date( 'H:m:i d-m-Y', $employee->quizattempt_timefinish ) . '<br />' . $employee->quizattempt_state*/;
                        }
                    ?>
                </td>
               
                <td class="col-delete text-center">
                    <span class="btn btn-light btn-delete">Видалити</span>
                </td>

            </tr>

    <?php
    
    }
    
    ?>

        </tbody>
        <tfoot>
            <tr>
                <th class="text-center">№</th>
                <th>Співробітник</th>
                <th>Екзамен</th>
                <th>Спроба</th>
                <th class="text-center">Дія</th>
            </tr>
        </tfoot>
    </table>
    
</form>
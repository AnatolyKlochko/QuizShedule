<?php

$employees = $params[0];

?>
<div id="employeelist-column-visibility">
    <a href="#" data-column="0">Статус</a><span class="splitter"></span>
    <a href="#" data-column="1">ПІБ</a><span class="splitter"></span>
    <a href="#" data-column="2">Філія</a><span class="splitter"></span>
    <a href="#" data-column="3">Відділ</a><span class="splitter"></span>
    <a href="#" data-column="4">Результат</a><span class="splitter"></span>
    <a href="#" data-column="5">Номер в Moodle</a><span class="splitter"></span>
    <a href="#" data-column="6">Наступний&nbsp;екзамен</a><span class="splitter"></span>
    <a href="#" data-column="7">Дія</a>
</div>
<table id="employeelist" class="display dataTable table table-striped mb-5">
    <thead>
        <tr>
            <th class="text-center"><span class="oi oi-badge"></span></th>
            <th>ПІБ</th>
            <th>Філія</th>
            <th>Відділ</th>
            <th class="col-grade text-center">Результат</th>
            <th class="text-center">Номер в Moodle</th>
            <th>Наступний екзамен</th>
            <th class="text-center">Дія</th>
        </tr>
    </thead>
    <tbody>

<?php

foreach ($employees as $employee) {
    
    $id = $employee->id;
    
?>

        <tr>
            
            <td class="col-status text-center" data-th="Статус">
                <span class=""></span>
            </td>
            
            <td>
                <?php echo $employee->name ?>
                <input name="employee<?php echo $id ?>[id]" value="<?php echo $employee->id ?>" placeholder="" type="hidden" tabindex="">
            </td>
            
            <td><?php echo $employee->institution ?></td>
            
            <td><?php echo $employee->department ?></td>
            
            <td>
                <div>
                    <div class="form-group row">
                        <div class="col-sm-6 text-center text-nowrap">
                            <?php echo get_string('quiz_mark_on', 'quizschedule') ?>
                        </div>
                        <div class="col-sm-6 text-center text-nowrap">
                            <?php echo get_string('quiz_mark_off', 'quizschedule') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 text-center">
                            <input name="employee<?php echo $id ?>[quiz_mark]" value="on" placeholder="" type="radio" tabindex="">
                        </div>
                        <div class="col-sm-6 text-center">
                            <input name="employee<?php echo $id ?>[quiz_mark]" value="off" placeholder="" type="radio" tabindex="">
                        </div>
                    </div>
                </div>
            </td>
            
            <td class="col-attemptid">
                <input name="employee<?php echo $id ?>[attempt_id]" value="<?php //echo date('Y-m-d') ?>" placeholder="" type="number" min="1" max="18446744073709551616" tabindex="1" autofocus>
            </td>
            
            <td class="col-datenext">
                <input name="employee<?php echo $id ?>[quiz_nextdate]" value="<?php //echo date('Y-m-d') ?>" placeholder="Next Quiz Date" type="date" tabindex="1" autofocus>
            </td>
            
            <td class="col-clean text-center"><span class="btn btn-light btn-clean">Очистити</span></td>
            
        </tr>

<?php
}
?>

    </tbody>
    <tfoot>
        <tr>
            <th><span class="oi oi-badge"></span></th>
            <th>ПІБ</th>
            <th>Філія</th>
            <th>Посада</th>
            <th>Результат</th>
            <th>Номер в Moodle</th>
            <th>Наступний екзамен</th>
            <th class="text-center">Дія</th>
        </tr>
    </tfoot>
</table>
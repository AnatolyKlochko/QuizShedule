<?php

$employees = $params[0];

?>
<div id="employeelist-column-visibility">
    <a href="#" data-column="0">Статус</a><span class="splitter"></span>
    <a href="#" data-column="1">ПІБ</a><span class="splitter"></span>
    <a href="#" data-column="2">Філія</a><span class="splitter"></span>
    <a href="#" data-column="3">Відділ</a><span class="splitter"></span>
    <a href="#" data-column="4">Дата&nbsp;екзамену</a><span class="splitter"></span>
    <a href="#" data-column="5">Дія</a>
</div>
<table id="employeelist" class="display dataTable table table-striped mb-5">
    <thead>
        <tr>
            <th class="text-center"><span class="oi oi-bookmark"></span></th>
            <th>ПІБ</th>
            <th>Філія</th>
            <th>Відділ</th>
            <th>Дата&nbsp;екзамену</th>
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
            <th><span class="oi oi-bookmark"></span></th>
            <th>ПІБ</th>
            <th>Філія</th>
            <th>Посада</th>
            <th>Дата&nbsp;екзамену</th>
            <th class="text-center">Дія</th>
        </tr>
    </tfoot>
</table>
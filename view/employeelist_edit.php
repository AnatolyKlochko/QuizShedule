<?php

$employees = $params[0];

?>
<div id="employeelistedit-column-visibility">
    <a href="#" data-column="0">ПІБ</a><span class="splitter"></span>
    <a href="#" data-column="1">Філія</a><span class="splitter"></span>
    <a href="#" data-column="2">Відділ</a><span class="splitter"></span>
    <a href="#" data-column="3">Наступний екзамен</a><span class="splitter"></span>
    <a href="#" data-column="4">Дія</a><span class="splitter"></span>
</div>

<table id="employeelistedit" class="display dataTable table table-striped mb-5">
    <thead>
        <tr>
            <th>ПІБ</th>
            <th>Філія</th>
            <th>Відділ</th>
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
           
            <td>
                <?php echo $employee->name ?>
            </td>
            
            <td>
                <?php echo $employee->institution ?>
            </td>
            
            <td>
                <?php echo $employee->department ?>
            </td>
            
            <td>
                <?php echo date( 'd.m.Y', strtotime( $employee->datenextquiz ) ) ?>
            </td>
            
            <td class="col-editemployee-link text-center">
                <a class="btn btn-light" href="edit_employee.php?employeeid=<?php echo $id ?>&quizid=<?php echo $employee->quizid ?>" target="_blank"><?php echo get_string('quiz_editlink', 'quizschedule') ?></a>
            </td>
            
        </tr>

<?php
}
?>

    </tbody>
    <tfoot>
        <tr>
            <th>ПІБ</th>
            <th>Філія</th>
            <th>Відділ</th>
            <th>Наступний екзамен</th>
            <th class="text-center">Дія</th>
        </tr>
    </tfoot>
</table>
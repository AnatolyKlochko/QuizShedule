<?php

$rd = $params[0];

?>
<!--div id="redundantdatalist-column-visibility">
    <a href="#" data-column="0">Екзамен</a><span class="splitter"></span>
    <a href="#" data-column="1">Факт</a><span class="splitter"></span>
    <a href="#" data-column="2">План</a><span class="splitter"></span>
    <a href="#" data-column="3">Занесено</a><span class="splitter"></span>
    <a href="#" data-column="4">Видалити</a><span class="splitter"></span>
</div-->
<table id="redundantdatalist" class="display dataTable table mb-5">
    <thead>
        <tr>
            <th>Екзамен</th>
            <th class="">Факт</th>
            <th class="">План</th>
            <th class="">Занесено</th>
            <th class="text-center">Видалити</th>
        </tr>
    </thead>
    <tbody>

<?php
$rdrowscount = count( $rd );
if ( $rdrowscount == 0 ) {
?>
    <tr class="empty-result bg-secondary">
        <td colspan="5">
            <span class="message text-white">Збиткові Дані Не Виявлені</span>
        </td>
    </tr>
<?php  
} else {
    
    foreach ($rd as $employeequiz) { // redundant data, quizschedule point
    
        $employeeid = $employeequiz->employeeid;
        $employeename = $employeequiz->employeename;
        $employeeaffiliatename = $employeequiz->employeeaffiliatename;

        $quizid = $employeequiz->quizid;
        $quizname = $employeequiz->quizname;

        $qspoints = $employeequiz->children;
?>
    <tr class="employee bg-secondary" data-employeeid="<?php echo $employeeid ?>" data-quizid="<?php echo $quizid ?>">
        <td colspan="5">
            <span class="employeename"><?php echo $employeename ?></span>,
            <span class="employeeaffiliatename"><?php echo $employeeaffiliatename ?></span> 
            <!--span class="quizname"><?php //echo $quizname ?></span-->
        </td>
        <td style="display:none;"></td>
        <td style="display:none;"></td>
        <td style="display:none;"></td>
        <td style="display:none;"></td>
    </tr>
<?php
        foreach ( $qspoints as $point ) {
            $id = $point['id'];
?>
    <tr class="checked-<?php echo $point['checked'] ?> <?php $point['checked'] == 'on' ? 'bg-danger' : 'bg-success' ?>">
        <td><?php echo $quizname ?></td>
        <td><?php echo $point['datequiz'] == 0 ? '' : $point['datequiz'] ?></td>
        <td><?php echo $point['datenextquiz'] ?></td>
        <td><?php echo $point['timecreated'] ?></td>
        <td class="text-center">
            <input name="qspoint<?php echo $id ?>[checked]" type="checkbox" <?php echo $point['checked'] === "on" ? 'checked' : '' ?> />
            <input name="qspoint<?php echo $id ?>[id]" value="<?php echo $id ?>" placeholder="" type="hidden" tabindex="">
        </td>

    </tr>
<?php
        }

    }

}
?>
    </tbody>
    <tfoot>
        <tr>
            <th>Екзамен</th>
            <th class="">Факт</th>
            <th class="">План</th>
            <th class="">Занесено</th>
            <th class="text-center">Видалити</th>
        </tr>
    </tfoot>
</table>
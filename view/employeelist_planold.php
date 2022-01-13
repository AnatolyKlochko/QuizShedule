<?php
$employees = $params[0];
?>
<div class="employee-row bold text-uppercase m-b-1">
    <div class="">
        Прізвище, імя, по-батькові
    </div>
    <div class="">
        Філія
    </div>
    <div class="">
        Відділ
    </div>
    <div class="centered">
        <?php echo get_string('quiz_nextdate', 'quizschedule') ?>
    </div>
</div>
<?php
foreach ($employees as $employee) {
    $id = $employee->id;  ?>
<div class="employee-row">
    <div class="">
        <?php echo $employee->name ?>
    </div>
    <div class="">
        <?php echo $employee->institution ?>
    </div>
    <div class="">
        <?php echo $employee->department ?>
    </div>
    <input name="employee<?php echo $id ?>[id]" value="<?php echo $employee->id ?>" placeholder="" type="hidden" tabindex="">
    <div class="centered">
        <fieldset>
            <input name="employee<?php echo $id ?>[quiz_nextdate]" value="" placeholder="Next Quiz Date" type="date" tabindex="1" autofocus />
        </fieldset>
    </div>
</div>  <?php
}
    
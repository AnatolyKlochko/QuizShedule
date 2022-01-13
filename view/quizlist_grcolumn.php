<?php defined('MOODLE_INTERNAL') || die(); ?>

<?php

$quiz_list = $params[0]; // \mod_quizschedule\model\schedule

?>

<table id="quizlist_grcolumn" class="display dataTable table table-striped mb-5">
    <thead>
        <tr>
            <th class="text-center">*</th>
            <th>ID</th>
            <th>Назва</th>
            <th>Категорія</th>
            <th>Остання зміна</th>
        </tr>
    </thead>
    <tbody>

<?php

foreach ( $quiz_list as $quizarr) {
    
    $id = $quizarr['id'];
    
?>

        <tr>
            
            <td class="col-status text-center" data-th="Статус">
                <input name="quiz<?php echo $id ?>[quiz_status]" placeholder="" type="checkbox" tabindex="">
                <input name="quiz<?php echo $id ?>[id]" value="<?php echo $id ?>" placeholder="" type="hidden" tabindex="">
            </td>
            
            <td>
                <?php echo $id ?>
            </td>
            
            <td>
            	<?php echo $quizarr['fullname'] ?>
            </td>
            
            <td>
            	<?php echo $quizarr['category_breadcrumb'] ?>
            </td>
            
            <td>
            	<?php echo date( 'Y-m-d H:i:s', $quizarr['modified'] ) ?>
            </td>
            
        </tr>

<?php
}
?>

    </tbody>
    <tfoot>
        <tr>
            <th class="text-center">*</th>
            <th>ID</th>
            <th>Назва</th>
            <th>Категорія</th>
            <th>Остання зміна</th>
        </tr>
    </tfoot>
</table>
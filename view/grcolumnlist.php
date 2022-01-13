<?php defined('MOODLE_INTERNAL') || die(); ?>

<select id="grcolumnid" name="grcolumnid" class="form-control" required="true"> <!--Supplement an id here instead of using 'name'-->
<?php

$grcolumn_list = $params[0]; // \mod_quizschedule\model\schedule

foreach ( $grcolumn_list as $grcolumnarr ) {
?>
    <option value="<?php echo $grcolumnarr->id ?>" data-desc-uk="<?php echo $grcolumnarr->desc_uk ?>"><?php echo $grcolumnarr->name_uk ?></option><?php
}
?>
</select>
<?php defined('MOODLE_INTERNAL') || die(); ?>

<select id="commissiontypeid" name="commissiontypeid" class="form-control" required="true"> <!--Supplement an id here instead of using 'name'-->
    <option value="0"></option>
<?php

    $commissiontype_list = $params[0];
    
    $ctid = ( isset( $_POST['ctid'] ) ? intval( $_POST['ctid'] ) : ''  );

    foreach ( $commissiontype_list as $id => $key ) { ?>
        <option value="<?php echo $id ?>" <?php if ( $id === $ctid ) { echo 'selected'; } ?>><?php echo get_string('add_commissiontype_val_'.$key, 'quizschedule') ?></option><?php
    }

?>
</select>
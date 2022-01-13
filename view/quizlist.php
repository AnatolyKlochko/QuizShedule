<?php

defined('MOODLE_INTERNAL') || die();

?>
<select id="quizid" name="quizid" class="form-control" required="true"> <!--Supplement an id here instead of using 'name'-->
<?php

$quiz_list = $params[0]; // \mod_quizschedule\model\schedule

$quiz_id = ( isset( $_POST['quizid'] ) ? intval( $_POST['quizid'] ) : ''  );

$optiongroup = '';

foreach ( $quiz_list as $quizarr ) { 
    if ( $quizarr['rootcat_name'] != $optiongroup ) {
        if ( ! empty( $optiongroup ) ) {
            echo '</optgroup>';
        }
        $optiongroup = $quizarr['rootcat_name'];
        echo '<optgroup label="' . $optiongroup . '">';
    }
?>
    <option value="<?php echo $quizarr['id'] ?>" <?php if ( $quizarr['id'] == $quiz_id ) { echo 'selected'; } ?>><?php echo $quizarr['fullname'] ?></option><?php
}
echo '</optgroup>';

?>
</select>
<?php

$al = $params[0];

$selected_key = $_POST['affiliate_key'];

?>

<select id="affiliate_key" name="affiliate_key" placeholder="Af" class="form-control" required="true"> <!--Supplement an id here instead of using 'name'-->
<?php
    foreach ($al as $key => $affiliate) {  ?>
        <option value="<?php echo $key ?>" <?php if ( $key === $selected_key ) { echo 'selected'; } ?>><?php echo $affiliate ?></option><?php
    }
?>
</select>

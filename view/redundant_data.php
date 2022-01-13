<?php

defined('MOODLE_INTERNAL') || die();

?>
<div class="container pt-3 cntr-redundant-data">
    
<?php

// Display Redundant Data List (only if )
if ( isset( $_POST['submit_save'] ) ) {

    $rd_to_delete = $_POST;
    
    $rd_delete_result = $ms->delete_redundant_data( $rd_to_delete );
    
    $rd_count = $ms->get_redundant_data_count();
    
    $vh->add_part( 'redundant_data_delete_result', $rd_delete_result, $rd_count );
    
}
?>

    <!--div class="mt-5 mb-5">
        <h2>
            <?php //echo get_string('add_exam_heading', 'quizschedule') ?>
        </h2>
    </div-->
    
    <form id="frm-redundant-data" action="" method="post">
        
    <?php
        
        // Redundant Data Part
        
        //$affiliate_key = $_POST['affiliate_key'];
    
        $redundantdata = $ms->get_redundant_data( /*$affiliate_key*/ );
        $ms->get_redundant_data_children( $redundantdata );
        $ms->mark_redundant_data_children( $redundantdata );
        $vh->add_part( 'redundant_data_list', $redundantdata );

        $rd_count = $ms->get_redundant_data_count();
        if ( $rd_count > 0 ):
?>        
        <div class="cnt-count">
            <span>Всього: </span>
            <span class="count">
<?php 
                echo $ms->get_redundant_data_count() 
?>
            </span> записів збиткових даних
        </div>
        
        <div class="form-group row">
            <div class="col-sm-12 text-center">
                <input id="submitSave" class="btn btn-danger" type="submit" value="<?php echo get_string('redundant_data_delete_btn_title', 'quizschedule') ?>" name="submit_save"/>
            </div>
        </div>
<?php
        endif;
?>  
    </form>
</div>
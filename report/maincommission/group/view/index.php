<?php

defined('MOODLE_INTERNAL') || die();

$date = isset( $_POST['quizdate'] ) ? date( 'dd.mm.YYYY', strtotime( $_POST['quizdate'] ) ) : date( 'dd.mm.YYYY' );

?>
<div class="container pt-3 cntr-maincommission-group">
    
    <form id="frm-quizdate" class="form-inline" method="post">
    
        <div id="cntr-quizdate" class="form-group">
            
            <input type="date" class="form-control" name="quizdate" id="quizdate" value="<?php echo $date ?>">
            
        </div>
        
        <input class="btn btn-primary" type="submit" value="<?php echo get_string('searchquizdate', 'quizschedulemaincommission_group') ?>" name="submit_quizdate">

    </form>
    
</div>
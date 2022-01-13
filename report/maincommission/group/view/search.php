<?php

defined('MOODLE_INTERNAL') || die();

$date = isset( $_POST['quizdate'] ) ? date( 'Y-m-d', strtotime( $_POST['quizdate'] ) ) : date( 'Y-m-d' );

$moodleattemptchecked = isset( $_POST['moodleattempt'] ) && $_POST['moodleattempt'] === 'on' ? 'checked' : '';

$schedulechecked = isset( $_POST['schedule'] ) && $_POST['schedule'] === 'on' ? 'checked' : '';
        
?>
<form id="frm-quizdate" class="form-inline" method="post">

    <div id="cntr-quizdate" class="form-group">

        <input type="date" class="form-control" name="quizdate" id="quizdate" value="<?php echo $date ?>">
               
    </div>
    
    <div id="cntr-moodleattempt" class="form-group">
        
        <input type="checkbox" class="form-control" name="moodleattempt" id="moodleattempt" <?php echo $moodleattemptchecked ?>>
        
        <label for="moodleattempt"><?php echo get_string( 'searchmoodle', 'quizschedulemaincommission_group' ) ?></label>
        
    </div>
    
    <div id="cntr-schedule" class="form-group">
        
        <input type="checkbox" class="form-control" name="schedule" id="schedule" <?php echo $schedulechecked ?>>
        
        <label for="schedule"><?php echo get_string( 'searchschedule', 'quizschedulemaincommission_group' ) ?></label>
        
    </div>

    <input id="quizdate_submit" class="btn btn-primary" type="submit" value="<?php echo get_string( 'searchquizdate', 'quizschedulemaincommission_group' ) ?>" name="submit_quizdate">

</form>
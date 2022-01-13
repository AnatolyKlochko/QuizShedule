<?php
defined('MOODLE_INTERNAL') || die();      
?>
<form id="frm-quizdate" class="form-inline" method="post" action="<?php echo $action ?>">

    <div id="cntr-quizdate" class="form-group">

        <input type="date" class="form-control" name="quizdate" id="quizdate" value="<?php echo $header->date ?>">
               
    </div>
    
    <div id="cntr-moodleattempt" class="form-group">
        
        <input type="checkbox" class="form-control" name="moodleattempt" id="moodleattempt" <?php echo $header->attemptstate ?>>
        
        <label for="moodleattempt"><?php echo $header->attempttitle ?></label>
        
    </div>
    
    <div id="cntr-schedule" class="form-group">
        
        <input type="checkbox" class="form-control" name="schedule" id="schedule" <?php echo $header->schedulestate ?>>
        
        <label for="schedule"><?php echo $header->scheduletitle ?></label>
        
    </div>

    <input id="quizdate_submit" class="btn btn-primary" type="submit" value="<?php echo $header->submittitle ?>" name="submit_quizdate">

</form>
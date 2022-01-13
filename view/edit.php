<?php

defined('MOODLE_INTERNAL') || die();

?>
<div class="container pt-3 cntr-edit">
    
    <form id="frm-affiliate-quiz" class="" method="post">
        
        <div class="mb-5">
            <h2>
                <?php echo get_string('add_affiliatelist_heading', 'quizschedule') ?>
            </h2>
        </div>
        
        <div id="cntr-affiliate" class="form-group row">
            
            <div class="col-lg-0 col-xl-2"></div>
            
            <div class="col-lg-12 col-xl-8 cntr-list">
                <?php
                    $vh->add_part( 'affiliatelist', $ms->get_affiliate_list() );
                ?>
            </div>
            
            <div class="col-lg-0 col-xl-2"></div>
            
        </div>
        
        
        
        <div class="mt-5 mb-5">
            <h2>
                <?php echo get_string('add_exam_heading', 'quizschedule') ?>
            </h2>
        </div>
        
        <div class="form-group row">
            
            <div class="col-lg-0 col-xl-2"></div>
            
            <div class="col-lg-12 col-xl-8 cntr-list">
                <?php
                    // Quiz List Part
                    $vh->add_part( 'quizlist', $ms->get_quiz_list() );
                ?>
            </div>
            
            <div class="col-lg-0 col-xl-2"></div>
            
        </div>
        
        <div class="form-group row mt-5">
            
            <div class="col-sm-12 text-center cntr-search">
                
                <input id="submitEdit" class="btn btn-success" type="submit" value="<?php echo get_string('edit_plan_find', 'quizschedule') ?>" name="submit_affiliate_quiz"/>
                
            </div>
            
        </div>
        
    </form>
<?php
    
    // Display Students form
    if ( isset( $_POST['submit_affiliate_quiz'] ) ) {
        
        $affiliate_key = $_POST['affiliate_key'];
        
        $quiz_id = $_POST['quizid'];
        
        $employees = $ms->get_employees_by_affiliate_quiz( $affiliate_key, $quiz_id );
        
?>

        <div class="mt-5 mb-5">
            <h2>
                <?php echo get_string('edit_results_heading', 'quizschedule') ?>
            </h2>
        </div>
    
<?php
        
        $vh->add_part( 'employeelist_edit', $employees );
        
    }
    
?>
</div>
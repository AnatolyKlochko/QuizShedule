<?php

defined('MOODLE_INTERNAL') || die();

?>
<div class="container pt-3 cntr-add">
    
<?php

// Display Affiliate List (only if )
if ( !isset( $_POST['submit_save'] ) ) { ?>
    
    <div class="mb-5">
        <h2>
            <?php echo get_string('add_affiliatelist_heading', 'quizschedule') ?>
        </h2>
    </div>
    
    <form id="frm-affiliate" class="" method="post">
    
        <div id="cntr-affiliate" class="form-group row">
            
            <div class="col-lg-0 col-xl-2"></div>
            
            <div class="col-lg-12 col-xl-8 cntr-list">
                <?php
                    $vh->add_part( 'affiliatelist', $ms->get_affiliate_list() );
                ?>
            </div>
            
            <div class="col-lg-0 col-xl-2"></div>
            
        </div>
        
        <div id="" class="form-group row">
            
            <div id="cntr-search" class="col-xs-12 text-center">
                
                <input class="btn btn-primary" type="submit" value="<?php echo get_string('add_affiliatelist_find', 'quizschedule') ?>" name="submit_affiliate">
                
            </div>
            
        </div>
        
    </form>
    
<?php
}

// Display Students form
if ( isset( $_POST['submit_affiliate'] ) ) {
    //$vh->add_styles( 'add', 'add' );
?>  

    <div class="mt-5 mb-5">
        <h2>
            <?php echo get_string('add_exam_heading', 'quizschedule') ?>
        </h2>
    </div>
    
    <form id="quiz-students" action="" method="post">
        
        <input type="hidden" name="managerid" value="<?php echo $managerid ?>">
        
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
        
        <div class="form-group row">
            
            <div class="col-lg-0 col-xl-2"></div>
            
            <div class="col-lg-12 col-xl-8 cntr-list">
                <?php
                    // Commission Type Part
                    $vh->add_part( 'commissiontypelist', $ms->get_commissiontype_list() );
                ?>
            </div>
            
            <div class="col-lg-0 col-xl-2"></div>
            
        </div>
        
        
        <div class="mt-5 mb-5">
            <h2>
                <?php echo get_string('add_plan_data_heading', 'quizschedule') ?>
            </h2>
        </div>
        
        
        
        <?php
        
        // Employees Part
        
        $affiliate_key = $_POST['affiliate_key'];
    
        $employees = $ms->get_affiliate_employees( $affiliate_key );
        
        $vh->add_part( 'employeelist_plan', $employees );
        
    ?>
          
        <!-- Modal -->
        <div class="modal fade" id="saveConfirmModal" tabindex="-1" role="dialog" aria-labelledby="saveConfirmModalLongTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="saveConfirmModalLongTitle">Ви впевнені у корректності даних?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>
                    <span class="oi oi-warning text-danger" style="float:left; margin:12px 12px 20px 0;"></span>
                    Після занесення до Бази Данних, планові дані мають право змінити лише працівники Учбового Центру при наявності електронного листа від керівника філії.
                </p>
                <p class="text-center text-danger">Ви впевнені у коректності даних?</p>
                <p>Якщо ні, натисніть "Відмінити" і ще раз перевірте правильність данних.</p>
              </div>
              <div class="modal-footer">
                <button id="saveModal-Dismiss" type="button" class="btn btn-secondary" data-dismiss="modal">Відмінити</button>
                <button id="saveModal-Save" type="button" class="btn btn-primary">Так, занести до Бази Даних</button>
              </div>
            </div>
          </div>
        </div>
        
        <div class="form-group row">
            <div class="col-sm-12 text-center">
                <input id="submitSave" class="btn btn-success" type="submit" value="<?php echo get_string('quiz_saveresults', 'quizschedule') ?>" name="submit_save"/>
            </div>
        </div>
        
    </form>
<?php
}

// Handle came data
if ( isset( $_POST['submit_save'] ) ) {
    
    $plan = $_POST;
    
    $planresult = $ms->save_quiz_plan( $plan );
    
    $vh->add_part( 'planresult', $planresult );
    
}
?>
</div>
<?php

defined('MOODLE_INTERNAL') || die();

?>
<div class="container pt-3 cntr-quiz-grcolumn">
    
<?php
    
    if ( ! isset( $_POST['submit_link'] ) ) : ?>
    
    <div class="mb-3">
        <h2>
            <?php echo get_string('linkquiztogrcolumn_searchtitle', 'quizschedule') ?>
        </h2>
    </div>
    
    <form id="frm-quizname" class="form-inline" method="post">
    
        <div id="cntr-quizname" class="form-group">
            
            <input type="text" class="form-control" name="quizname" id="quizname" placeholder="<?php echo get_string('linkquiztogrcolumn_quizname', 'quizschedule') ?>">
            
        </div>
        
        <input class="btn btn-primary" type="submit" value="<?php echo get_string('linkquiztogrcolumn_search', 'quizschedule') ?>" name="submit_quizname">

    </form>

<?php

    endif;
    
?>

<?php

// Display Affiliate List (only if )
if ( isset( $_POST['submit_quizname'] ) ) {

    $quizpartname = $_POST['quizname'];

    // Verify $quiz_name var
    // ...

    $quizzes = $ms->get_quiz_list_by_partname( $quizpartname );

    if ( count( $quizzes ) > 0 ) {

        $grcolumnlist = $ms->get_grcolumn_list();

    ?>
        
    <form id="frm-quizzes-grcolumn" class="" method="post">
        
        <div class="mb-3">
            <h2>
                <?php echo get_string('linkquiztogrcolumn_quizlisttitle', 'quizschedule') ?>
            </h2>
        </div>

        <?php

        $vh->add_part( 'quizlist_grcolumn', $quizzes );

        ?>
        
        <div class="mb-3">
            <h2>
                <?php echo get_string('linkquiztogrcolumn_grcolumntitle', 'quizschedule') ?>
            </h2>
        </div>
    
        <div id="cntr-grcolumn" class="form-group row">
            
            <div class="col-lg-12 col-xl-8 cntr-grcolumnlist">
                <?php
                    //$vh->add_part( 'affiliatelist', $ms->get_affiliate_list() );
                    $vh->add_part( 'grcolumnlist', $grcolumnlist );
                ?>
            </div>
            
        </div>
        
        <div id="" class="form-group row">
            
            <div id="cntr-search" class="col-xs-12 text-center">
                
                <input class="btn btn-primary" type="submit" value="<?php echo get_string('linkquiztogrcolumn_link', 'quizschedule') ?>" name="submit_link">

            </div>
            
        </div>
        
    </form>
    
<?php

    } else {

        echo get_string('linkquiztogrcolumn_searchempty', 'quizschedule');

    }

}


// Handle data
if ( isset( $_POST['submit_link'] ) ) {
    
    $quizzes_grcolumm = $_POST;
    
    $linkresult = $ms->save_link_quizzes_to_grcolumn( $quizzes_grcolumm );
    
    $vh->add_part( 'link_quizresult', $linkresult );
    
}
?>

</div>
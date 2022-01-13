<?php

/**
 * Quiz ID. Defined at \mod\quiz\report.php
 */
//global $QRS_CFG;
//global $id;
//
//if (isset($_POST['date_start'])) { 
//    $ds = $_POST['date_start']; 
//}
//if (isset($_POST['date_finish'])) { 
//    $df = $_POST['date_finish']; 
//}
//if (isset($_POST['for_students'])) { 
//    $fs = $_POST['for_students']; 
//}
?>
<style>
    .search-header {
        display: grid;
        grid-template-columns: 1fr 1fr 2fr;
        margin: 1rem 22px 0 22px;
    }
    .search-body {
        display: grid;
        grid-template-columns: 1fr 1fr 2fr;
        margin: 0 22px 1rem 22px;
    }
    .search-forstudents {
        align-self: center;
    }
</style>
<div class="container">
  <form id="search" action="find.php" method="post">
    <h4><?php //echo get_string('search_title', 'quiz_student') ?></h4>
    <div class="search-header">
        <div><?php //echo get_string('search_datestart', 'quiz_student') ?></div>
        <div><?php //echo get_string('search_dateend', 'quiz_student') ?></div>
    </div>
    <div class="search-body">
        <div>
            <fieldset>
                <label><?php echo get_string('quiz_search_datefrom', 'quizschedule') ?></label>
                <input name="date_start" value="<?php echo date('Y-m-d') ?>" placeholder="Date Start" type="date" tabindex="1" autofocus>
            </fieldset>
        </div>
        <div>
            <fieldset>
                <label><?php echo get_string('quiz_search_dateto', 'quizschedule') ?></label>
                <input name="date_finish" value="<?php echo date('Y-m-d') ?>" placeholder="Date Finish" type="date" tabindex="2">
            </fieldset>
        </div>
        <!--div class="search-forstudents">
            <fieldset>
                <input name="for_students" placeholder="Students" type="checkbox" tabindex="3" <?php //echo ($_POST['for_students']==='on')?'checked':'' ?>> <?php //echo get_string('search_forstudents', 'quiz_student') ?>
            </fieldset>
        </div-->
        <div>
            <fieldset>
                <button name="submit" value="submit" type="submit" id="search-submit" data-submit=""><?php echo get_string('quiz_search_button', 'quizschedule') ?></button>
            </fieldset>
        </div>
    </div>
    
  </form>
</div>
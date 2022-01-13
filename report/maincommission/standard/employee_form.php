<?php

/**
 * Quiz ID. Defined at \mod\quiz\report.php
 */
global $QRS_CFG;
global $id;

if (isset($_POST['date_start'])) { 
    $ds = $_POST['date_start']; 
}
if (isset($_POST['date_finish'])) { 
    $df = $_POST['date_finish']; 
}
?>
<style>
    .search-header {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 2fr;
        margin: 1rem 22px 0 22px;
    }
    .search-body {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 2fr;
        margin: 0 22px 1rem 22px;
    }
    .search-forstudents {
        align-self: center;
    }
</style>
<div class="container">
  <form id="search" action="<?php echo $QRS_CFG->dataurl ?>/mod/quiz/report.php?id=<?php echo $id ?>&mode=student" method="post">
    <h2><?php echo get_string('search_title', 'quiz_student') ?></h2>
    <div class="search-header">
        <div><?php echo get_string('search_datestart', 'quiz_student') ?></div>
        <div><?php echo get_string('search_dateend', 'quiz_student') ?></div>
    </div>
    <div class="search-body">
        <div>
            <fieldset>
                <input name="date_start" value="<?php echo $ds ?>" placeholder="Date Start" type="date" tabindex="1" autofocus>
            </fieldset>
        </div>
        <div>
            <fieldset>
                <input name="date_finish" value="<?php echo $df ?>" placeholder="Date Finish" type="date" tabindex="2">
            </fieldset>
        </div>
        <div>
            <fieldset>
                <button name="submit" value="submit" type="submit" id="search-submit" data-submit=""><?php echo get_string('search_find', 'quiz_student') ?></button>
            </fieldset>
        </div>
    </div>
    
  </form>
</div>
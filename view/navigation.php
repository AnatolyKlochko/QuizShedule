<?php

?>
<style>
    .nav-actions {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        justify-items: center;
        margin: 50px 0 50px 0;
    }
</style>
<div class="container">
    <div class="nav-actions">
        <div>
            <a href="add.php"><?php echo get_string('quiz_nav_quizresults', 'quizschedule') ?></a>
        </div>
        <div>
            <a href="edit.php"><?php echo get_string('quiz_nav_quizedit', 'quizschedule') ?></a>
        </div>
        <div>
            <a href="find.php"><?php echo get_string('quiz_nav_quizsearch', 'quizschedule') ?></a>
        </div>
    </div>  
</div>
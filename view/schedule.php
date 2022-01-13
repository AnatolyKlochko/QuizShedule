<style>
    .schedule {
        min-width: 1200px;
        margin: 50px 0 50px 0;
    }
    .quiz {
        display: grid;
        grid-template-columns: 1fr 1fr;
        margin: 0;
        /*font-size: 10px;*/
    }
</style>
<div class="container">
    <div class="schedule">
        <table class="table table-dark">
            <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col"><?php echo get_string('quiz_name', 'quizschedule') ?></th>
                  <th scope="col"><?php echo get_string('quiz_date', 'quizschedule') ?></th>
                </tr>
              </thead>
              <tbody>
            <?php
            
            foreach ($schedule as $quiz) { ?>
            <tr>
                <th scope="row">1</th>
                <td><?php echo $quiz->name ?></td>
                <td><?php echo $quiz->quizdate ?></td>
            </tr><?php
            }?>
            </tbody>
        </table>
    </div>
</div>
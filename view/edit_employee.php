<?php 

defined('MOODLE_INTERNAL') || die(); 

if ( ( ! isset( $_POST['submit_edit_schedulepoint'] ) ) && ( ! isset( $_POST['submit_delete_schedulepoint'] ) ) ) : 

?>

<div class="bold"><?php echo get_string( 'edit_employee_title', 'quizschedule' ) ?></div>

<div class="edit-employee mt-5">
<?php if ( $es === false ): ?>
    <div>Запис не знайдено.</div>
<?php else: ?>
    <form method="post">
        
        <table class="table">
            
            <tbody>
                <tr>
                    <td>Екзамен</td>
                    <td><?php $vh->add_part( 'quizlist', $ms->get_quiz_list() ) //echo $es->quizname ?></td>
                </tr>
                <tr>
                    <td>Оцінка</td>
                    <td>
                    <?php
                        if ( $es->datequiz ) : ?>
                        <select name="grade" class="form-control">
                            <option value="0" <?php echo ( $es->grade == 0 ? 'selected' : '' ) ?>>не здав</option>
                            <option value="1" <?php echo ( $es->grade == 1 ? 'selected' : '' ) ?>>здав</option>
                        </select>
                    <?php
                        endif;
                    ?>
                    </td>
                </tr>
                <tr>
                    <td>Дата Екзамену</td>
                    <td>
                        <input type="date" name="datequiz" value="<?php if ( $es->datequiz ) { echo $es->datequiz; } ?>" class="form-control" />
                    </td>
                </tr>
                <tr>
                    <td>Дата наступного Екзамену</td>
                    <td>
                        <input type="date" name="datenextquiz" value="<?php echo $es->datenextquiz ?>" class="form-control" />
                    </td>
                </tr>
                <tr>
                    <td>Тип комісії</td>
                    <td>
                    <?php
                        $vh->add_part( 'commissiontypelist', $ms->get_commissiontype_list() );
                    ?>
                    </td>
                </tr>
                <tr>
                    <td>Співробітник</td>
                    <td><?php echo $es->employeename ?></td>
                </tr>
                <tr>
                    <td>Відповідальна особа</td>
                    <td><?php echo $ms->get_employee_name( $es->managerid ) ?></td>
                </tr>
                <tr>
                    <td>Час внесення данних</td>
                    <td><?php echo date( 'H:i:s d.m.Y', strtotime( $es->timecreated ) ) ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <input type="hidden" name="scheduleid" value="<?php echo $es->quizscheduleid ?>" />
                        <input type="hidden" name="employee" value="<?php echo $es->employeename ?>" />
                        <input type="hidden" name="quiz" value="<?php echo $es->quizname ?>" />
                        <input type="submit" name="submit_edit_schedulepoint" value="Зберегти" class="btn btn-success" />
                        <input type="submit" name="submit_delete_schedulepoint" value="Видалити" class="btn btn-danger"/>
                    </td>
                </tr>
                
            </tbody>
            
        </table>
        
    </form>
<?php endif; ?>
</div>

<?php

endif;

// Handle came data

// Editing
if ( isset( $_POST['submit_edit_schedulepoint'] ) ) {
    
    $editdata = $_POST;
    
    $editdataresult = $ms->edit_data( $editdata );
    
    $vh->add_part( 'editdataresult', $editdataresult );
    
}

// Deleting
if ( isset( $_POST['submit_delete_schedulepoint'] ) ) {
    
    $editdata = $_POST;
    
    $deleteresult = $ms->delete_data( $editdata );
    
    $vh->add_part( 'deletedataresult', $deleteresult );
    //echo 'deleting...';
}

?>
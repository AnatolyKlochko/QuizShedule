<?php
defined('MOODLE_INTERNAL') || die();
?>
<div id="employeelist-column-visibility">
    <?php
    foreach ( $datatable->columns as $col ) { ?>
        <a href="#" data-column="<?php echo ++$dci; ?>" data-name="<?php echo $col->key ?>"><?php echo $col->title ?></a><span class="splitter"></span><?php
    }
    ?>
</div>

<form id="frm-employeelist">
    
    <table id="employeelist" class="display dataTable table table-striped mb-5">
        <thead>
            <tr>
                <?php
                foreach ( $datatable->columns as $col ) { ?>
                    <th class="<?php echo $col->headerclass ?>"><?php echo $col->title ?></th><?php
                }
                ?>
            </tr>
        </thead>
        <tbody>

    <?php

    foreach ($datatable->employees as $employee) {

        $id = $employee->employee_id;

    ?>

            <tr>

                <td class="col-nbo text-center" data-th="№">
                    <span class=""><?php echo $nbo++ ?></span>
                </td>

                <td>
                    <?php echo $employee->get_info() ?>
                    <input name="employee<?php echo $id ?>[id]" value="<?php echo $employee->employee_id ?>" placeholder="" type="hidden" tabindex="">
                    <input name="employee<?php echo $id ?>[fullname]" value="<?php echo $employee->employee_fullname ?>" placeholder="" type="hidden" tabindex="">
                    <input name="employee<?php echo $id ?>[position]" value="<?php echo $employee->hidden_employee_position ?>" placeholder="" type="hidden" tabindex="">
                    <input name="employee<?php echo $id ?>[affiliate]" value="<?php echo $employee->hidden_employee_affiliate ?>" placeholder="" type="hidden" tabindex="">
                </td>

                <td>
                    <?php echo $employee->quiz_name . '<br />' . $employee->commissionkey ?>
                </td>

                <td>
                    <?php 
                        if ( $employee->quizattempt_info ) {
                            echo $employee->quizattempt_info;
                        }
                    ?>
                </td>
               
                <td class="col-delete text-center">
                    <span class="btn btn-light btn-delete">Видалити</span>
                </td>

            </tr>

    <?php
    
    }
    
    ?>

        </tbody>
        <tfoot>
            <tr>
                <?php
                foreach ( $datatable->columns as $col ) { ?>
                    <th class="<?php echo $col->class ?>"><?php echo $col->title ?></th><?php
                }
                ?>
            </tr>
        </tfoot>
    </table>
    
</form>
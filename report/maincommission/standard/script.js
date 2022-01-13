//console.log('student');
require(['jquery'], function($) {
    // JQuery is available via $
    $('tr > td > select[name="quiz_student_table_reporttype"]').change(function (e) {
        let $option = $(e.target);
        let reportUrl = $option.find('option:selected').data('url');
        $option.closest('tr').prevAll('form').attr('action', reportUrl);
    });
});
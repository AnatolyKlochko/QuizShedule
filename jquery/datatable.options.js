;( function( ) {
    
    if ( 'dtOptions' in window ) { } else {
        
        // DataTables Common Options
        window.dtOptions = {
            "autoWidth": false,
            "ordering": true,
            //"scrollY": "auto",
            "paging": true,
            "info": true,
            "search": {regex: true},
            "language": {
                "oAria": {
                    "sSortAscending": ": активуйте для сортування стовпця по зростанню",
                    "sSortDescending": ": активуйте для сортування стовпця по спаданню"
                },
                "oPaginate": {
                    "sFirst": "Перша",
                    "sLast": "Остання",
                    "sNext": "Наступна",
                    "sPrevious": "Попередня"
                },
                "sEmptyTable": "Немає даних для відображення",
                "sInfo": "_START_ - _END_ з _TOTAL_ записів",
                "sInfoEmpty": "0 - 0 з 0 записів",
                "sInfoFiltered": "(відібрано з _MAX_ записів)",
                "sInfoPostFix": "",
                "sDecimal": "",
                "sThousands": ",",
                "sLengthMenu": "Відображати по _MENU_ записів",
                "sLoadingRecords": "Завантаження записів...",
                "sProcessing": "Обробка даних...",
                "sSearch": "_INPUT_",
                "sSearchPlaceholder": "Почніть вводити ПІБ, Філію або Відділ...",
                "sUrl": "",
                "sZeroRecords": "Записів не знайдено"
            },
            //"dom": '<fl>rt<ip><"clear">', // works strange

        }
        
    }
    
} )( )

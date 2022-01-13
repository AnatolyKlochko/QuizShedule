$(function () {
    //console.log('test...')
    
    // Loop: add content
    $( '[data-toggle="popover"]' ).each( function( index, element ) {
        //console.log( $( element ).find( 'data > popover' ).html() )
        
        $( element )
            .popover( {
                html: true,
                content: $( element ).find( 'data > popover' ).html()
            } )
        
        //DON'T WORK:
        //$( element ).content = $( element ).find( 'data > popover' ).text()
        // ONLY IN OPTION OBJECT
        
    } )
    
    
    
    // Attention Block
    // - hide after 7s
    setTimeout( function() {
        $( "#attention" ).hide( 'slow' )
    }, 100 );
    
    
    
    // DataTable Plugin
    
    // Globals
    var tableID = 'table'
    
    // Table row
//    $( `#${tableID} tbody tr` ).click( function() {
//        
//        $( this ).toggleClass( 'highlight' );
//        
//    });

	dtOptions.lengthMenu = [
		[1, 5, 10, 20, 50, 100, 500, 1000, 2000, -1], 
		[1, 5, 10, 20, 50, 100, 500, 1000, 2000, "Всі"]
	]
	dtOptions.pageLength = 100
	
	// Unsortable Columns
	let unsortableColumnIndexes = []
	let unsortableColumns = [
		'occupational_health',
		'technology_works',
		'fire_safety_rules',
		'safe_operation_of_lifts',
		'safe_operation_of_cranes',
		'pressure_vessels',
		'physical_examination'
	]
	// unsortableColumns.forEach( 
	// 	elemColumnName => 
	// 		$( `[data-name="${elemColumnName}"]` )
	// 		.attr( 'data-column' )
	// 		.split( ",", 3 )
	// 		.forEach( 
	// 			elemColumnIndex => 
	// 				unsortableColumnIndexes.push( parseInt( elemColumnIndex ) ) 
	// 		)
    // )
    
	dtOptions.columnDefs = [ {
        "orderable": false, // DON'T make these columns as sortable:
        "targets": unsortableColumnIndexes
    } ]

    dtOptions.order = [
        //[ 1, "asc" ]
    ]
    
	let currDate = new Date().toJSON().slice(0,10).split('-').reverse().join('.') // 07.01.2003
    dtOptions.language.sSearchPlaceholder = currDate + ", петренко, миргородська монтер, заступник і т.п." 
	
	// Extentions
	// Responsive rows
	//dtOptions.responsive = true
    
	
    var reportTbl = $( `#${tableID}` ).DataTable( dtOptions )
    
    // Make Fixed Header
	//new $.fn.dataTable.FixedHeader( reportTbl )
	
    // 'Employee List' Table Preparation: 
    reportTbl.on( 'draw.dt', function () {
        
        // Search field
        // 
        // - move search field to left
        $searchBlock = $( `#${tableID}_filter` )
        //console.log( $searchBlock )
        $( `#${tableID}_filter` ).parent().prev().append( $searchBlock )
        
        
        // 'Show entries' block 
        // 
        // - move to right
        $lengthBlock = $( `#${tableID}_length` )
        //console.log( $searchBlock )
        $( `#${tableID}_length` ).parent().next().append( $lengthBlock )
        
        
        // 'Status' Column
        //
        // - remove sorting icons
        //$( `#${tableID} > thead > tr > th:nth-child(1)` ).removeClass( 'sorting sorting_asc sorting_desc' ) // WARNING! when colomns hide/show it hides first column icon
        // - remove sorting icons
        //$( `#${tableID} > tbody > tr > td.col-status` ).attr( 'data-th', 'Статус' )
        
        // 'FLName' Column
        //
        // - sort asc
        //$( `#${tableID} > thead > tr > th:nth-child(2)` ).click().click() // WARNING! when colomns hide/show it ... second column
        
    } )
    
    // Trigger table redraw to run 'draw' event
    reportTbl.draw()

    
    
    
    // 'Column Visibility' block
    
    // - hide (change color) column
    $( `#${tableID}-column-visibility > a` ).on( 'click', function (e) {
        
        let _a_this = this
        
        e.preventDefault()
        
        // Array of Column Indexes
        let colInd = $( this ).attr( 'data-column' ).split( ",", 3 )
        
        colInd.forEach( function( i ) { // array element, column index
            
            // Get the column API object
            let column = reportTbl.column( i )

            // Toggle the visibility
            column.visible( ! column.visible() )

            // Add/Remove .inactive class
            if ( column.visible() ) {

                $( _a_this ).removeClass( 'inactive' )

            } else {

                $( _a_this ).addClass( 'inactive' )

            }
            
        })
 
    } )
    
	// Hide columns: 
    // № 
    $( `#${tableID}-column-visibility > a[data-name="numbering"]` ).click()
	// Група з електробезпеки
    $( `#${tableID}-column-visibility > a[data-name="group_of_electrical_safety"]` ).click()
    // БПРП
    //$( `#${tableID}-column-visibility > a[data-name="safe_operation_of_lifts"]` ).click()
    // БПРК
    //$( `#${tableID}-column-visibility > a[data-name="safe_operation_of_cranes"]` ).click()
	// ППТ
    //$( `#${tableID}-column-visibility > a[data-name="pressure_vessels"]` ).click()
    // МО
    //$( `#${tableID}-column-visibility > a[data-name="physical_examination"]` ).click()
    // Комісія
    $( `#${tableID}-column-visibility > a[data-name="commission_type"]` ).click()
    // Примітки
    $( `#${tableID}-column-visibility > a[data-name="notes"]` ).click()
    

    //Scroll X by mouse wheel
    var item = document.getElementById('table');

    item.addEventListener('wheel', function(e) {
        e.stopPropagation();
        e.preventDefault();
        if (e.deltaY > 0) item.scrollLeft += 100;
        else item.scrollLeft -= 100;
    });


    //----------------NEW SCRIPT------------------

    //search with filters
    $('#search_btn').click(function(e){
        e.preventDefault();
        
        //reset filters
        reportTbl.columns().search('').draw();

        if ($('.filter_text_field').filter(function () { return this.value; }).length) {
            //find all text fields with some value and show rows which meet the conditions
            $('.filter_text_field').filter(function () { return this.value; }).each(function (index, item) {
                let keywords = $(item).val().split(" ");
                //console.log(keywords.join("|"));

                let col_num = parseInt($(item).data("col"));
                
                if(col_num===3){
                    //tab.nomer starts with:
                    reportTbl.columns(col_num).search("^("+keywords.join("|")+")", true, false).draw();
                } else {
                    //columns with text:
                    reportTbl.columns(col_num).search(keywords.join(".*") + "|" + keywords.reverse().join(".*"), true, false).draw();
                }
            });
        }

        if($('.filter_field').filter(function() { return this.value; }).length){
            //find all date inputs with some value and show rows which meet the conditions
            $('.filter_field').filter(function() { return this.value; }).each(function(index, item){
                let date_start = $(item).val();
                let date_end = $('.'+$(item).data("type")+'.date_to').first().val() || date_start;
                //console.log(date_start);
                //console.log(date_end);

                let col_num = $(item).data("col");

                //convert dates to unix format
                let start_date = Math.floor(new Date(date_start).getTime() / 1000);
                let end_date = Math.floor(new Date(date_end).getTime() / 1000);

                if(end_date<start_date){
                    end_date = start_date;
                }
                

                let r = [];
                //then loop "for" and goes through every day and hide unneeded rows
                for(let i=start_date; i<=end_date; i+=86400){
                    let curD = new Date(i*1000);
                    let current_date = (curD.getDate()<10 ? '0':'') + curD.getDate() +'.'+ (curD.getMonth()+1<10 ? '0':'') + (curD.getMonth()+1) +'.'+ curD.getFullYear();

                    r.push(current_date);
                }
                reportTbl.columns(col_num).search(r.join('|'), true, false).draw();
            });
        }
    });

    //reset filter - show all - clear all fields
    $('#reset_btn').click(function(e){
        e.preventDefault();

        $('.filter_field, .filter_text_field').val("").css("background-color", "#fff");
        $('.filter_field').each(function(index, item){
            $('.'+$(item).data("type")+'.date_to').val("").css("background-color", "#fff");
        });

        reportTbl.columns().search('').draw();
    });

    //highlight inputs with some value
    $('input[type=date], .filter_text_field').on('change, input', function(){
        if($(this).val().length){
            $(this).css("background-color", "#dfd");
        } else {
            $(this).css("background-color", "#fff");
        }
    });


})

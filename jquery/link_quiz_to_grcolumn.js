$(function () {
    //console.log('test...')
    // Globals
    var tableID = 'quizlist_grcolumn'
    
    
    
    // Table row
    $( `#${tableID} tbody tr` ).click( function() {
        
        $( this ).toggleClass( 'highlight' );
        
    });
    
    
    
    // Button 'Clean': remove selected values
//    $( '.btn-clean' ).click( function( event ) {
//        //console.log( $( element ).find( 'data > popover' ).html() )
//        
//        $tr = $( this ).closest( 'tr' )
//        
//        // Quiz Mark input: remove checking and internal value
//        $tr.find( 'input[name*="quiz_mark"]' ).prop( 'checked', false ).val( null )
//        
//        // Next Quiz Date input: remove selected date and internal value
//        $tr.find( 'input[name*="quiz_nextdate"]' ).val( null )
//        
//        // Status column: remove status icon
//        $tr.find( '.col-status > span' ).removeClass( 'oi oi-check' )
//        
//        // self: remove 'hightliht' class
//        $tr.removeClass( 'highlight' )
//        
//        
//        $input = $tr.find( 'input[name*="quiz_mark"]' )
//        //console.log($input)
//        //console.log($input.val())
//        //$input.prop('checked', false)
//        //$input.val( null )
//        //console.log($input.val())
//    } )
    
    // Radio 'Result': add icon to Status column
//    $( 'input[name*="quiz_mark"]' ).change( function( event ) {
//        
//        $( this ).closest( 'tr' ).find( '.col-status > span' ).addClass( 'oi oi-check' )
//        
//    } )
 
 
    
    // Confirmation on 'Save': opens modal Save (to confirm or dismiss form post)
//    $( '#submitSave' ).click( function( event ) {
//        
//        // Cancel form submition
//        event.preventDefault();
//        
//        console.log( 'submitSave' )
//        
//        $( '#saveConfirmModal' ).modal()
//        
//    })
    
    // Button 'Save' in modal Save: force form submitting
//    $( '#saveModal-Save' ).click( function() {
//        
//        // Form 'Quiz Students': add param 'submit_save' to allow save data
//        $( "<input />" ).attr("type", "hidden")
//            .attr("name", "submit_save")
//            .attr("value", "000")
//            .appendTo( "#quiz-students" )
//    
//        //console.log( $( '#quiz-students' ).serialize() )
//        
//        $( '#quiz-students' ).submit()
//        
//    } )
    
    
    
    
    // 'Quiz List' Table
    
    
    // 'Quiz List': add responsivity at 1199px viewport width
    $( `#${tableID}` ).basictable( {
        breakpoint: 1199
    } )
    //$( '#quizlist_grcolumn' ).basictable('start') // applies responsivity immediately
        
    
    // 'Quiz List' Table: init, common options
    dtOptions.columnDefs = [ {
        "orderable": false, 
        "targets": [ 0 ] 
    } ]

    dtOptions.order = [
        //[ 1, "asc" ]
    ]
    
    dtOptions.language.sSearchPlaceholder = "Почніть вводити назву Екзамену"
    
    var quizListTbl = $( '#quizlist_grcolumn' ).DataTable( dtOptions )
    
    
    // 'Quiz List' Table Preparation: 
    quizListTbl.on( 'draw.dt', function () {
        
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
    quizListTbl.draw()

    
    
    
    // 'Column Visibility' block
    
    // - hide (change color) column
//    $( `#${tableID}-column-visibility > a` ).on( 'click', function (e) {
//        
//        e.preventDefault()
// 
//        // Get the column API object
//        var column = quizListTbl.column( $( this ).attr( 'data-column' ) )
// 
//        // Toggle the visibility
//        column.visible( ! column.visible() )
//        
//        // Add/Remove .inactive class
//        if ( column.visible() ) {
//            
//            $( this ).removeClass( 'inactive' )
//            
//        } else {
//            
//            $( this ).addClass( 'inactive' )
//            
//        }
//        
//    } )
    
    
})
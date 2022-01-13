$(function () {
    //console.log('test...')
    // Globals
    var tableID = 'employeelist'
    
    
    
    // Table row
    $( `#${tableID} tbody tr` ).click( function() {
        
        $( this ).toggleClass( 'highlight' );
        
    });
    
    
    
    // Button 'Clean': remove selected values
    $( '.btn-clean' ).click( function( event ) {
        
        $tr = $( this ).closest( 'tr' )
                
        // Next Quiz Date input: remove selected date and internal value
        $tr.find( 'input[name*="quiz_nextdate"]' ).val( null )
        
        // Status column: remove status icon
        $tr.find( '.col-status > span' ).removeClass( 'oi oi-check' )
        
        // self: remove 'hightliht' class
        $tr.removeClass( 'highlight' )
        
    } )
    
    
    // Date field 'Next Quiz': add icon to Status column
    $( 'input[name*="quiz_nextdate"]' ).change( function( event ) {
        
        $( this ).closest( 'tr' ).find( '.col-status > span' ).addClass( 'oi oi-check' )
        
    } )
    
        
    // Confirmation on 'Save': opens modal Save (to confirm or dismiss form post)
    $( '#submitSave' ).click( function( event ) {
        
        // Cancel form submition
        event.preventDefault();
                
        $( '#saveConfirmModal' ).modal()
        
    })
    
    // Button 'Save' in modal Save: force form submitting
    $( '#saveModal-Save' ).click( function() {
        
        // Form 'Quiz Students': add param 'submit_save' to allow save data
        $( "<input />" ).attr("type", "hidden")
            .attr("name", "submit_save")
            .attr("value", "000")
            .appendTo( "#quiz-students" )
    
        //console.log( $( '#quiz-students' ).serialize() )
        
        $( '#quiz-students' ).submit()
        
    } )
    
    
    
    
    // 'Employee List' Table
    
    
    // 'Employee List': add responsivity at 1199px viewport width
    $( `#${tableID}` ).basictable( {
        breakpoint: 1199
    } )
    //$( '#employeelist' ).basictable('start') // applies responsivity immediately
        
    
    // 'Employee List' Table: init, common options
    dtOptions.columnDefs = [ {
        "orderable": false, 
        "targets": [ 0, 4, 5 ] 
    } ]

    dtOptions.order = [
        [ 1, "asc" ]
    ]
    
    var employeeListTbl = $( '#employeelist' ).DataTable( dtOptions )
    
    
    // 'Employee List' Table Preparation: 
    employeeListTbl.on( 'draw.dt', function () {
        
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
        $( `#${tableID} > tbody > tr > td.col-status` ).attr( 'data-th', 'Статус' )
        
        // 'FLName' Column
        //
        // - sort asc
        //$( `#${tableID} > thead > tr > th:nth-child(2)` ).click().click() // WARNING! when colomns hide/show it ... second column
        
    } )
    
    // Trigger table redraw to run 'draw' event
    employeeListTbl.draw()

    
    
    
    // 'Column Visibility' block
    
    // - hide (change color) column
    $( `#${tableID}-column-visibility > a` ).on( 'click', function (e) {
        
        e.preventDefault()
 
        // Get the column API object
        var column = employeeListTbl.column( $( this ).attr( 'data-column' ) )
 
        // Toggle the visibility
        column.visible( ! column.visible() )
        
        // Add/Remove .inactive class
        if ( column.visible() ) {
            
            $( this ).removeClass( 'inactive' )
            
        } else {
            
            $( this ).addClass( 'inactive' )
            
        }
        
    } )
    
    
})
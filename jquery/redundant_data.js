$(function () {
    //console.log('test...')
    // Globals
    var tableID = 'redundantdatalist'
    
    
    
    // Table row
    $( `#${tableID} tbody tr` ).click( function() {
        
        //$( this ).toggleClass( 'highlight' )
        
    })
    
    
    
    // Checkbox 'Delete': change row background
    $( 'input[name*="checked"]' ).change( function( event ) {
        
//        if ( this.value === 'on' ) {
            
            //$( this ).closest( 'tr' ).toogleClass( 'checked-on' ).toogleClass( 'checked-off' )
//        } else {
//            $( this ).closest( 'tr' ).addClass( 'checked-off' )
//        }
        
    } )
 
 
    
    
    // 'Redundant Data List' Table
    
    
    // 'Redundant Data List': add responsivity at 1199px viewport width
    $( `#${tableID}` ).basictable( {
        breakpoint: 1199
    } )
    //$( `#${tableID}` ).basictable( 'start' ) // applies responsivity immediately
        
	dtOptions.lengthMenu = [
		[10, 25, 50, 100, -1], 
		[10, 25, 50, 100, "All"]
	]
	dtOptions.pageLength = 100
    
    // 'Redundant Data List' Table: init, common options
    dtOptions.columnDefs = [ {
        "orderable": false, 
        "targets": [ 0, 1, 2, 3, 4 ] 
    } ]

       
	//var redundantdataListTbl = $( `#${tableID}` ).DataTable( dtOptions )
    
    
    // 'Redundant Data List' Table Preparation: 
    //redundantdataListTbl.on( 'draw.dt', function () {
        
        // Search field
        // 
        // - move search field to left
        //$searchBlock = $( `#${tableID}_filter` )
        //console.log( $searchBlock )
        //$( `#${tableID}_filter` ).parent().prev().append( $searchBlock )
        
        
        // 'Show entries' block 
        // 
        // - move to right
        //$lengthBlock = $( `#${tableID}_length` )
        //console.log( $searchBlock )
        //$( `#${tableID}_length` ).parent().next().append( $lengthBlock )
        
        
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
        
    //} )
    
    // Trigger table redraw to run 'draw' event
    //redundantdataListTbl.draw()

    
    
    
    // 'Column Visibility' block
    
    // - hide (change color) column
    //$( `#${tableID}-column-visibility > a` ).on( 'click', function (e) {
        
        //e.preventDefault()
 
        // Get the column API object
        //var column = redundantdataListTbl.column( $( this ).attr( 'data-column' ) )
 
        // Toggle the visibility
        //column.visible( ! column.visible() )
        
        // Add/Remove .inactive class
        //if ( column.visible() ) {
            
            //$( this ).removeClass( 'inactive' )
            
        //} else {
            
            //$( this ).addClass( 'inactive' )
            
        //}
        
    //} )
    
    
})

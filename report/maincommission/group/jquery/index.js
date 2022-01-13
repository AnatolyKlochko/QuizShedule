$(function () {
    //console.log('test...')
    // Globals
    var tableID = 'employeelist'
    
    
    
    // Table row
    $( `#${tableID} tbody tr` ).click( function() {
        
        $( this ).toggleClass( 'highlight' );
        
    });
    
    
    
    // Button 'Clean': remove clicked row
    $( '.btn-delete' ).click( function( event ) {
        //console.log( $( element ).find( 'data > popover' ).html() )
        
        $tr = $( this ).closest( 'tr' )
		//console.log( $tr )
		
		$tr.remove()
        
    } )
    
        
    // Open report: Print format
    $( '#cntr-print > #btn-print' ).click( function( event ) {
             
        //console.log( 'submitSave' )
        
		// Get Quiz Date from  Form
		let quizDate = $( '#quizdate' ).val()
		let reportLink = $( this ).data('link')
		
        $( '#frm-employeelist' )
		.attr( 'action', reportLink )
		.attr( 'method', 'post' )
		.attr( 'target', '_blank' )
		.append( `<input type="hidden" name="quizdate" value="${quizDate}" />` )
		.submit()
        
    })
    
        
    
    
    // 'Employee List' Table
    
    
    // 'Employee List': add responsivity at 1199px viewport width
    $( `#${tableID}` ).basictable( {
        breakpoint: 1199
    } )
    //$( '#employeelist' ).basictable('start') // applies responsivity immediately
        
    
	// Modify default settings
	dtOptions.language.sSearchPlaceholder = "Почніть вводити ПІБ, Екзамен або Номер спроби..."
	
    // 'Employee List' Table: init, common options
	dtOptions.lengthMenu = [
		[ -1 ], 
		[ "Всі" ]
	]
	dtOptions.pageLength = -1
	
    dtOptions.columnDefs = [ {
        "orderable": false, 
        "targets": [ 0, 1 ] 
    } ]

    // dtOptions.order = [
        // [ 1, "asc" ]
    // ]
    
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
        //$( `#${tableID} > tbody > tr > td.col-status` ).attr( 'data-th', 'Статус' )
        
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
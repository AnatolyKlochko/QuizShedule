$(function () {
    //console.log('test...')
    // Globals
    var tableID = 'employeelistedit'
    
    
    
    // Table row
    $( `#${tableID} tbody tr` ).click( function() {
        
        $( this ).toggleClass( 'highlight' )
        
    });
    

    
    
    // 'Employee List' Table
    
    
    // 'Employee List': add responsivity at 1199px viewport width
    $( `#${tableID}` ).basictable( {
        breakpoint: 1199
    } )
    //$( '#employeelist' ).basictable('start') // applies responsivity immediately
        
    
    // 'Employee List' Table: init, common options
    dtOptions.columnDefs = [ {
        "orderable": false, 
        "targets": [ 4 ] 
    } ]

    dtOptions.order = [
        [ 1, "asc" ]
    ]
    
    var employeeListTbl = $( `#${tableID}` ).DataTable( dtOptions )
    
    
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
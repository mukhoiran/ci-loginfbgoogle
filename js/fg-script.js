$(document).ready(function() {

/*-----------------------------------------------------------------------------
|	Profile Picture dropdown function
|------------------------------------------------------------------------------
*/
    $(function(){
        var config = {    
             sensitivity: 3, // number = sensitivity threshold (must be 1 or higher)    
             interval: 50,  // number = milliseconds for onMouseOver polling interval    
             over: doOpen,   // function = onMouseOver callback (REQUIRED)    
             timeout: 200,   // number = milliseconds delay before onMouseOut    
             out: doClose    // function = onMouseOut callback (REQUIRED)    
        };
        function doOpen() {
            $( "#fg-dropdown" ).stop().animate({height: "toggle",opacity: "toggle"}, 300 );
        }
        function doClose() {
            $( "#fg-dropdown" ).stop().animate({height: "toggle",opacity: "toggle"}, 300 );
        }
        $("#user-img").hoverIntent(config);
        checkHeight();        
    });


    function checkHeight () {
        if( $( "#sidebar" ).length > 0 ){
            var winSize = ( window.innerHeight - 200 );
            var sidebarSize = document.getElementById("sidebar").clientHeight;
            if( winSize <= sidebarSize )
                stuckSidebar( false );
            else
                stuckSidebar( true );
        }
    }
    function stuckSidebar( argument ){
    if( argument )
            $( "#sidebar" ).waypoint( "sticky" );    
        else
            $( "#sidebar" ).waypoint( "unsticky" );    
    }

    $( window ).resize(function() {
       checkHeight(); 
    }); 


/*-----------------------------------------------------------------------------
|   For Edit Button DropDown
|------------------------------------------------------------------------------
*/
    $('body').on('click', function(event) {
        if( !( $( event.target ).hasClass('edit-btn') ) && $( 'ul.edit-dropdown' ).hasClass('show-menu') ){
            $( 'ul.edit-dropdown' ).removeClass('show-menu');
        }
    });

    $( ".edit-btn" ).on('click', this, function(event) {
        if( $( this ).next('ul.edit-dropdown').hasClass('show-menu') ){
            $( this ).next('ul.edit-dropdown').removeClass('show-menu');
            $( 'ul.edit-dropdown' ).removeClass('show-menu');
        }else{
            $( 'ul.edit-dropdown' ).removeClass('show-menu');
            $( this ).next('ul.edit-dropdown').addClass('show-menu');
        }
        event.stopPropagation();
    });

    $('#reply-dropdown').click(function(event) {
        replyDropReset();
        $('#send-dropdown').css('display', 'block').animate({ marginTop: "2px", opacity: 1},160);
        event.stopPropagation();
    });
    $('#auto-text-pop').click(function(event) {
        replyDropReset();
        $('#macro-pop').css('display', 'block').animate({ marginTop: "2px", opacity: 1},160);
        event.stopPropagation();
    });

    $('body').on('click', function(event) {
        if( !( $(event.target).is('#auto-text-pop') || $(event.target).is('#reply-dropdown') ) )
           replyDropReset(); 
    });

    function replyDropReset(){
       $('#send-dropdown').css({
           display : 'none',
           opacity : '0',
           marginTop: '15px'
       });
       $('#macro-pop').css({
           display : 'none',
           opacity : '0',
           marginTop: '15px'
       });
    }

});

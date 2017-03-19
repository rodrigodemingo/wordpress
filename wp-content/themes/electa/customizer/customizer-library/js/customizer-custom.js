/**
 * Customizer Custom Functionality
 *
 */
( function( $ ) {
    
    $( window ).load( function() {
        
        var kaira_upgrade_button = '<a href="' + upgrade_button.link + '" class="kaira-upgrade-btn" target="_blank">' + upgrade_button.text + '</a><div class="kaira-upgrade-txt">' + upgrade_button.sub_text + '</div>';    
        $( '.preview-notice' ).append( kaira_upgrade_button );
        
    } );
    
} )( jQuery );
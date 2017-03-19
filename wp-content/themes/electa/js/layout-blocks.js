/**
 * Electa Theme Custom Home & Blog Functionality
 *
 */
( function( $ ) {
    
    $(window).load(function() {
        var $container = $('.body-blocks-layout .blocks-wrap');
        
        // initialize
        $container.masonry({
          columnWidth: '.electa-blocks-post',
          itemSelector: '.electa-blocks-post'
        });
        
        // Show layout once Masonry is complete
        $container.masonry( 'on', 'layoutComplete', onBlogGridLayout() );
    });
    
    function onBlogGridLayout() {
        $('.blocks-wrap').removeClass('blocks-wrap-remove');
    }
    
} )( jQuery );
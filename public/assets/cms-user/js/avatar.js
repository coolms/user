
$(function(){
    // Cache the div so that the browser doesn't have to find it every time the window is resized.
    var div = $('.avatar');

    // Run the following when the window is resized, and also trigger it once to begin with.
    $(window).resize(function(){
        div.css({
            'height': div.width() + 'px'
        });
        // Get the current height of the div and save it as a variable.
        var height = div.height();
        // Set the font-size and line-height of the text within the div according to the current height.
        (div.find('.glyphicon') || div.find('.fa')).css({
            'font-size': height + 'px',
            'line-height': height + 'px'
        });
    }).trigger('resize');
});

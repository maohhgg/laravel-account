'use strict';
$(window).on('load', function() {
    // [ Light-toolbar ]
    $('.toolbar').toolbar({
        content: '#toolbar-options',
        style: 'primary',
        event: 'click',
        adjustment: 25,
        hideOnClick: true
    });
});

'use strict';
$(window).on('load', function() {
    $('.toolbar').toolbar({
        content: '#toolbar-options',
        style: 'primary',
        event: 'click',
        adjustment: 25,
        hideOnClick: true
    });

    $('.toolbar').on('toolbarItemClick', function( event , triggerButton ) {
        switch (triggerButton.getAttribute('data-content')) {
            case 'edit':
                window.location.href = this.getAttribute('data-url');
                break;

            case 'push':
                window.location.href = this.getAttribute('data-data-url');
                break;
            case 'delete':
                $('#deleteModalBody').html(this.getAttribute('data-name'));
                $('#deleteModalId').val(this.getAttribute('data-content'));
                $('#deleteModal').modal('show');
                break;
        }
    });
});

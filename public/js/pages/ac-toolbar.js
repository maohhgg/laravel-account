'use strict';
$(window).on('load', function() {
    $('.toolbar').toolbar({
        content: '#toolbar-options',
        style: 'primary',
        event: 'click',
        adjustment: 20,
        hideOnClick: true
    });

    $('.toolbar').on('toolbarItemClick', function( event , triggerButton ) {
        switch (triggerButton.getAttribute('data-content')) {
            case 'edit':
                window.location.href = this.getAttribute('data-url');
                break;
            case 'collect':
                $('#collect-user-id').val(this.getAttribute('data-user-id'));
                $('#collect-user').val(this.getAttribute('data-name'));
                $('#createCollectModal').modal('show');
                break;

            case 'push':
                $('#turnover-user-id').val(this.getAttribute('data-user-id'));
                $('#turnover-user').val(this.getAttribute('data-name'));
                $('#createTurnoverModal').modal('show');
                break;
            case 'delete':
                $('#deleteModalBody').html(this.getAttribute('data-name'));
                $('#deleteModalId').val(this.getAttribute('data-content'));
                $('#deleteModal').modal('show');
                break;
        }
    });
});

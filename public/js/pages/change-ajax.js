$(document).ready(function () {

    $('.updateChangeType').click(function () {
        let id = this.getAttribute('data-type');
        let input = '#changeAction' + id;
        $.post(
            UPDATEURL,
            {'_token': CSRFTOKEN, 'id': id, 'name': $(input).val()}
        ).done(function () {
            window.location.reload();
        });
    });

    $('.deleteChangeType').click(function () {
        let id = this.getAttribute('data-type');
        $.post(
            DELETEURL,
            {'_token': CSRFTOKEN, 'id': id}
        ).done(function () {
            window.location.reload();
        });
    });

    $('button.addChangeType').click(function () {
        $('#change-type-id').val(this.getAttribute('data-type'));
        $('#actionModalLabel').html(this.getAttribute('data-type-name'));
        $('#createActionModal').modal('show');
    });

});

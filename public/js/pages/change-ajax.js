$(document).ready(function () {

    $('.updateChangeType').click(function () {
        let actionId = this.getAttribute('data-action');
        let typeId = this.getAttribute('data-type');
        let input = '#changeAction' + actionId;
        $.post(
            UPDATEURL,
            {'_token': CSRFTOKEN, 'id': actionId, 'change_type_id': typeId, 'name': $(input).val()}
        ).done(function () {
            window.location.reload();
        });
    });

    $('.deleteChangeType').click(function () {
        let actionId = this.getAttribute('data-action');
        $.post(
            DELETEURL,
            {'_token': CSRFTOKEN, 'id': actionId}
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
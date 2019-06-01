$(document).ready(function () {

    $('.updateChangeType').click(function () {
        let actionID = this.getAttribute('data-action');
        let typeID = this.getAttribute('data-type');
        let input = '#changeAction' + actionID;
        $.post(
            UPDATEURL,
            {'_token':CSRFTOKEN, 'id': actionID, 'change_type_id': typeID, 'name': $(input).val()}
        );
    });

    $('.deleteChangeType').click(function () {
        let actionID = this.getAttribute('data-action');
        $.post(
            DELETEURL,
            {'_token':CSRFTOKEN, 'id': actionID}
        );
    });

});
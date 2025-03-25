function close_alert(elem) {
    $(elem).closest('div.my-back-dorp').addClass('d-none');
}
function __delete(self, id) {

    const form = $(self).parent();
    const action = $(form).attr('action')

    $('.myalert form').attr('action', action);

    $('.my-back-dorp-delete').removeClass('d-none');
    $.when($('#confirmDelete').on('click', function () {
        if (id == $(form).find('input[name="id"]').val()) {
            $.ajax({
                type: "get",
                url: action,
                dataType: "json",
                success: function (response) {
                    window.location.assign(response.redirect);
                }
            });
        } else {
            $('.my-back-dorp-delete').addClass('d-none');
        }
    }))
}

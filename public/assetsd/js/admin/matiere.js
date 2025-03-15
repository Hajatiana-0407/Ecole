$(document).ready(function () {
    $('#matier_denomination').focus();

    // ***************** edition  *********************** //
    $(document).on('click', '.edit', function () {
        const id = $(this).data('id');
        if (id > 0) {
            $('.editspinner').removeClass('d-none');
            $('#nom-edit').val("");
            $('#id-edit').val('');
            $.ajax({
                type: "post",
                url: "/parametre/matiere/ajaxdata/" + id,
                dataType: "json",
                success: function (response) {
                    const action = $('.form-edit').attr('action');
                    $('.form-edit').attr('action', action + response.id);

                    /*******champs ********/
                    $('#denomination-edit').focus();
                    $('#denomination-edit').val(response.denomination);
                    $('#abreviation-edit').val(response.abreviation);
                    $('#id-edit').val(response.id);
                    /*******champs ********/
                    $('.editspinner').addClass('d-none');
                }
            });
        }
    })
    // ***************** edition  *********************** //
})
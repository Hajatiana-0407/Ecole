$(document).ready(function () {
    $('#__add_classe').on('click', function () {
        const elem = $(this);
        if ($('#__classe_add_container').hasClass('d-none')) {
            $(elem).remove();
            $('#__classe_add_container').removeClass('d-none');
            $('#niveau_nrb_classe').focus();
        }
    })

    // ***************** edition  *********************** //
    $(document).on('click', '.edit', function () {
        const id = $(this).data('id');
        if (id > 0) {
            $('.editspinner').removeClass('d-none')  ; 
            $('#nom-edit').val("");
            $('#id-edit').val('');
            $.ajax({
                type: "post",
                url: "/parametre/niveau/ajaxdata/" + id,
                dataType: "json",
                success: function (response) {
                    const action = $('.form-edit').attr('action') ; 
                     $('.form-edit').attr('action' , action + response.id ) ; 
                    $('#nom-edit').val(response.nom);
                    $('#nom-edit').focus();
                    $('#id-edit').val(response.id);
                    $('.editspinner').addClass('d-none')  ; 
                }
            });
        }
    })
    // ***************** edition  *********************** //

})
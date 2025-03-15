function __delete(self ,id ) {
    $('.my-back-dorp-delete').removeClass('d-none');
    $.when( $('#confirmDelete').on('click', function () {
        
        const form = $( self ).parent() ; 
        const action = $( form ).attr('action')
        if (  id == $(form).find('input[name="id"]').val()){
            $.ajax({
                type: "get",
                url: action  ,
                dataType: "json",
                success: function (response) {
                    window.location.assign(response.redirect); 
                }
            });
        }else {
            $('.my-back-dorp-delete').addClass('d-none');
        }
    }))
}
$( document ).ready( function (){
    $('#__add_classe').on('click' , function (){
        const elem = $( this ) ; 
        if ( $('#__classe_add_container').hasClass('d-none') ){
            $(elem ).remove() ; 
            $('#__classe_add_container').removeClass('d-none') ; 
            $('#niveau_nrb_classe').focus() ; 
        }
    })
})
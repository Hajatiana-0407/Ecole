function hidde_sidebar() {
    const elem_hidde = $('.attribut-to-hidde');
    $(elem_hidde).removeClass('attribut-to-hidde');
    $(elem_hidde).addClass('attribut-to-show');
    $('.attribute-menu').css({
        display: 'none'
    });
    $('.sidebare').animate({
        width: '46px'
    }, 250)
    $('.corps , .head').animate({
        paddingLeft: '53px'
    }, 250)
}
function show_sidebar() {
    const elem_hidde = $('.attribut-to-show');
    $(elem_hidde).removeClass('attribut-to-show');
    $(elem_hidde).addClass('attribut-to-hidde');

    $('.sidebare').animate({
        width: '220px'
    }, 250)
    $('.corps , .head ').animate({
        paddingLeft: '240px'
    }, 250, function () {
        $('.attribute-menu').css({
            display: 'inline-block'
        });
    })
}

$(window).resize(function () {
    if ($(window).width() < 996) {
        const elem_hidde = $('.attribut-to-hidde');
        $(elem_hidde).removeClass('attribut-to-hidde');
        $(elem_hidde).addClass('attribut-to-show');
    } else {
        const elem_hidde = $('.attribut-to-show');
        $(elem_hidde).removeClass('attribut-to-show');
        $(elem_hidde).addClass('attribut-to-hidde');
    }
});

$(document).ready(function () {
    if (document.querySelector(".ui.dropdown")) {
        $('.ui.dropdown').dropdown();
    }

    /** side bare animation */
    $(document).on('click', '#hide-show-menu', function () {
        const element = $('.sidebare');

        if ($(element).width() > 200) {
            hidde_sidebar();
        } else {
            show_sidebar();
        }
    })

    /** user info animation  */
    $(document).on('click', '.user-info-container', function (e) {
        e.stopPropagation();
        const element = $('.user-info-liste');
        const position = $(element).position().top;

        if (position == -200) {
            $('.user-info-liste-li').removeClass('d-none');
            $(element).animate({
                top: '50px'
            }, 250);
        } else {
            $('.user-info-liste-li').addClass('d-none');
            $(element).animate({
                top: '-200px'
            }, 300);
        }
    })

    $(document).click(function (event) {
        if (!$(event.target).closest('.user-info-container').length && !$(event.target).closest('.user-info-liste-li').length) {
            $('.user-info-liste-li').addClass('d-none');
            const element = $('.user-info-liste');
            $(element).animate({
                top: '-200px'
            }, 300);
        }
    });

    // $(document).on("click", "a, button[type='submit'], input[type='submit'] , #confirmDelete", function () {
    //     let href = $(this).attr("href");

    //     // Vérifier si l'élément est un lien et que son href n'est pas vide ou "#"
    //     if ($(this).is("a") && (!href || href === "#")) {
    //         return; // Ne fait rien si href est vide ou "#"
    //     }
    //     $('.loader-spinner').removeClass('d-none') ; 
    // });


    $(document).on('click', '.container_image', function () {
        const id = $(this).data('id');
        $('div#' + id + ' input[type="file"]').click();


        $(document).on('change', 'div#' + id + ' input[type="file"]', function (event) {
            var file = event.target.files[0];  // Récupérer le premier fichier sélectionné

            if (file) {
                var reader = new FileReader();  // Créer un lecteur de fichiers


                var fileType = file.type;
                var validImageTypes = ["image/jpeg", "image/png"];

                if (!validImageTypes.includes(fileType)) {
                    return; // Sortir de la fonction si le fichier n'est pas une image
                }

                // Lorsque le fichier est chargé, mettre à jour l'image
                reader.onload = function (e) {
                    $('.container_image img').css({
                        'border': '1px solid rgb(135, 135, 135)',
                        'padding': '10px',
                    })
                    $('.container_image img').attr('src', e.target.result);  // Mettre à jour l'attribut src de l'image
                };

                // Lire le fichier comme une URL de données
                reader.readAsDataURL(file);
            }
        });
    })


})
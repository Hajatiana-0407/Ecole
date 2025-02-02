$(document).ready(function () {

    /** side bare animation */
    $(document).on('click', '#hide-show-menu', function () {
        const element = $('.sidebare');

        if ($(element).width() > 230) {
            const elem_hidde = $('.attribut-to-hidde');
            $(elem_hidde).removeClass('attribut-to-hidde');
            $(elem_hidde).addClass('attribut-to-show');

            $('.attribute-menu').addClass('d-none');
            $('.sidebare').animate({
                width: '46px'
            }, 250)
            $('.corps').animate({
                paddingLeft: '53px'
            }, 250)
        } else {

            const elem_hidde = $('.attribut-to-show');
            $(elem_hidde).removeClass('attribut-to-show');
            $(elem_hidde).addClass('attribut-to-hidde');

            $('.sidebare').animate({
                width: '250px'
            }, 250)
            $('.corps').animate({
                paddingLeft: '260px'
            }, 250, function () {
                $('.attribute-menu').removeClass('d-none');
            })
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
            }, 250)
        } else {
            $('.user-info-liste-li').addClass('d-none');
            $(element).animate({
                top: '-200px'
            }, 300)
        }
    })

    $(document).click(function (event) {
        if (!$(event.target).closest('.user-info-container').length && !$(event.target).closest('.user-info-liste-li').length) {
            $('.user-info-liste-li').addClass('d-none');
            const element = $('.user-info-liste');
            $(element).animate({
                top: '-200px'
            }, 300)
        }
    });
})
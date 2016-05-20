$(function () {

    $('#login').click(function () {
        $('.upload-popup').hide();

        if ($('.login-popup').css('display') === 'none') {
            $('.login-popup').fadeIn();
            $('.mask').fadeIn();
        }
        else {
            $('.login-popup').fadeOut();
            $('.mask').fadeOut();
        }
    });

    $('.mask').click(function () {

        $('.login-popup').fadeOut();
        $('.mask').fadeOut();
    });

});


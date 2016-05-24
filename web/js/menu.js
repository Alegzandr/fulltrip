$(function () {
    function open() {
        $('.mask').fadeIn();
        $('header, footer, main').animate({
            marginLeft: '250px'
        }, 200);
        $('.mask').css('margin-left', '250px');
        $('nav').animate({
            left: '0'
        }, 200);

        $('nav').attr('id', 'open');
    }
    function close() {
        $('header, main, footer').animate({
            marginLeft: '0'
        });
        $('nav').animate({
            left: '-250'
        }, 200);

        $('.mask').css('display', 'none');

        $('nav').removeAttr('id');
    }

    $('.menu-icon').click(function () {
        if ($('nav').is('#open')) {
            close();
        } else {
            open();
        }
    });

    $('.mask').click(function () {
        if ($('nav').is('#open')) {
            close();
        }
    });

    $('nav > ul > li > a').click(function () {
        if ($('nav').is('#open')) {
            close();
        }
    });
});

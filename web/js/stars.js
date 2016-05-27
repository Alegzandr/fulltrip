$(function () {
    var labels = $('.label-stars');

    $('input[type="radio"]').css('display', 'none');
    labels.css('cursor', 'pointer');

    labels.click(function () {
        labels.html('<i class="fa fa-star-o" aria-hidden="true"></i>');

        var count = parseInt($(this).attr('for').slice(-1)) + 1;
        for (var i = 0; i < count; i++) {
            $('.label-stars:eq(' + i + ')').html('<i class="fa fa-star" aria-hidden="true"></i>');
        }
    });

    var star = '<i class="fa fa-star" aria-hidden="true"></i>';
    for (var j = 0; j < $('.stars').length; j++) {
        var len = parseInt($('.stars:eq(' + j + ')').html());
        $('.stars:eq(' + j + ')').html(star.repeat(len));
    }

});

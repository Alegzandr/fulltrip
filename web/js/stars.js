$(function () {
    var labels = $('.label-stars');
    var star = '<i class="fa fa-star" aria-hidden="true"></i>';
    var halfStar = '<i class="fa fa-star-half-o" aria-hidden="true"></i>';
    var emptyStar = '<i class="fa fa-star-o" aria-hidden="true"></i>';

    $('input[type="radio"]').css('display', 'none');
    labels.css('cursor', 'pointer');

    labels.click(function () {
        labels.html('<i class="fa fa-star-o" aria-hidden="true"></i>');

        var count = parseInt($(this).attr('for').slice(-1)) + 1;
        for (var i = 0; i < count; i++) {
            $('.label-stars:eq(' + i + ')').html('<i class="fa fa-star" aria-hidden="true"></i>');
        }
    });

    for (var j = 0; j < $('.stars').length; j++) {
        var len = parseInt($('.stars:eq(' + j + ')').html());
        $('.stars:eq(' + j + ')').html(star.repeat(len));
        $('.stars:eq(' + j + ')').append(emptyStar.repeat(5 - len));
    }

    switch (parseFloat($('.average-stars').html())) {
        case 0.5:
            $('.average-stars').html(halfStar + emptyStar.repeat(2));
            break;
        case 1:
            $('.average-stars').html(star + emptyStar.repeat(2));
            break;
        case 1.5:
            $('.average-stars').html(star + halfStar + emptyStar);
            break;
        case 2:
            $('.average-stars').html(star.repeat(2) + emptyStar);
            break;
        case 2.5:
            $('.average-stars').html(star.repeat(2) + halfStar);
            break;
        case 3:
            $('.average-stars').html(star.repeat(3));
            break;
    }
});

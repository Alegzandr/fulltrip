$(function () {
    $('a.add').click(function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('href'),
            type: 'get',
            dataType: 'json',
            success: function (data) {
                console.log(data);
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
});

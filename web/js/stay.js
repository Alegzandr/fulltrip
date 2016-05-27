$(function () {
    
    
    $('a.add').click(function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('href'),
            type: 'get',
            dataType: 'json',
            success: function (data) {
                $('.stay tbody').append(data.places);
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
});

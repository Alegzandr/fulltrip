$(function () {
    $('form[name="fos_user_login_form"]').submit(function () {
        $('.loading').show();
        $('.error').html('');
        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function (data) {
                $('.loading').hide();
                window.open("/", "_self");
            },
            error: function (data) {
                $('.loading').hide();
                var response;
                if (data.responseText == '"Bad credentials.') {
                }
                response = "Mauvais identifiants.";
                $('.error').html(response);
            }

        });
        return false;
    });
});

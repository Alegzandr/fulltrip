$(function () {
    $('input[type="search"]').autocomplete({
        source: function (request, response) {
            $.get("/autocomplete", {
                query: request.term
            }, function (data) {
                response(JSON.parse(data));
            });
        },
        minLength: 3,
        messages: {
            noResults: '',
            results: function() {}
        }
    });
});

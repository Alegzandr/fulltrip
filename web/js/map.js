function initMap() {
    var geocoder = new google.maps.Geocoder();
    var address = document.getElementsByClassName('city')[0].value;
    var mapOptions = {
        mapTypeId: google.maps.MapTypeId.SATELLITE,
        center: new google.maps.LatLng(54.00, -3.00),
        zoom: 15
    };
    var map = new google.maps.Map(document.getElementById("map"), mapOptions);
    geocoder.geocode({'address': address}, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            result = results[0].geometry.location;
            console.log(result);

            map.setCenter(result);

            var marker = new google.maps.Marker({
                map: map,
                position: result
            });
        }
    });
}
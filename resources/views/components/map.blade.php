<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6AZeqOMNJVUWhNHjclBF5uVuJnjdpxPM&callback=initMap"
    async
    defer></script>

<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: 9.007, // Adjusted latitude (lower value)
                lng: 125.66, // Adjusted longitude (left value)
            },
            zoom: 14,
            mapTypeId: "hybrid",
        });

        var marker = new google.maps.Marker({
            position: {
                lat: 9.026,
                lng: 125.665,
            },
            map: map,
            draggable: true,
        });

        var polygonCoords = [{
                lat: 9.009383,
                lng: 125.650838,
            },
            {
                lat: 9.012476,
                lng: 125.652721,
            },
            {
                lat: 9.01249,
                lng: 125.654012,
            },
            {
                lat: 9.011155,
                lng: 125.654377,
            },
            {
                lat: 9.010646,
                lng: 125.654935,
            },
            {
                lat: 9.010837,
                lng: 125.656179,
            },
            {
                lat: 9.012342,
                lng: 125.658003,
            },
            {
                lat: 9.012427,
                lng: 125.658561,
            },
            {
                lat: 9.01177,
                lng: 125.659291,
            },
            {
                lat: 9.011473,
                lng: 125.661565,
            },
            {
                lat: 9.025651,
                lng: 125.661585,
            },
            {
                lat: 9.025736,
                lng: 125.646865,
            },
            {
                lat: 9.011621,
                lng: 125.647294,
            },
            {
                lat: 9.01107,
                lng: 125.648625,
            },
            {
                lat: 9.009383,
                lng: 125.650838,
            },
        ];

        var polygon = new google.maps.Polygon({
            paths: polygonCoords,
            strokeColor: "#DAF7A6",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#f3fae6",
            fillOpacity: 0.35,
        });
        polygon.setMap(map);

        // Create an InfoWindow
        var infoWindow = new google.maps.InfoWindow();

        // Function to update the InfoWindow content
        function updateInfoWindow(lat, lng) {
            infoWindow.setContent("Latitude: " + lat + "<br>Longitude: " + lng);
            infoWindow.setPosition(new google.maps.LatLng(lat, lng));
            infoWindow.open(map, marker);
        }

        // Set the initial position of the InfoWindow
        updateInfoWindow(marker.getPosition().lat(), marker.getPosition().lng());

        // Update InfoWindow when marker is dragged
        google.maps.event.addListener(marker, "dragend", function(evt) {
            var lat = evt.latLng.lat().toFixed(4);
            var lng = evt.latLng.lng().toFixed(4);
            marker.setPosition(evt.latLng); // Update marker position
            updateInfoWindow(lat, lng); // Update InfoWindow with new position
        });

        // Update InfoWindow when the map is clicked
        google.maps.event.addListener(map, "click", function(evt) {
            marker.setPosition(evt.latLng); // Move marker to click location
            var lat = evt.latLng.lat().toFixed(4);
            var lng = evt.latLng.lng().toFixed(4);
            updateInfoWindow(lat, lng); // Update InfoWindow with new position
        });
    }
</script>
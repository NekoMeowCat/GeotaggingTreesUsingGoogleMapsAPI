<x-filament-widgets::widget>
    <div class="w-full bg-white shadow rounded-lg p-6 h-72">
        <!-- Your custom map widget content -->
        <h1 class="text-xl font-bold">Map Widget</h1>
        <div id="map" class="h-96 border"></div>
    </div>

    <script>
        // Function to initialize the map
        function initMap() {
            const myLatLng = { lat: 9.0197, lng: 125.6598 };
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: myLatLng,
                mapTypeId: 'satellite',
            });
        }

        window.initMap = initMap;
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6AZeqOMNJVUWhNHjclBF5uVuJnjdpxPM&libraries=places&callback=initMap&v=weekly" async defer></script>
</x-filament-widgets::widget>

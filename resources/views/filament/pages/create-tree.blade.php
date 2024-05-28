<x-filament-panels::page>
    <div id="map" class="min-h-screen"></div>

    <x-filament-panels::form wire:submit.prevent="submitForm">
        {{ $this->form }}

        <x-filament-panels::form.actions 
            :actions="$this->getFormActions()"
        /> 
    </x-filament-panels::form>

    <script>
    function initMap() {
        const myLatLng = { lat: 9.0197, lng: 125.6598 };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 14,
            center: myLatLng,
            mapTypeId: 'satellite',
        });

        const infoWindow = new google.maps.InfoWindow();

        map.addListener("click", (mapsMouseEvent) => {
            const latLng = mapsMouseEvent.latLng;
            const formattedLat = latLng.lat().toFixed(4);
            const formattedLng = latLng.lng().toFixed(4);

            infoWindow.setContent(`<article class="font-medium">Latitude: ${formattedLat}<br>Longitude: ${formattedLng}</article>`);
            infoWindow.setPosition(latLng);
            infoWindow.open(map);
        });
    }

    window.initMap = initMap;
</script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6AZeqOMNJVUWhNHjclBF5uVuJnjdpxPM&libraries=places&callback=initMap&v=weekly" async defer></script>
</x-filament-panels::page>

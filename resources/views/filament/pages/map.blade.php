<div>
    <x-filament-panels::page>
        <div id="map" class="min-h-screen"></div>
        <x-location-modal />

        <!-- Assuming $trees contains the necessary data including tree_name, area, and image_url -->
        
        <div class="hidden">
            @foreach($trees as $tree)
                <div>
                    <h3>{{ $tree->tree_name }}</h3>
                    <p>Area: {{ $tree->area->name }}</p>
                    <img src="{{ asset('storage/' . $tree->tree_image) }}" alt="{{ $tree->tree_name }}">
                </div>
            @endforeach
        </div>
        
        <script>
            let marker;

            // Function to initialize the map
            function initMap() {
                const myLatLng = { lat: 9.0197, lng: 125.6598 };
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 14,
                    center: myLatLng,
                    mapTypeId: 'satellite',
                });

                // Dynamically adding markers based on the tree data
                const trees = {!! json_encode($trees) !!};
                trees.forEach(tree => {
                    const marker = new google.maps.Marker({
                        position: { lat: parseFloat(tree.latitude), lng: parseFloat(tree.longitude) }, 
                        map: map,
                        animation: google.maps.Animation.DROP,
                    });

                    // Adding a click listener to toggle the bounce animation
                    marker.addListener("click", () => {
                        toggleBounce(marker);
                    });

                    // Create an InfoWindow for each marker
                    const infoWindowContent = `
                        <div class="flex justify-center mb-2">
                            <article class="text-lg font-bold text-green-700">
                                ${tree.tree_name}
                            </article>
                        </div>
                        <div>
                            <img class="rounded-md h-12 w-full object-center" src="{{ asset('storage/' . $tree->tree_image) }}" alt="{{ $tree->tree_name }}">
                        </div>
                        <div class="pt-4">
                            <article class="flex justify-between">
                                <article class="text-lg font-bold">${tree.area.name}</article>
                                <article class="text-lg font-bold">${tree.classification.name}</article>
                            </article>
                        </div>
                        <div class="py-6">
                            <p>${tree.tree_description}</p>
                        </div>
                    `;
                    const infoWindow = new google.maps.InfoWindow({
                        content: infoWindowContent,
                    });

                    // Open the InfoWindow when the marker is clicked
                    marker.addListener('click', () => {
                        infoWindow.open(map, marker);
                    });
                });

                // Event listeners for map interactions
                map.addListener("click", (mapsMouseEvent) => {
                    const latLng = mapsMouseEvent.latLng;
                    const formattedLat = latLng.lat().toFixed(4);
                    const formattedLng = latLng.lng().toFixed(4);

                    document.getElementById('latitude').value = formattedLat;
                    document.getElementById('longitude').value = formattedLng;

                    document.getElementById('mapModal').classList.remove('hidden');
                });

                document.getElementById('closeModal').addEventListener('click', () => {
                    document.getElementById('mapModal').classList.add('hidden');
                });

                document.getElementById('closeModalFooter').addEventListener('click', () => {
                    document.getElementById('mapModal').classList.add('hidden');
                });

                document.getElementById('locationForm').addEventListener('submit', (event) => {
                    event.preventDefault();

                    const latitude = document.getElementById('latitude').value;
                    const longitude = document.getElementById('longitude').value;

                    marker = new google.maps.Marker({
                        position: { lat: parseFloat(latitude), lng: parseFloat(longitude) },
                        map: map,
                        animation: google.maps.Animation.DROP,
                    });

                    // Adding a click listener to toggle the bounce animation
                    marker.addListener("click", () => {
                        toggleBounce(marker);
                    });

                    document.getElementById('mapModal').classList.add('hidden');
                });
            }

            function toggleBounce(marker) {
                if (marker.getAnimation() !== null) {
                    marker.setAnimation(null);
                } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                }
            }

            window.initMap = initMap;
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6AZeqOMNJVUWhNHjclBF5uVuJnjdpxPM&libraries=places&callback=initMap&v=weekly" async defer></script>
    </x-filament-panels::page>
</div>

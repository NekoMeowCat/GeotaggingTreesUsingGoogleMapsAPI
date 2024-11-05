<div>
    @vite(['resources/css/app.css'])
    <x-filament-panels::page>
        <p class="capitalize text-red-600 font-bold">legend</p>
        <div class="grid grid-cols-5 grid-flow-col gap-1">
            <div class="rounded-md">
                <div class="flex justify-center">Area 1</div>
                <div class="rounded-md w-full flex justify-center">
                    <div class="bg-[#DAF7A6] w-full rounded-sm flex justify-center">2</div>
                </div>
            </div>
            <div class="rounded-md">
                <div class="flex justify-center">Area 2</div>
                <div class="rounded-md w-full flex justify-center">
                    <div class="bg-[#FFC300] w-full rounded-sm flex justify-center">2</div>
                </div>
            </div>
            <div class="rounded-md">
                <div class="flex justify-center">Area 3</div>
                <div class="rounded-md w-full flex justify-center">
                    <div class="bg-[#FF5733] w-full rounded-sm flex justify-center">2</div>
                </div>
            </div>
            <div class="rounded-md">
                <div class="flex justify-center">Area 4</div>
                <div class="rounded-md w-full flex justify-center">
                    <div class="bg-[#C70039] w-full rounded-sm flex justify-center">2</div>
                </div>
            </div>
            <div class="rounded-md">
                <div class="flex justify-center">Area 5</div>
                <div class="rounded-md w-full flex justify-center">
                    <div class="bg-[#900C3F] w-full rounded-sm flex justify-center">2</div>
                </div>
            </div>
        </div>
        <div id="map" class="min-h-screen"></div>
        <x-location-modal />

        <!-- Display the trees data -->
        <div class="hidden">
            @foreach($trees as $tree)
            <div>
                <h3>{{ $tree->tree_name }}</h3>
                <p>Area: {{ $tree->area->name }}</p>
                <img src="{{ asset('storage/' . $tree->tree_image) }}" alt="{{ $tree->tree_name }}">
                <h1>{{ $tree->latitude}}</h1>
                <h1>{{ $tree->longitude}}</h1>
            </div>
            @endforeach
        </div>

        <script>
            let marker;

            // Function to initialize the map
            // Function to initialize the map
            function initMap() {
                const myLatLng = {
                    lat: 9.0197,
                    lng: 125.6598
                };
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 14,
                    center: myLatLng,
                    mapTypeId: 'hybrid',
                });

                const polygonCoordinates = [ /*...your polygon coordinates...*/ ];

                // Create the polygon and set its properties
                const polygon = new google.maps.Polygon({
                    paths: polygonCoordinates,
                    strokeColor: '#DAF7A6',
                    strokeOpacity: 0.8,
                    strokeWeight: 1,
                    fillColor: '#C70039',
                    fillOpacity: 0.35
                });

                // Add the polygon to the map
                polygon.setMap(map);

                // Define area colors
                const areaColors = {
                    "Area 1": "#DAF7A6", // Light green
                    "Area 2": "#FFC300", // Yellow
                    "Area 3": "#FF5733", // Orange
                    "Area 4": "#C70039", // Red
                    "Area 5": "#900C3F", // Dark Red
                };

                // Base URL for image assets
                const baseImageUrl = '/storage/';

                // Dynamically adding markers based on the tree data
                const trees = @json($trees); // Correct JSON encoding
                trees.forEach(tree => {
                    const areaColor = areaColors[tree.area.name] || "#000000"; // Default to black if no match

                    // Create custom marker icon using SVG with the area's color
                    const markerIcon = {
                        path: "M12 2C8.13 2 5 5.13 5 9c0 4.25 4.84 9.77 6.45 11.58a1 1 0 0 0 1.1 0C14.16 18.77 19 13.25 19 9c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z",
                        fillColor: areaColor,
                        fillOpacity: 1,
                        strokeWeight: 1,
                        strokeColor: '#000000',
                        scale: 2,
                        anchor: new google.maps.Point(12, 24)
                    };

                    const marker = new google.maps.Marker({
                        position: {
                            lat: parseFloat(tree.latitude),
                            lng: parseFloat(tree.longitude)
                        },
                        map: map,
                        icon: markerIcon, // Use custom icon
                        animation: google.maps.Animation.DROP,
                    });

                    const infoWindowContent = `
            <section class="w-[25rem]">
                <div class="flex justify-center mb-2">
                    <article class="flex justify-center capitalize text-xl font-bold text-black">
                        ${tree.tree_name}
                    </article>
                </div>
                <div class="pt-4">
                    <article class="flex justify-between">
                        <div class="text-lg font-medium">${tree.area.name}</div>
                        <div class="text-lg font-medium">${tree.classification.name}</div>
                    </article>
                    <article class="">
                        <img src="${baseImageUrl}${tree.tree_image}" alt="${tree.tree_name} Image" class="w-full h-64">
                    </article>
                </div>
                <article class="py-6">
                    <div class="text-pretty leading-relaxed">${tree.tree_description}</div>
                </article>                       
            </section>
        `;
                    const infoWindow = new google.maps.InfoWindow({
                        content: infoWindowContent,
                    });

                    marker.addListener('click', () => {
                        infoWindow.open(map, marker);
                    });
                });

                // Event listeners for map interactions
            }

            window.initMap = initMap;
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6AZeqOMNJVUWhNHjclBF5uVuJnjdpxPM&libraries=places&callback=initMap&v=weekly" async defer></script>
    </x-filament-panels::page>
</div>
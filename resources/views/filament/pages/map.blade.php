<div>
    @vite(['resources/css/app.css'])
    <x-filament-panels::page>
        <p class="capitalize text-red-600 font-bold">Legend</p>
        <div class="grid grid-cols-5 gap-1">
            @foreach ($trees->groupBy('area.name') as $areaName => $areaTrees)
            <div x-data="{ open: false }" class="rounded-md border">
                <!-- Click to toggle accordion and filter map markers for multiple areas -->
                <div @click="open = !open; toggleArea('{{ $areaName }}')"
                    class="cursor-pointer flex justify-center bg-gray-200 p-1">
                    {{ $areaName }}
                </div>
                <div x-show="open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                    class="rounded-md w-full">
                    @foreach ($areaTrees as $tree)
                    <ul class="flex justify-between items-center p-1 border rounded">
                        <li class="text-sm font-bold">{{ $tree->tree_name }}</li>
                        <li class="text-sm text-gray-600">{{ $tree->classification->name }}</li>
                    </ul>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>



        <!-- Map container -->
        <div id="map" class="min-h-screen"></div>
        <x-location-modal />

        <script>
            let map;
            let markers = [];
            let openAreas = []; // Track open areas

            function initMap() {
                const myLatLng = {
                    lat: 9.0197,
                    lng: 125.6598
                };
                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 14,
                    center: myLatLng,
                    mapTypeId: 'hybrid',
                });

                // Define area colors
                const areaColors = {
                    "Area 1": "#DAF7A6",
                    "Area 2": "#FFC300",
                    "Area 3": "#05C793",
                    "Area 4": "#C70039",
                    "Area 5": "#900C3F",
                };

                const baseImageUrl = '/storage/';

                // Add markers based on tree data
                const trees = @json($trees);
                trees.forEach(tree => {
                    const areaColor = areaColors[tree.area.name] || "#05C793";
                    const markerIcon = {
                        path: "M12 2C8.13 2 5 5.13 5 9c0 4.25 4.84 9.77 6.45 11.58a1 1 0 0 0 1.1 0C14.16 18.77 19 13.25 19 9c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z",
                        fillColor: areaColor,
                        fillOpacity: 1,
                        strokeWeight: 1,
                        strokeColor: '#000000',
                        scale: 1,
                        anchor: new google.maps.Point(12, 24)
                    };

                    const marker = new google.maps.Marker({
                        position: {
                            lat: parseFloat(tree.latitude),
                            lng: parseFloat(tree.longitude)
                        },
                        map: map,
                        icon: markerIcon,
                        animation: google.maps.Animation.DROP,
                        title: tree.tree_name,
                        area: tree.area.name // Area name to filter by
                    });
                    markers.push(marker);

                    function getStatusClass(status) {
                        switch (status) {
                            case 'Healthy':
                                return 'bg-green-400 border-2 border-green-500';
                            case 'Diseased':
                                return 'bg-red-400 border-2 border-red-500';
                            case 'For Replacement':
                                return 'bg-gray-400 border-2 border-gray-500';
                            default:
                                return 'bg-gray-400';
                        }
                    }

                    // const infoWindowContent = `
                    //     <section class="w-[25rem]">
                    //         <div class="flex justify-center mb-2">
                    //             <article class="flex justify-center capitalize text-xl font-bold text-black">
                    //                 ${tree.tree_name}
                    //             </article>
                    //         </div>
                    //         <div class="pt-4">
                    //             <article class="flex justify-between">
                    //                 <div class="text-lg font-medium">${tree.area.name}</div>
                    //                 <div class="text-lg font-medium">${tree.classification.name}</div>
                    //             </article>
                    //             <article class="">
                    //                 <img src="${baseImageUrl}${tree.tree_image}" alt="${tree.tree_name} Image" class="w-full h-64">
                    //             </article>
                    //         </div>
                    //         <article class="py-6">
                    //             <div class="text-pretty leading-relaxed">${tree.tree_description}</div>
                    //         </article>                       
                    //     </section>
                    // `;
                    const infoWindowContent = `
                        <article class="h-auto w-[25rem] rounded-lg bg-white shadow-lg">
                            <div class="block rounded-lg h-auto w-full">
                                <span class="">
                                    <img src="${baseImageUrl}${tree.tree_image}" alt="${tree.tree_name} Image" class="h-[20rem] w-full rounded-lg">
                                </span>
                                <div class="flex justify-between  py-3">
                                    <span class="font-bold text-lg tracking-tight font-inter capitalize flex items-center">${tree.tree_name}</span>
                                    <span class="rounded-xl text-white text-sm px-4 tracking-tight capitalize flex items-center ${getStatusClass(tree.tree_status)}">
                                        ${tree.tree_status}
                                    </span>
                                </div>
                                <div class="flex space-x-2">
                                    <div class="flex w-full items-center font-inter tracking-tight">
                                        <span>
                                            <img src="{{ asset('storage/images/pin.png') }}" alt="" class="h-5 w-5">
                                        </span>
                                        <span class="text-gray-600 text-sm">${tree.area.name}</span>
                                    </div>
                                    <span class="flex w-full items-center font-inter tracking-tight">
                                        <span>
                                            <img src="{{ asset('storage/images/gps.png') }}" alt="" class="h-5 w-5">
                                        </span>
                                        <span class="text-gray-600 text-sm">${tree.latitude}</span>
                                    </span>
                                    <span class="flex w-full items-center font-inter tracking-tight">
                                        <span>
                                            <img src="{{ asset('storage/images/gps.png') }}" alt="" class="h-5 w-5">
                                        </span>
                                        <span class="text-gray-600 text-sm">${tree.longitude}</span>
                                    </span>
                                </div>
                                <div class="py-3 ">
                                    <span class="font-inter text-sm font-bold tracking-tight">Description</span>
                                </div>
                                <div class="">
                                    <span class="text-justify tracking-tight text-sm text-gray-600">${tree.tree_description}</span>
                                </div>
                            </div>
                        </article>                    
                    `;
                    const infoWindow = new google.maps.InfoWindow({
                        content: infoWindowContent
                    });
                    marker.addListener('click', () => {
                        infoWindow.open(map, marker);
                    });
                });
            }

            // Toggle area in openAreas array and update markers accordingly
            function toggleArea(areaName) {
                const areaIndex = openAreas.indexOf(areaName);
                if (areaIndex > -1) {
                    // Remove area if already open
                    openAreas.splice(areaIndex, 1);
                } else {
                    // Add area if not already open
                    openAreas.push(areaName);
                }
                filterMarkers();
            }

            // Show markers for all open areas
            function filterMarkers() {
                // Hide all markers first
                markers.forEach(marker => {
                    marker.setMap(null);
                });

                // Show markers for each area in openAreas
                markers.forEach(marker => {
                    if (openAreas.includes(marker.area)) {
                        marker.setMap(map);
                    }
                });
            }

            window.initMap = initMap;
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6AZeqOMNJVUWhNHjclBF5uVuJnjdpxPM&callback=initMap" async defer></script>
    </x-filament-panels::page>
</div>
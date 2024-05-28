<div id="mapModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg overflow-hidden w-1/3">
        <div class="px-4 py-2 border-b flex justify-between items-center">
            <h2 class="text-xl">Location Coordinates</h2>
            <button id="closeModal" class="text-red-500">&times;</button>
        </div>
        <div class="p-4">
            <form id="locationForm">
                <div class="mb-4">
                    <label for="latitude" class="block text-gray-700">Latitude:</label>
                    <input type="text" id="latitude" class="w-full p-2 border rounded" readonly>
                </div>
                <div class="mb-4">
                    <label for="longitude" class="block text-gray-700">Longitude:</label>
                    <input type="text" id="longitude" class="w-full p-2 border rounded" readonly>
                </div>
                <div class="flex justify-end">
                    <button id="closeModalFooter" class="bg-blue-500 text-white px-4 py-2 rounded">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

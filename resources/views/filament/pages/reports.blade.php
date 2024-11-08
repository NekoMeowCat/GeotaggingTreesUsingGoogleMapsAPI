<x-filament-panels::page>
    @vite('resources/css/app.css')
    <div class="flex justify-end mb-4">
        <button onclick="printTable()" class="relative inline-flex items-center px-12 py-3 overflow-hidden text-base font-medium text-indigo-600 border-2 border-indigo-600 rounded-md hover:text-white group hover:bg-gray-50">
            <span class="absolute left-0 block w-full h-0 transition-all bg-indigo-600 opacity-100 group-hover:h-full top-1/2 group-hover:top-0 duration-400 ease"></span>
            <span class="absolute right-0 flex items-center justify-start w-10 h-10 duration-300 transform translate-x-full group-hover:translate-x-0 ease">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </span>
            <span class="relative">Print</span>
        </button>
    </div>
    <main class="" id="printableTable">
        <header class="mb-4">
            {{ config('app.name') }}
        </header>

        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse border border-gray-300 table-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border border-gray-300">Tree Name</th>
                        <th class="px-4 py-2 border border-gray-300">Description</th>
                        <th class="px-4 py-2 border border-gray-300">Status</th>
                        <th class="px-4 py-2 border border-gray-300">Date Planted</th>
                        <th class="px-4 py-2 border border-gray-300">Coordinates</th>
                        <th class="px-4 py-2 border border-gray-300">Area</th>
                        <th class="px-4 py-2 border border-gray-300">Classification</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($treeData as $tree)
                    <tr class="text-sm">
                        <td class="px-4 py-2 border border-gray-300">{{ $tree->tree_name }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $tree->tree_description }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $tree->tree_status }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $tree->date_planted->format('F j, Y') }}</td>
                        <td class="px-4 py-2 border border-gray-300">
                            Latitude: {{ $tree->latitude }}, Longitude: {{ $tree->longitude }}
                        </td>
                        <td class="px-4 py-2 border border-gray-300">
                            {{ optional($tree->area)->name ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-2 border border-gray-300">
                            {{ optional($tree->classification)->name ?? 'N/A' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <script>
        function printTable() {
            const tableContent = document.getElementById('printableTable').innerHTML;
            const originalContent = document.body.innerHTML;

            document.body.innerHTML = tableContent;
            window.print();
            document.body.innerHTML = originalContent;
        }
    </script>
</x-filament-panels::page>
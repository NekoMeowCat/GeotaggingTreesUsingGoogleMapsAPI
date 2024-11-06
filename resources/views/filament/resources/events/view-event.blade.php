<x-filament::page>
    @vite(['resources/css/app.css'])
    <main class="min-h-screen min-w-full bg-white rounded-md p-2">
        <section class="flex flex-col items-center h-auto font-bona font-bold tracking-tighter mt-5">
            <span class="text-8xl">{{ $record->event_title }}</span>
            <span class="text-3xl font-lora text-gray-700">{{ \Carbon\Carbon::parse($record->date)->format('F j, Y') }}</span>
        </section>
        <section class="flex justify-center p-10">
            <img src="{{ asset('storage/' . $record->image) }}" alt="{{ $record->image }}" class="w-full rounded-md">
        </section>
        <section class="px-10">
            <span class="text-justify font-inter text-lg tracking-tight">
                {!! str($record->event_description)->sanitizeHtml() !!}
            </span>
        </section>
        <span></span>
    </main>
</x-filament::page>
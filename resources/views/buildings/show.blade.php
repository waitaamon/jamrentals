<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <span>{{ __($building->name) }}</span>
            <span class="text-lg">Location: {{ $building->location }}</span> <br>
            <span class="text-sm">Default Rent: {{ number_format($building->default_rent) }} | Default Deposit: {{ number_format($building->default_deposit) }}</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @include('buildings.partials.stats')

                    <div class="mt-4 w-full">
                        <h2 class="text-lg text-gray-700">Houses</h2>

                        <div class="mt-4">
                            <building-show></building-show>
{{--                            <houses-list :building="{{ $building }}"></houses-list>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

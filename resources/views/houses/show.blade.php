<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <span>{{ __($house->name) }}</span>
            <div>
                <span class="text-lg">Building: {{ $house->building->name }}</span>
                @if($house->is_occupied)
                    <span class="text-lg">Tenant: {{ $house->tenant->name }}</span>
                @endif
            </div>
            <span class="text-sm tracking-wide">
                <span class="text-indigo-200">Default Rent:</span> {{ number_format($house->rent) }}
                | <span class="text-indigo-200">Default Deposit:</span> {{ number_format($house->deposit) }}

                | <span class="text-indigo-200">Status:</span> {{ $house->is_occupied ? 'Occupied' : 'Vacant' }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mt-4 w-full">
                        <div class="mt-4">
                            <h4 class="mb-4 font-bold uppercase tracking-wide text-gray-400">Payments</h4>
                            <payments-list :building-id="{{ $house->building->id }}" :house-id="{{ $house->id }}"></payments-list>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


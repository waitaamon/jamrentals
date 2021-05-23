<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="space-y-2">
                <span>{{ __($tenant->name) }}</span><br>
                <p class="text-sm"><span class="text-indigo-200">Phone Number:</span> {{ __($tenant->phone) }}</p>
                <p class="text-sm"><span class="text-indigo-200">ID Number: </span> {{ $tenant->id_number }}</p>
            </div>
            <div>
                <span class="text-lg">Building: {{ $tenant->house->building->name }}</span>
                <span class="text-lg">House: {{ $tenant->house->name }}</span>
            </div>
            <span class="text-sm tracking-wide">
                <span class="text-indigo-200">Total Rent Paid:</span> {{ number_format($tenant->approved_payments_sum_amount) }}
                | <span class="text-indigo-200">Deposit:</span> {{ number_format($tenant->deposit) }}

                | <span class="text-indigo-200">Balance:</span> {{ number_format($tenant->balance) }}
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
                                {{ $tenant->payments }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


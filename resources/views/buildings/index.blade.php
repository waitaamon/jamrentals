<x-app-layout>
    <x-slot name="header">
        {{ __('Buildings') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <buildings-list></buildings-list>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

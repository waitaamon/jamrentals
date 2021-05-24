<x-app-layout>
    <x-slot name="header">
        {{ __('Reports') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 min-h-screen bg-white border-b border-gray-200">
                    <reports-index></reports-index>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<div>
    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">
                Total Houses
            </dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                {{ $building->houses_count }}
            </dd>
        </div>

        <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">
                Total Vacant
            </dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                {{ $building->vacant_houses_count }}
            </dd>
        </div>

        <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">
                Total Occupied
            </dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                {{ $building->occupied_houses_count }}
            </dd>
        </div>
    </dl>
</div>
